<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="shortcut icon" href="<?= BASEURL; ?>/img/Logo.png" width="30" height="30">
    <title>Halaman <?= $data['judul'] ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= BASEURL; ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= BASEURL; ?>/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= BASEURL; ?>/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link href="<?= BASEURL; ?>/css/stylebadge.css" rel="stylesheet" />




</head>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-success shadow-lg">
                <div class="card-header bg-success text-white text-center">
                    <h4 class="mb-0"><i class="fas fa-check-circle"></i> Dokumen RAB Telah Diverifikasi</h4>
                </div>
                <div class="card-body text-center">
                    <p class="lead mb-2">Dokumen pengajuan anggaran dengan judul:</p>
                    <h5 class="font-weight-bold text-primary mb-3"><?= htmlspecialchars($pengajuan['judul']) ?></h5>

                    <div class="mb-4">
                        <p class="mb-1">Telah <strong class="text-success">diverifikasi</strong> dan disetujui oleh:</p>
                        <h6 class="mb-0"><?= htmlspecialchars($pengajuan['nama_pimpinan']) ?></h6>
                        <small class="text-muted"><?= htmlspecialchars($pengajuan['jabatan_pimpinan']) ?></small>
                    </div>

                    <div class="my-3">
                        <p class="mt-2"><strong>Tanggal Verifikasi:</strong> <?= tglLengkapIndonesia(($pengajuan['tanggal_disetujui'])) ?></p>
                    </div>

                    <hr>

                    <div class="text-left mt-4">
                        <p><strong>ID Verifikasi:</strong> <?= $pengajuan['id'] ?></p>
                        <p><strong>Nama Pengusul:</strong> <?= htmlspecialchars($pengajuan['nama_pegawai'] ?? '-') ?></p>
                        <p><strong>Total Anggaran:</strong> Rp <?= number_format($pengajuan['total_anggaran'] ?? 0, 0, ',', '.') ?></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
