@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Kepala Keluarga</h2>
    <a href="{{ route('kk_jemaat.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <form action="{{ route('kk_jemaat.update', $kepalaKeluarga->id_kk_jemaat) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Pilih Group Wilayah -->
        <div class="form-group">
            <label for="id_group_wilayah">Pilih Group Wilayah</label>
            <select name="id_group_wilayah" id="id_group_wilayah" class="form-control" required>
                <option value="">-- Pilih Group Wilayah --</option>
                @foreach ($groupWilayah as $group)
                    <option value="{{ $group->id_group_wilayah }}" {{ $kepalaKeluarga->id_group_wilayah == $group->id_group_wilayah ? 'selected' : '' }}>
                        {{ $group->id_group_wilayah }} - {{ $group->nama_group }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Pilih Kepala Keluarga (Jemaat) -->
        <div class="form-group">
            <label for="id_jemaat">Pilih Kepala Keluarga (Jemaat)</label>
            <select name="id_jemaat" id="id_jemaat" class="form-control" required>
                <option value="">-- Pilih Jemaat --</option>
                @foreach ($jemaat as $j)
                    <option value="{{ $j->id_jemaat }}" {{ $kepalaKeluarga->id_jemaat == $j->id_jemaat ? 'selected' : '' }}>
                        {{ $j->id_jemaat }} - {{ $j->nama_jemaat }} ({{ $j->no_anggota }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Nama Kepala Keluarga -->
        <div class="form-group">
            <label for="nama_kepala_keluarga">Nama Kepala Keluarga</label>
            <input type="text" name="nama_kepala_keluarga" id="nama_kepala_keluarga" class="form-control" value="{{ $kepalaKeluarga->nama_kepala_keluarga }}" required>
        </div>

        <!-- Alamat -->
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <textarea name="alamat" id="alamat" class="form-control" required>{{ $kepalaKeluarga->alamat }}</textarea>
        </div>

        <!-- Tombol Simpan -->
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection
