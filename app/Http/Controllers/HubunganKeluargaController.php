<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HubunganKeluarga;
use App\Models\KkJemaat;
use App\Models\Jemaat;

class HubunganKeluargaController extends Controller
{
    public function index()
    {
        $hubunganKeluarga = HubunganKeluarga::with(['kkJemaat', 'jemaat'])->get();
        $kkJemaat = KkJemaat::all();
        $jemaat = Jemaat::all();

        return view('hubungan_keluarga.index', compact('hubunganKeluarga', 'kkJemaat', 'jemaat'));
    }

    public function create()
    {
        $kkJemaat = KkJemaat::all();
        $jemaat = Jemaat::all();
        return view('hubungan_keluarga.create', compact('kkJemaat', 'jemaat'));
    }

    public function store(Request $request)
    {
        // Pastikan ID Jemaat sudah tersimpan
        if (!$request->has('id_jemaat') || empty($request->id_jemaat)) {
            return response()->json([
                'success' => false,
                'message' => 'ID Jemaat belum tersedia, pastikan data Jemaat sudah tersimpan!'
            ], 400);
        }

        // Validasi data
        $validated = $request->validate([
            'id_kk_jemaat' => 'required|exists:kk_jemaat,id_kk_jemaat',
            'id_jemaat' => 'required|exists:jemaat,id_jemaat',
            'hubungan_keluarga' => 'required|in:Kepala Keluarga,Pasangan,Anak,Kerabat,Belum Menikah',
        ]);

        try {
            // Simpan data hubungan keluarga
            $hubungan = HubunganKeluarga::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Data Hubungan Keluarga berhasil disimpan!',
                'data' => $hubungan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan Hubungan Keluarga.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
{
    // Ambil data hubungan keluarga berdasarkan ID
    $hubungan = HubunganKeluarga::with(['kkJemaat', 'jemaat'])->findOrFail($id);
    
    // Ambil daftar kepala keluarga untuk dropdown
    $kkJemaat = KkJemaat::all();
    
    // Ambil daftar jemaat yang bukan kepala keluarga untuk dropdown anggota keluarga
    $jemaat = Jemaat::whereDoesntHave('kkJemaat')->get();

    return view('hubungan_keluarga.edit', compact('hubungan', 'kkJemaat', 'jemaat'));
}

public function update(Request $request, $id)
{
    try {
        // Validasi input data
        $validated = $request->validate([
            'id_kk_jemaat' => 'required|exists:kk_jemaat,id_kk_jemaat',
            'id_jemaat' => 'required|exists:jemaat,id_jemaat',
            'hubungan_keluarga' => 'required|in:Kepala Keluarga,Pasangan,Anak,Kerabat,Belum Menikah',
        ]);

        // Ambil data hubungan keluarga berdasarkan ID
        $hubungan = HubunganKeluarga::findOrFail($id);

        // Jika ada perubahan kepala keluarga, pastikan jemaat tidak sedang menjadi kepala keluarga lain
        if ($request->id_kk_jemaat !== $hubungan->id_kk_jemaat) {
            $existingKK = KkJemaat::where('id_jemaat', $request->id_jemaat)->first();
            if ($existingKK) {
                return redirect()->back()->with('error', 'Jemaat ini sudah menjadi Kepala Keluarga!');
            }
        }

        // Update data hubungan keluarga
        $hubungan->update($validated);

        return redirect()->route('hubungan_keluarga.index')->with('success', 'Data Hubungan Keluarga berhasil diperbarui!');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return redirect()->back()->withErrors($e->validator)->withInput();
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui Hubungan Keluarga.');
    }
}

    public function destroy($id)
    {
        HubunganKeluarga::findOrFail($id)->delete();
        return redirect()->route('hubungan_keluarga.index')->with('success', 'Data berhasil dihapus!');
    }
}
