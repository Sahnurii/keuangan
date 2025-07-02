<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Tambah Data Pegawai</h3>
        </div>

        <form action="<?= BASEURL; ?>/pegawai/tambah" method="POST">
            <div class="container mt-2">

                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">NAMA PEGAWAI</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nipy" class="col-sm-2 col-form-label">NIPY</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="nipy" name="nipy" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tmt" class="col-sm-2 col-form-label">TMT</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tmt" name="tmt" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sk_pengangkatan" class="col-sm-2 col-form-label">SK PENGANGKATAN</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="sk_pengangkatan" name="sk_pengangkatan" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nomor_induk" class="col-sm-2 col-form-label">NOMOR INDUK</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="nomor_induk" name="nomor_induk">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jenis_nomor_induk" class="col-sm-2 col-form-label">JENIS NOMOR INDUK</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="jenis_nomor_induk" name="jenis_nomor_induk">
                            <option value="" disabled selected>-- Pilih Jenis --</option>
                            <option value="NIDN">NIDN</option>
                            <option value="NUP">NUP</option>
                            <option value="NIDK">NIDK</option>
                            <option value="NITK">NITK</option>
                            <option value="NUPTK">NUPTK</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tempat_lahir" class="col-sm-2 col-form-label">TEMPAT LAHIR</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tanggal_lahir" class="col-sm-2 col-form-label">TANGGAL LAHIR</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jenis_kelamin" class="col-sm-2 col-form-label">JENIS KELAMIN</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                            <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="no_hp" class="col-sm-2 col-form-label">NO HP</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="no_hp" name="no_hp">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="agama" class="col-sm-2 col-form-label">AGAMA</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="agama" name="agama">
                            <option value="" disabled selected>-- Pilih Agama --</option>
                            <option value="Islam">Islam</option>
                            <option value="Kristen">Kristen</option>
                            <option value="Katolik">Katolik</option>
                            <option value="Hindu">Hindu</option>
                            <option value="Buddha">Buddha</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status_perkawinan" class="col-sm-2 col-form-label">STATUS</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="status_perkawinan" name="status_perkawinan">
                            <option value="" disabled selected>-- Pilih Status --</option>
                            <option value="Menikah">Menikah</option>
                            <option value="Belum Menikah">Belum Menikah</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="alamat_pegawai" class="col-sm-2 col-form-label">ALAMAT</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="alamat_pegawai" name="alamat_pegawai"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="keterangan" class="col-sm-2 col-form-label">KETERANGAN</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">EMAIL</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="spk" class="col-sm-2 col-form-label">SPK</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="spk" name="spk">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="rekening" class="col-sm-2 col-form-label">REKENING</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="rekening" name="no_rekening" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="bank" class="col-sm-2 col-form-label">BANK</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="bank" name="bank" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jabatan_bidang" class="col-sm-2 col-form-label">JABATAN & BIDANG</label>
                    <div class="col-sm-10">
                        <select class="form-control select2" id="jabatan_bidang" name="jabatan_bidang[]" multiple required>
                            <?php foreach ($data['jabatan_bidang'] as $jb) : ?>
                                <option value="<?= $jb['id']; ?>"><?= $jb['jabatan']; ?> - <?= $jb['nama_bidang']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-muted">Tekan Ctrl / Cmd untuk memilih lebih dari satu</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id_klasifikasi" class="col-sm-2 col-form-label">KLASIFIKASI MASA KERJA</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="id_klasifikasi" name="id_klasifikasi" required>
                            <option value="" disabled selected>-- Pilih Klasifikasi --</option>
                            <?php foreach ($data['bobot_klasifikasi'] as $bk) : ?>
                                <option value="<?= $bk['id']; ?>">
                                    <?= $bk['klasifikasi']; ?> (Bobot: <?= $bk['bobot']; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-muted">Pilih klasifikasi masa kerja pegawai</small>
                    </div>
                </div>


                <div class="form-group row">
                    <label for="tanggal_mulai_jabatan" class="col-sm-2 col-form-label">TANGGAL MULAI JABATAN</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_mulai_jabatan" name="tanggal_mulai_jabatan"
                            value="<?= isset($p['tanggal_mulai_jabatan']) ? $p['tanggal_mulai_jabatan'] : date('Y-m-d'); ?>">
                        <small class="form-text text-muted">Opsional. Jika tidak diisi, sistem akan otomatis menggunakan tanggal hari ini.</small>
                    </div>
                </div>


                <button type="submit" class="btn btn-block btn-primary btn-lg mb-4" name="submit">Tambah</button>
            </div>
        </form>
    </div>
</div>