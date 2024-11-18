<?php include("../../inc/koneksi.php"); ?>

<?php 
$error = "";
$sukses = "";
$nama = "";
$nipy = "";
$bidang = "";
$op = "";

if (isset($_GET['op']) && $_GET['op'] == 'edit') {
    $op = 'edit';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        // Ganti nama tabel ke pegawai
        $ambildata = "SELECT * FROM pegawai WHERE id = '$id'";
        $q1 = mysqli_query($koneksi, $ambildata);
        $r1 = mysqli_fetch_array($q1);

        if ($r1) {
            $nama = $r1['nama']; // Ubah sesuai kolom yang benar
            $nipy = $r1['nipy']; // Ubah sesuai kolom yang benar
            $bidang = $r1['bidang']; // Ubah sesuai kolom yang benar
        } else {
            $error = "Data tidak ditemukan";
        }
    } else {
        $error = "ID tidak ditemukan";
    }
}

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $nipy = $_POST['nipy'];
    $bidang = $_POST['bidang'];
    $op = $_POST['op'];
    $id = $_POST['id'];

    if ($nama && $nipy && $bidang) {
        if ($op == 'edit') {
            $sql1 = "UPDATE pegawai SET nama='$nama', nipy='$nipy', bidang='$bidang' WHERE id='$id'";
        } else {
            $sql1 = "INSERT INTO pegawai(nama, nipy, bidang) VALUES ('$nama', '$nipy', '$bidang')";
        }
        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses = "Berhasil memperbarui data";
                // Tambahkan pengalihan setelah berhasil memperbarui data
            header("Location: data_pegawai.php?sukses=" . urlencode($sukses));
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
                <h3 class="card-title">Edit Data Pegawai</h3>
            </div>
            <!-- form start -->
            <form action="" method="POST">
                <div class="card-body">
                    <input type="hidden" name="op" value="<?php echo $op; ?>">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    
                    <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">NAMA</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>" placeholder="Masukkan Nama" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nipy" class="col-sm-2 col-form-label">NIPY</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="nipy" name="nipy" value="<?php echo $nipy; ?>" placeholder="NIPY" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="bidang" class="col-sm-2 col-form-label">BIDANG/JABATAN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="bidang" name="bidang" value="<?php echo $bidang; ?>" placeholder="Bidang/Jabatan" required>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-block btn-primary btn-lg" name="submit">Simpan Perubahan</button>
                        <a href="data_pegawai.php" class="btn btn-secondary btn-block">Kembali</a>
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
