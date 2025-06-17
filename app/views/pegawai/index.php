<?php
$flashData = Flasher::flash();  // Ambil data flash
?>

<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">

    <div class="card card-info">
        <div class="card-header  bg-primary">
            <h3 class="card-title text-center text-white">Data Pegawai</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="mb-3">
                    <a href="<?= BASEURL; ?>/pegawai/tambah/" class="btn btn-primary"><i class="fa fa-edit"></i>Tambah Pegawai</a>
                </div>
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>NAMA PEGAWAI</th>
                            <th>NIPY</th>
                            <th>BIDANG</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data['pegawai'] as $pegawai) : ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $pegawai['nama']; ?></td>
                                <td><?= $pegawai['nipy']; ?></td>
                                <td><?= $pegawai['nama_bidang']; ?></td>
                                <td class="text-center">
                                    <a href="<?= BASEURL; ?>/pegawai/edit/<?= $pegawai['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= BASEURL; ?>/pegawai/hapus/<?= $pegawai['id']; ?>" class="btn btn-danger btn-sm tombol-hapus">
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