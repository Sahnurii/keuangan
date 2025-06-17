<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Edit Data Gaji</h3>
        </div>

        <form action="<?= BASEURL; ?>/gaji/update" method="POST">
            <div class="container mt-2">
                <input type="hidden" name="id" value="<?= $data['gaji']['id']; ?>">

                <div class="form-group row">
                    <label for="tanggal" class="col-sm-2 col-form-label">TANGGAL</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= $data['gaji']['tanggal']; ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id_pegawai" class="col-sm-2 col-form-label">Nama Pegawai</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="id_pegawai" name="id_pegawai" required readonly disabled>
                            <option value="<?= $data['gaji']['id_pegawai']; ?>"><?= $data['gaji']['nama']; ?></option>
                        </select>
                        <small class="text-muted">* Tidak bisa mengubah pegawai</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="gaji_pokok" class="col-sm-2 col-form-label">Gaji Pokok</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok" value="<?= $data['gaji']['gaji_pokok']; ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="insentif" class="col-sm-2 col-form-label">Insentif</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="insentif" name="insentif" value="<?= $data['gaji']['insentif']; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="bobot_masa_kerja" class="col-sm-2 col-form-label">Bobot Masa Kerja</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="bobot_masa_kerja" name="bobot_masa_kerja" value="<?= $data['gaji']['bobot_masa_kerja']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pendidikan" class="col-sm-2 col-form-label">Pendidikan</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="pendidikan" name="pendidikan" value="<?= $data['gaji']['pendidikan']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="beban_kerja" class="col-sm-2 col-form-label">Beban Kerja</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="beban_kerja" name="beban_kerja" value="<?= $data['gaji']['beban_kerja']; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="pemotongan" class="col-sm-2 col-form-label">Pemotongan</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="pemotongan" name="pemotongan" value="<?= $data['gaji']['pemotongan']; ?>">
                    </div>
                </div>

                <!-- Tambah kolom lain kalau mau edit bobot kerja, beban kerja dll -->

                <button type="submit" class="btn btn-success btn-block btn-lg mb-4">Update</button>
            </div>
        </form>
    </div>
</div>
