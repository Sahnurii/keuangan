<?php include("../../inc/koneksi.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Laporan</title>

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


    <!-- <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Dashboard</li>
    </ol> -->
  </section>
  <div class="container mt-3">
  <section class="content-header">
  <h1>LAPORAN <small>Data Laporan</small></h1>

  <section class="content">
    <div class="row">
      <section class="col-lg-12">
        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Filter Laporan</h3>
          </div>
          <div class="card-body">
            <form method="get" action="">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Mulai Tanggal</label>
                    <input autocomplete="off" type="text" value="<?php if(isset($_GET['tanggal_dari'])){echo $_GET['tanggal_dari'];}else{echo "";} ?>" name="tanggal_dari" class="form-control datepicker2" placeholder="Mulai Tanggal" required="required">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Sampai Tanggal</label>
                    <input autocomplete="off" type="text" value="<?php if(isset($_GET['tanggal_sampai'])){echo $_GET['tanggal_sampai'];}else{echo "";} ?>" name="tanggal_sampai" class="form-control datepicker2" placeholder="Sampai Tanggal" required="required">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label>Kategori</label>
                    <select name="kategori" class="form-control" required="required">
                      <option value="semua">- Semua Kategori -</option>
                      <?php 
                      $kategori = mysqli_query($koneksi,"SELECT id_kategori, nama_kategori FROM kategori");
                      while($k = mysqli_fetch_array($kategori)){
                        ?>
                        <option <?php if(isset($_GET['kategori'])){ if($_GET['kategori'] == $k['id_kategori']){echo "selected='selected'";}} ?>  value="<?php echo $k['id_kategori']; ?>"><?php echo $k['nama_kategori']; ?></option>
                        <?php 
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <br/>
                    <input type="submit" value="TAMPILKAN" class="btn btn-sm btn-primary btn-block">
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="card card-info">
          <div class="card-header">
            <h3 class="card-title">Laporan Pemasukan & Pengeluaran</h3>
          </div>
          <div class="card-body">
            <?php 
            if(isset($_GET['tanggal_sampai']) && isset($_GET['tanggal_dari']) && isset($_GET['kategori'])){
              $tgl_dari = $_GET['tanggal_dari'];
              $tgl_sampai = $_GET['tanggal_sampai'];
              $kategori = $_GET['kategori'];
              ?>

              <div class="row">
                <div class="col-lg-6">
                  <table class="table table-bordered">
                    <tr>
                      <th width="30%">DARI TANGGAL</th>
                      <th width="1%">:</th>
                      <td><?php echo $tgl_dari; ?></td>
                    </tr>
                    <tr>
                      <th>SAMPAI TANGGAL</th>
                      <th>:</th>
                      <td><?php echo $tgl_sampai; ?></td>
                    </tr>
                    <tr>
                      <th>KATEGORI</th>
                      <th>:</th>
                      <td><?php echo ($kategori == "semua") ? "SEMUA KATEGORI" : mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT kategori FROM kategori WHERE kategori_id='$kategori'"))['kategori']; ?></td>
                    </tr>
                  </table>
                </div>
              </div>

              <a href="laporan_pdf.php?tanggal_dari=<?php echo $tgl_dari ?>&tanggal_sampai=<?php echo $tgl_sampai ?>&kategori=<?php echo $kategori ?>" target="_blank" class="btn btn-sm btn-success"><i class="fa fa-file-pdf-o"></i> &nbsp;CETAK PDF</a>
              <a href="laporan_print.php?tanggal_dari=<?php echo $tgl_dari ?>&tanggal_sampai=<?php echo $tgl_sampai ?>&kategori=<?php echo $kategori ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-print"></i> &nbsp;PRINT</a>

              <div class="table-responsive">
                <table class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th width="1%" rowspan="2">NO</th>
                      <th width="10%" rowspan="2" class="text-center">TANGGAL</th>
                      <th rowspan="2" class="text-center">KATEGORI</th>
                      <th rowspan="2" class="text-center">KETERANGAN</th>
                      <th colspan="2" class="text-center">JENIS</th>
                    </tr>
                    <tr>
                      <th class="text-center">PEMASUKAN</th>
                      <th class="text-center">PENGELUARAN</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                    include '../koneksi.php';
                    $no=1;
                    $total_pemasukan=0;
                    $total_pengeluaran=0;
                    $query = "SELECT * FROM transaksi, kategori WHERE kategori_id=transaksi_kategori AND date(transaksi_tanggal) >= '$tgl_dari' AND date(transaksi_tanggal) <= '$tgl_sampai'";
                    if ($kategori != "semua") {
                      $query .= " AND kategori_id='$kategori'";
                    }
                    $data = mysqli_query($koneksi, $query);
                    while($d = mysqli_fetch_array($data)) {
                      if($d['transaksi_jenis'] == "Pemasukan") {
                        $total_pemasukan += $d['transaksi_nominal'];
                      } elseif($d['transaksi_jenis'] == "Pengeluaran") {
                        $total_pengeluaran += $d['transaksi_nominal'];
                      }
                      ?>
                      <tr>
                        <td class="text-center"><?php echo $no++; ?></td>
                        <td class="text-center"><?php echo date('d-m-Y', strtotime($d['transaksi_tanggal'])); ?></td>
                        <td><?php echo $d['kategori']; ?></td>
                        <td><?php echo $d['transaksi_keterangan']; ?></td>
                        <td class="text-center"><?php echo ($d['transaksi_jenis'] == "Pemasukan") ? "Rp. ".number_format($d['transaksi_nominal'])." ,-" : "-"; ?></td>
                        <td class="text-center"><?php echo ($d['transaksi_jenis'] == "Pengeluaran") ? "Rp. ".number_format($d['transaksi_nominal'])." ,-" : "-"; ?></td>
                      </tr>
                    <?php } ?>
                    <tr>
                      <th colspan="4" class="text-right">TOTAL</th>
                      <td class="text-center text-bold text-success"><?php echo "Rp. ".number_format($total_pemasukan)." ,-"; ?></td>
                      <td class="text-center text-bold text-danger"><?php echo "Rp. ".number_format($total_pengeluaran)." ,-"; ?></td>
                    </tr>
                    <tr>
                      <th colspan="4" class="text-right">SALDO</th>
                      <td colspan="2" class="text-center text-bold"><?php echo "Rp. ".number_format($total_pemasukan - $total_pengeluaran)." ,-"; ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <?php 
            } else {
              echo "<div class='alert alert-info text-center'><b>Silahkan Filter Laporan Terlebih Dulu.</b></div>";
            }
            ?>
          </div>
        </div>
      </section>
    </div>
  </section>
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
  <!-- AdminLTE App -->
  <script src="../../dist/js/adminlte.min.js"></script>
  <script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    });
  </script>
</body>
</html>
