<?php
$flashData = Flasher::flash();  // Ambil data flash
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Data Buku Pembantu Pajak</h3>
        </div>
        <div class="card-body">
            <!-- Form Filter -->
            <form method="GET" action="<?= BASEURL; ?>/buku_pajak/index" class="mb-3">
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
                        <a href="<?= BASEURL; ?>/laporan/cetak_print?tahun=<?= $selectedTahun; ?>&bulan=<?= $selectedBulan; ?>"
                            class="btn btn-success ml-2" target="_blank">CETAK</a>
                    </div>
                </div>
            </form>



            <!-- End Form Filter -->
            <div class="table-responsive">
                <div class="mb-3">
                    <a href="<?= BASEURL; ?>/transaksi" class="btn btn-primary"><i class="fa fa-edit"></i> TAMBAH</a>
                </div>
                <table id="dataTable" class="table table-bordered table-hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th rowspan="2" width="1%">NO</th>
                            <th rowspan="2" class="text-center">SUMBER SALDO</th>
                            <th rowspan="2" class="text-center">TANGGAL</th>
                            <th rowspan="2" class="text-center">NO BUKTI</th>
                            <th rowspan="2" class="text-center">URAIAN</th>
                            <!-- <th rowspan="2" class="text-center">KATEGORI</th> -->
                            <th colspan="5" class="text-center">PEMASUKAN</th>
                            <th rowspan="2" class="text-center">PENGELUARAN</th>
                            <th rowspan="2" class="text-center">SALDO</th>
                            <th rowspan="2" width="10%" class="text-center">OPSI</th>
                        </tr>
                        <tr>
                            <th class="text-center">PPN</th>
                            <th class="text-center">PPh 4(2) Final</th>
                            <th class="text-center">PPh21</th>
                            <th class="text-center">PPh22</th>
                            <th class="text-center">PPh23</th>
                        </tr>
                    </thead>
                    <tbody id="transaksi-body">
                        <?php $i = 1; ?>
                        <?php foreach ($data['transaksi'] as $trx): ?>
                            <tr>
                                <td class="text-center"><?= $i++; ?></td>
                                <td class="text-center">
                                    <?php if (($trx['tipe_buku'] ?? '') === 'Kas'): ?>
                                        <a href="<?= BASEURL; ?>/buku_kas?bulan=<?= $selectedBulan ?>&tahun=<?= $selectedTahun ?>" class="badge badge-success">Kas</a>
                                    <?php elseif (($trx['tipe_buku'] ?? '') === 'Bank'): ?>
                                        <a href="<?= BASEURL; ?>/buku_bank?bulan=<?= $selectedBulan ?>&tahun=<?= $selectedTahun ?>" class="badge badge-info">Bank</a>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Tidak Diketahui</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?= tglSingkatIndonesia($trx['tanggal']); ?></td>
                                <td class="text-center"><?= $trx['no_bukti']; ?></td>
                                <td class="text-wrap" style="max-width: 250px;"><?= $trx['keterangan']; ?></td>
                                <!-- <td><?= $trx['kategori']; ?></td> -->

                                <!-- Pemasukan tiap jenis -->
                                <?php foreach (['PPN', 'Pph4(2)Final', 'PPh21', 'PPh22', 'PPh23'] as $jenis): ?>
                                    <?php $val = $trx['pajak'][$jenis]['Pemasukan']; ?>
                                    <td class="text-center"><?= $val > 0 ? uang_indo($val) : '-'; ?></td>
                                <?php endforeach; ?>

                                <!-- Total Pengeluaran -->
                                <?php
                                $out = array_sum(array_column($trx['pajak'], 'Pengeluaran'));
                                ?>
                                <td class="text-center"><?= $out > 0 ? uang_indo($out) : '-'; ?></td>

                                <!-- Kolom Saldo -->
                                <td rowspan="<?= $rowspan; ?>" class="text-end fw-bold"><?= uang_indo($trx['saldo']); ?></td>

                                <!-- Opsi -->
                                <td class="text-center">
                                    <a href="<?= BASEURL; ?>/buku_pajak/edit/<?= $trx['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= BASEURL; ?>/transaksi/hapusPajak/<?= $trx['id']; ?>" class="btn btn-danger btn-sm tombol-hapus">
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        let saldoAwal = <?= $data['saldo_awal']; ?>;
        // console.log(saldoAwal)
        let saldo = saldoAwal;

        const rows = document.querySelectorAll('#transaksi-body tr');
        rows.forEach(row => {
            const jenis = row.querySelector('.saldo-cell').getAttribute('data-jenis');
            const nominal = parseFloat(row.querySelector('.saldo-cell').getAttribute('data-nominal'));

            if (jenis === 'Pemasukan') {
                saldo += nominal;
            } else if (jenis === 'Pengeluaran') {
                saldo -= nominal;
            }

            row.querySelector('.saldo-cell').textContent = saldo.toLocaleString('id-ID', {
                style: 'currency',
                currency: 'IDR'
            });
        });
    });

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

    function fetchNoBukti(tipeBuku, tanggal) {
        fetch(`<?= BASEURL; ?>/transaksi_pajak/getNomorBukti/${tipeBuku}/${tanggal}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('no_bukti').value = data;
            })
            .catch(error => console.error('Error:', error));
    }
</script>