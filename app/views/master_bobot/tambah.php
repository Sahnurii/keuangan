<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Tambah Bobot Masa Kerja</h3>
        </div>
        <form action="<?= BASEURL; ?>/master_bobot/tambah" method="POST">
            <div class="container mt-2">
                <div class="form-group row">
                    <label for="klasifikasi" class="col-sm-2 col-form-label">Klasifikasi</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="klasifikasi" id="klasifikasi" onchange="setBobotByKlasifikasi()" required>
                            <option value="">-- Pilih Klasifikasi --</option>
                            <option value="Tenaga Kependidikan">Tenaga Kependidikan</option>
                            <option value="Manajemen">Manajemen</option>
                            <option value="Dosen">Dosen</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bobot" class="col-sm-2 col-form-label">Bobot</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="bobot" id="bobot" step="0.01" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-primary btn-lg mb-4">Tambah</button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
    function setBobotByKlasifikasi() {
        const klasifikasi = document.getElementById("klasifikasi").value;
        const bobotField = document.getElementById("bobot");

        const bobotMap = {
            "Tenaga Kependidikan": 5500,
            "Manajemen": 8000,
            "Dosen": 6000
        };

        bobotField.value = bobotMap[klasifikasi] || "";
    }
</script>