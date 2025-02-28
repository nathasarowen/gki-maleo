@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Kepala Keluarga</h2>
    <a href="{{ route('kk_jemaat.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <!-- Menampilkan pesan error jika ada -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('kk_jemaat.store') }}" method="POST">
        @csrf

        <!-- Pilih Group Wilayah -->
        <div class="form-group">
            <label for="id_group_wilayah">Pilih Group Wilayah</label>
            <select name="id_group_wilayah" id="id_group_wilayah" class="form-control" required>
                <option value="">-- Pilih Group Wilayah --</option>
                @foreach ($groupWilayah as $group)
                    <option value="{{ $group->id_group_wilayah }}" {{ old('id_group_wilayah') == $group->id_group_wilayah ? 'selected' : '' }}>
                        {{ $group->id_group_wilayah }} - {{ $group->nama_group }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Pilih Kepala Keluarga (Jemaat) -->
        <div class="form-group">
            <label>Pilih Kepala Keluarga (Jemaat)</label>
            <select name="id_jemaat" class="form-control" required>
                <option value="">-- Pilih Jemaat --</option>
                @foreach ($jemaat as $j)
                    <option value="{{ $j->id_jemaat }}" {{ old('id_jemaat') == $j->id_jemaat ? 'selected' : '' }}>
                        {{ $j->nama_jemaat }} ({{ $j->no_anggota }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Nama Kepala Keluarga -->
        <div class="form-group">
            <label>Nama Kepala Keluarga</label>
            <input type="text" name="nama_kepala_keluarga" class="form-control" value="" required>
        </div>

        <!-- Alamat -->
        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" class="form-control" required></textarea>
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection