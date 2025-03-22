@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Anggota Keluarga</h2>
    <a href="{{ route('kk_jemaat.show', $kepalaKeluarga->id_kk_jemaat) }}" class="btn btn-secondary">Kembali</a>
    <br><br>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('anggota.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama Jemaat</label>
            <input type="text" name="nama_jemaat" class="form-control" required>
        </div>

        <div class="form-group">
            <label>No Anggota</label>
            <input type="text" name="no_anggota" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Nomor HP</label>
            <input type="text" name="nomor_hp" class="form-control">
        </div>

        <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control">
        </div>

        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control">
        </div>

        <div class="form-group">
            <label>Hubungan dalam Keluarga</label>
            <select name="hubungan_keluarga" class="form-control" required>
                <option value="">-- Pilih Hubungan --</option>
                @foreach ($hubunganList as $hubungan)
                    <option value="{{ $hubungan }}">{{ ucfirst($hubungan) }}</option>
                @endforeach
            </select>
        </div>

        <input type="hidden" name="id_kk_jemaat" value="{{ $kepalaKeluarga->id_kk_jemaat }}">

        <br>
        <button type="submit" class="btn btn-success">Simpan Anggota Keluarga</button>
    </form>
</div>
@endsection
