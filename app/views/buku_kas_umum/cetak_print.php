<?php


setlocale(LC_TIME, 'id_ID.utf8');

$selectedTahun = $_GET['tahun'] ?? date('Y'); // Gunakan tahun sekarang jika tidak ada yang dipilih
$selectedBulan = $_GET['bulan'] ?? date('m'); // Gunakan bulan sekarang jika tidak ada yang dipilih

$bulanNama = bulanIndonesia((int)$selectedBulan);
// Format bulan untuk menampilkan nama bulan
// $bulanNama = ucfirst(date('F', strtotime("$selectedTahun-$selectedBulan-01")));
// Ambil data yang sudah disiapkan oleh Controller

?>

<head>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= BASEURL; ?>/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/css/cetak.css" rel="stylesheet">
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
        <h4>Laporan Buku Kas Umum</h4>
        <h4>Bulan : <?= $bulanNama ?> </h4>
    </div>
    <table style="width: 50%; margin: left auto; border: none;">
        <tr>
            <th>Nama Perguruan</th>
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
        <table id="dataTable" class="table table-bordered table-hover" style="width: 100%;">
            <thead>
                <tr>
                    <th rowspan="2" width="1%" class="align-content-center">NO</th>
                    <th rowspan="2" class="text-center align-content-center">TANGGAL</th>
                    <th rowspan="2" class="text-center align-content-center">NO BUKTI</th>
                    <th rowspan="2" class="text-center align-content-center">URAIAN</th>
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
                        <td class="text-center align-content-center"><?= $i++; ?></td>
                        <td class="text-center align-content-center"><?= date('d M Y', strtotime($transaksi['tanggal'])); ?></td>
                        <td class="text-center align-content-center"><?= $transaksi['no_bukti']; ?></td>
                        <td class="text-wrap"><?= $transaksi['keterangan']; ?></td>
                        <td class="text-center align-content-center"><?= $transaksi['tipe_kategori'] === 'Pemasukan' ? uang_indo($transaksi['nominal_transaksi']) : '-'; ?></td>
                        <td class="text-center align-content-center"><?= $transaksi['tipe_kategori'] === 'Pengeluaran' ? uang_indo($transaksi['nominal_transaksi']) : '-'; ?></td>
                        <td class="saldo-cell text-right align-content-center" data-nominal="<?= $transaksi['nominal_transaksi']; ?>" data-jenis="<?= $transaksi['tipe_kategori']; ?>"></td>

                    </tr>
                <?php endforeach; ?>
            <tfoot id="transaksi-body">
                <tr>
                    <th colspan="6" class="text-right align-content-center">SALDO AKHIR BULAN</th>
                    <td class="saldo-cell text-right align-content-center"></td>
                </tr>
            </tfoot>
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

<script>
    window.onload = function() {
        window.print(); // Otomatis cetak saat halaman terbuka
    };
</script>