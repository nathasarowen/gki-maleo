@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Data Jemaat</h2>
    <a href="{{ route('jemaat.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="formJemaat" action="{{ route('jemaat.update', $jemaat->id_jemaat) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" id="id_jemaat" name="id_jemaat" value="{{ $jemaat->id_jemaat }}">

        <div class="form-group">
            <label>No Anggota</label>
            <input type="text" name="no_anggota" class="form-control"
                   value="{{ old('no_anggota', $jemaat->no_anggota) }}" required>
        </div>

        <div class="form-group">
            <label>Nama Jemaat</label>
            <input type="text" name="nama_jemaat" class="form-control"
                   value="{{ old('nama_jemaat', $jemaat->nama_jemaat) }}" required>
        </div>

        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="gender" class="form-control">
                <option value="L" {{ old('gender', $jemaat->gender) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                <option value="P" {{ old('gender', $jemaat->gender) == 'P' ? 'selected' : '' }}>Perempuan</option>
            </select>
        </div>

        <div class="form-group">
            <label>Nomor HP</label>
            <input type="text" name="nomor_hp" class="form-control" 
                value="{{ old('nomor_hp', $jemaat->nomor_hp) }}">
        </div>

        <div class="form-group">
            <label>Asal Gereja</label>
            <input type="text" name="asal_gereja" class="form-control" 
                value="{{ old('asal_gereja', $jemaat->asal_gereja) }}">
        </div>

        <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control" 
                value="{{ old('tempat_lahir', $jemaat->tempat_lahir) }}">
        </div>

        <div class="form-group">
            <label>Tanggal Terdaftar</label>
            <input type="date" name="tanggal_terdaftar" class="form-control" 
                value="{{ old('tanggal_terdaftar', $jemaat->tanggal_terdaftar) }}">
        </div>

        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control" 
                value="{{ old('tanggal_lahir', $jemaat->tanggal_lahir) }}">
        </div>

        <div class="form-group">
            <label>Tanggal Baptis</label>
            <input type="date" name="tanggal_baptis" class="form-control" 
                value="{{ old('tanggal_baptis', $jemaat->tanggal_baptis) }}">
        </div>

        <div class="form-group">
            <label>Tanggal Sidi</label>
            <input type="date" name="tanggal_sidi" class="form-control" 
                value="{{ old('tanggal_sidi', $jemaat->tanggal_sidi) }}">
        </div>

        <div class="form-group">
            <label>Tanggal Nikah</label>
            <input type="date" name="tanggal_nikah" class="form-control" 
                value="{{ old('tanggal_nikah', $jemaat->tanggal_nikah) }}">
        </div>

        <div class="form-group">
            <label>Status Aktif</label>
            <select name="status_aktif" class="form-control">
                <option value="Aktif" {{ old('status_aktif', $jemaat->status_aktif) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="Pindah" {{ old('status_aktif', $jemaat->status_aktif) == 'Pindah' ? 'selected' : '' }}>Pindah</option>
                <option value="Meninggal Dunia" {{ old('status_aktif', $jemaat->status_aktif) == 'Meninggal Dunia' ? 'selected' : '' }}>Meninggal Dunia</option>
            </select>
        </div>

        <div class="form-group">
            <label>Status Menikah</label>
            <select name="status_menikah" class="form-control">
                <option value="Menikah" {{ old('status_menikah', $jemaat->status_menikah) == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                <option value="Belum Menikah" {{ old('status_menikah', $jemaat->status_menikah) == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                <option value="Duda" {{ old('status_menikah', $jemaat->status_menikah) == 'Duda' ? 'selected' : '' }}>Duda</option>
                <option value="Janda" {{ old('status_menikah', $jemaat->status_menikah) == 'Janda' ? 'selected' : '' }}>Janda</option>
            </select>
        </div>

        <div class="form-group">
            <label>Status dalam Keluarga</label>
            <select id="status_keluarga" name="status_keluarga" class="form-control">
                <option value="kepala" {{ $jemaat->kkJemaat ? 'selected' : '' }}>Kepala Keluarga</option>
                <option value="anggota" {{ $jemaat->kkJemaat ? '' : 'selected' }}>Anggota Keluarga</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    </form>

    <!-- Form untuk memilih Kepala Keluarga baru -->
    <div id="formPilihKK" style="display: none; margin-top: 20px;">
        <h4>Pilih Kepala Keluarga Baru</h4>
        <form id="formHubunganKeluarga">
            @csrf
            <input type="hidden" id="id_jemaat_hub" name="id_jemaat" value="{{ $jemaat->id_jemaat }}">

            <div class="form-group">
                <label>Pilih Kepala Keluarga</label>
                <select name="id_kk_jemaat" class="form-control">
                    <option value="">-- Pilih Kepala Keluarga --</option>
                    @foreach($anggota_keluarga as $anggota)
                        <option value="{{ $anggota->jemaat->id_jemaat }}">
                            {{ $anggota->jemaat->nama_jemaat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan sebagai Anggota Keluarga</button>
        </form>
    </div>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        let statusKeluarga = document.getElementById("status_keluarga");
        let formPilihKK = document.getElementById("formPilihKK");

        // Cek apakah status_keluarga sudah ada dan bisa diubah
        if (statusKeluarga) {
            statusKeluarga.addEventListener("change", function () {
                if (this.value === "anggota") {
                    formPilihKK.style.display = "block";
                } else {
                    formPilihKK.style.display = "none";
                }
            });

            // Pastikan saat halaman dimuat kembali, form tetap sesuai status
            if (statusKeluarga.value === "anggota") {
                formPilihKK.style.display = "block";
            } else {
                formPilihKK.style.display = "none";
            }
        }
    });

    // Validasi sebelum submit jika memilih anggota keluarga
    document.getElementById("formJemaat").addEventListener("submit", function (event) {
        let statusKeluarga = document.getElementById("status_keluarga").value;
        let kepalaKeluarga = document.getElementById("id_kk_jemaat").value;

        if (statusKeluarga === "anggota" && !kepalaKeluarga) {
            event.preventDefault();
            alert("Pilih Kepala Keluarga sebelum menyimpan perubahan!");
        }
    });

    // Submit form Hubungan Keluarga jika jemaat diubah menjadi anggota
    document.getElementById("formHubunganKeluarga").addEventListener("submit", function (event) {
        event.preventDefault();

        let formData = new FormData(this);
        let idJemaat = document.getElementById("id_jemaat_hub").value;
        let idKepalaKeluarga = document.getElementById("id_kk_jemaat").value;

        if (!idKepalaKeluarga) {
            alert("Silakan pilih Kepala Keluarga baru sebelum menyimpan.");
            return;
        }

        formData.append("hubungan_keluarga", "Anggota");

        fetch("{{ route('hubungan_keluarga.store') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Jemaat berhasil dipindahkan ke Hubungan Keluarga!");
                window.location.href = "{{ route('jemaat.index') }}";
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            alert("Terjadi kesalahan pada server.");
            console.error("Error:", error);
        });
    });
</script>

@endsection