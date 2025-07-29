<?php
require_once 'lib/fpdf.php';

setlocale(LC_TIME, 'id_ID.utf8');
// Ambil data yang sudah disiapkan oleh Controller
$selectedTahun = $_GET['tahun'] ?? date('Y'); // Gunakan tahun sekarang jika tidak ada yang dipilih
$selectedBulan = $_GET['bulan'] ?? date('m'); // Gunakan bulan sekarang jika tidak ada yang dipilih

$bulanNama = bulanIndonesia((int)$selectedBulan);

$totalPemasukan = $data['total_pemasukan'] ?? 0;
$totalPengeluaran = $data['total_pengeluaran'] ?? 0;
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
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->SetMargins(5, 30, 10);  // Set margin kiri, atas, kanan
$pdf->SetAutoPageBreak(true, 10);  // Set margin bawah dan aktifkan auto page break

$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 35);

// Header
$pdf->Image('img/Logo.png', 15, 30, 15); // Logo
$pdf->Cell(0, 8, 'POLITEKNIK BATULICIN', 0, 1, 'C');
$pdf->Ln(4);
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(0, 4, 'Izin Pendirian dari Menteri Pendidikan dan Kebudayaan Republik Indonesia', 0, 1, 'C');
$pdf->Cell(0, 4, 'Nomor : 568/E/O/2014, Tanggal 17 Oktober 2014', 0, 1, 'C');
$pdf->Cell(0, 4, 'Jl. Malewa Raya Komplek Maming One Residence Kel. Batulicin, Kec. Batulicin, Kab. Tanah Bumbu', 0, 1, 'C');
$pdf->Cell(0, 4, 'Prov. Kalimantan Selatan, Kode Pos: 72273, E-mail: Politeknikbatulicin@gmail.com, Website: www.politeknikbatulicin.ac.id', 0, 1, 'C');
$pdf->Ln(5); // Tambahkan jarak sebelumnya
$pdf->SetLineWidth(1.5); // Atur ketebalan garis menjadi 0.5 (default adalah 0.2)
$pdf->Cell(0, 0, '', 'T', 1, 'C');
$pdf->SetLineWidth(0.2); // Kembalikan ke ketebalan default jika diperlukan untuk elemen lain
$pdf->Ln(5); // Tambahkan jarak setelah garis

// Judul Laporan

// Panjang masing-masing kolom
$colKategoriWidth = 95;
$colNominalWidth = 40;

// Total tabel: 2 kategori + 2 nominal
$totalTableWidth = ($colKategoriWidth + $colNominalWidth) * 2; // 270

$pageWidth = $pdf->GetPageWidth(); // Biasanya 297 untuk landscape A4
$leftMargin = ($pageWidth - $totalTableWidth) / 2; // Misalnya 13.5
// === Perhitungan posisi tengah untuk tanda tangan 2 kolom ===
$tandaTanganLebar = 95 * 2; // 190 mm
$halamanLebar = $pdf->GetPageWidth(); // 297 mm untuk A4 landscape
$posisiTengah = ($halamanLebar - $tandaTanganLebar) / 2; // misal: 53.5

$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Laporan Pemasukan & Pengeluaran', 0, 1, 'C');
$pdf->Cell(0, 10, 'Periode: ' . $bulanNama. ' ' . $selectedTahun, 0, 1, 'C');
$pdf->Ln(10);; // Tabel Rincian Pemasukan dan Pengeluaran
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX($leftMargin);
$pdf->Cell(135, 10, 'PEMASUKAN', 1, 0, 'C');
$pdf->Cell(135, 10, 'PENGELUARAN', 1, 1, 'C');

// Rincian Pemasukan dan Pengeluaran
$pdf->SetFont('Arial', '', 10);
// Menentukan jumlah baris maksimum antara pemasukan dan pengeluaran
$maxRows = max(count($data['rincian_pemasukan']), count($data['rincian_pengeluaran']));

// Ambil data pemasukan dan pengeluaran
$pemasukanKeys = array_keys($data['rincian_pemasukan']);
$pengeluaranKeys = array_keys($data['rincian_pengeluaran']);


// Loop berdasarkan jumlah baris maksimum
for ($i = 0; $i < $maxRows; $i++) {
    $pemasukanKategori = $pemasukanKeys[$i] ?? ''; // Ambil key kategori pemasukan
    $pemasukanNominal = $data['rincian_pemasukan'][$pemasukanKategori] ?? 0; // Ambil nominal pemasukan

    $pengeluaranKategori = $pengeluaranKeys[$i] ?? ''; // Ambil key kategori pengeluaran
    $pengeluaranNominal = $data['rincian_pengeluaran'][$pengeluaranKategori] ?? 0; // Ambil nominal pengeluaran

    $cellWidth = 95;
    $lineHeight = 8;

    // Hitung tinggi MultiCell berdasarkan jumlah baris yang dibutuhkan
    $pemasukanLines = ceil($pdf->GetStringWidth($pemasukanKategori) / $cellWidth);
    $pengeluaranLines = ceil($pdf->GetStringWidth($pengeluaranKategori) / $cellWidth);

    // Pastikan minimal 1 baris
    $pemasukanLines = max(1, $pemasukanLines);
    $pengeluaranLines = max(1, $pengeluaranLines);

    // Tentukan tinggi baris terbesar
    $rowHeight = max($pemasukanLines, $pengeluaranLines) * $lineHeight;

    // Cek apakah tabel akan melebihi batas halaman
    if ($pdf->GetY() + $rowHeight > $pdf->GetPageHeight() - 20) {
        $pdf->AddPage(); // Tambahkan halaman baru jika terlalu panjang
    }

    // Set posisi X ke tengah
    $pdf->SetX($leftMargin);

    // Output kategori pemasukan (MultiCell)
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell($cellWidth, $rowHeight, $pemasukanKategori, 1, 'L');
    $pdf->SetXY($x + $cellWidth, $y);

    // Output nominal pemasukan
    $pdf->Cell(40, $rowHeight, uang_indo($pemasukanNominal), 1, 0, 'R');

    // Output kategori pengeluaran (MultiCell)
    $x = $pdf->GetX();
    $y = $pdf->GetY();
    $pdf->MultiCell($cellWidth, $lineHeight, $pengeluaranKategori, 1, 'L');
    $pdf->SetXY($x + $cellWidth, $y);

    // Output nominal pengeluaran
    $pdf->Cell(40, $rowHeight, uang_indo($pengeluaranNominal), 1, 1, 'R');
}


// Total Pemasukan dan Pengeluaran
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX($leftMargin);
$pdf->Cell(95, 8, 'Total Pemasukan', 1);
$pdf->Cell(40, 8, uang_indo($totalPemasukan), 1, 0, 'R');
$pdf->Cell(95, 8, 'Total Pengeluaran', 1);
$pdf->Cell(40, 8, uang_indo($totalPengeluaran), 1, 1, 'R');

$tandaTanganSpace = 80; // Estimasi tinggi tanda tangan
if ($pdf->GetY() + $tandaTanganSpace > $pdf->GetPageHeight() - 10) {
    // Jika tidak cukup ruang, buat halaman baru
    $pdf->AddPage();
}
// Tanda tangan
$pdf->Ln(15); // Jarak atas sebelum tanda tangan
$pdf->SetFont('Arial', '', 10);


// Baris lokasi dan tanggal
$pdf->SetX($posisiTengah);
$pdf->Cell(190, 8, 'Tanah Bumbu, ' . tglIndonesia(date('d F Y', strtotime($tgl))), 0, 1, 'C');
$pdf->Ln(7);

// Kolom tanda tangan
$pdf->SetFont('Arial', '', 10);
$pdf->SetX($posisiTengah);
$pdf->Cell(95, 8, 'Mengetahui,', 0, 0, 'C'); // Direktur
$pdf->Cell(95, 8, '', 0, 1, 'C');           // Kabag

$pdf->SetX($posisiTengah);
$pdf->Cell(95, 8, 'Direktur,', 0, 0, 'C');
$pdf->Cell(95, 8, 'Kabag. Program dan Keuangan,', 0, 1, 'C');

$pdf->Ln(20); // Jarak tanda tangan

// Baris nama pejabat
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetX($posisiTengah);
$pdf->Cell(95, 8, $namaDirektur, 0, 0, 'C');
$pdf->Cell(95, 8, $namaKabag, 0, 1, 'C');

// Baris NIP pejabat
$pdf->SetFont('Arial', '', 10);
$pdf->SetX($posisiTengah);
$pdf->Cell(95, 8, 'NIPY. ' . $nipyDirektur, 0, 0, 'C');
$pdf->Cell(95, 8, 'NIPY. ' . $nipyKabag, 0, 1, 'C');

// Output PDF
$pdf->Output('I', 'Laporan_Pemasukan_Pengeluaran.pdf');
