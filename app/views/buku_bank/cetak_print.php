<?php

use Mpdf\Mpdf;

require_once $_SERVER['DOCUMENT_ROOT'] . '/keuangan/public/vendor/autoload.php'; // Panggil library MPDF

setlocale(LC_TIME, 'id_ID.utf8');

// Ambil data yang sudah disiapkan oleh Controller
$selectedTahun = $_GET['tahun'] ?? date('Y'); // Gunakan tahun sekarang jika tidak ada yang dipilih
$selectedBulan = $_GET['bulan'] ?? date('m'); // Gunakan bulan sekarang jika tidak ada yang dipilih

$bulanNama = bulanIndonesia((int)$selectedBulan); // Format bulan untuk menampilkan nama bulan
$tgl = date('Y-m-d'); // Tanggal hari ini

// Membuat instance MPDF
$mpdf = new \Mpdf\Mpdf([
    'orientation' => 'L',   // Landscape orientation
    'format' => 'A4'
]);
$mpdf->SetMargins(5, 30, 30);

$imageUrl = 'http://localhost/keuangan/public/img/Logo.png';

$html = '<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; font-size: 10pt; }
        .header { text-align: center; font-size: 14pt; font-weight: bold; }
        .sub-header { text-align: center; font-size: 10pt; }
        .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .table th, .table td { border: 1px solid black; padding: 5px; text-align: center; }
        .footer { text-align: center; font-size: 10pt; margin-top: 30px; }
        .signature-table { page-break-inside: avoid; }
        .spacer { margin-top: 20px; }
        .saldo-akhir {
            background-color:rgb(187, 189, 188); /* Warna hijau muda */
            font-weight: bold;
        }

    </style>
</head>
<body>
<table width="100%">
    <tr>
        <td width="10%" style="text-align: left;">
            <img src="' . $imageUrl . '" width="50">
        </td>
        <td width="90%" style="text-align: center; padding-left: -100px;">
            <div class="header" style="font-size: 33pt;">POLITEKNIK BATULICIN</div>
            <div class="sub-header">Izin Pendirian dari Menteri Pendidikan dan Kebudayaan Republik Indonesia</div>
            <div class="sub-header">Nomor : 568/E/O/2014, Tanggal 17 Oktober 2014</div>
            <div class="sub-header">Jl. Malewa Raya Komplek Maming One Residence Kel. Batulicin, Kec. Batulicin, Kab. Tanah Bumbu</div>
            <div class="sub-header">Prov. Kalimantan Selatan, Kode Pos: 72273, E-mail: Politeknikbatulicin@gmail.com, Website: www.politeknikbatulicin.ac.id</div>
        </td>
    </tr>
</table>
<hr style="height: 5px; background-color: black; border: none;">

<div class="spacer"></div>    
<div class="header" style="font-size: 15pt;">Laporan Buku Pembantu Bank</div>
    <div class="sub-header" style="font-weight: bold; font-size: 15pt;">Periode: ' . $bulanNama . ' ' . $selectedTahun . '</div>
    <div class="spacer"></div>';

$html .= '<table width="100%">
            <tr>
                <td width="10%">Nama Perguruan Tinggi</td>
                <td width="5%">:</td>
                <td width="75%">Politeknik Batulicin</td>
            </tr>
            <tr>
                <td>Desa/Kecamatan</td>
                <td>:</td>
                <td>Batulicin</td>
            </tr>
            <tr>
                <td>Kabupaten</td>
                <td>:</td>
                <td>Tanah Bumbu</td>
            </tr>
            <tr>
                <td>Provinsi</td>
                <td>:</td>
                <td>Kalimantan Selatan</td>
            </tr>
        </table>
        <br><br>';

$html .= '<div class="spacer"></div>
    <table class="table">
        <thead>
            <tr class="saldo-akhir">
                <th>No</th>
                <th>Tanggal</th>
                <th>No Bukti</th>
                <th>Uraian</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>';

$saldo = $data['saldo_awal'];
$i = 1;
$html .= '<tr>
            <td>' . $i++ . '</td>
            <td>' . (!empty($data['saldo_awal_tanggal']) ? date('d M Y', strtotime($data['saldo_awal_tanggal'])) : '-') . '</td>
            <td>-</td>
            <td style="text-align: left;">' . $data['saldo_awal_keterangan'] . '</td>
            <td>' . uang_indo($data['saldo_awal']) . '</td>
            <td>-</td>
            <td>' . uang_indo($saldo) . '</td>
        </tr>';
foreach ($data['transaksi'] as $transaksi) {
    $pemasukan = $transaksi['tipe_kategori'] === 'Pemasukan' ? $transaksi['nominal_transaksi'] : 0;
    $pengeluaran = $transaksi['tipe_kategori'] === 'Pengeluaran' ? $transaksi['nominal_transaksi'] : 0;
    $saldo += $pemasukan - $pengeluaran;

    $html .= '<tr>
                                <td>' . $i++ . '</td>
                                <td>' . date('d M Y', strtotime($transaksi['tanggal'])) . '</td>
                                <td >' . $transaksi['no_bukti'] . '</td>
                                <td style="text-align: left;">' . $transaksi['keterangan'] . '</td>
                                <td>' . ($pemasukan > 0 ? uang_indo($pemasukan) : '-') . '</td>
                                <td>' . ($pengeluaran > 0 ? uang_indo($pengeluaran) : '-') . '</td>
                                <td>' . uang_indo($saldo) . '</td>
                            </tr>';
}

$html .= '   <tr class="saldo-akhir">
                                <td colspan="6" style="text-align: right; font-weight: bold;">Saldo Akhir Bulan</td>
                                <td style="font-weight: bold;">' . uang_indo($saldo) . '</td>
                            </tr>
                        </tbody>
                    </table>';

// Tambahkan pemisah halaman jika bagian berikutnya tidak muat
$html .= '<div style="page-break-before: always;"></div>';

$html .= '<br><br>'; // Tambahkan jarak sebelum bagian baru
$html .= "<p>Pada hari ini, " . tglLengkapIndonesia(date('d F Y')) . ", Buku Pembantu Bank Ditutup dengan Saldo Akhir Sebesar " . uang_indo($saldo) . "</p><br>";


$direktur = null;
$kabag = null;

foreach ($data['pegawai'] as $pgw) {
    foreach ($pgw['jabatan_bidang'] as $jab) {
        if (stripos($jab['jabatan'], 'direktur') !== false) {
            $direktur = $pgw;
        } elseif (stripos($jab['jabatan'], 'kabag') !== false && stripos($jab['jabatan'], 'keuangan') !== false) {
            $kabag = $pgw;
        }
    }
}
$namaDirektur = $direktur['nama'] ?? 'Direktur';
$nipyDirektur = $direktur['nipy'] ?? '-';

$namaKabag = $kabag['nama'] ?? 'Kabag. Keuangan';
$nipyKabag = $kabag['nipy'] ?? '-';

$html .= '<br><br><table class="signature-table" width="100%" border="0" cellpadding="5" align="center">
    <tr>
        <td></td>
        <td align="center">Tanah Bumbu, ' . tglIndonesia(date('d F Y', strtotime($tgl))) . '</td>
    </tr>
    <tr>
        <td align="center">Mengetahui,</td>
        <td align="center"></td>
    </tr>
    <tr>
        <td align="center">Direktur,</td>
        <td align="center">Kabag. Program dan Keuangan,</td>
    </tr>
    <tr><td colspan="2" height="100"></td></tr>
    <tr>
        <td align="center"><strong>' . $namaDirektur . '</strong></td>
        <td align="center"><strong>' . $namaKabag . '</strong></td>
    </tr>
    <tr>
        <td align="center">NIPY. ' . $nipyDirektur . '</td>
        <td align="center">NIPY. ' . $nipyKabag . '</td>
    </tr>
</table>';

$html .= '</body>
            </html>';


$mpdf->WriteHTML($html);
$mpdf->Output('Laporan_Buku_Pembantu_Bank.pdf', 'I');
