<?php include("../../inc/koneksi.php"); ?>

<?php
$error = "";
$sukses = "";
$tgl_transaksi = "";
$no_bukti = "";
$keterangan = "";
$penerimaan_debit = "";
$pengeluaran_kredit = "";
$op = "";

if (isset($_GET['op']) && $_GET['op'] == 'edit') {
    $op = 'edit';
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

if (isset($_POST['submit'])) {
    $tgl_transaksi = $_POST['tgl_transaksi'];
    $no_bukti = $_POST['no_bukti'];
    $keterangan = $_POST['keterangan'];
    $penerimaan_debit = $_POST['penerimaan_debit'];
    $pengeluaran_kredit = $_POST['pengeluaran_kredit'];
    $op = $_POST['op'];
    $id_pembantu_kas = $_POST['id_pembantu_kas'];

    if ($tgl_transaksi && isset($no_bukti) && $keterangan && isset($penerimaan_debit) && isset($pengeluaran_kredit)) {
        if ($op == 'edit') {
            $sql1 = "UPDATE b_pembantu_kas SET tgl_transaksi='$tgl_transaksi', no_bukti='$no_bukti', keterangan='$keterangan', penerimaan_debit='$penerimaan_debit', pengeluaran_kredit='$pengeluaran_kredit' WHERE id_pembantu_kas='$id_pembantu_kas'";
        } else {
            $sql1 = "INSERT INTO b_pembantu_bank(tgl_transaksi, no_bukti, keterangan, penerimaan_debit, pengeluaran_kredit) VALUES ('$tgl_transaksi', '$no_bukti', '$keterangan', '$penerimaan_debit', '$pengeluaran_kredit')";
        }
        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses = "Berhasil memperbarui data";
            // Tambahkan pengalihan setelah berhasil memperbarui data
            header("Location: data_pembantu_kas.php?sukses=" . urlencode($sukses));
            exit(); // Pastikan untuk menghentikan eksekusi skrip
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
    <title>EDIT DATA</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-3">
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

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
            <!-- form start -->
            <form action="" method="POST">
                <div class="card-body">
                    <input type="hidden" name="op" value="<?php echo $op; ?>">
                    <input type="hidden" name="id_pembantu_kas" value="<?php echo $id_pembantu_kas; ?>">

                    <div class="form-group row">
                        <label for="tgl_transaksi" class="col-sm-2 col-form-label">TANGGAL TRANSAKSI</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tgl_transaksi" name="tgl_transaksi" value="<?php echo $tgl_transaksi; ?>" placeholder="Masukkan Tanggal" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="no_bukti" class="col-sm-2 col-form-label">NO BUKTI</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_bukti" name="no_bukti" value="<?php echo $no_bukti; ?>" placeholder="No Bukti">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-2 col-form-label">KETERANGAN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $keterangan; ?>" placeholder="keterangan/Uraian" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="penerimaan_debit" class="col-sm-2 col-form-label">PENERIMAAN (DEBIT)</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="penerimaan_debit" name="penerimaan_debit" value="<?php echo $penerimaan_debit; ?>" placeholder="Masukkan Penerimaan (Debit)">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pengeluaran_kredit" class="col-sm-2 col-form-label">PENGELUARAN (KREDIT)</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="pengeluaran_kredit" name="pengeluaran_kredit" value="<?php echo $pengeluaran_kredit; ?>" placeholder="Masukkan Pengeluaran (Kredit)">
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

    <!-- Include jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>