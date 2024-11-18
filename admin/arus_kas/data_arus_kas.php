<?php include("../../inc/koneksi.php") ?>
<?php

function uang_indo($angka)
{
  $rupiah = "Rp." . number_format($angka, 2, ',', '.');
  return $rupiah;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buku Pembantu Bank</title>
  
  <?php include("header.php"); ?>
</head>

<body>

<div class="card card-info">
  <div class="card-header">
    <h3 class="card-title">
      <i class="fa fa-table"></i> Data Arus Keuangan
    </h3>
  </div>
  <!-- /.card-header -->
  <div class="card-body">
    <div class="table-responsive">

      <br>
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Bulan</th>
            <th>Total Pemasukan</th>
            <th>Total Pengeluaran</th>
            <th>Saldo</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>

          <?php
          $no = 1;

          // Query total pemasukan dan pengeluaran dari b_pembantu_bank
          $sql_bank = $koneksi->query("SELECT 
                                         MONTH(tgl_transaksi) AS bulan,
                                         SUM(penerimaan_debit) AS pemasukan_bank,
                                         SUM(pengeluaran_kredit) AS pengeluaran_bank
                                       FROM b_pembantu_bank
                                       GROUP BY MONTH(tgl_transaksi)");

          // Query total pemasukan dan pengeluaran dari b_pembantu_kas
          $sql_kas = $koneksi->query("SELECT 
                                        MONTH(tgl_transaksi) AS bulan,
                                        SUM(penerimaan_debit) AS pemasukan_kas,
                                        SUM(pengeluaran_kredit) AS pengeluaran_kas
                                      FROM b_pembantu_kas
                                      GROUP BY MONTH(tgl_transaksi)");

          // Inisialisasi array untuk menyimpan total per bulan
          $data_per_bulan = [];

          // Memasukkan data dari b_pembantu_bank
          while ($row_bank = $sql_bank->fetch_assoc()) {
            $bulan = $row_bank['bulan'];
            $data_per_bulan[$bulan]['pemasukan'] = $row_bank['pemasukan_bank'];
            $data_per_bulan[$bulan]['pengeluaran'] = $row_bank['pengeluaran_bank'];
          }

          // Memasukkan data dari b_pembantu_kas, dan menjumlahkan jika sudah ada data di bulan tersebut
          while ($row_kas = $sql_kas->fetch_assoc()) {
            $bulan = $row_kas['bulan'];
            if (isset($data_per_bulan[$bulan])) {
              $data_per_bulan[$bulan]['pemasukan'] += $row_kas['pemasukan_kas'];
              $data_per_bulan[$bulan]['pengeluaran'] += $row_kas['pengeluaran_kas'];
            } else {
              $data_per_bulan[$bulan]['pemasukan'] = $row_kas['pemasukan_kas'];
              $data_per_bulan[$bulan]['pengeluaran'] = $row_kas['pengeluaran_kas'];
            }
          }

          // Menampilkan data per bulan
          foreach ($data_per_bulan as $bulan => $data) {
            $total_pemasukan = $data['pemasukan'];
            $total_pengeluaran = $data['pengeluaran'];
            $saldo = $total_pemasukan - $total_pengeluaran;

            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . date("F", mktime(0, 0, 0, $bulan, 10)) . "</td>";
            echo "<td>" . uang_indo($total_pemasukan) . "</td>";
            echo "<td>" . uang_indo($total_pengeluaran) . "</td>";
            echo "<td>" . uang_indo($saldo) . "</td>";
            echo "<td>
                    <a href='admin/arus_keuangan/cetak_arus_keuangan.php?bulan=$bulan' 
                       title='Cetak' target='_blank' class='btn btn-primary btn-sm'>
                      <i class='fa fa-print'></i>
                    </a>
                  </td>";
            echo "</tr>";
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- /.card-body -->

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
      $('#example1').DataTable({
          "pageLength": 10, // Jumlah item yang ditampilkan per halaman
          "lengthMenu": [10, 15, 25, 50, 100] // Opsi yang tersedia untuk jumlah item
      });
  });
</script>
</body>

</html>
