<?php
require_once 'lib/fpdf.php'; // Panggil library FPDF

setlocale(LC_TIME, 'id_ID.utf8');

// Ambil data yang sudah disiapkan oleh Controller
$selectedTahun = $_GET['tahun'] ?? date('Y'); // Gunakan tahun sekarang jika tidak ada yang dipilih
$selectedBulan = $_GET['bulan'] ?? date('m'); // Gunakan bulan sekarang jika tidak ada yang dipilih

$bulanNama = bulanIndonesia((int)$selectedBulan); // Format bulan untuk menampilkan nama bulan
$tgl = date('Y-m-d'); // Tanggal hari ini

// Membuat instance FPDF
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Header
$pdf->Image('img/Logo.png', 10, 10, 15); // Logo
$pdf->Cell(0, 8, 'POLITEKNIK BATULICIN', 0, 1, 'C');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 7, 'Jl. Malewa Raya Komplek Maming One Residence Kel. Batulicin Kec. Batulicin', 0, 1, 'C');
$pdf->Cell(0, 7, 'Kab. Tanah Bumbu Prov. Kalimantan Selatan Kode Pos 72271', 0, 1, 'C');
$pdf->Cell(0, 7, 'E-mail: Politeknikbatulicin@gmail.com', 0, 1, 'C');
$pdf->Ln(5);
$pdf->Cell(0, 0, '', 'T', 1, 'C');
$pdf->Ln(5);

// Judul laporan
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 8, 'Laporan Buku Kas Umum', 0, 1, 'C');
$pdf->Cell(0, 8, 'Bulan: ' . $bulanNama, 0, 1, 'C');
$pdf->Ln(5);

// Informasi tambahan
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(50, 7, 'Nama Perguruan', 0, 0);
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

// Header tabel
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(200, 200, 200);
$pdf->Cell(10, 10, 'No', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Tanggal', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'No Bukti', 1, 0, 'C', true);
$pdf->Cell(100, 10, 'Uraian', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Pemasukan', 1, 0, 'C', true);
$pdf->Cell(30, 10, 'Pengeluaran', 1, 0, 'C', true);
$pdf->Cell(40, 10, 'Saldo', 1, 1, 'C', true);

// Data transaksi
$pdf->SetFont('Arial', '', 10);
$saldo = $data['saldo_awal']; // Ambil saldo awal dari data
$i = 1;

//saldo awal kas
$pdf->Cell(10, 8, $i++, 1, 0, 'C'); // Nomor
$pdf->Cell(30, 8, !empty($data['saldo_kas_tanggal']) ? date('d M Y', strtotime($data['saldo_kas_tanggal'])) : '-', 1, 0, 'C'); // Tanggal Kas
$pdf->Cell(30, 8, '-', 1, 0, 'C'); // No Bukti
$pdf->Cell(100, 8, $data['saldo_kas_keterangan'], 1, 0, 'L'); // Keterangan Kas
$pdf->Cell(30, 8, uang_indo($data['saldo_kas']), 1, 0, 'R'); // Pemasukan Kas
$pdf->Cell(30, 8, '-', 1, 0, 'R'); // Pengeluaran
$pdf->Cell(40, 8, uang_indo($data['saldo_kas']), 1, 1, 'R'); // Saldo

//saldo awal bank
$pdf->Cell(10, 8, $i++, 1, 0, 'C'); // Nomor
$pdf->Cell(30, 8, !empty($data['saldo_bank_tanggal']) ? date('d M Y', strtotime($data['saldo_bank_tanggal'])) : '-', 1, 0, 'C'); // Tanggal Bank
$pdf->Cell(30, 8, '-', 1, 0, 'C'); // No Bukti
$pdf->Cell(100, 8, $data['saldo_bank_keterangan'], 1, 0, 'L'); // Keterangan Bank
$pdf->Cell(30, 8, uang_indo($data['saldo_bank']), 1, 0, 'R'); // Pemasukan Bank
$pdf->Cell(30, 8, '-', 1, 0, 'R'); // Pengeluaran
$pdf->Cell(40, 8, uang_indo($data['saldo_bank']), 1, 1, 'R'); // Saldo


// Perbarui saldo total
$saldo = $data['saldo_kas'] + $data['saldo_bank'];

foreach ($data['transaksi'] as $transaksi) {
    $pemasukan = $transaksi['tipe_kategori'] === 'Pemasukan' ? $transaksi['nominal_transaksi'] : 0;
    $pengeluaran = $transaksi['tipe_kategori'] === 'Pengeluaran' ? $transaksi['nominal_transaksi'] : 0;
    $saldo += $pemasukan - $pengeluaran;

    // Tentukan tinggi maksimum berdasarkan kolom "Uraian"
    $uraianHeight = $pdf->GetStringWidth($transaksi['keterangan']) > 100 
                    ? ceil($pdf->GetStringWidth($transaksi['keterangan']) / 100) * 8 
                    : 8;

    // Tentukan tinggi maksimum dari semua kolom (jika ada kolom lain yang lebih tinggi)
    $rowHeight = max(8, $uraianHeight);

    // Output semua kolom
    $pdf->Cell(10, $rowHeight, $i++, 1, 0, 'C');
    $pdf->Cell(30, $rowHeight, date('d M Y', strtotime($transaksi['tanggal'])), 1, 0, 'C');
    $pdf->Cell(30, $rowHeight, $transaksi['no_bukti'], 1, 0, 'C');

    // Output kolom "Uraian" dengan MultiCell
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell(100, 8, $transaksi['keterangan'], 1, 'L');
    $pdf->SetXY($x + 100, $y);

    $pdf->Cell(30, $rowHeight, $pemasukan > 0 ? uang_indo($pemasukan) : '-', 1, 0, 'R');
    $pdf->Cell(30, $rowHeight, $pengeluaran > 0 ? uang_indo($pengeluaran) : '-', 1, 0, 'R');
    $pdf->Cell(40, $rowHeight, uang_indo($saldo), 1, 1, 'R');
}


// Saldo akhir bulan
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(230, 8, 'Saldo Akhir Bulan', 1, 0, 'R', true);
$pdf->Cell(40, 8, uang_indo($saldo), 1, 1, 'R', true);

// Tanda tangan
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, 'Tanah Bumbu, ' . tglIndonesia(date('d F Y', strtotime($tgl))), 0, 1, 'R');
$pdf->Cell(0, 8, 'Kabag. Program dan Keuangan,', 0, 1, 'R');
$pdf->Ln(15);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 8, 'Nurul Hatmah, S.Pd.', 0, 1, 'R');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 8, '19911027 202301 2 050', 0, 1, 'R');

// Output PDF
$pdf->Output('I', 'Laporan_Buku_Kas_Umum.pdf');
?>
