<?php include("../../inc/koneksi.php"); ?>

<?php
$error = "";
$sukses = "";

if (isset($_POST['submit'])) {
    $nama_kategori = $_POST['nama_kategori'];
    $tipe_kategori = $_POST['tipe_kategori'];

    if ($nama_kategori && $tipe_kategori) {
        $sql1 = "INSERT INTO kategori(nama_kategori, tipe_kategori) VALUES ('$nama_kategori', '$tipe_kategori')";
        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses = "Berhasil memasukkan data baru";
        } else {
            $error = "Gagal Memasukkan data baru";
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
    <title> ADD DATA</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
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

        <!-- Horizontal Form -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Tambah Data Kategori</h3>
            </div>
            <!-- /.card-header -->

            <!-- form start -->
            <form action="" method="POST">
                <div class="card-body">
                    <div>
                        <a href="data_kategori.php" class="btn btn-primary">KEMBALI</a>
                    </div>
                    <br>
                    <div class="form-group row">
                        <label for="nama_kategori" class="col-sm-2 col-form-label">NAMA KATEGORI</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Masukkan Nama Kategori">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tipe_kategori" class="col-sm-2 col-form-label">TIPE KATEGORI</label>
                        <div class="col-sm-10">
                        <select class="form-control" id="tipe_kategori" name="tipe_kategori" required>
                                <option value="" selected disabled>-- Pilih Tipe Kategori --</option>
                                <option value="Pemasukan">Pemasukan</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                    </div>
                   
                    <div class="form-group row">
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn-primary btn-lg" name="submit">Tambah</button>
                    </div>
                    <!-- /.card-footer -->
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.container -->

    <!-- Include jQuery -->
    <script src="../../js/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
