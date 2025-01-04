<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Data Buku Bank</h3>
        </div>
        <div class="card-body">
            <!-- Form Filter -->
            <form method="GET" action="<?= BASEURL; ?>/buku_bank/index" class="mb-3">
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
                    </div>
                </div>
            </form>



            <!-- End Form Filter -->
            <div class="table-responsive">
                <div class="mb-3">
                    <a href="<?= BASEURL; ?>/kategori/tambah/" class="btn btn-primary"><i class="fa fa-edit"></i> CETAK</a>
                    <a href="<?= BASEURL; ?>/kategori/tambah/" class="btn btn-primary"><i class="fa fa-edit"></i> TAMBAH</a>
                </div>
                
                <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th rowspan="2" width="1%">NO</th>
                            <th rowspan="2" class="text-center">TIPE BUKU</th>
                            <th rowspan="2" class="text-center">TANGGAL</th>
                            <th rowspan="2" class="text-center">NO BUKTI</th>
                            <th rowspan="2" class="text-center">KETERANGAN</th>
                            <th rowspan="2" class="text-center">KATEGORI</th>
                            <th rowspan="2" class="text-center">JENIS TRANSAKSI</th>
                            <th colspan="3" class="text-center">JENIS</th>
                            <th rowspan="2" width="10%" class="text-center">OPSI</th>
                        </tr>
                        <tr>
                            <th class="text-center">PEMASUKAN</th>
                            <th class="text-center">PENGELUARAN</th>
                            <th class="text-center">SALDO</th>
                        </tr>
                    </thead>
                    <tbody id="transaksi-body">
                        <?php $i = 1; ?>
                        <?php foreach ($data['transaksi'] as $transaksi) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $transaksi['tipe_buku']; ?></td>
                                <td><?= date('d M Y', strtotime($transaksi['tanggal'])); ?></td>
                                <td><?= $transaksi['no_bukti']; ?></td>
                                <td><?= $transaksi['keterangan']; ?></td>
                                <td><?= $transaksi['kategori']; ?></td>
                                <td><?= $transaksi['tipe_kategori']; ?></td>
                                <td><?= $transaksi['tipe_kategori'] === 'Pemasukan' ? uang_indo($transaksi['nominal_transaksi']) : '-'; ?></td>
                                <td><?= $transaksi['tipe_kategori'] === 'Pengeluaran' ? uang_indo($transaksi['nominal_transaksi']) : '-'; ?></td>
                                <td class="saldo-cell" data-nominal="<?= $transaksi['nominal_transaksi']; ?>" data-jenis="<?= $transaksi['tipe_kategori']; ?>"></td>
                                <td>
                                    <a href="<?= BASEURL; ?>/transaksi/edit/<?= $transaksi['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= BASEURL; ?>/transaksi/hapusBank/<?= $transaksi['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
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