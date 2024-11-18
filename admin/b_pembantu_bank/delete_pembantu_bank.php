<?php 
include("../../inc/koneksi.php");

// Cek apakah ID ada di URL
if (isset($_GET['id_pembantu_bank'])) {
    $id_pembantu_bank = $_GET['id_pembantu_bank'];

    // Hapus data dari tabel
    $sql1 = "DELETE FROM b_pembantu_bank WHERE id_pembantu_bank = '$id_pembantu_bank'";
    $q1 = mysqli_query($koneksi, $sql1);

    // Redirect ke data_pegawai.php setelah proses hapus selesai
    if ($q1) {
        header("Location: data_pembantu_bank.php?sukses=Data berhasil dihapus");
        exit();
    } else {
        header("Location: data_pembantu_bank.php?error=Gagal menghapus data");
        exit();
    }
} else {
    header("Location: data_pembantu_bank.php?error=ID tidak ditemukan");
    exit();
}
