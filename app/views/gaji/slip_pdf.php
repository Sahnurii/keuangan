<?php

use Mpdf\Mpdf;

require_once $_SERVER['DOCUMENT_ROOT'] . '/keuangan/public/vendor/autoload.php';

// Data gaji dari database (contoh)
$gaji = $data['gaji'];
$tanggalCetak = date('d/m/Y');
// Ambil periode gaji dari tanggal gaji
$periodeGaji = bulanIndonesia((int)date('m', strtotime($gaji['tanggal']))) . ' ' . date('Y', strtotime($gaji['tanggal']));
$nomorSlip = 'SLIP/' . date('Ym', strtotime($gaji['tanggal'])) . '/' . str_pad($gaji['id'], 4, '0', STR_PAD_LEFT);

// Perhitungan total
$totalPendapatan = $gaji['gaji_pokok'] + $gaji['insentif'] + $gaji['bobot_masa_kerja'] + $gaji['pendidikan'] + $gaji['beban_kerja'];
$totalPemotongan = $gaji['pemotongan'];
$penerimaanBersih = $totalPendapatan - $totalPemotongan;

// Ambil direktur dari data pegawai
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

$mpdf = new Mpdf(['format' => 'A4']);
$mpdf->SetMargins(10, 10, 15);

$imageUrl = 'http://localhost/keuangan/public/img/Logo.png';

$html = '
<style>
    body { font-family: sans-serif; font-size: 10pt; }
    .header { text-align: center; font-size: 14pt; font-weight: bold; }
    .kop { text-align: center; font-size: 11pt; }
    .kop .judul { font-size: 16pt; font-weight: bold; }
    .table, .table th, .table td { border: 1px solid black; border-collapse: collapse; padding: 5px; }
    .bold { font-weight: bold; }
    .center { text-align: center; }
    .right { text-align: right; }
    .gray-bg { background-color: #ccc; font-weight: bold; }
</style>

<table width="100%">
    <tr>
        <td width="10%"><img src="' . $imageUrl . '" width="60"></td>
        <td width="90%" class="kop">
            <div class="header">POLITEKNIK BATULICIN</div>
            <div>Jl. Malewa Raya Komplek Maming One Residence Kel. Batulicin, Kec. Batulicin</div>
            <div>Kab. Tanah Bumbu, Provinsi Kalimantan Selatan Kode Pos 72271</div>
            <div>e-mail: Politeknikbatulicin@gmail.com</div>
        </td>
    </tr>
</table>

<h3 class="center">BUKTI PENERIMAAN GAJI KARYAWAN</h3>

<table class="table" width="100%">
    <tr>
        <td style="border-right: none; width: 20%;">NO</td>
        <td style="border-left: none; width: 30%;">: '. $nomorSlip .'</td>
        <td style="border-right: none; width: 20%;">Ket</td>
        <td style="border-left: none; width: 30%;">: </td>
    </tr>
    <tr>
        <td style="border-right: none; width: 20%;">Nama</td>
        <td style="border-left: none; width: 30%;">: ' . $gaji['nama'] . '</td>
        <td style="border-right: none; width: 20%;">Tgl</td>
        <td style="border-left: none; width: 30%;">: ' . $tanggalCetak . ' </td>
    </tr>
    <tr>
        <td style="border-right: none; width: 20%;">NIPY</td>
        <td style="border-left: none; width: 30%;">: ' . $gaji['nipy'] . '</td>
        <td style="border-right: none; width: 20%;">Periode Gaji</td>
        <td style="border-left: none; width: 30%;">: ' . $periodeGaji . '</td>
    </tr>
    <tr>
        <td style="border-right: none; width: 20%;">Jabatan / Divisi / Bidang</td>
        <td colspan="3" style="border-left: none; width: 30%;">: ' . $gaji['jabatan'] . '</td>
    </tr>
</table>

<br>

<table class="table" width="100%">
    <tr class="gray-bg">
        <td class="center" width="50%"><strong>PENDAPATAN</strong></td>
        <td class="center" width="50%"><strong>PEMOTONGAN</strong></td>
    </tr>
    <tr>
        <td>
            <table width="100%" style="border: none;">
                <tr><td style="border: none;">Gaji Pokok</td><td style="border: none;">:</td><td align="right" style="border: none;">' . uang_indo($gaji['gaji_pokok']) . '</td></tr>
                <tr><td style="border: none;">Insentif</td><td style="border: none;">:</td><td align="right" style="border: none;">' . uang_indo($gaji['insentif']) . '</td></tr>
                <tr><td style="border: none;">Bobot Masa Kerja</td><td style="border: none;">:</td><td align="right" style="border: none;">' . uang_indo($gaji['bobot_masa_kerja']) . '</td></tr>
                <tr><td style="border: none;">Pendidikan</td><td style="border: none;">:</td><td align="right" style="border: none;">' . uang_indo($gaji['pendidikan']) . '</td></tr>
                <tr><td style="border: none;">Beban Kerja</td><td style="border: none;">:</td><td align="right" style="border: none;">' . uang_indo($gaji['beban_kerja']) . '</td></tr>
            </table>
        </td>
        <td class="right" valign="top">
            ' . ($gaji['pemotongan'] > 0 ? uang_indo($gaji['pemotongan']) : '-') . '
        </td>
    </tr>
    <tr class="bold">
        <td>
            <table width="100%">
                <tr>
                    <td style="border: none;"><strong>Total Pendapatan</strong></td><td style="border: none;">:</td>
                    <td align="right" style="border: none;"><strong>' . uang_indo($totalPendapatan) . '</strong></td>
                </tr>
            </table>
        </td>
        <td>
            <table width="100%">
                <tr>
                    <td style="border: none;"><strong>Total Pemotongan</strong></td><td style="border: none;">:</td>
                    <td align="right" style="border: none;"><strong>' . uang_indo($totalPemotongan) . '</strong></td>
                </tr>
            </table>
        </td>
        
    </tr>
</table>


<br>

<table class="table" width="100%">
    <tr class="gray-bg">
        <td class="right" width="50%"><strong>Penerimaan Bersih</strong></td>
        <td class="right" width="50%"><strong>' . uang_indo($penerimaanBersih) . '</strong></td>
    </tr>
</table>

<br>

<table width="100%">
    <tr style="border: none;">
        <td width="50%">
            <table width="100%" style="border: none;">
                <tr>
                    <td style="border: none;">Ditransfer ke</td>
                    <td style="border: none;"></td>
                </tr>
                <tr>
                    <td style="border: none;">Rekening</td>
                    <td style="border: none;">: ' . ($gaji['no_rekening'] ?? '-') . '</td>
                </tr>
                <tr>
                    <td style="border: none;">Bank</td>
                    <td style="border: none;">: ' . ($gaji['bank'] ?? '-') . '</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="border: none;">
        <td class="center">
            <br>
            Direktur<br><br><br><br><br><br><br>
            <strong>' . $namaDirektur . '</strong><br>
            NIPY. ' . $nipyDirektur . '
        </td>

        <td class="center">
            Tanah Bumbu, ' . tglBiasaIndonesia(date('Y-m-d')) . '<br>
            Penerima<br><br><br><br><br><br><br>
            <strong>' . $gaji['nama'] . '</strong><br>
            NIPY. ' . $gaji['nipy'] . '
        </td>
    </tr>
</table>    
';

$mpdf->WriteHTML($html);
$mpdf->Output("Slip_Gaji_" . str_replace(' ', '_', $gaji['nama']) . "_" . $gaji['periode'] . ".pdf", "I");
