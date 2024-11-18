<?php include("../../inc/koneksi.php"); ?>

<?php
$error = "";
$sukses = "";
$nama_kategori = "";
$tipe_kategori = "";
$id_kategori = "";

// Ambil data berdasarkan ID saat mengedit
if (isset($_GET['op']) && $_GET['op'] == 'edit') {
    if (isset($_GET['id_kategori'])) {
        $id_kategori = $_GET['id_kategori'];
        $ambildata = "SELECT * FROM kategori WHERE id_kategori = '$id_kategori'";
        $q1 = mysqli_query($koneksi, $ambildata);
        $r1 = mysqli_fetch_array($q1);

        if ($r1) {
            $nama_kategori = $r1['nama_kategori'];
            $tipe_kategori = $r1['tipe_kategori'];
           
        } else {
            $error = "Data tidak ditemukan";
        }
    } else {
        $error = "ID tidak ditemukan";
    }
}

// Proses update data saat form disubmit
if (isset($_POST['submit'])) {
    $nama_kategori = $_POST['nama_kategori'];
    $tipe_kategori = $_POST['tipe_kategori'];
    $id_kategori = $_POST['id_kategori'];

    // Validasi jika data kosong
    if ($nama_kategori && $tipe_kategori ) {

        // Update data ke database
        $sql1 = "UPDATE kategori 
                 SET nama_kategori='$nama_kategori', 
                     tipe_kategori='$tipe_kategori' 
                    
                 WHERE id_kategori='$id_kategori'";
        
        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses = "Berhasil memperbarui data";
            header("Location: data_kategori.php?sukses=" . urlencode($sukses));
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
    <title>Edit Data Kategori</title>

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
                <h3 class="card-title">Edit Data Kategori</h3>
            </div>
            <!-- Form Edit Data -->
            <form action="" method="POST">
                <div class="card-body">
                    <input type="hidden" name="id_kategori" value="<?php echo $id_kategori; ?>">

                    <div class="form-group row">
                        <label for="nama_kategori" class="col-sm-2 col-form-label">Nama Kategori</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?php echo $nama_kategori; ?>" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tipe_kategori" class="col-sm-2 col-form-label">Tipe Kategori</label>
                        <div class="col-sm-10">
                        <select class="form-control" id="tipe_kategori"  name="tipe_kategori" required>
                                <option value="" selected disabled><?php echo $tipe_kategori; ?></option>
                                <option value="Pemasukan">Pemasukan</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                    </div>
                   
                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn-primary btn-lg" name="submit">Simpan Perubahan</button>
                        <a href="data_kategori.php" class="btn btn-secondary btn-block">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
