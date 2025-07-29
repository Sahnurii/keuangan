<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Tambah Template Gaji Jabatan</h3>
        </div>
        <form action="<?= BASEURL; ?>/template_gaji_jabatan/tambah" method="POST">
            <div class="container mt-2">
                <div class="form-group row">
                    <label for="id_jabatan_bidang" class="col-sm-2 col-form-label">Jabatan & Bidang</label>
                    <div class="col-sm-10">
                        <select name="id_jabatan_bidang" class="form-control select2" required>
                            <option value="">-- Pilih Jabatan & Bidang --</option>
                            <?php foreach ($data['bidang'] as $row): ?>
                                <option value="<?= $row['id']; ?>"><?= $row['jabatan']; ?> - <?= $row['nama_bidang']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="gaji_pokok" class="col-sm-2 col-form-label">Gaji Pokok</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="gaji_pokok" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="insentif" class="col-sm-2 col-form-label">Insentif</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" name="insentif" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-primary btn-lg mb-4">Tambah</button>
            </div>
        </form>
    </div>
</div>
</div>