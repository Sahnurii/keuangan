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
    <table class="table table-bordered table-hover">
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


<script>
    window.onload = function() {
        window.print(); // Otomatis cetak saat halaman terbuka
    };
</script>