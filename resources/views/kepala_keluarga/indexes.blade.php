@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Kepala Keluarga</h2>
    <a href="{{ route('kk_jemaat.create') }}" class="btn btn-primary mb-3">Tambah Data</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Kepala Keluarga</th>
                <th>Alamat</th>
                <th>ID Group Wilayah</th>
                <th>No Anggota</th>
                <!-- <th>Tempat Lahir</th> -->
                <!-- <th>Tanggal Lahir</th> -->
                <!-- <th>Nomor HP</th> -->
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($jemaats as $jemaat)
                <tr>                    
                    <td>{{ $jemaat->no_anggota }}</td>
                    <td>{{ $jemaat->nama_jemaat }}</td>
                    <td>
                        {{ $jemaat->kkJemaat->alamat ?? $jemaat->hubunganKeluarga->kkJemaat->alamat ?? '-' }}
                    </td>
                    <!-- <td>
                        {{ $jemaat->kkJemaat->id_group_wilayah ?? $jemaat->hubunganKeluarga->kkJemaat->id_group_wilayah ?? '-' }}
                    </td> -->
                    <!-- <td>{{ $jemaat->gender }}</td> 
                    <td>{{ $jemaat->nomor_hp }}</td> 
                    <td>{{ $jemaat->asal_gereja }}</td> 
                    <td>{{ $jemaat->tanggal_terdaftar }}</td> 
                    <td>{{ $jemaat->tempat_lahir }}</td> 
                    <td>{{ $jemaat->tanggal_lahir }}</td>  -->
                    <!-- <td>{{ $jemaat->tanggal_baptis }}</td> 
                    <td>{{ $jemaat->tanggal_sidi }}</td> 
                    <td>{{ $jemaat->tanggal_nikah }}</td>  -->
                    <td>{{ $jemaat->status_aktif }}</td>                    
                    <td>{{ $jemaat->status_menikah }}</td>                    
                    <td>
                        <!-- Tombol Lihat (Modal Popup) -->
                        <button class="btn btn-success" data-toggle="modal" data-target="#viewModal{{ $jemaat->id_jemaat }}">Lihat</button>

                        <!-- Tombol Edit (Menuju Halaman Edit) -->
                        <a href="{{ route('jemaat.edit', $jemaat->id_jemaat) }}" class="btn btn-info">Edit</a>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('jemaat.destroy', $jemaat->id_jemaat) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>

                <!-- Modal Detail Jemaat -->
                <div class="modal fade" id="viewModal{{ $jemaat->id_jemaat }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Detail Jemaat</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                <p><strong>ID KK Jemaat:</strong> {{ $jemaat->id_kk_jemaat ? $jemaat->id_kk_jemaat : 'Tidak Ada' }}</p>
                                
                                <!-- ID Group Wilayah dari Kepala Keluarga -->
                                <p><strong>ID Group Wilayah:</strong> 
                                    {{ optional($jemaat->kkJemaat)->id_group_wilayah ?? 'Tidak Ada' }}
                                </p>

                                <p><strong>No Anggota:</strong> {{ $jemaat->no_anggota }}</p>
                                <p><strong>Nama Jemaat:</strong> {{ $jemaat->nama_jemaat }}</p>
                                <p><strong>Jenis Kelamin:</strong> {{ $jemaat->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                <p><strong>Nomor HP:</strong> {{ $jemaat->nomor_hp ? $jemaat->nomor_hp : '-' }}</p>
                                <p><strong>Asal Gereja:</strong> {{ $jemaat->asal_gereja ? $jemaat->asal_gereja : '-' }}</p>
                                <p><strong>Tempat Lahir:</strong> {{ $jemaat->tempat_lahir ? $jemaat->tempat_lahir : '-' }}</p>
                                <p><strong>Tanggal Terdaftar:</strong> {{ $jemaat->tanggal_terdaftar ? $jemaat->tanggal_terdaftar : '-' }}</p>
                                <p><strong>Tanggal Lahir:</strong> {{ $jemaat->tanggal_lahir ? $jemaat->tanggal_lahir : '-' }}</p>
                                <p><strong>Tanggal Baptis:</strong> {{ $jemaat->tanggal_baptis ? $jemaat->tanggal_baptis : '-' }}</p>
                                <p><strong>Tanggal Sidi:</strong> {{ $jemaat->tanggal_sidi ? $jemaat->tanggal_sidi : '-' }}</p>
                                <p><strong>Tanggal Nikah:</strong> {{ $jemaat->tanggal_nikah ? $jemaat->tanggal_nikah : '-' }}</p>
                                
                                <!-- Alamat dari Kepala Keluarga -->
                                <p><strong>Alamat:</strong> 
                                    {{ optional($jemaat->kkJemaat)->alamat ?? 'Tidak Ada' }}
                                </p>

                                <p><strong>Status Aktif:</strong> {{ $jemaat->status_aktif }}</p>
                                <p><strong>Status Menikah:</strong> {{ $jemaat->status_menikah }}</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
