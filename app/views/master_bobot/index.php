<?php $flashData = Flasher::flash(); ?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>

<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Data Bobot Masa Kerja</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="mb-3">
                    <a href="<?= BASEURL; ?>/master_bobot/tambah" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</a>
                </div>
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Klasifikasi</th>
                            <th>Bobot</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($data['bobot_kerja'] as $bk) : ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $bk['klasifikasi']; ?></td>
                                <td><?= uang_indo_v2($bk['bobot']); ?></td>
                                <td class="text-center">
                                    <a href="<?= BASEURL; ?>/master_bobot/edit/<?= $bk['id']; ?>" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> Edit</a>
                                    <a href="<?= BASEURL; ?>/master_bobot/hapus/<?= $bk['id']; ?>" class="btn btn-danger btn-sm tombol-hapus"><i class="fa fa-trash"></i> Hapus</a>
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