<?php
$flashData = Flasher::flash();
?>

<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">

    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Data Pegawai</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="mb-3">
                    <a href="<?= BASEURL; ?>/pegawai/tambah/" class="btn btn-primary"><i class="fa fa-edit"></i> Tambah Pegawai</a>
                </div>
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>NO</th>
                            <th>NAMA</th>
                            <th>NIPY</th>
                            <th>JABATAN</th>
                            <th>BIDANG</th>
                            <th>STATUS</th>
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
                                <td>
                                    <?php if (!empty($pegawai['jabatan_bidang'])) : ?>
                                        <ul class="pl-3 mb-0">
                                            <?php foreach ($pegawai['jabatan_bidang'] as $item) : ?>
                                                <li><?= $item['jabatan']; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else : ?>
                                        <em class="text-muted">-</em>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (!empty($pegawai['jabatan_bidang'])) : ?>
                                        <ul class="pl-3 mb-0">
                                            <?php foreach ($pegawai['jabatan_bidang'] as $item) : ?>
                                                <li><?= $item['nama_bidang']; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else : ?>
                                        <em class="text-muted">-</em>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($pegawai['status_aktif'] == 'aktif') : ?>
                                        <a href="<?= BASEURL ?>/pegawai/toggleStatus/<?= $pegawai['id'] ?>"
                                            class="badge badge-success tombol-status"
                                            data-status="<?= $pegawai['status_aktif'] ?>"
                                            onclick="return false;">Aktif</a>
                                    <?php else : ?>
                                        <a href="<?= BASEURL ?>/pegawai/toggleStatus/<?= $pegawai['id'] ?>"
                                            class="badge badge-danger tombol-status"
                                            data-status="<?= $pegawai['status_aktif'] ?>"
                                            onclick="return false;">Nonaktif</a>
                                    <?php endif; ?>
                                </td>

                                <td class="text-center">
                                    <a href="<?= BASEURL; ?>/pegawai/detail/<?= $pegawai['id']; ?>" class="btn btn-info btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="<?= BASEURL; ?>/pegawai/edit/<?= $pegawai['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="<?= BASEURL; ?>/pegawai/hapus/<?= $pegawai['id']; ?>" class="btn btn-danger btn-sm tombol-hapus">
                                        <i class="fa fa-trash"></i>
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