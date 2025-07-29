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
                    <table class="table mt-4">
                        <tbody>
                            <tr>
                                <th width="40%">Judul Pengajuan</th>
                                <td>:</td>
                                <td class="text-primary font-weight-bold"><?= htmlspecialchars($pengajuan['judul']) ?></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-user-tie"></i> Nama Pimpinan</th>
                                <td>:</td>
                                <td><strong><?= htmlspecialchars($pengajuan['nama_pimpinan']) ?></strong></td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-briefcase"></i> Jabatan Pimpinan</th>
                                <td>:</td>
                                <td>
                                    <span class="badge bg-primary text-white px-3 py-2">
                                        <?= htmlspecialchars($pengajuan['jabatan_pimpinan']) ?>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th><i class="fas fa-calendar-check"></i> Tanggal Verifikasi</th>
                                <td>:</td>
                                <td><?= tglLengkapIndonesia(($pengajuan['tanggal_disetujui'])) ?></td>
                            </tr>
                            <tr>
                                <th width="40%">ID Verifikasi</th>
                                <td>:</td>
                                <td><?= $pengajuan['id'] ?></td>
                            </tr>
                            <tr>
                                <th>Nama Pengusul</th>
                                <td>:</td>
                                <td><?= htmlspecialchars($pengajuan['nama_pegawai'] ?? '-') ?></td>
                            </tr>
                            <tr>
                                <th>Total Anggaran</th>
                                <td>:</td>
                                <td><?= uang_indo_v2($pengajuan['total_anggaran']) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>