<?php
require_once 'lib/fpdf.php';

// Data dinamis
$selectedTahun = $_GET['tahun'] ?? date('Y');
$selectedBulan = $_GET['bulan'] ?? date('m');
$bulanNama = bulanIndonesia((int)$selectedBulan);

$totalPemasukan = $data['total_pemasukan'] ?? 0; // Sesuaikan dengan data yang ada
$totalPengeluaran = $data['total_pengeluaran'] ?? 0;
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
$pdf->Cell(0, 10, 'Laporan Pemasukan & Pengeluaran', 0, 1, 'C');
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

// Tabel Pemasukan & Pengeluaran
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(95, 10, 'PEMASUKAN', 1, 0, 'C');
$pdf->Cell(95, 10, 'PENGELUARAN', 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);
$pdf->Cell(95, 10, uang_indo($totalPemasukan), 1, 0, 'C');
$pdf->Cell(95, 10, uang_indo($totalPengeluaran), 1, 1, 'C');
$pdf->Ln(10);

// Tanda tangan
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 10, '', 0, 1, 'R'); // Spasi
$pdf->Cell(120, 6, '', 0, 0); // Spasi kiri
$pdf->MultiCell(70, 6, 'Tanah Bumbu, ' . tglIndonesia(date('d F Y', strtotime($tgl))) . "\nKabag. Program dan Keuangan,\n\n\n\nNurul Hatmah, S.Pd.\n19911027 202301 2 050", 0, 'R');

// Output PDF
$pdf->Output('I', 'Laporan_Pemasukan_Pengeluaran.pdf');
?>
