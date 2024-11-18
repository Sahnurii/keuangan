<?php include("../../inc/koneksi.php"); ?>
<?php
$sukses = "";
$error = "";

if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}

if (isset($_GET['error'])) {
    $error = $_GET['error'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kategori</title>

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
        <!-- Alert untuk sukses -->
        <?php if ($sukses): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $sukses; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Alert untuk error -->
        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title text-center">Data Kategori</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div>
                        <a href="add_kategori.php" class="btn btn-primary"><i class="fa fa-edit"></i> Tambah Kategori</a>
                    </div>
                    <br>
                    <table id="example" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>NAMA KATEGORI</th>
                                <th>TIPE KATEGORI</th>                               
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $ambildata = "SELECT * FROM kategori ORDER BY id_kategori ASC";
                            $q2 = mysqli_query($koneksi, $ambildata);
                            $urut = 1;
                            while ($tampil = mysqli_fetch_array($q2)) {
                                $id_kategori = $tampil['id_kategori'];
                                $nama_kategori = $tampil['nama_kategori'];
                                $tipe_kategori = $tampil['tipe_kategori'];
                            ?>
                                <tr>
                                    <th><?php echo $urut++ ?></th>
                                    <td><?php echo $nama_kategori ?></td>
                                    <td><?php echo $tipe_kategori ?></td>
                                    <td>
                                        <a href='edit_kategori.php?op=edit&id_kategori=<?php echo $id_kategori ?>' class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href='delete_kategori.php?id_kategori=<?php echo $id_kategori ?>' class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fa fa-trash"></i> Hapus
                                        </a>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

   <!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="../../plugins/jszip/jszip.min.js"></script>
<script src="../../plugins/pdfmake/pdfmake.min.js"></script>
<script src="../../plugins/pdfmake/vfs_fonts.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="../../plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "pageLength": 10, // Jumlah item yang ditampilkan per halaman
                "lengthMenu": [10, 15, 25, 50, 100] // Opsi yang tersedia untuk jumlah item
            });
        });
    </script>

    
</body>
</html>
