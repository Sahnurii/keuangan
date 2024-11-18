<?php include("../../inc/koneksi.php"); ?>

<?php

$error = "";
$sukses = "";

$sql_cek = "SELECT * FROM kampus WHERE id_kampus";
$query_cek = mysqli_query($koneksi, $sql_cek);
$data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);

if ($data_cek['gambar_kampus']) {
    $gambar = "admin/gambar/" . $data_cek['gambar_kampus'];
} else {
    $gambar = "admin/gambar/noimage.png";
}
?>

<?php

if (isset($_POST['Ubah'])) {
    $fileName = $_FILES['gambar_kampus']['name'];
    if ($fileName) {
        move_uploaded_file($_FILES['gambar_kampus']['tmp_name'], "admin/gambar/" . $_FILES['gambar_kampus']['name']);

    $sql_ubah = "UPDATE kampus SET 
        nama_kampus='" . $_POST['nama_kampus'] . "',
        yayasan_kampus='" . $_POST['yayasan_kampus'] . "',
        alamat='" . $_POST['alamat'] . "',
        kecamatan='" . $_POST['kecamatan'] . "',
        kabupaten='" . $_POST['kabupaten'] . "',
        provinsi='" . $_POST['provinsi'] . "',
        telepon='" . $_POST['telepon'] . "',
        nama_bendahara='" . $_POST['nama_bendahara'] . "',
        nipy_bendahara='" . $_POST['nipy_bendahara'] . "',
        nama_direktur='" . $_POST['nama_direktur'] . "',
        nipy_direktur='" . $_POST['nipy_direktur'] . "',
        gambar_kampus='$fileName'
        WHERE id_kampus='" . $_POST['id_kampus'] . "'";

    $query_ubah = mysqli_query($koneksi, $sql_ubah);
    mysqli_close($koneksi);

    if ($query_ubah) {
        $sukses = "Berhasil memperbarui data";
        // Tambahkan pengalihan setelah berhasil memperbarui data
        header("Location: data_kampus.php?sukses=" . urlencode($sukses));
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
    <title>Profil Kampus</title>
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>

<body>
    <div class="container mt-3">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><i class="fa fa-school"></i> Pengaturan Profil Kampus</h3>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="card-body">
                    <input type="hidden" class="form-control" id="id_kampus" name="id_kampus" value="<?php echo $data_cek['id_kampus']; ?>" readonly />

                    <!-- Nama Kampus -->
                    <div class="form-group row">
                        <label for="nama_kampus" class="col-sm-2 col-form-label">Nama Kampus</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_kampus" name="nama_kampus" value="<?php echo $data_cek['nama_kampus']; ?>" />
                        </div>
                    </div>

                    <!-- Yayasan -->
                    <div class="form-group row">
                        <label for="yayasan_kampus" class="col-sm-2 col-form-label">Yayasan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="yayasan_kampus" name="yayasan_kampus" value="<?php echo $data_cek['yayasan_kampus']; ?>" />
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="form-group row">
                        <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $data_cek['alamat']; ?>" />
                        </div>
                    </div>

                    <!-- Kecamatan -->
                    <div class="form-group row">
                        <label for="kecamatan" class="col-sm-2 col-form-label">Kecamatan</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kecamatan" name="kecamatan" value="<?php echo $data_cek['kecamatan']; ?>" />
                        </div>
                    </div>

                    <!-- Kabupaten -->
                    <div class="form-group row">
                        <label for="kabupaten" class="col-sm-2 col-form-label">Kabupaten</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kabupaten" name="kabupaten" value="<?php echo $data_cek['kabupaten']; ?>" />
                        </div>
                    </div>

                    <!-- Provinsi -->
                    <div class="form-group row">
                        <label for="provinsi" class="col-sm-2 col-form-label">Provinsi</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="provinsi" name="provinsi" value="<?php echo $data_cek['provinsi']; ?>" />
                        </div>
                    </div>

                    <!-- Telepon -->
                    <div class="form-group row">
                        <label for="telepon" class="col-sm-2 col-form-label">Telepon</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="telepon" name="telepon" value="<?php echo $data_cek['telepon']; ?>" />
                        </div>
                    </div>

                    <!-- Nama Bendahara -->
                    <div class="form-group row">
                        <label for="nama_bendahara" class="col-sm-2 col-form-label">Bendahara</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_bendahara" name="nama_bendahara" value="<?php echo $data_cek['nama_bendahara']; ?>" />
                        </div>
                    </div>

                    <!-- NIPY Bendahara -->
                    <div class="form-group row">
                        <label for="nipy_bendahara" class="col-sm-2 col-form-label">NIPY Bendahara</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nipy_bendahara" name="nipy_bendahara" value="<?php echo $data_cek['nipy_bendahara']; ?>" />
                        </div>
                    </div>

                    <!-- Nama Direktur -->
                    <div class="form-group row">
                        <label for="nama_direktur" class="col-sm-2 col-form-label">Direktur</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama_direktur" name="nama_direktur" value="<?php echo $data_cek['nama_direktur']; ?>" />
                        </div>
                    </div>

                    <!-- NIPY Direktur -->
                    <div class="form-group row">
                        <label for="nipy_direktur" class="col-sm-2 col-form-label">NIPY Direktur</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nipy_direktur" name="nipy_direktur" value="<?php echo $data_cek['nipy_direktur']; ?>" />
                        </div>
                    </div>



                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Logo Kampus</label>
                        <div class="col-sm-6">
                            <input type="file" class="form-control" id="upload" name="gambar_kampus" value="<?php echo $data_cek['gambar_kampus']; ?>" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-6">
                            <img id="preview" src="<?php echo $gambar; ?>" width="200px">
                        </div>
                    </div>

                </div>
        </div>

        <div class="card-footer">
            <button type="submit" name="Ubah" class="btn btn-success">Simpan</button>
            <a href="home.php?page=data-kampus" class="btn btn-secondary">Batal</a>
        </div>
        </form>
    </div>
    </div>

    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        function readURL(input) {

            if (input.files &&
                input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#upload").change(function() {
            readURL(this);
        });
    
    </script>
</body>
</html>