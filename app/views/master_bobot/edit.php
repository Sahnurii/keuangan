<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Edit Bobot Masa Kerja</h3>
        </div>
        <form action="<?= BASEURL; ?>/master_bobot/update" method="POST">
            <input type="hidden" name="id" value="<?= $data['bobot_kerja']['id']; ?>">
            <div class="container mt-2">
                <div class="form-group row">
                    <label for="klasifikasi" class="col-sm-2 col-form-label">Klasifikasi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="klasifikasi" value="<?= $data['bobot_kerja']['klasifikasi']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bobot" class="col-sm-2 col-form-label">Bobot</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="bobot" value="<?= $data['bobot_kerja']['bobot']; ?>" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-primary btn-lg mb-4">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
</div>
