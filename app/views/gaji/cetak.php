<?php
$flashData = Flasher::flash();  // Ambil data flash
?>

<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">LAPORAN GAJI PEGAWAI</h3>
        </div>

        <div class="card-body">
            <form method="GET" action="<?= BASEURL; ?>/laporan/cetakGaji" class="mb-3">
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
                        <a href="<?= BASEURL; ?>/laporan/cetakGaji_print?tahun=<?= $selectedTahun; ?>&bulan=<?= $selectedBulan; ?>"
                            class="btn btn-success ml-2" target="_blank">CETAK</a>
                    </div>
                </div>
            </form>
            
            <div class="table-responsive">
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
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1;
                    $total_gaji_pokok = 0;
                    $total_insentif = 0;
                    $total_bobot_masa_kerja = 0;
                    $total_pendidikan = 0;
                    $total_beban_kerja = 0;
                    $total_pemotongan = 0;
                    $total_total_gaji = 0;

                    foreach ($data['gaji'] as $gaji) :
                        $totalGaji = ($gaji['gaji_pokok'] + $gaji['insentif'] + $gaji['bobot_masa_kerja'] + $gaji['pendidikan'] + $gaji['beban_kerja']) - $gaji['pemotongan'];

                        $total_gaji_pokok += $gaji['gaji_pokok'];
                        $total_insentif += $gaji['insentif'];
                        $total_bobot_masa_kerja += $gaji['bobot_masa_kerja'];
                        $total_pendidikan += $gaji['pendidikan'];
                        $total_beban_kerja += $gaji['beban_kerja'];
                        $total_pemotongan += $gaji['pemotongan'];
                        $total_total_gaji += $totalGaji;
                    ?>
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
                        </tr>
                    <?php endforeach; ?>
                <tfoot>
                    <tr class="text-center font-weight-bold bg-light">
                        <td colspan="3">Total</td>
                        <td><?= uang_indo($total_gaji_pokok); ?></td>
                        <td><?= uang_indo($total_insentif); ?></td>
                        <td><?= uang_indo($total_bobot_masa_kerja); ?></td>
                        <td><?= uang_indo($total_pendidikan); ?></td>
                        <td><?= uang_indo($total_beban_kerja); ?></td>
                        <td><?= uang_indo($total_pemotongan); ?></td>
                        <td><?= uang_indo($total_total_gaji); ?></td>
                    </tr>
                </tfoot>
                </tbody>
            </table>
        </div>
        </div>
    </div>
    <div class="card-footer">
        <h5 class="text-center bg-success text-white ">Silahkan Filter Data Terlebih Dahulu Sebelum Mencetak</h5>
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