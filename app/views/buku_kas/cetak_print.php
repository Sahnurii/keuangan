<?php


setlocale(LC_TIME, 'id_ID.utf8');

$selectedTahun = $_GET['tahun'] ?? date('Y'); // Gunakan tahun sekarang jika tidak ada yang dipilih
$selectedBulan = $_GET['bulan'] ?? date('m'); // Gunakan bulan sekarang jika tidak ada yang dipilih

// Format bulan untuk menampilkan nama bulan
$bulanNama = ucfirst(date('F', strtotime("$selectedTahun-$selectedBulan-01")));
// Ambil data yang sudah disiapkan oleh Controller

?>

<head>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= BASEURL; ?>/css/sb-admin-2.min.css" rel="stylesheet">
</head>


<div class="card-header">
    <h3 class="card-title text-center ">Laporan Buku Kas</h3>
    <h3 class="card-title text-center ">Bulan : <?= $bulanNama ?> </h3>
</div>
<div class="card-body">
    <table class="table table-bordered" style="width: 50%; margin: left auto;">
        <tr>
            <th>Nama Perguruan Tinggi</th>
            <th>:</th>
            <td>Politeknik Batulicin</td>
        </tr>
        <tr>
            <th>Desa/Kecamatan</th>
            <th>:</th>
            <td>Batulicin</td>
        </tr>
        <tr>
            <th>Kabupaten</th>
            <th>:</th>
            <td>
                Tanah Bumbu
            </td>
        </tr>
        <tr>
            <th>Provinsi</th>
            <th>:</th>
            <td>
                Kalimantan Selatan
            </td>
        </tr>
    </table>

</div>
</div>
<div class="table-responsive">
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

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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
</script>

<!-- <script>
    window.onload = function() {
        window.print(); // Otomatis cetak saat halaman terbuka
    };
</script> -->