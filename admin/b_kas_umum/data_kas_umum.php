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
  <title>Buku Kas Umum</title>

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
                <h3 class="card-title text-center">Data Kas Umum</h3>
            </div>
            <div>
                        <a href="cetak_kas_umum.php" class="btn btn-primary"><i class="fa fa-edit"></i> CETAK</a>
                    </div>
            <div class="card-body">
                <div class="table-responsive">
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
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Mengambil saldo awal dari buku pembantu kas dan bank
                            $saldo_kas_awal_query = "SELECT tgl_transaksi, no_bukti, keterangan, penerimaan_debit, pengeluaran_kredit FROM b_pembantu_kas WHERE jenis_transaksi = 'saldo_awal' LIMIT 1";
                            $saldo_bank_awal_query = "SELECT tgl_transaksi, no_bukti, keterangan, penerimaan_debit, pengeluaran_kredit FROM b_pembantu_bank WHERE jenis_transaksi = 'saldo_awal' LIMIT 1";

                            $q_kas_awal = mysqli_query($koneksi, $saldo_kas_awal_query);
                            $q_bank_awal = mysqli_query($koneksi, $saldo_bank_awal_query);

                            $urut = 1;
                            $saldo = 0; // Mulai saldo dari 0

                            // Tampilkan saldo awal buku pembantu kas
                            if ($kas_awal = mysqli_fetch_array($q_kas_awal)) {
                                $saldo += ($kas_awal['penerimaan_debit'] - $kas_awal['pengeluaran_kredit']);
                                echo "<tr>
                                        <th>{$urut}</th>
                                        <td>{$kas_awal['tgl_transaksi']}</td>
                                        <td>{$kas_awal['no_bukti']}</td>
                                        <td>{$kas_awal['keterangan']}</td>
                                        <td>" . uang_indo($kas_awal['penerimaan_debit']) . "</td>
                                        <td>" . uang_indo($kas_awal['pengeluaran_kredit']) . "</td>
                                        <td>" . uang_indo($saldo) . "</td>
                                    </tr>";
                                $urut++;
                            }

                            // Tampilkan saldo awal buku pembantu bank
                            if ($bank_awal = mysqli_fetch_array($q_bank_awal)) {
                                $saldo += ($bank_awal['penerimaan_debit'] - $bank_awal['pengeluaran_kredit']);
                                echo "<tr>
                                        <th>{$urut}</th>
                                        <td>{$bank_awal['tgl_transaksi']}</td>
                                        <td>{$bank_awal['no_bukti']}</td>
                                        <td>{$bank_awal['keterangan']}</td>
                                        <td>" . uang_indo($bank_awal['penerimaan_debit']) . "</td>
                                        <td>" . uang_indo($bank_awal['pengeluaran_kredit']) . "</td>
                                        <td>" . uang_indo($saldo) . "</td>
                                    </tr>";
                                $urut++;
                            }

                            // Mengambil semua transaksi dari buku pembantu kas dan bank selain saldo awal
                            $ambildata = "
                                SELECT tgl_transaksi, no_bukti, keterangan, penerimaan_debit, pengeluaran_kredit 
                                FROM b_pembantu_kas WHERE jenis_transaksi != 'saldo_awal'
                                UNION ALL
                                SELECT tgl_transaksi, no_bukti, keterangan, penerimaan_debit, pengeluaran_kredit 
                                FROM b_pembantu_bank WHERE jenis_transaksi != 'saldo_awal'
                                ORDER BY tgl_transaksi ASC
                            ";
                            $q2 = mysqli_query($koneksi, $ambildata);

                            // Tampilkan transaksi lainnya
                            while ($tampil = mysqli_fetch_array($q2)) {
                                $tgl_transaksi = $tampil['tgl_transaksi'];
                                $no_bukti = $tampil['no_bukti'];
                                $keterangan = $tampil['keterangan'];
                                $penerimaan_debit = $tampil['penerimaan_debit'];
                                $pengeluaran_kredit = $tampil['pengeluaran_kredit'];

                                // Update saldo secara dinamis
                                $saldo += ($penerimaan_debit - $pengeluaran_kredit);
                                echo "<tr>
                                        <th>{$urut}</th>
                                        <td>{$tgl_transaksi}</td>
                                        <td>{$no_bukti}</td>
                                        <td>{$keterangan}</td>
                                        <td>" . uang_indo($penerimaan_debit) . "</td>
                                        <td>" . uang_indo($pengeluaran_kredit) . "</td>
                                        <td>" . uang_indo($saldo) . "</td>
                                    </tr>";
                                $urut++;
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
                "pageLength": 100, // Jumlah item yang ditampilkan per halaman
                "lengthMenu": [150, 250, 500, 1000] // Opsi yang tersedia untuk jumlah item
            });
        });
    </script>
</body>

</html>
