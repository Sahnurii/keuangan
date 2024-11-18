<?php 
include("../../inc/koneksi.php");

// Cek apakah ID ada di URL
if (isset($_GET['id_pembantu_kas'])) {
    $id_pembantu_kas = $_GET['id_pembantu_kas'];

    // Hapus data dari tabel
    $sql1 = "DELETE FROM b_pembantu_kas WHERE id_pembantu_kas = '$id_pembantu_kas'";
    $q1 = mysqli_query($koneksi, $sql1);

    // Redirect ke data_pegawai.php setelah proses hapus selesai
    if ($q1) {
        header("Location: data_pembantu_kas.php?sukses=Data berhasil dihapus");
        exit();
    } else {
        header("Location: data_pembantu_kas.php?error=Gagal menghapus data");
        exit();
    }
} else {
    header("Location: data_pembantu_kas.php?error=ID tidak ditemukan");
    exit();
}
