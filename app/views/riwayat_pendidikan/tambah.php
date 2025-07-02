<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-white">Tambah Riwayat Pendidikan</h3>
        </div>
        <div class="card-body">
            <form action="<?= BASEURL; ?>/riwayat_pendidikan/tambah" method="POST">
                <div class="form-group">
                    <label for="id_pegawai">Nama Pegawai</label>
                    <select class="form-control" id="id_pegawai" name="id_pegawai" required>
                        <option value="" disabled selected>-- Pilih Pegawai --</option>
                        <?php foreach ($data['pegawai'] as $pegawai): ?>
                            <option value="<?= $pegawai['id']; ?>"><?= $pegawai['nama']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jenjang">Jenjang</label>
                    <select class="form-control" id="jenjang" name="id_jenjang" required>
                        <option value="" disabled selected>-- Pilih Jenjang --</option>
                        <?php foreach ($data['jenjang'] as $j): ?>
                            <option value="<?= $j['id']; ?>"><?= $j['jenjang']; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <div class="form-group">
                    <label for="gelar">Gelar</label>
                    <input type="text" class="form-control" id="gelar" name="gelar">
                </div>

                <div class="form-group">
                    <label for="program_studi">Program Studi</label>
                    <input type="text" class="form-control" id="program_studi" name="program_studi" required>
                </div>

                <div class="form-group">
                    <label for="nama_kampus">Nama Kampus</label>
                    <input type="text" class="form-control" id="nama_kampus" name="nama_kampus" required>
                </div>

                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan</button>
                <a href="<?= BASEURL; ?>/riwayatpendidikan" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>