<?php include("../../inc/koneksi.php"); ?>
<?php

function uang_indo($angka)
{
	$rupiah = "Rp " . number_format($angka, 2, ',', '.');
	return $rupiah;
}

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
    <title>Data Pembantu Kas</title>

    <!-- Include CSS dependencies -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/datatables.min.css">
</head>

<body>

    <div class="container mt-3">
        <!-- Notifications -->
        <?php if ($sukses): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $sukses; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error; ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php endif; ?>

        <!-- Data Table -->
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title text-center">Data Pembantu Kas</h3>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div>
                        <a href="saldo_awal/saldo_awal.php" class="btn btn-primary"><i class="fa fa-edit"></i> Tambah Dana Awal</a>
                    </div>
                    <br>
                    <table id="example" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>TANGGAL</th>
                                <th>NO BUKTI</th>
                                <th>KETERANGAN</th>
                                <th>PENERIMAAN (DEBIT)</th>
                                <th>PENGELUARAN (KREDIT)</th>
                                <th>SALDO</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Mengambil data dari database
                            $ambildata = "SELECT * FROM b_pembantu_kas ORDER BY tgl_transaksi ASC";
                            $q2 = mysqli_query($koneksi, $ambildata);
                            $urut = 1;
                            while ($tampil = mysqli_fetch_array($q2)) {
                                $id_pembantu_kas = $tampil['id_pembantu_kas'];
                                $tgl_transaksi = $tampil['tgl_transaksi'];
                                $no_bukti = $tampil['no_bukti'];
                                $keterangan = $tampil['keterangan'];
                                $penerimaan_debit = $tampil['penerimaan_debit'];
                                $pengeluaran_kredit = $tampil['pengeluaran_kredit'];
                                $saldo = $tampil['saldo']; // Menampilkan saldo yang sudah disimpan di database
                            ?>
                                <tr>
                                    <th><?php echo $urut++ ?></th>
                                    <td><?php echo $tgl_transaksi ?></td>
                                    <td><?php echo $no_bukti ?></td>
                                    <td><?php echo $keterangan ?></td>
                                    <td><?php echo uang_indo($penerimaan_debit) ?></td>
                                    <td><?php echo uang_indo($pengeluaran_kredit) ?></td>
                                    <td><?php echo uang_indo($saldo) ?></td>
                                    <td>
                                        <a href='edit_pembantu_kas.php?op=edit&id_pembantu_kas=<?php echo $id_pembantu_kas ?>' class="btn btn-warning"><i class="fa fa-edit"></i></a>
                                        <a href='delete_pembantu_kas.php?op=hapus&id_pembantu_kas=<?php echo $id_pembantu_kas ?>' onclick="return confirm('Apakah yakin mau delete data?')" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Include JS dependencies -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>
</body>
</html>
