<?php $pengajuan = $data['pengajuan']; ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12pt; }
        .header { text-align: center; font-size: 20pt; font-weight: bold; }
        .sub-header { text-align: center; font-size: 10pt; }
        .table-info { width: 100%; margin-top: 20px; border-collapse: collapse; }
        .table-info td { padding: 4px 2px; vertical-align: top; }
        .ttd-kanan { width: 40%; float: right; text-align: center; margin-top: 60px; }
        .ttd-kanan img { width: 150px; height: auto; margin: 10px 0; }
        hr.garis { height: 3px; background-color: black; border: none; margin-top: 10px; }
        .table-info td:last-child { white-space: pre-wrap; word-break: break-word;}
        table { page-break-inside: avoid;}
    </style>
</head>
<body>

<!-- Kop Surat -->
<table width="100%">
    <tr>
        <td width="10%" style="text-align: left;">
            <img src="<?= BASEURL ?>/img/Logo.png" width="60">
        </td>
        <td width="90%" style="text-align: center;">
            <div class="header">POLITEKNIK BATULICIN</div>
            <div class="sub-header">Izin Pendirian: Kemendikbud RI No. 568/E/O/2014, Tgl 17 Oktober 2014</div>
            <div class="sub-header">Jl. Malewa Raya Komp. Maming One Residence, Batulicin, Tanah Bumbu</div>
            <div class="sub-header">Prov. Kalimantan Selatan, Kode Pos: 72273</div>
            <div class="sub-header">Email: Politeknikbatulicin@gmail.com | Website: www.politeknikbatulicin.ac.id</div>
        </td>
    </tr>
</table>
<hr class="garis">

<!-- Judul -->
<h3 style="text-align: center; margin-top: 30px;">Rencana Anggaran Biaya (RAB)</h3>
<p style="text-align: center;"><strong><?= htmlspecialchars($pengajuan['judul']) ?></strong></p>

<!-- Informasi Pengajuan -->
<table class="table-info">
    <tr><td width="160"><strong>Nama Pengaju</strong></td><td width="10">:</td><td><?= $pengajuan['nama_pegawai'] ?></td></tr>
    <tr><td><strong>Jabatan/Bidang</strong></td><td>:</td><td><?= $pengajuan['jabatan_pengaju'] ?? '-' ?></td></tr>
    <tr><td><strong>Tanggal Pengajuan</strong></td><td>:</td><td><?= tglBiasaIndonesia($pengajuan['tanggal_upload']) ?></td></tr>
    <tr><td><strong>Tanggal Disetujui</strong></td><td>:</td><td><?= tglBiasaIndonesia($pengajuan['tanggal_disetujui']) ?></td></tr>
    <tr><td><strong>Total Anggaran</strong></td><td>:</td><td><?= uang_indo($pengajuan['total_anggaran']) ?></td></tr>
    <tr><td><strong>Deskripsi</strong></td><td>:</td><td><?= nl2br($pengajuan['deskripsi']) ?></td></tr>
    <tr><td><strong>Status</strong></td><td>:</td><td><?= ucfirst($pengajuan['status']) ?></td></tr>
</table>

<!-- Tanda Tangan dengan QR Code -->
<table style="width: 100%; margin-top: 60px;">
    <tr>
        <td style="width: 60%;"></td>
        <td style="width: 40%; text-align: center;">
            <p>Tanah Bumbu, <?= tglBiasaIndonesia(date('Y-m-d')) ?></p>
            <p>Mengetahui,</p>
            <table style="margin-top: 10px;">
                <tr>
                    <td style="text-align: center; font-weight: bold;">
                        <p><strong>Wakil Direktur I</strong></p>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center;">
                        <?php if ($pengajuan['status'] === 'diterima') : ?>
                        <img src="<?= BASEURL ?>/uploads/ttd/ttd-pimpinan.png" alt="Tanda Tangan" style="width: 120px; height: auto; margin: 10px 0;">
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <td style="text-align: center; font-weight: bold;">
                        <?= $pengajuan['nama_pimpinan'] ?? '-' ?><br>
                        <span style="font-weight: normal;">NIPY. <?= $pengajuan['nipy_pimpinan'] ?? '-' ?></span>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>

<!-- Tanda Tangan
<table style="width: 100%; margin-top: 60px;">
    <tr>
        <td style="width: 60%;"></td>
        <td style="width: 40%; text-align: center;">
            <p>Tanah Bumbu, <?= tglBiasaIndonesia(date('Y-m-d')) ?></p>
            <p>Mengetahui,</p>
            <p><strong>Wakil Direktur I</strong></p>
            <?php if ($pengajuan['status'] === 'diterima') : ?>
                <img src="<?= BASEURL ?>/uploads/ttd/ttd-pimpinan.png" alt="Tanda Tangan" style="width: 120px; height: auto; margin: 10px 0;">
            <?php endif; ?>
            <p><strong><?= $pengajuan['nama_pimpinan'] ?? '-' ?></strong></p>
            <p>NIPY: <?= $pengajuan['nipy_pimpinan'] ?? '-' ?></p>
        </td>
    </tr>
</table> -->


</body>
</html>
