<?php
$flashData = Flasher::flash();  // Ambil data flash
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">

    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Data Riwayat Pendidikan Pegawai</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="mb-3">
                    <a href="<?= BASEURL; ?>/riwayat_pendidikan/tambah/" class="btn btn-primary">
                        <i class="fa fa-edit"></i> Tambah Riwayat
                    </a>
                </div>
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>NAMA PEGAWAI</th>
                            <th>JENJANG</th>
                            <th>GELAR</th>
                            <th>PROGRAM STUDI</th>
                            <th>NAMA KAMPUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data['pendidikan'] as $row) : ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $row['nama_pegawai']; ?></td> <!-- pastikan join nama pegawai -->
                                <td><?= $row['nama_jenjang']; ?></td>
                                <td><?= $row['gelar']; ?></td>
                                <td><?= $row['program_studi']; ?></td>
                                <td><?= $row['nama_kampus']; ?></td>
                                <td class="text-center">
                                    <a href="<?= BASEURL; ?>/riwayat_pendidikan/edit/<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= BASEURL; ?>/riwayat_pendidikan/hapus/<?= $row['id']; ?>" class="btn btn-danger btn-sm tombol-hapus">
                                        <i class="fa fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
