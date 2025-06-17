<?php
$flashData = Flasher::flash();  // Ambil data flash
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">
    
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Data Jenis Pajak</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="mb-3">
                    <a href="<?= BASEURL; ?>/jenis_pajak/tambah/" class="btn btn-primary"><i class="fa fa-edit"></i> Tambah Jenis</a>
                </div>
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>TARIF PAJAK</th>
                            <th>TIPE</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($data['jenis_pajak'] as $jenis_pajak) : ?>
                            <tr class="text-center">
                                <td><?= $i++; ?></td>
                                <td><?= $jenis_pajak['tarif_pajak']; ?></td>
                                <td><?= $jenis_pajak['tipe']; ?></td>
                                <td>
                                    <a href="<?= BASEURL; ?>/jenis_pajak/edit/<?= $jenis_pajak['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= BASEURL; ?>/jenis_pajak/hapus/<?= $jenis_pajak['id']; ?>" class="btn btn-danger btn-sm tombol-hapus">
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