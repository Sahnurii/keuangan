<?php
$flashData = Flasher::flash();  // Ambil data flash
$role = $_SESSION['user']['role'];
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">

    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Histori Pengajuan Anggaran Diterima</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>No</th>
                            <th>Nama Pengusul</th>
                            <th>Judul</th>
                            <th>Total</th>
                            <th>Tanggal Upload</th>
                            <th>Tanggal Diterima</th>
                            <th>QR Code</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        foreach ($data['pengajuan'] as $row) : ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td><?= $row['nama_pegawai']; ?></td>
                                <td><?= $row['judul']; ?></td>
                                <td><?= uang_indo($row['total_anggaran']); ?></td>
                                <td class="text-center"><?= tglBiasaIndonesia($row['tanggal_upload']); ?></td>
                                <td class="text-center"><?= tglBiasaIndonesia($row['tanggal_disetujui']); ?></td>
                                <td style="text-align: center;">
                                    <img class="border border-primary rounded p-1" src="<?= BASEURL ?>/uploads/ttd/ttd-pimpinan.png" alt="Tanda Tangan" style="width: 120px; height: auto; margin: 10px 0;"><br>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>