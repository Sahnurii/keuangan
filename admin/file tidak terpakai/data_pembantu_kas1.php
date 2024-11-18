<?php include("../../inc/koneksi.php"); ?>
<?php

function uang_indo($angka)
{
	$rupiah = "Rp " . number_format($angka, 2, ',', '.');
	return $rupiah;
}

?>
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
    <title>Data Pembantu Kas</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css">
    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="../../css/datatables.min.css">
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
                            // Mengambil data dari database dan mengurutkan berdasarkan tanggal
                            $ambildata = "SELECT * FROM b_pembantu_kas ORDER BY tgl_transaksi ASC";
                            $q2 = mysqli_query($koneksi, $ambildata);
                            $urut = 1;
                            $saldo = 0; // Mulai saldo dari 0
                            while ($tampil = mysqli_fetch_array($q2)) {
                                $id_pembantu_kas = $tampil['id_pembantu_kas'];
                                $tgl_transaksi = $tampil['tgl_transaksi'];
                                $no_bukti = $tampil['no_bukti'];
                                $keterangan = $tampil['keterangan'];
                                $penerimaan_debit = $tampil['penerimaan_debit'];
                                $pengeluaran_kredit = $tampil['pengeluaran_kredit'];

                                // Update saldo secara dinamis
                                $saldo += ($penerimaan_debit - $pengeluaran_kredit);
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
                                        <a href='edit_pembantu_kas.php?op=edit&id_pembantu_kas=<?php echo $id_pembantu_kas ?>' class="btn btn-warning btn-sm">
                                            <i class="fa fa-edit"></i> Edit
                                        </a>
                                        <a href='delete_pembantu_kas.php?id_pembantu_kas=<?php echo $id_pembantu_kas ?>' class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">
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

    <!-- Include jQuery -->
    <script src="../../js/jquery-3.6.0.min.js"></script>
    <!-- Include Bootstrap JS -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Include DataTables JS -->
    <script src="../../js/datatables.min.js"></script>
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
