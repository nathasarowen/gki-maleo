@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Kepala Keluarga</h2>
    <a href="{{ route('kk_jemaat.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <!-- Detail Kepala Keluarga -->
    <div class="card">
        <div class="card-header">
            <h4>{{ $kepalaKeluarga->nama_jemaat }}</h4>
        </div>
        <div class="card-body">
            <p><strong>No Anggota:</strong> {{ $kepalaKeluarga->no_anggota }}</p>
            <p><strong>Nomor HP:</strong> {{ $kepalaKeluarga->nomor_hp }}</p>
            <p><strong>Tempat Lahir:</strong> {{ $kepalaKeluarga->tempat_lahir }}</p>
            <p><strong>Tanggal Lahir:</strong> {{ $kepalaKeluarga->tanggal_lahir }}</p>
            <p><strong>Alamat:</strong> {{ $kkJemaat->alamat }}</p>
            <p><strong>Asal Gereja:</strong> {{ $kepalaKeluarga->asal_gereja }}</p>
            <p><strong>Tanggal Terdaftar:</strong> {{ $kepalaKeluarga->tanggal_terdaftar }}</p>
            <p><strong>Gender:</strong> {{ $kepalaKeluarga->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
            <p><strong>Status Menikah:</strong> {{ $kepalaKeluarga->status_menikah }}</p>
            <p><strong>Tanggal Baptis:</strong> {{ $kepalaKeluarga->tanggal_baptis }}</p>
            <p><strong>Tanggal Sidi:</strong> {{ $kepalaKeluarga->tanggal_sidi }}</p>
            <p><strong>Tanggal Nikah:</strong> {{ $kepalaKeluarga->tanggal_nikah }}</p>
            <p><strong>Status Aktif:</strong> {{ $kepalaKeluarga->status_aktif }}</p>
            <p><strong>Group Wilayah:</strong> {{ $groupWilayah ? $groupWilayah->nama_group_wilayah : '-' }}</p>
        </div>
    </div>

    <!-- Anggota Keluarga -->
    <h3 class="mt-4">Anggota Keluarga</h3>
    <a href="{{ route('anggota.create', ['id_kk' => $kkJemaat->id_kk_jemaat]) }}" class="btn btn-primary">
        Tambah Anggota Keluarga
    </a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Hubungan</th>
                <th>Status</th>
                <th>Aksi</th>                
            </tr>
        </thead>
        <tbody>
            @foreach($anggotaKeluarga as $anggota)
                <tr>
                    <td>{{ $anggota->jemaat->nama_jemaat }}</td>
                    <td>{{ $anggota->hubungan_keluarga }}</td>
                    <td>{{ $anggota->jemaat->status_aktif }}</td>
                    <td>
                        <button class="btn btn-info btn-detail"
                            data-id="{{ $anggota->jemaat->id_jemaat }}"
                            data-idkk="{{ $anggota->jemaat->id_kk_jemaat }}"
                            data-no_anggota="{{ $anggota->jemaat->no_anggota }}"
                            data-nama="{{ $anggota->jemaat->nama_jemaat }}"
                            data-gender="{{ $anggota->jemaat->gender }}"
                            data-nomor_hp="{{ $anggota->jemaat->nomor_hp }}"
                            data-asal_gereja="{{ $anggota->jemaat->asal_gereja }}"
                            data-tempat_lahir="{{ $anggota->jemaat->tempat_lahir }}"
                            data-tanggal_terdaftar="{{ $anggota->jemaat->tanggal_terdaftar }}"
                            data-tanggal_lahir="{{ $anggota->jemaat->tanggal_lahir }}"
                            data-tanggal_baptis="{{ $anggota->jemaat->tanggal_baptis }}"
                            data-tanggal_sidi="{{ $anggota->jemaat->tanggal_sidi }}"
                            data-tanggal_nikah="{{ $anggota->jemaat->tanggal_nikah }}"
                            data-status_aktif="{{ $anggota->jemaat->status_aktif }}"
                            data-status_menikah="{{ $anggota->jemaat->status_menikah }}"
                            data-group_wilayah="{{ optional($anggota->jemaat->kkJemaat)->id_group_wilayah ?? '-' }}"
                            data-alamat="{{ optional($anggota->jemaat->kkJemaat)->alamat ?? '-' }}"
                            data-toggle="modal" data-target="#detailJemaatModal">
                            Lihat
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Detail Jemaat -->
<div class="modal fade" id="detailJemaatModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Jemaat</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p><strong>ID KK Jemaat:</strong> <span id="modal_id_kk"></span></p>
                <p><strong>ID Group Wilayah:</strong> <span id="modal_group_wilayah"></span></p>
                <p><strong>No Anggota:</strong> <span id="modal_no_anggota"></span></p>
                <p><strong>Nama Jemaat:</strong> <span id="modal_nama"></span></p>
                <p><strong>Jenis Kelamin:</strong> <span id="modal_gender"></span></p>
                <p><strong>Nomor HP:</strong> <span id="modal_nomor_hp"></span></p>
                <p><strong>Asal Gereja:</strong> <span id="modal_asal_gereja"></span></p>
                <p><strong>Tempat Lahir:</strong> <span id="modal_tempat_lahir"></span></p>
                <p><strong>Tanggal Terdaftar:</strong> <span id="modal_tanggal_terdaftar"></span></p>
                <p><strong>Tanggal Lahir:</strong> <span id="modal_tanggal_lahir"></span></p>
                <p><strong>Tanggal Baptis:</strong> <span id="modal_tanggal_baptis"></span></p>
                <p><strong>Tanggal Sidi:</strong> <span id="modal_tanggal_sidi"></span></p>
                <p><strong>Tanggal Nikah:</strong> <span id="modal_tanggal_nikah"></span></p>
                <p><strong>Alamat:</strong> <span id="modal_alamat"></span></p>
                <p><strong>Status Aktif:</strong> <span id="modal_status_aktif"></span></p>
                <p><strong>Status Menikah:</strong> <span id="modal_status_menikah"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.btn-detail').click(function() {
            $('#modal_id_kk').text($(this).data('idkk'));
            $('#modal_group_wilayah').text($(this).data('group_wilayah'));
            $('#modal_no_anggota').text($(this).data('no_anggota'));
            $('#modal_nama').text($(this).data('nama'));
            $('#modal_gender').text($(this).data('gender') == 'L' ? 'Laki-laki' : 'Perempuan');
            $('#modal_nomor_hp').text($(this).data('nomor_hp'));
            $('#modal_asal_gereja').text($(this).data('asal_gereja'));
            $('#modal_tempat_lahir').text($(this).data('tempat_lahir'));
            $('#modal_tanggal_terdaftar').text($(this).data('tanggal_terdaftar'));
            $('#modal_tanggal_lahir').text($(this).data('tanggal_lahir'));
            $('#modal_tanggal_baptis').text($(this).data('tanggal_baptis'));
            $('#modal_tanggal_sidi').text($(this).data('tanggal_sidi'));
            $('#modal_tanggal_nikah').text($(this).data('tanggal_nikah'));
            $('#modal_alamat').text($(this).data('alamat'));
            $('#modal_status_aktif').text($(this).data('status_aktif'));
            $('#modal_status_menikah').text($(this).data('status_menikah'));
        });
    });
</script>
@endsection
