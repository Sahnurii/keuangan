<?php
$flashData = Flasher::flash();  // Ambil data flash
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">
    
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Saldo</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="mb-3">
                    <a href="<?= BASEURL; ?>/saldo/tambah/" class="btn btn-primary"><i class="fa fa-edit"></i> Tambah Saldo</a>
                </div>
                <table id="example" class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>TIPE BUKU</th>
                            <th>SALDO AWAL</th>
                            <th>KETERANGAN</th>
                            <th>TANGGAL </th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data['sldo'] as $saldo) : ?>
                            <tr class="text-center">
                                <td><?= $i++; ?></td>
                                <td><?= $saldo['tipe_buku']; ?></td>
                                <td><?= uang_indo($saldo['saldo_awal']); ?></td>
                                <td class="text-left"><?= $saldo['keterangan']; ?></td>
                                <td><?= $saldo['tanggal']; ?></td>
                                <td>
                                    <a href="<?= BASEURL; ?>/saldo/edit/<?= $saldo['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= BASEURL; ?>/saldo/hapus/<?= $saldo['id']; ?>" class="btn btn-danger btn-sm tombol-hapus">
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