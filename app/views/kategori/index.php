<?php
$flashData = Flasher::flash();  // Ambil data flash
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">

    <div class="card card-info">
        <div class="card-header  bg-primary">
            <h3 class="card-title text-center text-white">Data Kategori</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="mb-3">
                    <a href="<?= BASEURL; ?>/kategori/tambah/" class="btn btn-primary"><i class="fa fa-edit"></i> Tambah Kategori</a>
                </div>
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>NAMA KATEGORI</th>
                            <th>TIPE KATEGORI</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data['ktg'] as $kategori) : ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $kategori['nama_kategori']; ?></td>
                                <td><?= $kategori['tipe_kategori']; ?></td>
                                <td class="text-center">
                                    <a href="<?= BASEURL; ?>/kategori/edit/<?= $kategori['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= BASEURL; ?>/kategori/hapus/<?= $kategori['id']; ?>" class="btn btn-danger btn-sm tombol-hapus">
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