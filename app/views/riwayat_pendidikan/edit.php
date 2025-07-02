<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-warning">
            <h3 class="card-title text-white">Edit Riwayat Pendidikan</h3>
        </div>
        <div class="card-body">
            <form action="<?= BASEURL; ?>/riwayat_pendidikan/update" method="POST">
                <input type="hidden" name="id" value="<?= $data['pendidikan']['id']; ?>">

                <div class="form-group">
                    <label for="id_pegawai">Nama Pegawai</label>
                    <select class="form-control" id="id_pegawai" name="id_pegawai" required>
                        <?php foreach ($data['pegawai'] as $pegawai): ?>
                            <option value="<?= $pegawai['id']; ?>" <?= $pegawai['id'] == $data['pendidikan']['id_pegawai'] ? 'selected' : ''; ?>>
                                <?= $pegawai['nama']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="jenjang">Jenjang</label>
                    <input type="text" class="form-control" id="jenjang" name="jenjang" value="<?= $data['pendidikan']['jenjang']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="gelar">Gelar</label>
                    <input type="text" class="form-control" id="gelar" name="gelar" value="<?= $data['pendidikan']['gelar']; ?>">
                </div>

                <div class="form-group">
                    <label for="program_studi">Program Studi</label>
                    <input type="text" class="form-control" id="program_studi" name="program_studi" value="<?= $data['pendidikan']['program_studi']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="nama_kampus">Nama Kampus</label>
                    <input type="text" class="form-control" id="nama_kampus" name="nama_kampus" value="<?= $data['pendidikan']['nama_kampus']; ?>" required>
                </div>

                <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Simpan Perubahan</button>
                <a href="<?= BASEURL; ?>/riwayatpendidikan" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
