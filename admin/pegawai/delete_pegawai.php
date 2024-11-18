<?php 
include("../../inc/koneksi.php");

// Cek apakah ID ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus data dari tabel
    $sql1 = "DELETE FROM pegawai WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);

    // Redirect ke data_pegawai.php setelah proses hapus selesai
    if ($q1) {
        header("Location: data_pegawai.php?sukses=Data berhasil dihapus");
        exit();
    } else {
        header("Location: data_pegawai.php?error=Gagal menghapus data");
        exit();
    }
} else {
    header("Location: data_pegawai.php?error=ID tidak ditemukan");
    exit();
}
