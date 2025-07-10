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

        <!-- SALDO AWAL -->
        <?php if (in_array($_SESSION['user']['role'], ['Admin', 'Petugas'])) : ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-dark shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h4 font-weight-bold text-dark text-uppercase mb-3">
                                SALDO AWAL</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= uang_indo($data['saldo_awal']); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Pemasukan Bulan Ini -->
        <?php if (in_array($_SESSION['user']['role'], ['Admin', 'Petugas'])) : ?>
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
        <?php endif; ?>

        <!-- Pengeluaran Bulan Ini -->
        <?php if (in_array($_SESSION['user']['role'], ['Admin', 'Petugas'])) : ?>
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
        <?php endif; ?>

        <!-- SALDO AKHIR -->
        <?php if (in_array($_SESSION['user']['role'], ['Admin', 'Petugas'])) : ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h4 font-weight-bold text-dark text-uppercase mb-3">
                                SALDO AKHIR</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= uang_indo($data['saldo_awal'] + $data['total_pemasukan'] - $data['total_pengeluaran']); ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-fw fa-wallet fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Pending Requests Card Example -->
        <?php if (in_array($_SESSION['user']['role'], ['Admin', 'Petugas'])) : ?>
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
        <?php endif; ?>

        <?php if (in_array($_SESSION['user']['role'], ['Admin'])) : ?>
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
        <?php endif; ?>

        <?php if (in_array($_SESSION['user']['role'], ['Admin'])) : ?>
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
        <?php endif; ?>

        <!-- Total Seluruh Pengajuan -->
        <?php if (in_array($_SESSION['user']['role'], ['Admin'])) : ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-info text-uppercase mb-3">Total Pengajuan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data['total_pengajuan'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-file-alt fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Total Pengajuan Diajukan -->
        <?php if (in_array($_SESSION['user']['role'], ['Admin', 'Pimpinan', 'Pegawai', 'Petugas'])) : ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-warning text-uppercase mb-3">Pengajuan - Diajukan</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data['pengajuan']['diajukan'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-paper-plane fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Total Pengajuan Diterima -->
        <?php if (in_array($_SESSION['user']['role'], ['Admin', 'Pimpinan', 'Pegawai', 'Petugas'])) : ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-success text-uppercase mb-3">Pengajuan - Diterima</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data['pengajuan']['diterima'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Total Pengajuan Ditolak -->
        <?php if (in_array($_SESSION['user']['role'], ['Admin', 'Pimpinan', 'Pegawai', 'Petugas'])) : ?>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-danger text-uppercase mb-3">Pengajuan - Ditolak</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $data['pengajuan']['ditolak'] ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

    </div>

    <?php if (in_array($_SESSION['user']['role'], ['Admin', 'Pimpinan'])) : ?>
    <!-- Chart Area -->
    <div class="row">
        <!-- Grafik Line -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary py-3">
                    <?php
                    $tahunTerpilih = $data['tahun'] ?? date('Y');
                    ?>
                    <h6 class="m-0 font-weight-bold text-white">Grafik Pemasukan dan Pengeluaran Bulanan<br><small><?= $tahunTerpilih; ?></small></h6>
                </div>
                <div class="card-body">
                    <canvas id="grafikBulanan"></canvas>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header bg-success py-3">
                    <h6 class="m-0 font-weight-bold text-white">Komposisi Pemasukan</h6>
                </div>
                <div class="card-body" style="height: 400px;">
                    <div class="mb-3">
                        <form method="get" action="<?= BASEURL ?>/dashboard" class="form-inline">
                            <select name="tahun" id="tahun-pemasukan" class="form-control form-control-sm mr-2">
                                <?php foreach ($data['bulan_tahun'] as $tahun => $bulanList): ?>
                                    <option value="<?= $tahun ?>" <?= ($tahun == $data['tahun']) ? 'selected' : '' ?>>
                                        <?= $tahun ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <select name="bulan" id="bulan-pemasukan" class="form-control form-control-sm mr-2">
                                <!-- Diisi via JS -->
                            </select>

                            <button class="btn btn-sm btn-primary">Tampilkan</button>
                            <a href="<?= BASEURL ?>/dashboard" class="btn btn-sm btn-secondary text-white ml-2">Reset</a>
                        </form>
                    </div>
                    <div style="position: relative; height: calc(100% - 60px);">
                        <canvas id="myPieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header bg-danger py-3">
                <h6 class="m-0 font-weight-bold text-white">Komposisi Pengeluaran</h6>
            </div>
            <div class="card-body" style="height: 400px;">
                <div class="mb-3">
                    <form method="get" action="<?= BASEURL ?>/dashboard" class="form-inline">
                        <select name="tahun" id="tahun-pengeluaran" class="form-control form-control-sm mr-2">
                            <?php foreach ($data['bulan_tahun'] as $tahun => $bulanList): ?>
                                <option value="<?= $tahun ?>" <?= ($tahun == $data['tahun']) ? 'selected' : '' ?>>
                                    <?= $tahun ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <select name="bulan" id="bulan-pengeluaran" class="form-control form-control-sm mr-2">
                            <!-- Diisi via JS -->
                        </select>

                        <button class="btn btn-sm btn-primary">Tampilkan</button>
                        <a href="<?= BASEURL ?>/dashboard" class="btn btn-sm btn-secondary text-white ml-2">Reset</a>
                    </form>
                </div>
                <div style="position: relative; height: calc(100% - 60px);">
                    <canvas id="komposisiPengeluaranChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>


</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php if (!empty($data['grafik_bulanan'])): ?>
            const bulan = <?= json_encode(array_map(fn($b) => date("M", mktime(0, 0, 0, $b['bulan'], 10)), $data['grafik_bulanan'])) ?>;
            const pemasukan = <?= json_encode(array_map(fn($b) => (float) $b['pemasukan'], $data['grafik_bulanan'])) ?>;
            const pengeluaran = <?= json_encode(array_map(fn($b) => (float) $b['pengeluaran'], $data['grafik_bulanan'])) ?>;

            const ctxLine = document.getElementById('grafikBulanan').getContext('2d');
            new Chart(ctxLine, {
                type: 'line',
                data: {
                    labels: bulan,
                    datasets: [{
                            label: 'Pemasukan',
                            borderColor: 'green',
                            backgroundColor: 'rgba(0, 255, 0, 0.1)',
                            data: pemasukan
                        },
                        {
                            label: 'Pengeluaran',
                            borderColor: 'red',
                            backgroundColor: 'rgba(255, 0, 0, 0.1)',
                            data: pengeluaran
                        }
                    ]
                },
                options: {
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                const dataset = data.datasets[tooltipItem.datasetIndex];
                                const label = dataset.label || '';
                                const value = tooltipItem.yLabel;
                                const formatted = 'Rp ' + Number(value).toLocaleString('id-ID', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                                return label + ': ' + formatted;
                            }
                        }
                    }
                }
            });
        <?php endif; ?>

        <?php if (!empty($data['komposisi_pemasukan'])): ?>
            const labelKategori = <?= json_encode(array_column($data['komposisi_pemasukan'], 'kategori')) ?>;
            const dataKategori = <?= json_encode(array_map(fn($d) => (float) $d['total'], $data['komposisi_pemasukan'])) ?>;

            const ctxPie = document.getElementById('myPieChart').getContext('2d');
            new Chart(ctxPie, {
                type: 'doughnut',
                data: {
                    labels: labelKategori,
                    datasets: [{
                        data: dataKategori,
                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                const label = data.labels[tooltipItem.index] || '';
                                const value = data.datasets[0].data[tooltipItem.index] || 0;
                                const formatted = 'Rp ' + Number(value).toLocaleString('id-ID', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                                return label + ': ' + formatted;
                            }
                        }
                    }
                }
            });
        <?php endif; ?>

        <?php if (!empty($data['komposisi_pengeluaran'])): ?>
            const labelPengeluaran = <?= json_encode(array_column($data['komposisi_pengeluaran'], 'kategori')) ?>;
            const dataPengeluaran = <?= json_encode(array_map(fn($d) => (float) $d['total'], $data['komposisi_pengeluaran'])) ?>;

            const ctxPengeluaran = document.getElementById('komposisiPengeluaranChart')?.getContext('2d');
            new Chart(ctxPengeluaran, {
                type: 'doughnut',
                data: {
                    labels: labelPengeluaran,
                    datasets: [{
                        data: dataPengeluaran,
                        backgroundColor: ['#f6c23e', '#e74a3b', '#36b9cc', '#1cc88a', '#4e73df', '#858796'],
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '70%',
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                const label = data.labels[tooltipItem.index] || '';
                                const value = data.datasets[0].data[tooltipItem.index] || 0;
                                const formatted = 'Rp ' + Number(value).toLocaleString('id-ID', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                                return label + ': ' + formatted;
                            }
                        }
                    }
                }
            });
        <?php endif; ?>

    });
</script>
<script>
    function setupBulanDropdown(tahunId, bulanId, selectedBulan) {
        const tahunSelect = document.getElementById(tahunId);
        const bulanSelect = document.getElementById(bulanId);
        const bulanData = <?= json_encode($data['bulan_tahun']); ?>;

        function updateBulan(tahun) {
            bulanSelect.innerHTML = '';

            if (bulanData[tahun]) {
                bulanData[tahun].forEach(function(bulan) {
                    const bulanStr = String(bulan).padStart(2, '0');
                    const option = document.createElement('option');
                    option.value = bulanStr;
                    option.textContent = new Date(0, bulan - 1).toLocaleString('id-ID', {
                        month: 'long'
                    });

                    if (bulanStr === selectedBulan) {
                        option.selected = true;
                    }

                    bulanSelect.appendChild(option);
                });
            }
        }

        updateBulan(tahunSelect.value);

        tahunSelect.addEventListener('change', function() {
            updateBulan(this.value);
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const selectedBulan = "<?= str_pad($data['bulan'], 2, '0', STR_PAD_LEFT); ?>";
        setupBulanDropdown('tahun-pemasukan', 'bulan-pemasukan', selectedBulan);
        setupBulanDropdown('tahun-pengeluaran', 'bulan-pengeluaran', selectedBulan);
    });
</script>