@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Kepala Keluarga</h2>
    <a href="{{ route('kk_jemaat.create') }}" class="btn btn-primary mb-3">Tambah Data</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No Anggota Jemaat</th>
                <th>Nama Kepala Keluarga</th>
                <th>Alamat</th>
                <th>ID Group Wilayah</th>
                <!-- <th>Tempat Lahir</th> -->
                <!-- <th>Tanggal Lahir</th> -->
                <!-- <th>Nomor HP</th> -->
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kkJemaat as $kk)
                <tr>
                    <td>{{ $kk->jemaat->no_anggota ?? '-' }}</td>
                    <td>{{ $kk->jemaat->nama_jemaat }}</td>
                    <td>{{ $kk->alamat }}</td>
                    <td>{{ $kk->id_group_wilayah }}</td>
                    <!-- <td>{{ $kk->jemaat->tempat_lahir ?? '-' }}</td> -->
                    <!-- <td>{{ $kk->jemaat->tanggal_lahir ?? '-' }}</td> -->
                    <!-- <td>{{ $kk->jemaat->nomor_hp ?? '-' }}</td> -->
                    <td>
                        <a href="{{ route('kk_jemaat.show', $kk->id_kk_jemaat) }}" class="btn btn-success">Lihat</a>
                        <a href="{{ route('kk_jemaat.edit', $kk->id_kk_jemaat) }}" class="btn btn-info">Edit</a>
                        <form action="{{ route('kk_jemaat.destroy', $kk->id_kk_jemaat) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
