<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KkJemaat;
use App\Models\Jemaat;
use App\Models\GroupWilayah;
use App\Models\HubunganKeluarga;
use Illuminate\Support\Facades\Log; // Tambahkan untuk logging

class KkJemaatController extends Controller
{
    public function index()
{
    $kkJemaat = KkJemaat::with('jemaat:id_jemaat,nama_jemaat,no_anggota')->get();

    return view('kepala_keluarga.index', compact('kkJemaat'));
}

// public function index()
// {    
//     $jemaats = Jemaat::with(['hubunganKeluarga.kkJemaat', 'kkJemaat'])->get();

//     return view('jemaat.index', compact('jemaats'));
// }


    public function create()
    {
        $jemaat = Jemaat::all();
        $groupWilayah = GroupWilayah::all(); // Ambil semua data group wilayah

        // Cek apakah data group wilayah ada
        if ($groupWilayah->isEmpty()) {
            return redirect()->route('group_wilayah.index')->with('error', 'Data Group Wilayah belum tersedia.');
        }

        return view('kepala_keluarga.create', compact('jemaat', 'groupWilayah'));
    }

    public function store(Request $request)
{
    Log::info('Request Data Kepala Keluarga:', $request->all()); // Log request data

    if (!$request->has('id_jemaat') || empty($request->id_jemaat)) {
        Log::error('ID Jemaat tidak ditemukan dalam request!');
        return response()->json([
            'success' => false,
            'message' => 'ID Jemaat belum tersedia, silakan simpan data Jemaat terlebih dahulu.'
        ], 400);
    }

    try {
        $jemaat = Jemaat::find($request->id_jemaat);
        if (!$jemaat) {
            Log::error('Jemaat tidak ditemukan di database untuk ID: ' . $request->id_jemaat);
            return response()->json([
                'success' => false,
                'message' => 'ID Jemaat tidak ditemukan di database. Pastikan data Jemaat sudah benar-benar tersimpan.'
            ], 400);
        }

        // **DEBUG**: Log Data yang akan disimpan
        Log::info('Data yang akan disimpan:', [
            'id_jemaat' => $request->id_jemaat,
            'id_group_wilayah' => $request->id_group_wilayah,
            'alamat' => $request->alamat
        ]);

        // **Pastikan tidak ada kolom nama_kepala_keluarga**
        $kepalaKeluarga = KkJemaat::create([
            'id_jemaat' => $request->id_jemaat,
            'id_group_wilayah' => $request->id_group_wilayah,
            'alamat' => $request->alamat
        ]);

        Log::info('Data Kepala Keluarga Berhasil Disimpan:', $kepalaKeluarga->toArray());

        return response()->json([
            'success' => true,
            'message' => 'Data Kepala Keluarga berhasil disimpan!',
            'data' => $kepalaKeluarga
        ]);
    } catch (\Exception $e) {
        Log::error('Kesalahan saat menyimpan Kepala Keluarga:', ['error' => $e->getMessage()]);
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat menyimpan Kepala Keluarga.',
            'error' => $e->getMessage()
        ], 500);
    }
}



public function show($id)
{
    // Ambil informasi kepala keluarga dari tabel kk_jemaat
    // $kkJemaat = KkJemaat::with('jemaat')->where('id_kk_jemaat', $id)->firstOrFail();
    $kkJemaat = KkJemaat::with('jemaat')->findOrFail($id);

    // Ambil kepala keluarga dari jemaat berdasarkan id_jemaat di kk_jemaat
    $kepalaKeluarga = Jemaat::where('id_jemaat', $kkJemaat->id_jemaat)->firstOrFail();

    // Ambil semua anggota keluarga yang terhubung dengan kepala keluarga ini dari tabel hubungan_keluarga
    $anggotaKeluarga = HubunganKeluarga::where('id_kk_jemaat', $id)->with('jemaat')->get();

    // Ambil data group wilayah
    $groupWilayah = GroupWilayah::where('id_group_wilayah', $kkJemaat->id_group_wilayah)->first();

    return view('kepala_keluarga.show', compact('kepalaKeluarga', 'kkJemaat', 'anggotaKeluarga', 'groupWilayah'));
}


    public function edit($id)
{
    $kepalaKeluarga = KkJemaat::findOrFail($id);
    $jemaat = Jemaat::all();
    $groupWilayah = GroupWilayah::all();

    // Ambil semua anggota keluarga yang berada dalam KK ini
    $anggotaKeluarga = HubunganKeluarga::where('id_kk_jemaat', $id)->with('jemaat')->get();

    return view('kepala_keluarga.edit', compact('kepalaKeluarga', 'jemaat', 'groupWilayah', 'anggotaKeluarga'));
}

public function update(Request $request, $id)
{
    try {
        // Validasi Data
        $validatedData = $request->validate([
            'id_group_wilayah' => 'required',
            'alamat' => 'required',
            'status_keluarga' => 'required|in:kepala,anggota',
        ]);

        // Ambil data kepala keluarga berdasarkan ID
        $kepalaKeluarga = KkJemaat::findOrFail($id);
        $status_lama = 'kepala';
        $status_baru = $request->status_keluarga;

        // Jika Kepala Keluarga diubah menjadi Anggota Keluarga
        if ($status_baru === 'anggota') {
            // Validasi apakah kepala keluarga baru telah dipilih
            if (!$request->filled('id_kk_jemaat_baru')) {
                return redirect()->back()->with('error', 'Harap pilih Kepala Keluarga baru!');
            }

            // Hapus dari tabel kepala keluarga
            $kepalaKeluarga->delete();

            // Tambahkan ke tabel hubungan keluarga dengan kepala keluarga baru
            HubunganKeluarga::create([
                'id_kk_jemaat' => $request->id_kk_jemaat_baru,
                'id_jemaat' => $kepalaKeluarga->id_jemaat,
                'hubungan_keluarga' => $request->hubungan_keluarga
            ]);

            return redirect()->route('kk_jemaat.index')->with('success', 'Data telah diubah menjadi anggota keluarga.');
        }

        // Update data kepala keluarga jika status tetap kepala keluarga
        $kepalaKeluarga->update([
            'id_group_wilayah' => $request->id_group_wilayah,
            'alamat' => $request->alamat
        ]);

        return redirect()->route('kk_jemaat.index')->with('success', 'Data Kepala Keluarga berhasil diperbarui!');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator)->withInput();
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui Kepala Keluarga.');
    }
}

    public function destroy($id)
    {
        try {
            KkJemaat::findOrFail($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Kepala Keluarga berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            Log::error('Kesalahan saat menghapus Kepala Keluarga:', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus Kepala Keluarga.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
