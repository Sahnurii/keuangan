<?php 
include("../../inc/koneksi.php");

// Cek apakah ID ada di URL
if (isset($_GET['id_kategori'])) {
    $id_kategori = $_GET['id_kategori'];

    // Hapus data dari tabel
    $sql1 = "DELETE FROM kategori WHERE id_kategori = '$id_kategori'";
    $q1 = mysqli_query($koneksi, $sql1);

    // Redirect ke data_pegawai.php setelah proses hapus selesai
    if ($q1) {
        header("Location: data_kategori.php?sukses=Data berhasil dihapus");
        exit();
    } else {
        header("Location: data_kategori.php?error=Gagal menghapus data");
        exit();
    }
} else {
    header("Location: data_kategori.php?error=ID tidak ditemukan");
    exit();
}
