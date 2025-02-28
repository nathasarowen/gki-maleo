@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tambah Data Jemaat</h2>
    <a href="{{ route('jemaat.index') }}" class="btn btn-secondary mb-3">Kembali</a>

    <!-- Form Tambah Jemaat -->
    <form id="formJemaat">
        @csrf
        <div class="form-group">
            <label>No Anggota</label>
            <input type="text" name="no_anggota" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Nama Jemaat</label>
            <input type="text" name="nama_jemaat" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Jenis Kelamin</label>
            <select name="gender" class="form-control">
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>
        </div>

        <div class="form-group">
            <label>Nomor HP</label>
            <input type="text" name="nomor_hp" class="form-control">
        </div>

        <div class="form-group">
            <label>Asal Gereja</label>
            <input type="text" name="asal_gereja" class="form-control">
        </div>

        <div class="form-group">
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="form-control">
        </div>

        <div class="form-group">
            <label>Tanggal Terdaftar</label>
            <input type="date" name="tanggal_terdaftar" class="form-control">
        </div>

        <div class="form-group">
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="form-control">
        </div>

        <div class="form-group">
            <label>Tanggal Baptis</label>
            <input type="date" name="tanggal_baptis" class="form-control">
        </div>

        <div class="form-group">
            <label>Tanggal Sidi</label>
            <input type="date" name="tanggal_sidi" class="form-control">
        </div>

        <div class="form-group">
            <label>Tanggal Nikah</label>
            <input type="date" name="tanggal_nikah" class="form-control">
        </div>

        <div class="form-group">
            <label>Status Aktif</label>
            <select name="status_aktif" class="form-control">
                <option value="Aktif">Aktif</option>
                <option value="Pindah">Pindah</option>
                <option value="Menikah">Menikah</option>
                <option value="Meninggal Dunia">Meninggal Dunia</option>
            </select>
        </div>

        <div class="form-group">
            <label>Status Menikah</label>
            <select name="status_menikah" class="form-control">
                <option value="Menikah">Menikah</option>
                <option value="Belum Menikah">Belum Menikah</option>
                <option value="Duda">Duda</option>
                <option value="Janda">Janda</option>
            </select>
        </div>

        <div class="form-group">
            <label>Status dalam Keluarga</label>
            <select id="status_keluarga" name="status_keluarga" class="form-control">
                <option value="">-- Pilih Status --</option>
                <option value="kepala">Kepala Keluarga</option>
                <option value="anggota">Anggota Keluarga</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Simpan Jemaat</button>
    </form>

    <!-- Form Kepala Keluarga -->
    <div id="formKepalaKeluarga" style="display: none; margin-top: 20px;">
        <h4>Data Kepala Keluarga</h4>
        <form id="formKK">
            @csrf
            <input type="hidden" id="id_jemaat" name="id_jemaat">

            <div class="form-group">
                <label>Pilih Group Wilayah</label>
                <select name="id_group_wilayah" class="form-control" required>
                    <option value="">-- Pilih Group Wilayah --</option>
                    @foreach ($groupWilayah as $group)
                        <option value="{{ $group->id_group_wilayah }}">{{ $group->nama_group_wilayah }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Kepala Keluarga</button>
        </form>
    </div>

    <!-- Form Hubungan Keluarga -->
    <div id="formHubunganKeluarga" style="display: none; margin-top: 20px;">
        <h4>Data Hubungan Keluarga</h4>
        <form id="formHK">
            @csrf
            <input type="hidden" id="id_jemaat_hub" name="id_jemaat">
            
            <div class="form-group">
                <label>Pilih Kepala Keluarga</label>
                <select name="id_kk_jemaat" class="form-control" required>
                    <option value="">-- Pilih Kepala Keluarga --</option>
                    @foreach ($kkJemaat as $kk)
                        <option value="{{ $kk->id_kk_jemaat }}">{{ $kk->nama_kepala_keluarga }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Hubungan</label>
                <select name="hubungan_keluarga" class="form-control" required>
                    <option value="Pasangan">Pasangan</option>
                    <option value="Anak">Anak</option>
                    <option value="Kerabat">Kerabat</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Hubungan Keluarga</button>
        </form>
    </div>
</div>

<script>
    document.getElementById("status_keluarga").addEventListener("change", function() {
        document.getElementById("formKepalaKeluarga").style.display = this.value === "kepala" ? "block" : "none";
        document.getElementById("formHubunganKeluarga").style.display = this.value === "anggota" ? "block" : "none";
    });

    document.getElementById("formJemaat").addEventListener("submit", function(event) {
        event.preventDefault();
        let formData = new FormData(this);

        fetch("{{ route('jemaat.store') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log("Response Data dari Server Jemaat:", data);

            if (data.success) {
                alert("Data Jemaat berhasil disimpan!");
                document.getElementById("id_jemaat").value = data.id_jemaat;
                document.getElementById("id_jemaat_hub").value = data.id_jemaat;
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            alert("Terjadi kesalahan pada server.");
            console.error("Error:", error);
        });
    });

    document.getElementById("formKK").addEventListener("submit", function(event) {
        event.preventDefault();
        let idJemaat = document.getElementById("id_jemaat").value;

        if (!idJemaat) {
            alert("ID Jemaat masih kosong, pastikan data Jemaat sudah tersimpan!");
            return;
        }

        let formData = new FormData(this);
        formData.append("id_jemaat", idJemaat);

        fetch("{{ route('kk_jemaat.store') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Data Kepala Keluarga berhasil disimpan!");
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

    document.getElementById("formHK").addEventListener("submit", function(event) {
        event.preventDefault();
        let idJemaat = document.getElementById("id_jemaat_hub").value;

        if (!idJemaat) {
            alert("ID Jemaat masih kosong, pastikan data Jemaat sudah tersimpan!");
            return;
        }

        let formData = new FormData(this);
        formData.append("id_jemaat", idJemaat);

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
                alert("Data Hubungan Keluarga berhasil disimpan!");
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