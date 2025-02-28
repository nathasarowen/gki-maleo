@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Hubungan Keluarga</h2>
    <a href="{{ route('hubungan_keluarga.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('hubungan_keluarga.update', $hubungan->id_hub_kel) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Pilih Kepala Keluarga</label>
            <select name="id_kk_jemaat" class="form-control" required>
                <option value="">-- Pilih Kepala Keluarga --</option>
                @foreach ($kkJemaat as $kk)
                    <option value="{{ $kk->id_kk_jemaat }}" {{ $kk->id_kk_jemaat == $hubungan->id_kk_jemaat ? 'selected' : '' }}>
                        {{ $kk->nama_kepala_keluarga }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Pilih Anggota Keluarga</label>
            <select name="id_jemaat" class="form-control" required>
                <option value="">-- Pilih Anggota --</option>
                @foreach ($jemaat as $j)
                    <option value="{{ $j->id_jemaat }}" {{ $j->id_jemaat == $hubungan->id_jemaat ? 'selected' : '' }}>
                        {{ $j->nama_jemaat }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Hubungan</label>
            <select name="hubungan_keluarga" class="form-control" required>
                <option value="Kepala Keluarga" {{ $hubungan->hubungan_keluarga == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                <option value="Pasangan" {{ $hubungan->hubungan_keluarga == 'Pasangan' ? 'selected' : '' }}>Pasangan</option>
                <option value="Anak" {{ $hubungan->hubungan_keluarga == 'Anak' ? 'selected' : '' }}>Anak</option>
                <option value="Kerabat" {{ $hubungan->hubungan_keluarga == 'Kerabat' ? 'selected' : '' }}>Kerabat</option>
                <option value="Belum Menikah" {{ $hubungan->hubungan_keluarga == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    </form>
</div>
@endsection
