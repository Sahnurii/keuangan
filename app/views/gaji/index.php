<?php
$flashData = Flasher::flash();  // Ambil data flash
?>

<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Data Gaji</h3>
        </div>

        <div class="card-body">
            <form method="GET" action="<?= BASEURL; ?>/gaji/index" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <label for="tahun">Pilih Tahun</label>
                        <select id="tahun" name="tahun" class="form-control">
                            <?php
                            $selectedTahun = $_GET['tahun'] ?? $data['tahun'];
                            foreach ($data['bulan_tahun'] as $tahun => $bulanList) :
                                $selected = $selectedTahun == $tahun ? 'selected' : '';
                                echo "<option value='$tahun' $selected>$tahun</option>";
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="bulan">Pilih Bulan</label>
                        <select id="bulan" name="bulan" class="form-control">
                            <?php
                            $selectedBulan = $_GET['bulan'] ?? $data['bulan'];
                            foreach ($data['bulan_tahun'] as $tahun => $bulanList) :
                                if ($tahun == $selectedTahun) { // Hanya tampilkan bulan untuk tahun yang dipilih
                                    foreach ($bulanList as $bulan) :
                                        $bulanStr = str_pad($bulan, 2, '0', STR_PAD_LEFT); // Format dua digit
                                        $selected = $selectedBulan == $bulanStr ? 'selected' : '';
                                        echo "<option value='$bulanStr' $selected>" . ucfirst(strftime('%B', strtotime("$tahun-$bulan-01"))) . "</option>";
                                    endforeach;
                                }
                            endforeach;
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary" id="tes">Filter</button>
                        <?php if (in_array($_SESSION['user']['role'], ['Admin'])) : ?>
                        <a href="<?= BASEURL; ?>/laporan/cetakGaji_print?tahun=<?= $selectedTahun; ?>&bulan=<?= $selectedBulan; ?>"
                            class="btn btn-success ml-2" target="_blank">CETAK</a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
            <a href="<?= BASEURL; ?>/gaji/tambah" class="btn btn-primary mb-3">Tambah Gaji</a>

            <table class="table table-bordered table-hover">
                <thead class="text-center">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Pegawai</th>
                        <th>Gaji Pokok</th>
                        <th>Insentif</th>
                        <th>Bobot Masa Kerja</th>
                        <th>Pendidikan</th>
                        <th>Beban Kerja</th>
                        <th>Pemotongan</th>
                        <th>Total Gaji</th>
                        <th>Aksi</th>
                        <th>Status</th>
                        <th>Pembayaran</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    foreach ($data['gaji'] as $gaji) : ?>
                        <tr class="text-center">
                            <td><?= $no++; ?></td>
                            <td><?= tglSingkatIndonesia($gaji['tanggal']); ?></td>
                            <td><?= $gaji['nama']; ?></td>
                            <td><?= uang_indo($gaji['gaji_pokok']); ?></td>
                            <td><?= uang_indo($gaji['insentif']); ?></td>
                            <td><?= uang_indo($gaji['bobot_masa_kerja']); ?></td>
                            <td><?= uang_indo($gaji['pendidikan']); ?></td>
                            <td><?= uang_indo($gaji['beban_kerja']); ?></td>
                            <td><?= uang_indo($gaji['pemotongan']); ?></td>
                            <td>
                                <?= uang_indo(
                                    ($gaji['gaji_pokok'] + $gaji['insentif'] + $gaji['bobot_masa_kerja'] + $gaji['pendidikan'] + $gaji['beban_kerja']) - $gaji['pemotongan']
                                ); ?>
                            </td>
                            <td>
                                <a href="<?= BASEURL; ?>/gaji/edit/<?= $gaji['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= BASEURL; ?>/gaji/hapus/<?= $gaji['id']; ?>" class="btn btn-danger btn-sm tombol-hapus">Hapus</a>
                            </td>
                            <!-- Kolom Status -->
                            <td>
                                <?php if ($gaji['status_pembayaran'] == 'paid') : ?>
                                    <span class="badge badge-success">Paid</span>
                                <?php else : ?>
                                    <span class="badge badge-warning">Pending</span>
                                <?php endif; ?>
                            </td>

                            <!-- Kolom Pembayaran -->
                            <td>
                                <?php if ($gaji['status_pembayaran'] != 'paid') : ?>
                                    <a href="<?= BASEURL; ?>/gaji/bayar/<?= $gaji['id']; ?>" class="btn btn-success btn-sm">Bayar</a>
                                <?php else : ?>
                                    <span class="text-success">Sudah Dibayar</span>
                                <?php endif; ?>
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

<script>
    const tahunSelect = document.getElementById('tahun');
    const bulanSelect = document.getElementById('bulan');
    document.addEventListener('DOMContentLoaded', function() {

        // Data bulan yang tersedia berdasarkan tahun
        const bulanData = <?= json_encode($data['bulan_tahun']); ?>;
        const selectedBulan = "<?= $selectedBulan; ?>";
        // Fungsi untuk update bulan sesuai dengan tahun yang dipilih
        function updateBulan(tahun) {
            // Kosongkan opsi bulan
            bulanSelect.innerHTML = '';

            // Tambahkan bulan-bulan yang sesuai dengan tahun yang dipilih
            if (bulanData[tahun]) {
                bulanData[tahun].forEach(function(bulan) {
                    const bulanStr = String(bulan).padStart(2, '0'); // Format bulan dua digit
                    const option = document.createElement('option');
                    option.value = bulanStr;
                    option.textContent = new Date(0, bulanStr - 1).toLocaleString('id-ID', {
                        month: 'long'
                    });
                    if (bulanStr === selectedBulan) {
                        option.selected = true; // Tetapkan opsi yang sesuai sebagai selected
                    }
                    bulanSelect.appendChild(option);
                });
            }
        }

        // Panggil fungsi untuk mengupdate bulan ketika halaman pertama kali dimuat
        updateBulan(tahunSelect.value);

        // Setiap kali tahun dipilih, update bulan
        tahunSelect.addEventListener('change', function() {
            updateBulan(tahunSelect.value);
        });
    });
</script>