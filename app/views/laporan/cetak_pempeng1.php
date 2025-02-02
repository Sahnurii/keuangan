<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">LAPORAN PENGELUARAN & PEMASUKAN</h3>
        </div>
        <div class="card-body">
            <form method="GET" action="<?= BASEURL; ?>/laporan/cetakPemasukanDanPengeluaran" class="mb-3">
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
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="<?= BASEURL; ?>/laporan/cetakPemasukanDanPengeluaran_print?tahun=<?= $selectedTahun; ?>&bulan=<?= $selectedBulan; ?>"
                            class="btn btn-success ml-2" target="_blank">CETAK</a>
                    </div>
                </div>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" style="width: 100%;">
                    <thead>
                        <tr>
                            <th class="text-center">PEMASUKAN</th>
                            <th class="text-center">PENGELUARAN</th>
                        </tr>
                    </thead>
                    <tbody id="transaksi-body">
                        <tr>
                            <td class="text-center"><?= uang_indo($data['total_pemasukan']); ?></td>
                            <td class="text-center"><?= uang_indo($data['total_pengeluaran']); ?></td>
                        </tr>
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
</script>