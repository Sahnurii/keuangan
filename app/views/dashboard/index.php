<!-- Begin Page Content -->
<?php
$flashData = Flasher::flash();  // Ambil data flash
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <!-- Content Row -->
    <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h4 font-weight-bold text-primary text-uppercase mb-1">
                                PEMASUKAN
                            </div>
                            <div class="h5 font-weight-bold text-primary text-uppercase mb-3">
                                BULAN INI
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= uang_indo($data['total_pemasukan']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h4 font-weight-bold text-success text-uppercase mb-1">
                                PENGELUARAN </div>
                            <div class="h5 font-weight-bold text-success text-uppercase mb-3">
                                BULAN INI</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= uang_indo($data['total_pengeluaran']); ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h4 font-weight-bold text-warning text-uppercase mb-3">
                                KATEGORI</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $data['total_kategori']; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h4 font-weight-bold text-info text-uppercase mb-3">
                                BIDANG</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $data['total_bidang']; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-solid fa-sitemap fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h4 font-weight-bold text-danger text-uppercase mb-3">
                                PEGAWAI</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"> <?php echo $data['total_pegawai']; ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->