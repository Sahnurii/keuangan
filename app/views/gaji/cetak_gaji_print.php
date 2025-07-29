<?php
// require_once 'vendor/autoload.php'; // sesuaikan dengan path mPDF Anda

$bulanNama = bulanIndonesia((int)$data['bulan']);
$tahun = $data['tahun'];
$tanggalCetak = date('d F Y');
$gaji = $data['gaji'];

$mpdf = new \Mpdf\Mpdf([
    'orientation' => 'L',   // Landscape orientation
    'format' => 'A4'
]);
// $stylesheet = file_get_contents('css/mpdf-custom.css'); // Jika Anda punya file CSS
$mpdf->SetMargins(5, 30, 30);

$imageUrl = 'http://localhost/keuangan/public/img/Logo.png';

$html = '
<style>
    body { font-family: Arial, sans-serif; font-size: 10pt; }
    .header { text-align: center; font-size: 14pt; font-weight: bold; }
    .sub-header { text-align: center; font-size: 10pt; }
    .table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    .table th, .table td { border: 1px solid black; padding: 5px; text-align: center; }
    .signature-table { page-break-inside: avoid; }
    .spacer { margin-top: 20px; }
</style>

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
<div class="header" style="font-size: 15pt;">LAPORAN GAJI PEGAWAI</div>
    <div class="sub-header" style="font-weight: bold; font-size: 15pt;">Periode: ' . $bulanNama . ' ' . $tahun . '</div>
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
        <br><br>

<div class="spacer"></div>

    <table class="table">
    <thead>
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
    <tbody>';

$total_gaji_pokok = 0;
$total_insentif = 0;
$total_bobot_masa_kerja = 0;
$total_pendidikan = 0;
$total_beban_kerja = 0;
$total_pemotongan = 0;
$total_total_gaji = 0;



$no = 1;
foreach ($gaji as $g) {
    
    $totalGaji = ($g['gaji_pokok'] + $g['insentif'] + $g['bobot_masa_kerja'] + $g['pendidikan'] + $g['beban_kerja']) - $g['pemotongan'];
    $total_gaji_pokok += $g['gaji_pokok'];
    $total_insentif += $g['insentif'];
    $total_bobot_masa_kerja += $g['bobot_masa_kerja'];
    $total_pendidikan += $g['pendidikan'];
    $total_beban_kerja += $g['beban_kerja'];
    $total_pemotongan += $g['pemotongan'];
    $total_total_gaji += $totalGaji;

    $html .= '
        <tr>
            <td>' . $no++ . '</td>
            <td>' . tglSingkatIndonesia($g['tanggal']) . '</td>
            <td>' . $g['nama'] . '</td>
            <td>' . uang_indo($g['gaji_pokok']) . '</td>
            <td>' . uang_indo($g['insentif']) . '</td>
            <td>' . uang_indo($g['bobot_masa_kerja']) . '</td>
            <td>' . uang_indo($g['pendidikan']) . '</td>
            <td>' . uang_indo($g['beban_kerja']) . '</td>
            <td>' . uang_indo($g['pemotongan']) . '</td>
            <td>' . uang_indo($totalGaji) . '</td>
        </tr>';
}


$html .= '
    </tbody>
    <tfoot>
        <tr style="font-weight:bold; background-color: #eee;">
            <td colspan="3">Total</td>
            <td>' . uang_indo($total_gaji_pokok) . '</td>
            <td>' . uang_indo($total_insentif) . '</td>
            <td>' . uang_indo($total_bobot_masa_kerja) . '</td>
            <td>' . uang_indo($total_pendidikan) . '</td>
            <td>' . uang_indo($total_beban_kerja) . '</td>
            <td>' . uang_indo($total_pemotongan) . '</td>
            <td>' . uang_indo($total_total_gaji) . '</td>
        </tr>
    </tfoot>
</table>';




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

// Tambahkan pemisah halaman jika bagian berikutnya tidak muat
$html .= '<div style="page-break-before: always;"></div>

<br><br><table class="signature-table" width="100%" border="0" cellpadding="5" align="center">
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
    <tr><td colspan="2" height="100"></td></tr> <!-- Jarak untuk tanda tangan -->
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

// $mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);
$mpdf->WriteHTML($html);
$mpdf->Output('Laporan_Gaji_' . $bulanNama . '_' . $tahun . '.pdf', 'I');
