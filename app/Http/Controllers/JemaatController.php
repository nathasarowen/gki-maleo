<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jemaat;
use App\Models\KkJemaat;
use App\Models\GroupWilayah;
use App\Models\HubunganKeluarga;

class JemaatController extends Controller
{
    public function index()
    {
        // Ambil semua jemaat dan relasi ke hubungan keluarga jika ada
        $jemaats = Jemaat::with(['hubunganKeluarga.kkJemaat'])->get();

        return view('jemaat.index', compact('jemaats'));
    }

    public function create()
    {
        $groupWilayah = GroupWilayah::all(); // Mengambil semua data dari tabel group wilayah
        $kkJemaat = KkJemaat::all(); // Data kepala keluarga untuk dropdown
        $jemaat = Jemaat::all(); // Data jemaat untuk dropdown hubungan keluarga

        return view('jemaat.create', compact('groupWilayah', 'kkJemaat', 'jemaat'));
    }

    public function store(Request $request)
    {
        // Validasi data input
        $validatedData = $request->validate([
            'no_anggota' => 'required|unique:jemaat,no_anggota',
            'nama_jemaat' => 'required',
        ], [
            'no_anggota.required' => 'No Anggota wajib diisi.',
            'no_anggota.unique' => 'No Anggota sudah terdaftar.',
            'nama_jemaat.required' => 'Nama Jemaat wajib diisi.',
        ]);

        try {
            // Simpan data Jemaat ke database
            $jemaat = Jemaat::create([
                'no_anggota' => $request->no_anggota,
                'nama_jemaat' => $request->nama_jemaat,
                'gender' => $request->gender,
                'nomor_hp' => $request->nomor_hp,
                'asal_gereja' => $request->asal_gereja,
                'tanggal_terdaftar' => $request->tanggal_terdaftar,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tanggal_baptis' => $request->tanggal_baptis,
                'tanggal_sidi' => $request->tanggal_sidi,
                'tanggal_nikah' => $request->tanggal_nikah,
                'status_aktif' => $request->status_aktif,
                'status_menikah' => $request->status_menikah,
            ]);

            // Pastikan ID Jemaat dikembalikan dengan benar
            if (!$jemaat->id_jemaat) {
                throw new \Exception("Gagal menyimpan data Jemaat, ID tidak ditemukan.");
            }

            return response()->json([
                'success' => true,
                'message' => 'Data Jemaat berhasil disimpan!',
                'id_jemaat' => $jemaat->id_jemaat // Pastikan ini sesuai dengan nama kolom di database
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data Jemaat.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
{
    // Ambil data jemaat berdasarkan ID
    $jemaat = Jemaat::findOrFail($id);

    // Ambil data kepala keluarga jika jemaat ini adalah kepala keluarga
    $kepala_keluarga = KkJemaat::where('id_jemaat', $jemaat->id_jemaat)->first();

    // Jika jemaat ini adalah kepala keluarga, cari anggota keluarganya
    $anggota_keluarga = [];
    if ($kepala_keluarga) {
        $anggota_keluarga = HubunganKeluarga::where('id_kk_jemaat', $kepala_keluarga->id_kk_jemaat)
                            ->with('jemaat')
                            ->get();
    }

    return view('jemaat.edit', compact('jemaat', 'kepala_keluarga', 'anggota_keluarga'));
}


public function update(Request $request, $id)
{
    try {
        // Validasi Data
        $validatedData = $request->validate([
            'no_anggota' => 'required|unique:jemaat,no_anggota,' . $id . ',id_jemaat',
            'nama_jemaat' => 'required',
            'status_keluarga' => 'required|in:kepala,anggota',
            'id_kk_jemaat' => 'nullable|exists:kk_jemaat,id_kk_jemaat'
        ], [
            'no_anggota.required' => 'No Anggota wajib diisi.',
            'no_anggota.unique' => 'No Anggota sudah terdaftar.',
            'nama_jemaat.required' => 'Nama Jemaat wajib diisi.',
            'status_keluarga.required' => 'Status keluarga harus dipilih.',
            'id_kk_jemaat.exists' => 'Kepala Keluarga yang dipilih tidak valid.',
        ]);

        $jemaat = Jemaat::findOrFail($id);
        $kepalaKeluargaLama = KkJemaat::where('id_jemaat', $jemaat->id_jemaat)->first();

        // Jika berubah dari Kepala Keluarga ke Anggota Keluarga
        if ($kepalaKeluargaLama && $request->status_keluarga === 'anggota') {
            if (!$request->id_kk_jemaat) {
                return redirect()->back()->with('error', 'Anda harus memilih Kepala Keluarga baru.');
            }

            // Hapus dari tabel Kepala Keluarga
            KkJemaat::where('id_jemaat', $jemaat->id_jemaat)->delete();

            // Tambahkan ke Hubungan Keluarga sebagai anggota
            HubunganKeluarga::create([
                'id_kk_jemaat' => $request->id_kk_jemaat,
                'id_jemaat' => $jemaat->id_jemaat,
                'hubungan_keluarga' => 'Anggota'
            ]);
        }

        // Simpan data perubahan Jemaat
        $jemaat->update([
            'no_anggota' => $request->no_anggota,
            'nama_jemaat' => $request->nama_jemaat,
            'gender' => $request->gender,
            'nomor_hp' => $request->nomor_hp,
            'asal_gereja' => $request->asal_gereja,
            'tanggal_terdaftar' => $request->tanggal_terdaftar,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_baptis' => $request->tanggal_baptis,
            'tanggal_sidi' => $request->tanggal_sidi,
            'tanggal_nikah' => $request->tanggal_nikah,
            'status_aktif' => $request->status_aktif,
            'status_menikah' => $request->status_menikah,
        ]);

        return redirect()->route('jemaat.index')->with('success', 'Data Jemaat berhasil diperbarui!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui data.')->withErrors($e->getMessage());
    }
}


    public function destroy($id)
    {
        try {
            Jemaat::findOrFail($id)->delete();
            return redirect()->route('jemaat.index')->with('success', 'Data Jemaat berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('jemaat.index')->with('error', 'Terjadi kesalahan saat menghapus data.');
        }
    }
}
