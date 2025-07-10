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
    'Pajak' => $data['saldo_akhir']['Pajak'] ?? 0,
];

$tgl = date('Y-m-d');



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

// Membuat instance FPDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->SetMargins(15, 30, 15);  // Set margin kiri, atas, kanan
$pdf->SetAutoPageBreak(true, 15);  // Set margin bawah dan aktifkan auto page break

$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 25);

// Header
$pdf->Image('img/Logo.png', 15, 30, 12); // Logo
$pdf->Cell(0, 8, 'POLITEKNIK BATULICIN', 0, 1, 'C');
$pdf->Ln(2);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 4, 'Izin Pendirian dari Menteri Pendidikan dan Kebudayaan Republik Indonesia', 0, 1, 'C');
$pdf->Cell(0, 4, 'Nomor : 568/E/O/2014, Tanggal 17 Oktober 2014', 0, 1, 'C');
$pdf->Cell(0, 4, 'Jl. Malewa Raya Komplek Maming One Residence Kel. Batulicin, Kec. Batulicin, Kab. Tanah Bumbu', 0, 1, 'C');
$pdf->Cell(0, 4, 'Prov. Kalimantan Selatan, Kode Pos: 72273, E-mail: Politeknikbatulicin@gmail.com, Website: www.politeknikbatulicin.ac.id', 0, 1, 'C');
$pdf->Ln(5); // Tambahkan jarak sebelumnya
$pdf->SetLineWidth(1.5); // Atur ketebalan garis menjadi 0.5 (default adalah 0.2)
$pdf->Cell(0, 0, '', 'T', 1, 'C');
$pdf->SetLineWidth(0.2); // Kembalikan ke ketebalan default jika diperlukan untuk elemen lain
$pdf->Ln(5); // Tambahkan jarak setelah garis

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

// Menghitung posisi tengah halaman
$pageWidth = $pdf->GetPageWidth();
$colWidth = 45;
$tabelWidth = $colWidth * 4; // Lebar total tabel (kolom1 + kolom2 + kolom3 + kolom4)

// Mengatur margin kiri agar tabel berada di tengah
$leftMargin = ($pageWidth - $tabelWidth) / 2;

// Menentukan posisi kiri untuk seluruh tabel
$pdf->SetX($leftMargin);  // Menempatkan posisi horizontal di tengah halaman

// Header tabel
$pdf->SetX($leftMargin); // Menempatkan posisi kiri untuk tabel
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell($colWidth, 10, 'BUKU KAS', 1, 0, 'C');
$pdf->Cell($colWidth, 10, 'BUKU BANK', 1, 0, 'C');
$pdf->Cell($colWidth, 10, 'BUKU KAS UMUM', 1, 0, 'C');
$pdf->Cell($colWidth, 10, 'BUKU PAJAK', 1, 1, 'C');

// Data tabel
$pdf->SetX($leftMargin); // Menempatkan posisi kiri untuk tabel
$pdf->SetFont('Arial', '', 10);
$pdf->Cell($colWidth, 10, uang_indo($saldoAkhir['Kas']), 1, 0, 'C');
$pdf->Cell($colWidth, 10, uang_indo($saldoAkhir['Bank']), 1, 0, 'C');
$pdf->Cell($colWidth, 10, uang_indo($saldoAkhir['Kas Umum']), 1, 0, 'C');
$pdf->Cell($colWidth, 10, uang_indo($saldoAkhir['Pajak']), 1, 1, 'C');

// Menambahkan jarak sebelum tanda tangan
$pdf->Ln(10);

$tandaTanganSpace = 100; // Estimasi tinggi tanda tangan
if ($pdf->GetY() + $tandaTanganSpace > $pdf->GetPageHeight() - 10) {
    // Jika tidak cukup ruang, buat halaman baru
    $pdf->AddPage();
}
// Tanda tangan
$pdf->Ln(15); // Jarak atas sebelum tanda tangan
$pdf->SetFont('Arial', '', 10);

// Baris lokasi dan tanggal
$pdf->Cell(280, 8, 'Tanah Bumbu, ' . tglIndonesia(date('d F Y', strtotime($tgl))), 0, 1, 'C');
$pdf->Ln(7);

// Kolom tanda tangan
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(95, 8, 'Mengetahui,', 0, 0, 'C'); // Direktur
$pdf->Cell(95, 8, '', 0, 1, 'C');           // Kabag

$pdf->Cell(95, 8, 'Direktur,', 0, 0, 'C');
$pdf->Cell(95, 8, 'Kabag. Program dan Keuangan,', 0, 1, 'C');

$pdf->Ln(20); // Jarak tanda tangan

// Baris nama pejabat
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(95, 8, $namaDirektur, 0, 0, 'C');
$pdf->Cell(95, 8, $namaKabag, 0, 1, 'C');

// Baris NIPY pejabat
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(95, 8, 'NIPY. ' . $nipyDirektur, 0, 0, 'C');
$pdf->Cell(95, 8, 'NIPY. ' . $nipyKabag, 0, 1, 'C');

// Output PDF
$pdf->Output('I', 'Laporan_Saldo.pdf');
