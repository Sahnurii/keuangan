<?php $flashData = Flasher::flash(); ?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>

<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Data Tunjangan Pendidikan</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="mb-3">
                    <a href="<?= BASEURL; ?>/master_tunjangan/tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                </div>
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Jenjang</th>
                            <th>Nominal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($data['tunjangan'] as $tj) : ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $tj['jenjang']; ?></td>
                                <td><?= uang_indo_v2($tj['nominal']); ?></td>
                                <td class="text-center">
                                    <a href="<?= BASEURL; ?>/master_tunjangan/edit/<?= $tj['id']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="<?= BASEURL; ?>/master_tunjangan/hapus/<?= $tj['id']; ?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fa fa-trash"></i> Hapus</a>
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