<div class="container mt-4">
    <div class="card">
        <div class="card-header bg-info text-white text-center">
            <h4>Slip Gaji Pegawai</h4>
        </div>
        <div class="card-body">
            <table class="table table-borderless table-sm" style="width: 100%;">
                <tr>
                    <th style="width: 150px;">Nama</th>
                    <td>: <?= $data['gaji']['nama']; ?></td>
                </tr>
                <tr>
                    <th>NIPY</th>
                    <td>: <?= $data['gaji']['nipy']; ?></td>
                </tr>
                <tr>
                    <th>Jabatan</th>
                    <td>: <?= $data['gaji']['jabatan']; ?></td>
                </tr>
                <tr>
                    <th>Tanggal Cetak</th>
                    <td>: <?= tglBiasaIndonesia(date('Y-m-d')); ?></td>
                </tr>
                <tr>
                    <th>Periode Gaji</th>
                    <td>: <?= bulanIndonesia((int)date('m', strtotime($data['gaji']['tanggal']))) . ' ' . date('Y', strtotime($data['gaji']['tanggal'])); ?></td>
                </tr>
            </table>
            <!-- <p><strong>Nama:</strong> <?= $data['gaji']['nama']; ?></p>
            <p><strong>NIPY:</strong> <?= $data['gaji']['nipy']; ?></p>
            <p><strong>Jabatan:</strong> <?= $data['gaji']['jabatan']; ?></p>
            <p><strong>Tanggal:</strong> <?= tglIndonesia($data['gaji']['tanggal']); ?></p> -->
            <br>
            <table class="table table-sm table-hover">
                <tr>
                    <th>Gaji Pokok</th>
                    <td><?= uang_indo($data['gaji']['gaji_pokok']); ?></td>
                </tr>
                <tr>
                    <th>Insentif</th>
                    <td><?= uang_indo($data['gaji']['insentif']); ?></td>
                </tr>
                <tr>
                    <th>Bobot Masa Kerja</th>
                    <td><?= uang_indo($data['gaji']['bobot_masa_kerja']); ?></td>
                </tr>
                <tr>
                    <th>Pendidikan</th>
                    <td><?= uang_indo($data['gaji']['pendidikan']); ?></td>
                </tr>
                <tr>
                    <th>Beban Kerja</th>
                    <td><?= uang_indo($data['gaji']['beban_kerja']); ?></td>
                </tr>
                <tr>
                    <th>Pemotongan</th>
                    <td><?= uang_indo($data['gaji']['pemotongan']); ?></td>
                </tr>
                <tr class="bg-light">
                    <th>Total Gaji Diterima</th>
                    <td><strong>
                            <?= uang_indo(
                                ($data['gaji']['gaji_pokok'] + $data['gaji']['insentif'] + $data['gaji']['bobot_masa_kerja'] + $data['gaji']['pendidikan'] + $data['gaji']['beban_kerja']) - $data['gaji']['pemotongan']
                            ); ?>
                        </strong></td>
                </tr>
            </table>
            <a href="<?= BASEURL; ?>/laporan/slipPdf/<?= $data['gaji']['id']; ?>" target="_blank" class="btn btn-success mt-3">Cetak PDF</a>
        </div>
    </div>
</div>
</div>