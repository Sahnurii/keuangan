<?php


$selectedTahun = $_GET['tahun'] ?? date('Y'); // Gunakan tahun sekarang jika tidak ada yang dipilih
$selectedBulan = $_GET['bulan'] ?? date('m'); // Gunakan bulan sekarang jika tidak ada yang dipilih

// Format bulan untuk menampilkan nama bulan
$bulanNama = bulanIndonesia((int)$selectedBulan);

?>

<head>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= BASEURL; ?>/css/sb-admin-2.min.css" rel="stylesheet">
</head>


<div class="card-header text-center" style="display: flex; align-items: center; border-bottom: 5px solid black; padding-bottom: 15px;">
    <img src="<?= BASEURL; ?>/img/Logo.png" alt="Logo" style="width: 60px; height: auto; margin-right: 15px;">
    <div class="header-text" style="flex-grow: 1;">
        <div><b>
                <font size="5">POLITEKNIK BATULICIN</font>
            </b></div>
        <div>
            <font size="4">Jl. Malewa Raya Komplek Maming One Residence Kel. Batulicin Kec. Batulicin</font>
        </div>
        <div>
            <font size="4">Kab. Tanah Bumbu Prov. Kalimantan Selatan Kode Pos 72271</font>
        </div>
        <div>
            <font size="4">E-mail: Politeknikbatulicin@gmail.com</font>
        </div>
    </div>
</div>
<div class="card-body mt-3 mb-3">
    <div class="card-title text-center ">
        <h4>Laporan Saldo</h4>
        <h4>Bulan : <?= $bulanNama ?> </h4>
    </div>
    <table style="width: 50%; margin: left auto; border: none;">
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

    <div class="table-responsive mt-5">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">BUKU KAS</th>
                    <th class="text-center">BUKU BANK</th>
                    <th class="text-center">BUKU KAS UMUM</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center"><?= uang_indo($data['saldo_akhir']['Kas']); ?></td>
                    <td class="text-center"><?= uang_indo($data['saldo_akhir']['Bank']); ?></td>
                    <td class="text-center"><?= uang_indo($data['saldo_akhir']['Kas Umum']); ?></td>
                </tr>
                <?php $tgl = date('Y-m-d'); ?>
                <table width="100%">
                    <tr>
                        <td align="center"></td>
                        <td align="center" width="200px" style="line-height: 1.5; white-space: nowrap;">
                            <span style="display: inline;">Tanah Bumbu, <?php echo tglIndonesia(date('d F Y', strtotime($tgl))); ?></span>
                            <br />Bendahara,
                            <br /><br /><br />
                            <b><u>Nurul Hatmah, S.Pd.</u><br />19911027 202301 2 050</b>
                        </td>
                    </tr>
                </table>
            </tbody>
        </table>
    </div>
</div>
</div>


<script>
    window.onload = function() {
        window.print(); // Otomatis cetak saat halaman terbuka
    };
</script>