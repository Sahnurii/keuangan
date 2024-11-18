<?php include("../../../inc/koneksi.php"); ?>

<?php
$error = "";
$sukses = "";

// Cek apakah saldo awal sudah diinput
$cekSaldo = "SELECT COUNT(*) AS total FROM b_pembantu_bank WHERE jenis_transaksi = 'saldo_awal'";
$result = mysqli_query($koneksi, $cekSaldo);
$row = mysqli_fetch_assoc($result);

if ($row['total'] > 0) {
    $error = "Saldo awal sudah diinput. Tidak dapat diubah.";
}

if (isset($_POST['submit']) && $row['total'] == 0) { // Tambah kondisi untuk cek saldo awal
    $tgl_transaksi = $_POST['tgl_transaksi'];
    $keterangan = $_POST['keterangan'];
    $penerimaan_debit = $_POST['penerimaan_debit'];

    if ($tgl_transaksi && $keterangan && $penerimaan_debit) {
        $sql1 = "INSERT INTO b_pembantu_bank(tgl_transaksi, keterangan, penerimaan_debit, jenis_transaksi) VALUES ('$tgl_transaksi','$keterangan', '$penerimaan_debit', 'saldo_awal')";
        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses = "Berhasil memasukkan data saldo awal";
        } else {
            $error = "Gagal Memasukkan data saldo awal";
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
    <title> Tambah Saldo Awal</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="../../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../../dist/css/adminlte.min.css">
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
                <h3 class="card-title">Tambah Saldo Awal</h3>
            </div>
            <form action="" method="POST">
                <div class="card-body">
                    <div>
                        <a href="../data_pembantu_bank.php" class="btn btn-primary">KEMBALI</a>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="tgl_transaksi" class="col-sm-2 col-form-label">TANGGAL TRANSAKSI</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tgl_transaksi" name="tgl_transaksi" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-2 col-form-label">KETERANGAN/URAIAN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="penerimaan_debit" class="col-sm-2 col-form-label">PENERIMAAN (DEBIT)</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="penerimaan_debit" name="penerimaan_debit" placeholder="Masukkan Debit" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn-primary btn-lg" name="submit">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="../../../js/jquery-3.6.0.min.js"></script>
    <script src="../../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
