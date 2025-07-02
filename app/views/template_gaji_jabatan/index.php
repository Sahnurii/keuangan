<?php $flashData = Flasher::flash(); ?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>

<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Data Template Gaji Jabatan</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <a href="<?= BASEURL; ?>/template_gaji_jabatan/tambah" class="btn btn-primary mb-3">
                    <i class="fa fa-plus"></i> Tambah
                </a>
                <table class="table table-bordered table-hover">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Jabatan</th>
                            <th>Bidang</th>
                            <th>Gaji Pokok</th>
                            <th>Insentif</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        foreach ($data['template'] as $row): ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td><?= $row['jabatan']; ?></td>
                                <td><?= $row['nama_bidang']; ?></td>
                                <td><?= uang_indo_v2($row['gaji_pokok']); ?></td>
                                <td><?= uang_indo_v2($row['insentif']); ?></td>
                                <td class="text-center">
                                    <a href="<?= BASEURL; ?>/template_gaji_jabatan/edit/<?= $row['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= BASEURL; ?>/template_gaji_jabatan/hapus/<?= $row['id']; ?>" class="btn btn-danger btn-sm tombol-hapus">
                                        <i class="fa fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>