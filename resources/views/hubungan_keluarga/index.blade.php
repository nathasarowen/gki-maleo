@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Hubungan Keluarga</h2>
    <a href="{{ route('hubungan_keluarga.create') }}" class="btn btn-primary mb-3">Tambah Data</a>

    <!-- Menampilkan pesan sukses atau error -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Kepala Keluarga</th>
                <th>Anggota</th>
                <th>Hubungan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hubunganKeluarga as $hubungan)
                <tr>
                    <!-- <td>{{ $hubungan->kkJemaat->nama_kepala_keluarga }}</td>                     -->
                    <td>{{ $hubungan->jemaat->nama_jemaat }}</td>
                    <td>{{ $hubungan->hubungan_keluarga }}</td>
                    <td>{{ $hubungan->hubungan_keluarga }}</td>
                    <td>
                        <!-- Tombol Lihat Detail -->
                        <button class="btn btn-success btn-detail" 
                            data-kepala="{{ $hubungan->kkJemaat->nama_kepala_keluarga }}" 
                            data-anggota="{{ $hubungan->jemaat->nama_jemaat }}" 
                            data-hubungan="{{ $hubungan->hubungan_keluarga }}"
                            data-toggle="modal" data-target="#detailHubunganModal">
                            Lihat
                        </button>

                        <!-- Tombol Edit -->
                        <a href="{{ route('hubungan_keluarga.edit', $hubungan->id_hub_kel) }}" class="btn btn-info">Edit</a>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('hubungan_keluarga.destroy', $hubungan->id_hub_kel) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus?');">
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

<!-- Modal Detail Hubungan Keluarga -->
<div class="modal fade" id="detailHubunganModal" tabindex="-1" aria-labelledby="detailHubunganLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailHubunganLabel">Detail Hubungan Keluarga</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p><strong>Kepala Keluarga:</strong> <span id="detailKepala"></span></p>
                <p><strong>Anggota:</strong> <span id="detailAnggota"></span></p>
                <p><strong>Hubungan:</strong> <span id="detailHubungan"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk memuat data ke dalam modal -->
<script>
    $(document).ready(function() {
        $('.btn-detail').click(function() {
            $('#detailKepala').text($(this).data('kepala'));
            $('#detailAnggota').text($(this).data('anggota'));
            $('#detailHubungan').text($(this).data('hubungan'));
            $('#detailHubunganModal').modal('show');
        });
    });
</script>

@endsection
