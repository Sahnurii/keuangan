<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Tambah Data Gaji</h3>
        </div>

        <form action="<?= BASEURL; ?>/gaji/tambah" method="POST">
            <div class="container mt-2">
            <div class="form-group row">
                    <label for="tanggal" class="col-sm-2 col-form-label">TANGGAL</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Masukkan Tanggal" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="id_pegawai" class="col-sm-2 col-form-label">Nama Pegawai</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="id_pegawai" name="id_pegawai" required>
                            <option value="" disabled selected>Pilih Pegawai</option>
                            <?php foreach ($data['pegawai'] as $p) : ?>
                                <option value="<?= $p['id']; ?>"><?= $p['nama']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="gaji_pokok" class="col-sm-2 col-form-label">Gaji Pokok</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok" placeholder="Masukkan Gaji Pokok" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="insentif" class="col-sm-2 col-form-label">Insentif</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="insentif" name="insentif" placeholder="Masukkan Insentif">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bobot_masa_kerja" class="col-sm-2 col-form-label">Bobot Masa Kerja</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="bobot_masa_kerja" name="bobot_masa_kerja" placeholder="Masukkan Bobot Masa Kerja">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pendidikan" class="col-sm-2 col-form-label">Pendidikan</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="pendidikan" name="pendidikan" placeholder="Masukkan Pendidikan">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="beban_kerja" class="col-sm-2 col-form-label">Beban Kerja</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="beban_kerja" name="beban_kerja" placeholder="Masukkan Beban Kerja">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pemotongan" class="col-sm-2 col-form-label">Pemotongan</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="pemotongan" name="pemotongan" placeholder="Masukkan Pemotongan">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block btn-lg mb-4">Simpan</button>
            </div>
        </form>
    </div>
</div>