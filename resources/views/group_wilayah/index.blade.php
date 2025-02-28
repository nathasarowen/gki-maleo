@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Group Wilayah</h2>

    <!-- Tombol Tambah Data -->
    <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal">Tambah Data</button>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Group</th>
                <th>Kelurahan</th>
                <th>Kecamatan</th>
                <th>Koordinator</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($groups as $group)
            <tr>
                <td>{{ $group->id_group_wilayah }}</td>
                <td>{{ $group->nama_group_wilayah }}</td>
                <td>{{ $group->kelurahan }}</td>
                <td>{{ $group->kecamatan }}</td>
                <td>{{ $group->koor_group_wilayah ?? '-' }}</td>
                <td>
                    <!-- Tombol Lihat -->
                    <button class="btn btn-success" data-toggle="modal" data-target="#viewModal{{ $group->id_group_wilayah }}">Lihat</button>

                    <!-- Tombol Edit -->
                    <button class="btn btn-info" data-toggle="modal" data-target="#editModal{{ $group->id_group_wilayah }}">Edit</button>

                    <!-- Tombol Hapus -->
                    <form action="{{ route('group_wilayah.destroy', $group->id_group_wilayah) }}" method="POST" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>

            <!-- Modal Lihat Detail -->
            <div class="modal fade" id="viewModal{{ $group->id_group_wilayah }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Detail Group Wilayah</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p><strong>ID Group Wilayah:</strong> {{ $group->id_group_wilayah }}</p>
                            <p><strong>Nama Group Wilayah:</strong> {{ $group->nama_group_wilayah }}</p>
                            <p><strong>Kelurahan:</strong> {{ $group->kelurahan }}</p>
                            <p><strong>Kecamatan:</strong> {{ $group->kecamatan }}</p>
                            <p><strong>Koordinator:</strong> {{ $group->koor_group_wilayah ?? '-' }}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal{{ $group->id_group_wilayah }}" tabindex="-1">
                <div class="modal-dialog">
                    <form method="POST" action="{{ route('group_wilayah.update', $group->id_group_wilayah) }}">
                        @csrf
                        @method('PUT')
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Group Wilayah</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <input type="text" name="nama_group_wilayah" value="{{ $group->nama_group_wilayah }}" class="form-control mb-2" required>
                                <input type="text" name="kelurahan" value="{{ $group->kelurahan }}" class="form-control mb-2" required>
                                <input type="text" name="kecamatan" value="{{ $group->kecamatan }}" class="form-control mb-2" required>
                                <input type="text" name="koor_group_wilayah" value="{{ $group->koor_group_wilayah }}" class="form-control mb-2">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('group_wilayah.store') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Group Wilayah</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <input type="text" name="id_group_wilayah" class="form-control mb-2" placeholder="ID Group Wilayah (G01, G02, ...)" required>
                    <input type="text" name="nama_group_wilayah" class="form-control mb-2" placeholder="Nama Group Wilayah" required>
                    <input type="text" name="kelurahan" class="form-control mb-2" placeholder="Kelurahan" required>
                    <input type="text" name="kecamatan" class="form-control mb-2" placeholder="Kecamatan" required>
                    <input type="text" name="koor_group_wilayah" class="form-control mb-2" placeholder="Koordinator (Opsional)">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Tambah</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
