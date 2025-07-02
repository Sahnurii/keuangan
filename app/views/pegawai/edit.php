<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-warning">
            <h3 class="card-title text-center text-white">Edit Data Pegawai</h3>
        </div>

        <form action="<?= BASEURL; ?>/pegawai/update" method="POST">
            <input type="hidden" name="id" value="<?= $data['pegawai']['id']; ?>">
            <div class="container mt-2">

                <!-- Form Input, seperti pada form tambah, tapi dengan value -->
                <?php
                $p = $data['pegawai'];
                function selected($val, $target)
                {
                    return $val == $target ? 'selected' : '';
                }
                ?>

                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">NAMA PEGAWAI</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" value="<?= $p['nama']; ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nipy" class="col-sm-2 col-form-label">NIPY</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="nipy" name="nipy" value="<?= $p['nipy']; ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tmt" class="col-sm-2 col-form-label">TMT</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tmt" name="tmt" value="<?= $p['tmt']; ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sk_pengangkatan" class="col-sm-2 col-form-label">SK PENGANGKATAN</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="sk_pengangkatan" name="sk_pengangkatan" value="<?= $p['sk_pengangkatan']; ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="nomor_induk" class="col-sm-2 col-form-label">NOMOR INDUK</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="nomor_induk" name="nomor_induk" value="<?= $p['nomor_induk']; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jenis_nomor_induk" class="col-sm-2 col-form-label">JENIS NOMOR INDUK</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="jenis_nomor_induk" name="jenis_nomor_induk">
                            <option disabled>-- Pilih Jenis --</option>
                            <option value="NIDN" <?= selected($p['jenis_nomor_induk'], 'NIDN'); ?>>NIDN</option>
                            <option value="NUP" <?= selected($p['jenis_nomor_induk'], 'NUP'); ?>>NUP</option>
                            <option value="NIDK" <?= selected($p['jenis_nomor_induk'], 'NIDK'); ?>>NIDK</option>
                            <option value="NITK" <?= selected($p['jenis_nomor_induk'], 'NITK'); ?>>NITK</option>
                            <option value="NUPTK" <?= selected($p['jenis_nomor_induk'], 'NUPTK'); ?>>NUPTK</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tempat_lahir" class="col-sm-2 col-form-label">TEMPAT LAHIR</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="<?= $p['tempat_lahir']; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tanggal_lahir" class="col-sm-2 col-form-label">TANGGAL LAHIR</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="<?= $p['tanggal_lahir']; ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jenis_kelamin" class="col-sm-2 col-form-label">JENIS KELAMIN</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="jenis_kelamin" name="jenis_kelamin">
                            <option value="Laki-laki" <?= selected($p['jenis_kelamin'], 'Laki-laki'); ?>>Laki-laki</option>
                            <option value="Perempuan" <?= selected($p['jenis_kelamin'], 'Perempuan'); ?>>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="no_hp" class="col-sm-2 col-form-label">NO HP</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="no_hp" name="no_hp" value="<?= $p['no_hp']; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="agama" class="col-sm-2 col-form-label">AGAMA</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="agama" name="agama">
                            <?php
                            $agamaList = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Lainnya'];
                            foreach ($agamaList as $agama) {
                                echo "<option value='$agama' " . selected($p['agama'], $agama) . ">$agama</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="status_perkawinan" class="col-sm-2 col-form-label">STATUS</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="status_perkawinan" name="status_perkawinan">
                            <option value="Menikah" <?= selected($p['status_perkawinan'], 'Menikah'); ?>>Menikah</option>
                            <option value="Belum Menikah" <?= selected($p['status_perkawinan'], 'Belum Menikah'); ?>>Belum Menikah</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="alamat_pegawai" class="col-sm-2 col-form-label">ALAMAT</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="alamat_pegawai" name="alamat_pegawai"><?= $p['alamat_pegawai']; ?></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="keterangan" class="col-sm-2 col-form-label">KETERANGAN</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" id="keterangan" name="keterangan"><?= $p['keterangan']; ?></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="col-sm-2 col-form-label">EMAIL</label>
                    <div class="col-sm-10">
                        <input type="email" class="form-control" id="email" name="email" value="<?= $p['email']; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="spk" class="col-sm-2 col-form-label">SPK</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="spk" name="spk" value="<?= $p['spk']; ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="rekening" class="col-sm-2 col-form-label">REKENING</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="rekening" name="no_rekening" value="<?= $p['no_rekening']; ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="bank" class="col-sm-2 col-form-label">BANK</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="bank" name="bank" value="<?= $p['bank']; ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="jabatan_bidang" class="col-sm-2 col-form-label">JABATAN & BIDANG</label>
                    <div class="col-sm-10">
                        <select class="form-control select2" id="jabatan_bidang" name="jabatan_bidang[]" multiple required>
                            <?php foreach ($data['jabatan_bidang'] as $jb): ?>
                                <option value="<?= $jb['id']; ?>"
                                    <?= in_array($jb['id'], $data['selected_jabatan_bidang']) ? 'selected' : ''; ?>>
                                    <?= $jb['jabatan']; ?> - <?= $jb['nama_bidang']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-muted">Tekan Ctrl / Cmd untuk memilih lebih dari satu</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="id_klasifikasi" class="col-sm-2 col-form-label">KLASIFIKASI</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="id_klasifikasi" name="id_klasifikasi" required>
                            <option disabled selected>-- Pilih Klasifikasi --</option>
                            <?php foreach ($data['bobot_klasifikasi'] as $k): ?>
                                <option value="<?= $k['id']; ?>" <?= $p['id_klasifikasi'] == $k['id'] ? 'selected' : ''; ?>>
                                    <?= $k['klasifikasi']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>


                <button type="submit" class="btn btn-block btn-warning btn-lg mb-4" name="submit">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>