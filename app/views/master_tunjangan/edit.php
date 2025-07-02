<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Edit Tunjangan</h3>
        </div>
        <form action="<?= BASEURL; ?>/master_tunjangan/update" method="POST">
            <input type="hidden" name="id" value="<?= $data['tunjangan']['id']; ?>">
            <div class="container mt-2">
                <div class="form-group row">
                    <label for="jenjang" class="col-sm-2 col-form-label">Jenjang</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="jenjang" value="<?= $data['tunjangan']['jenjang']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nominal" class="col-sm-2 col-form-label">Nominal</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="nominal" value="<?= $data['tunjangan']['nominal']; ?>" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-primary btn-lg mb-4">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
</div>