<?php include("../../inc/koneksi.php"); ?>

<?php
$error = "";
$sukses = "";
$tgl_transaksi = "";
$no_bukti = "";
$keterangan = "";
$penerimaan_debit = "";
$pengeluaran_kredit = "";
$id_pembantu_kas = "";

// Ambil data berdasarkan ID saat mengedit
if (isset($_GET['op']) && $_GET['op'] == 'edit') {
    if (isset($_GET['id_pembantu_kas'])) {
        $id_pembantu_kas = $_GET['id_pembantu_kas'];
        $ambildata = "SELECT * FROM b_pembantu_kas WHERE id_pembantu_kas = '$id_pembantu_kas'";
        $q1 = mysqli_query($koneksi, $ambildata);
        $r1 = mysqli_fetch_array($q1);

        if ($r1) {
            $tgl_transaksi = $r1['tgl_transaksi'];
            $no_bukti = $r1['no_bukti'];
            $keterangan = $r1['keterangan'];
            $penerimaan_debit = $r1['penerimaan_debit'];
            $pengeluaran_kredit = $r1['pengeluaran_kredit'];
        } else {
            $error = "Data tidak ditemukan";
        }
    } else {
        $error = "ID tidak ditemukan";
    }
}

// Proses update data saat form disubmit
if (isset($_POST['submit'])) {
    $tgl_transaksi = $_POST['tgl_transaksi'];
    $no_bukti = $_POST['no_bukti'];
    $keterangan = $_POST['keterangan'];
    $penerimaan_debit = $_POST['penerimaan_debit'];
    $pengeluaran_kredit = $_POST['pengeluaran_kredit'];
    $id_pembantu_kas = $_POST['id_pembantu_kas'];

    // Validasi jika data kosong
    if ($tgl_transaksi && $no_bukti && $keterangan && isset($penerimaan_debit) && isset($pengeluaran_kredit)) {

        // Update data ke database
        $sql1 = "UPDATE b_pembantu_kas 
                 SET tgl_transaksi='$tgl_transaksi', 
                     no_bukti='$no_bukti', 
                     keterangan='$keterangan', 
                     penerimaan_debit='$penerimaan_debit', 
                     pengeluaran_kredit='$pengeluaran_kredit'
                 WHERE id_pembantu_kas='$id_pembantu_kas'";
        
        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses = "Berhasil memperbarui data";
            header("Location: data_pembantu_kas.php?sukses=" . urlencode($sukses));
            exit(); // Hentikan eksekusi setelah pengalihan
        } else {
            $error = "Gagal memperbarui data";
        }
    } else {
        $error = "Silahkan Masukkan Semua Data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Data Pembantu Kas</title>

    <!-- Include CSS dependencies -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body>
    <div class="container mt-3">
        <!-- Notifikasi Error -->
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Notifikasi Sukses -->
        <?php if ($sukses): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $sukses; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Edit Data Pembantu Kas</h3>
            </div>
            <!-- Form Edit Data -->
            <form action="" method="POST">
                <div class="card-body">
                    <input type="hidden" name="id_pembantu_kas" value="<?php echo $id_pembantu_kas; ?>">

                    <div class="form-group row">
                        <label for="tgl_transaksi" class="col-sm-2 col-form-label">Tanggal Transaksi</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tgl_transaksi" name="tgl_transaksi" value="<?php echo $tgl_transaksi; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_bukti" class="col-sm-2 col-form-label">No Bukti</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_bukti" name="no_bukti" value="<?php echo $no_bukti; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $keterangan; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="penerimaan_debit" class="col-sm-2 col-form-label">Penerimaan (Debit)</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="penerimaan_debit" name="penerimaan_debit" value="<?php echo $penerimaan_debit; ?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pengeluaran_kredit" class="col-sm-2 col-form-label">Pengeluaran (Kredit)</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="pengeluaran_kredit" name="pengeluaran_kredit" value="<?php echo $pengeluaran_kredit; ?>">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn-primary btn-lg" name="submit">Simpan Perubahan</button>
                        <a href="data_pembantu_kas.php" class="btn btn-secondary btn-block">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Include jQuery dan Bootstrap JS -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
