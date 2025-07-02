<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Tambah Tunjangan</h3>
        </div>
        <form action="<?= BASEURL; ?>/master_tunjangan/tambah" method="POST">
            <div class="container mt-2">
                <div class="form-group row">
                    <label for="jenjang" class="col-sm-2 col-form-label">Jenjang</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="jenjang" id="jenjang" required onchange="setNominalByJenjang()">
                            <option value="">-- Pilih Jenjang --</option>
                            <option value="SD/SMP">SD/SMP</option>
                            <option value="SMA">SMA</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nominal" class="col-sm-2 col-form-label">Nominal</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="nominal" name="nominal" step="0.01" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-primary btn-lg mb-4">Tambah</button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
    function setNominalByJenjang() {
        const jenjang = document.getElementById("jenjang").value;
        const nominalField = document.getElementById("nominal");

        const nominalMap = {
            "SD/SMP": 50000,
            "SMA": 75000,
            "D3": 150000,
            "S1": 200000,
            "S2": 400000,
            "S3": 600000
        };

        nominalField.value = nominalMap[jenjang] || "";
    }
</script>