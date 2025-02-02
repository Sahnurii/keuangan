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
$pdf->Cell(0, 4, 'Prov. Kalimantan Selatan Kode Pos: 72273, E-mail: Politeknikbatulicin@gmail.com, Website: www.politeknikbatulicin.ac.id', 0, 1, 'C');
$pdf->Ln(5); // Tambahkan jarak sebelumnya
$pdf->SetLineWidth(1.5); // Atur ketebalan garis menjadi 0.5 (default adalah 0.2)
$pdf->Cell(0, 0, '', 'T', 1, 'C');
$pdf->SetLineWidth(0.2); // Kembalikan ke ketebalan default jika diperlukan untuk elemen lain
$pdf->Ln(5); // Tambahkan jarak setelah garis

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
$pdf->Cell(115, 10, 'Uraian', 1, 0, 'C', true);
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
$pdf->Cell(115, 8, $data['saldo_kas_keterangan'], 1, 0, 'L'); // Keterangan Kas
$pdf->Cell(30, 8, uang_indo($data['saldo_kas']), 1, 0, 'R'); // Pemasukan Kas
$pdf->Cell(30, 8, '-', 1, 0, 'R'); // Pengeluaran
$pdf->Cell(40, 8, uang_indo($data['saldo_kas']), 1, 1, 'R'); // Saldo

//saldo awal bank
$pdf->Cell(10, 8, $i++, 1, 0, 'C'); // Nomor
$pdf->Cell(30, 8, !empty($data['saldo_bank_tanggal']) ? date('d M Y', strtotime($data['saldo_bank_tanggal'])) : '-', 1, 0, 'C'); // Tanggal Bank
$pdf->Cell(30, 8, '-', 1, 0, 'C'); // No Bukti
$pdf->Cell(115, 8, $data['saldo_bank_keterangan'], 1, 0, 'L'); // Keterangan Bank
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
    $uraianHeight = $pdf->GetStringWidth($transaksi['keterangan']) > 115 
                    ? ceil($pdf->GetStringWidth($transaksi['keterangan']) / 115) * 8 
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
    $pdf->MultiCell(115, 8, $transaksi['keterangan'], 1, 'L');
    $pdf->SetXY($x + 115, $y);

    $pdf->Cell(30, $rowHeight, $pemasukan > 0 ? uang_indo($pemasukan) : '-', 1, 0, 'R');
    $pdf->Cell(30, $rowHeight, $pengeluaran > 0 ? uang_indo($pengeluaran) : '-', 1, 0, 'R');
    $pdf->Cell(40, $rowHeight, uang_indo($saldo), 1, 1, 'R');
}

// Saldo akhir bulan
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(245, 8, 'Saldo Akhir Bulan', 1, 0, 'R', true);
$pdf->Cell(40, 8, uang_indo($saldo), 1, 1, 'R', true);

// Tambahkan jarak sebelum header laporan
$pdf->Ln(5);

// Cek apakah cukup ruang untuk header laporan dan tanda tangan
$requiredSpace = 150; // Estimasi tinggi elemen header laporan dan tanda tangan
if ($pdf->GetY() + $requiredSpace > $pdf->GetPageHeight() - 10) { 
    // Jika tidak cukup ruang, buat halaman baru
    $pdf->AddPage();
}
// Header laporan
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 8, "Pada hari ini, " . tglLengkapIndonesia(date('d F Y')) . ", Buku Kas Umum Ditutup dengan Keadaan atau Posisi Buku sebagai berikut:", 0, 'L');
$pdf->Ln(5); // Tambahkan jarak setelah header

// Data saldo
$saldo_kas = $data['saldo_akhir']['Kas'];
$saldo_bank = $data['saldo_akhir']['Bank'];
$total_saldo_umum = $saldo_kas + $saldo_bank;

// Hitung perbedaan
$perbedaan = $saldo - ($saldo_kas + $saldo_bank);

// Tabel Saldo Buku Kas Umum
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(50, 8, 'Saldo Buku Kas Umum', 0, 1, 'L');

$pdf->Cell(50, 8, 'Terdiri Dari', 0, 0, 'L');
$pdf->Cell(15, 8, ':', 0, 0, 'C');
$pdf->Cell(30, 8, uang_indo($saldo), 0, 1, 'R');

// Saldo Bank
$pdf->Cell(50, 8, '- Saldo Bank', 0, 0, 'L');
$pdf->Cell(15, 8, ':', 0, 0, 'C');
$pdf->Cell(30, 8, uang_indo($saldo_bank), 0, 1, 'R');

// Saldo Kas Tunai
$pdf->Cell(50, 8, '- Saldo Kas Tunai', 0, 0, 'L');
$pdf->Cell(15, 8, ':', 0, 0, 'C');
$pdf->Cell(30, 8, uang_indo($saldo_kas), 0, 1, 'R');

// Total Jumlah
$pdf->Cell(50, 8, 'Jumlah', 0, 0, 'L');
$pdf->Cell(15, 8, ':', 0, 0, 'C');
$pdf->Cell(30, 8, uang_indo($total_saldo_umum), 0, 1, 'R');

// Perbedaan
$pdf->Cell(50, 8, 'Perbedaan', 0, 0, 'L');
$pdf->Cell(15, 8, ':', 0, 0, 'C');
$pdf->Cell(30, 8, uang_indo($perbedaan), 0, 1, 'R');

$tandaTanganSpace = 50; // Estimasi tinggi tanda tangan
if ($pdf->GetY() + $tandaTanganSpace > $pdf->GetPageHeight() - 10) {
    // Jika tidak cukup ruang, buat halaman baru
    $pdf->AddPage();
}
// Tanda tangan
$pdf->Ln(15); // Jarak atas sebelum tanda tangan
$pdf->SetFont('Arial', '', 10);

// Baris lokasi dan tanggal
$pdf->Cell(450, 8, 'Tanah Bumbu, ' . tglIndonesia(date('d F Y', strtotime($tgl))), 0, 1, 'C');
$pdf->Ln(10); // Jarak setelah tanggal

// Kolom tanda tangan
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(90, 8, 'Mengetahui,', 0, 0, 'C'); // Posisi kiri
$pdf->Cell(90, 8, '', 0, 0, 'C');           // Posisi tengah (kosong)
$pdf->Cell(90, 8, '', 0, 1, 'C');           // Posisi kanan (kosong)

// Baris kedua posisi jabatan
$pdf->Cell(90, 8, 'Direktur,', 0, 0, 'C');
$pdf->Cell(90, 8, 'Kabag. Program dan Keuangan,', 0, 0, 'C');
$pdf->Cell(90, 8, 'Bendahara Umum,', 0, 1, 'C');

// Tambahkan jarak untuk tanda tangan
$pdf->Ln(20);

// Baris tanda tangan kosong
$pdf->Cell(90, 8, '', 0, 0, 'C'); // Direktur (kosong untuk tanda tangan)
$pdf->Cell(90, 8, '', 0, 0, 'C'); // Kabag Program dan Keuangan
$pdf->Cell(90, 8, '', 0, 1, 'C'); // Bendahara Umum

// Baris nama pejabat
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(90, 8, 'Drs. H. M. Idjra\'i, M.Pd.', 0, 0, 'C'); // Direktur
$pdf->Cell(90, 8, 'Nurul Hatmah, S.Pd.', 0, 0, 'C');       // Kabag Program dan Keuangan
$pdf->Cell(90, 8, 'Sugeng Ludiyono, S.E., M.M.', 0, 1, 'C'); // Bendahara Umum

// Baris NIP pejabat
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(90, 8, '19590904 201510 1 003', 0, 0, 'C'); // NIP Direktur
$pdf->Cell(90, 8, '19911027 202301 2 050', 0, 0, 'C'); // NIP Kabag Program dan Keuangan
$pdf->Cell(90, 8, '19930914 201910 1 028', 0, 1, 'C'); // NIP Bendahara Umum


// Output PDF
$pdf->Output('I', 'Laporan_Buku_Kas_Umum.pdf');
?>
