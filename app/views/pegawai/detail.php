<!-- <div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Detail Pegawai</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <tr><th>Nama</th><td><?= $data['pegawai']['nama']; ?></td></tr>
                <tr><th>NIPY</th><td><?= $data['pegawai']['nipy']; ?></td></tr>
                <tr><th>No. Induk</th><td><?= $data['pegawai']['nomor_induk']; ?></td></tr>
                <tr><th>Jenis No. Induk</th><td><?= $data['pegawai']['jenis_nomor_induk']; ?></td></tr>
                <tr><th>Tempat Lahir</th><td><?= $data['pegawai']['tempat_lahir']; ?></td></tr>
                <tr><th>Jenis Kelamin</th><td><?= $data['pegawai']['jenis_kelamin']; ?></td></tr>
                <tr><th>TMT</th><td><?= $data['pegawai']['tmt']; ?></td></tr>
                <tr><th>SK Pengangkatan</th><td><?= $data['pegawai']['sk_pengangkatan']; ?></td></tr>
                <tr><th>Alamat</th><td><?= $data['pegawai']['alamat_pegawai']; ?></td></tr>
                <tr><th>No HP</th><td><?= $data['pegawai']['no_hp']; ?></td></tr>
                <tr><th>Email</th><td><?= $data['pegawai']['email']; ?></td></tr>
                <tr><th>Agama</th><td><?= $data['pegawai']['agama']; ?></td></tr>
                <tr><th>Status Perkawinan</th><td><?= $data['pegawai']['status_perkawinan']; ?></td></tr>
                <tr><th>Bank</th><td><?= $data['pegawai']['bank']; ?></td></tr>
                <tr><th>No Rekening</th><td><?= $data['pegawai']['no_rekening']; ?></td></tr>
                <tr><th>Jabatan & Bidang</th>
                    <td>
                        <ul>
                            <?php foreach ($data['pegawai']['jabatan_bidang'] as $jb) : ?>
                                <li><?= $jb['jabatan']; ?> - <?= $jb['nama_bidang']; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </td>
                </tr>
            </table>
            <a href="<?= BASEURL; ?>/pegawai" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div> -->

<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Detail Data Pegawai</h3>
        </div>
        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <th>Nama</th>
                    <td><?= $data['pegawai']['nama']; ?></td>
                </tr>
                <tr>
                    <th>NIPY</th>
                    <td><?= $data['pegawai']['nipy']; ?></td>
                </tr>
                <tr>
                    <th>TMT</th>
                    <td><?= tglBiasaIndonesia($data['pegawai']['tmt']); ?></td>
                </tr>
                <tr>
                    <th>SK Pengangkatan</th>
                    <td><?= $data['pegawai']['sk_pengangkatan']; ?></td>
                </tr>
                <tr>
                    <th>Nomor Induk</th>
                    <td><?= $data['pegawai']['nomor_induk']; ?></td>
                </tr>
                <tr>
                    <th>Jenis Nomor Induk</th>
                    <td><?= $data['pegawai']['jenis_nomor_induk']; ?></td>
                </tr>
                <tr>
                    <th>Tempat Lahir</th>
                    <td><?= $data['pegawai']['tempat_lahir']; ?></td>
                </tr>
                <tr>
                    <th>Tanggal Lahir</th>
                    <td><?= tglBiasaIndonesia($data['pegawai']['tanggal_lahir']); ?></td>
                </tr>
                <tr>
                    <th>Jenis Kelamin</th>
                    <td><?= $data['pegawai']['jenis_kelamin']; ?></td>
                </tr>
                <tr>
                    <th>No HP</th>
                    <td><?= $data['pegawai']['no_hp']; ?></td>
                </tr>
                <tr>
                    <th>Agama</th>
                    <td><?= $data['pegawai']['agama']; ?></td>
                </tr>
                <tr>
                    <th>Status Perkawinan</th>
                    <td><?= $data['pegawai']['status_perkawinan']; ?></td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td><?= $data['pegawai']['alamat_pegawai']; ?></td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td><?= $data['pegawai']['keterangan']; ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= $data['pegawai']['email']; ?></td>
                </tr>
                <tr>
                    <th>SPK</th>
                    <td><?= $data['pegawai']['spk']; ?></td>
                </tr>
                <tr>
                    <th>Lama Kerja</th>
                    <td><?= $data['pegawai']['lama_kerja']; ?></td>
                </tr>
                <tr>
                    <th>No Rekening</th>
                    <td><?= $data['pegawai']['no_rekening']; ?></td>
                </tr>
                <tr>
                    <th>Bank</th>
                    <td><?= $data['pegawai']['bank']; ?></td>
                </tr>
                <tr>
                    <th>Jabatan & Bidang</th>
                    <td>
                        <?php if (!empty($data['pegawai']['jabatan_bidang'])) : ?>
                            <ul>
                                <?php foreach ($data['pegawai']['jabatan_bidang'] as $jb) : ?>
                                    <li><?= $jb['jabatan']; ?> - <?= $jb['nama_bidang']; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            Tidak ada data jabatan/bidang
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>Riwayat Pendidikan</th>
                    <td>
                        <?php if (!empty($data['riwayat_pendidikan'])) : ?>
                            <ul>
                                <?php foreach ($data['riwayat_pendidikan'] as $rp) : ?>
                                    <li>
                                        <?= $rp['nama_jenjang']; ?>, <?= $rp['gelar']; ?> - <?= $rp['program_studi']; ?> (<?= $rp['nama_kampus']; ?>)
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else : ?>
                            <p>Tidak ada riwayat pendidikan.</p>
                            <a href="<?= BASEURL; ?>/riwayat_pendidikan/tambah?id_pegawai=<?= $data['pegawai']['id']; ?>" class="btn btn-sm btn-primary mt-2">
                                Tambahkan Riwayat Pendidikan
                            </a>
                        <?php endif; ?>
                    </td>
                </tr>

            </table>

            <a href="<?= BASEURL; ?>/pegawai" class="btn btn-secondary mt-3">Kembali</a>
        </div>
    </div>
</div>