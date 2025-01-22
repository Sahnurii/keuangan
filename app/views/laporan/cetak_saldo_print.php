<?php
require_once 'lib/fpdf.php';

// Data dinamis
$selectedTahun = $_GET['tahun'] ?? date('Y');
$selectedBulan = $_GET['bulan'] ?? date('m');
$bulanNama = bulanIndonesia((int)$selectedBulan);

$saldoAkhir = [
    'Kas' => $data['saldo_akhir']['Kas'] ?? 0,
    'Bank' => $data['saldo_akhir']['Bank'] ?? 0,
    'Kas Umum' => $data['saldo_akhir']['Kas Umum'] ?? 0,
];

$tgl = date('Y-m-d');



// Membuat PDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();

// Header
$pdf->SetFont('Arial', 'B', 12);
$pdf->Image('img/Logo.png', 10, 10, 15); // Logo
$pdf->Cell(0, 8, 'POLITEKNIK BATULICIN', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, 'Jl. Malewa Raya Komplek Maming One Residence Kel. Batulicin Kec. Batulicin', 0, 1, 'C');
$pdf->Cell(0, 7, 'Kab. Tanah Bumbu Prov. Kalimantan Selatan Kode Pos 72271', 0, 1, 'C');
$pdf->Cell(0, 7, 'E-mail: Politeknikbatulicin@gmail.com', 0, 1, 'C');
$pdf->Ln(5);
$pdf->Cell(0, 0, '', 'T', 1, 'C');
$pdf->Ln(5);

// Judul
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Laporan Saldo', 0, 1, 'C');
$pdf->Cell(0, 10, 'Bulan : ' . $bulanNama, 0, 1, 'C');
$pdf->Ln(10);

// Informasi
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 7, 'Nama Perguruan Tinggi', 0, 0);
$pdf->Cell(5, 7, ':', 0, 0);
$pdf->Cell(0, 7, 'Politeknik Batulicin', 0, 1);

$pdf->Cell(50, 7, 'Desa/Kecamatan', 0, 0);
$pdf->Cell(5, 7, ':', 0, 0);
$pdf->Cell(0, 7, 'Batulicin', 0, 1);

$pdf->Cell(50, 7, 'Kabupaten', 0, 0);
$pdf->Cell(5, 7, ':', 0, 0);
$pdf->Cell(0, 7, 'Tanah Bumbu', 0, 1);

$pdf->Cell(50, 7, 'Provinsi', 0, 0);
$pdf->Cell(5, 7, ':', 0, 0);
$pdf->Cell(0, 7, 'Kalimantan Selatan', 0, 1);
$pdf->Ln(10);

// Tabel Saldo
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(63, 10, 'BUKU KAS', 1, 0, 'C');
$pdf->Cell(63, 10, 'BUKU BANK', 1, 0, 'C');
$pdf->Cell(64, 10, 'BUKU KAS UMUM', 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(63, 10, uang_indo($saldoAkhir['Kas']), 1, 0, 'C');
$pdf->Cell(63, 10, uang_indo($saldoAkhir['Bank']), 1, 0, 'C');
$pdf->Cell(64, 10, uang_indo($saldoAkhir['Kas Umum']), 1, 1, 'C');
$pdf->Ln(10);

// Tanda Tangan
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, '', 0, 1, 'R'); // Spasi
$pdf->Cell(120, 6, '', 0, 0); // Spasi kiri
$pdf->MultiCell(70, 6, 'Tanah Bumbu, ' . tglIndonesia($tgl) . "\nKabag. Program dan Keuangan,\n\n\n\nNurul Hatmah, S.Pd.\n19911027 202301 2 050", 0, 'C');

// Output PDF
$pdf->Output('I', 'Laporan_Saldo.pdf');
?>
