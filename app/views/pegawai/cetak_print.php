<h3 style="text-align: center; margin-top: 0; margin-bottom: 5px;">LAPORAN DATA PEGAWAI</h3>
<br><br><br>

<table>
    <thead>
        <tr>
            <th rowspan="2">No</th>
            <th rowspan="2">Nama</th>
            <th rowspan="2">NIPY</th>
            <th colspan="2">Unit Kerja</th>
            <th rowspan="2">SK Pengangkatan</th>
            <th rowspan="2">TMT</th>
            <th rowspan="2">NIDN/NUP/ NIDK/NITK</th>
            <th rowspan="2">NUPTK</th>
            <th rowspan="2">Tempat Lahir</th>
            <th rowspan="2">Tanggal Lahir</th>
            <th rowspan="2">Jenis Kelamin</th>
            <th colspan="4">Pendidikan</th>
            <th rowspan="2">No HP</th>
            <th rowspan="2">Agama</th>
            <th rowspan="2">Status Perkawinan</th>
            <th rowspan="2">Alamat Sesuai KTP</th>
            <th rowspan="2">Keterangan</th>
        </tr>
        <tr>
            <th>Jabatan</th>
            <th>Bidang</th>
            <th>Jenjang</th>
            <th>Gelar</th>
            <th>Program Studi</th>
            <th>Kampus</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1;
        foreach ($data['pegawai'] as $pgw): ?>
            <tr>
                <td align="center" style="width: 2%;"><?= $no++; ?></td>
                <td><?= $pgw['nama']; ?></td>
                <td style="width: 5%;"><?= $pgw['nipy']; ?></td>
                <td>
                    <?php foreach ($pgw['jabatan_bidang'] as $jb): ?>
                        <div><?= $jb['jabatan']; ?></div>
                    <?php endforeach; ?>
                </td>
                <td style="width: 7%;">
                    <?php foreach ($pgw['jabatan_bidang'] as $jb): ?>
                        <div><?= $jb['nama_bidang']; ?></div>
                    <?php endforeach; ?>
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
                <td><?= tglBiasaIndonesia($pgw['tempat_lahir']); ?></td>
                <td><?= tglBiasaIndonesia($pgw['tanggal_lahir']); ?></td>
                <td><?= $pgw['jenis_kelamin']; ?></td>
                <td>
                    <ul>
                        <?php foreach ($pgw['riwayat_pendidikan'] as $rp): ?>
                            <li><?= $rp['nama_jenjang']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php foreach ($pgw['riwayat_pendidikan'] as $rp): ?>
                            <li><?= $rp['gelar']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td>
                    <ul>
                        <?php foreach ($pgw['riwayat_pendidikan'] as $rp): ?>
                            <li><?= $rp['program_studi']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td style="width: 8%;">
                    <ul>
                        <?php foreach ($pgw['riwayat_pendidikan'] as $rp): ?>
                            <li><?= $rp['nama_kampus']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </td>
                <td><?= $pgw['no_hp']; ?></td>
                <td><?= $pgw['agama']; ?></td>
                <td><?= $pgw['status_perkawinan']; ?></td>
                <td style="width: 8%;"><?= $pgw['alamat_pegawai']; ?></td>
                <td><?= $pgw['keterangan']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<br><br><br>
<table style="width: 100%; border: none; margin-top: 50px; font-size: 10pt;">
    <tr>
        <td style="width: 50%; text-align: center; border: none;">
            Mengetahui,<br>
            Direktur<br><br><br><br><br><br><br><br><br><br><br>
            <strong><u><?= $data['direktur']['nama']; ?></u></strong><br>
            NIPY. <?= $data['direktur']['nipy']; ?>
        </td>
        <td style="width: 50%; text-align: center; border: none;">
            Tanah Bumbu, <?= tglBiasaIndonesia(date('Y-m-d')); ?><br>
            Wakil Direktur III<br>
            Kepegawaian (SDM), Humas, Sarpras dan Kemitraan Antar Lembaga<br><br><br><br><br><br><br><br><br><br>
            <strong><u><?= $data['wakil_direktur_3']['nama']; ?></u></strong><br>
            NIPY. <?= $data['wakil_direktur_3']['nipy']; ?>
        </td>

    </tr>
</table>