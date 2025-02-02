<?php 

function uang_indo($angka)
{
    $rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $rupiah;
}

function tglIndonesia($str)
{
    $tr   = trim($str);
    $str    = str_replace(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'), array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'), $tr);
    return $str;
}

function tglLengkapIndonesia($str)
{
    // Array konversi nama hari
    $hari = array(
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    );

    // Array konversi nama bulan
    $bulan = array(
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    );

    // Konversi nama hari dan bulan
    $namaHari = date('l', strtotime($str)); // Nama hari bahasa Inggris
    $namaBulan = date('F', strtotime($str)); // Nama bulan bahasa Inggris

    // Ganti nama hari dan bulan dengan bahasa Indonesia
    $hariIndonesia = $hari[$namaHari] ?? $namaHari;
    $bulanIndonesia = $bulan[$namaBulan] ?? $namaBulan;

    // Format ulang tanggal
    return str_replace(
        array($namaHari, $namaBulan),
        array($hariIndonesia, $bulanIndonesia),
        date('l, d F Y', strtotime($str))
    );
}


function bulanIndonesia($bulan)
{
    $bulanIndo = [
        1 => 'Januari',
        2 => 'Februari',
        3 => 'Maret',
        4 => 'April',
        5 => 'Mei',
        6 => 'Juni',
        7 => 'Juli',
        8 => 'Agustus',
        9 => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember'
    ];
    // Pastikan bulan yang diberikan valid
    if ($bulan >= 1 && $bulan <= 12) {
        return $bulanIndo[$bulan];
    }

    // Jika bulan tidak valid, kembalikan string kosong
    return '';
}