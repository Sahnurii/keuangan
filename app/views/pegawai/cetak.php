<style>
    .wrap-lebar {
        white-space: normal;
        word-wrap: break-word;
    }
</style>
<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white w-100">LAPORAN DATA PEGAWAI</h3>
        </div>

        <div class="card-body">
            <div class="mb-3 text-right">
                <a href="<?= BASEURL; ?>/laporan/cetakPegawai_print" target="_blank" class="btn btn-success">
                    <i class="fas fa-print"></i> CETAK PDF
                </a>
            </div>
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead class="text-center bg-primary text-white">
                        <tr>
                            <th rowspan="2" class="align-middle">No</th>
                            <th rowspan="2" class="align-middle">Nama</th>
                            <th rowspan="2" class="align-middle">NIPY</th>
                            <th colspan="2" class="align-middle">Unit Kerja</th>
                            <th rowspan="2" class="align-middle">SK Pengangkatan</th>
                            <th rowspan="2" class="align-middle">TMT</th>
                            <th rowspan="2" class="align-middle">NIDN/NUP/ NIDK/NITK</th>
                            <th rowspan="2" class="align-middle">NUPTK</th>
                            <th rowspan="2" class="align-middle">Tempat Lahir</th>
                            <th rowspan="2" class="align-middle">Tanggal Lahir</th>
                            <th rowspan="2" class="align-middle">Jenis Kelamin</th>
                            <th colspan="4" class="align-middle">Pendidikan</th>
                            <th rowspan="2" class="align-middle">No HP</th>
                            <th rowspan="2" class="align-middle">Agama</th>
                            <th rowspan="2" class="align-middle">Status Perkawinan</th>
                            <th rowspan="2" class="align-middle " style="width: 200px;">Alamat Sesuai KTP</th>
                            <th rowspan="2" class="align-middle">Keterangan</th>
                        </tr>
                        <tr>
                            <th class="align-middle">Jabatan</th>
                            <th class="align-middle">Bidang</th>
                            <th class="align-middle">Jenjang</th>
                            <th class="align-middle">Gelar</th>
                            <th class="align-middle">Program Studi</th>
                            <th class="align-middle" style="width: 200px;">Kampus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data['pegawai'] as $pgw): ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= $pgw['nama']; ?></td>
                                <td><?= $pgw['nipy']; ?></td>
                                <td>
                                    <ul class="pl-3 mb-0">
                                        <?php foreach ($pgw['jabatan_bidang'] as $jb): ?>
                                            <li><?= $jb['jabatan']; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="pl-3 mb-0">
                                        <?php foreach ($pgw['jabatan_bidang'] as $jb): ?>
                                            <li><?= $jb['nama_bidang']; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td><?= $pgw['sk_pengangkatan']; ?></td>
                                <td><?= tglBiasaIndonesia($pgw['tmt']); ?></td>
                                <td>
                                    <?php
                                    if (in_array($pgw['jenis_nomor_induk'], ['NIDN', 'NIDK', 'NITK', 'NUP'])) {
                                        echo $pgw['nomor_induk'];
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($pgw['jenis_nomor_induk'] === 'NUPTK') {
                                        echo $pgw['nomor_induk'];
                                    } else {
                                        echo '-';
                                    }
                                    ?>
                                </td>
                                <td><?= $pgw['tempat_lahir']; ?></td>
                                <td><?= tglBiasaIndonesia($pgw['tanggal_lahir']); ?></td>
                                <td><?= $pgw['jenis_kelamin']; ?></td>
                                <td>
                                    <ul class="pl-3 mb-0">
                                        <?php foreach ($pgw['riwayat_pendidikan'] as $rp): ?>
                                            <li><?= $rp['nama_jenjang']; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="pl-3 mb-0">
                                        <?php foreach ($pgw['riwayat_pendidikan'] as $rp): ?>
                                            <li><?= $rp['gelar']; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td>
                                    <ul class="pl-3 mb-0">
                                        <?php foreach ($pgw['riwayat_pendidikan'] as $rp): ?>
                                            <li><?= $rp['program_studi']; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td style="width: 200px;" class="wrap-lebar">
                                    <ul class="pl-3 mb-0">
                                        <?php foreach ($pgw['riwayat_pendidikan'] as $rp): ?>
                                            <li><?= $rp['nama_kampus']; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </td>
                                <td><?= $pgw['no_hp']; ?></td>
                                <td><?= $pgw['agama']; ?></td>
                                <td><?= $pgw['status_perkawinan']; ?></td>
                                <td style="width: 150px;" class="wrap-lebar"><?= $pgw['alamat_pegawai']; ?></td>
                                <td><?= $pgw['keterangan']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer">
            <h6 class="text-center text-muted">Data ditarik pada: <?= date('d M Y, H:i') ?></h6>
        </div>
    </div>
</div>