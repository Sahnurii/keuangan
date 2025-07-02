<?php
$flashData = Flasher::flash();  // Ambil data flash
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">

    <div class="card card-info">
        <div class="card-header  bg-primary">
            <h3 class="card-title text-center text-white">Data Jabatan & Bidang</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="mb-3">
                    <a href="<?= BASEURL; ?>/bidang/tambah/" class="btn btn-primary"><i class="fa fa-edit"></i> Tambah</a>
                </div>
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>JABATAN</th>
                            <th>NAMA BIDANG</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data['bidang'] as $bidang) : ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $bidang['jabatan']; ?></td>
                                <td><?= $bidang['nama_bidang']; ?></td>
                                <td class="text-center">
                                    <a href="<?= BASEURL; ?>/bidang/edit/<?= $bidang['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= BASEURL; ?>/bidang/hapus/<?= $bidang['id']; ?>" class="btn btn-danger btn-sm tombol-hapus">
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

</div>