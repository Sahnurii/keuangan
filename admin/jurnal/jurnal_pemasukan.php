<?php include("../../inc/koneksi.php"); ?>

<?php
$error = "";
$sukses = "";

// Ambil saldo terakhir dan nomor bukti berdasarkan pilihan lokasi data
if (isset($_POST['get_saldo'])) {
    $lokasi_data = $_POST['lokasi_data'];
    if ($lokasi_data == "Buku Pembantu Kas") {
        $query = "SELECT saldo, no_bukti FROM b_pembantu_kas ORDER BY id_pembantu_kas DESC LIMIT 1";
        $prefix = "BPK";
    } else if ($lokasi_data == "Buku Pembantu Bank") {
        $query = "SELECT saldo, no_bukti FROM b_pembantu_bank ORDER BY id_pembantu_bank DESC LIMIT 1";
        $prefix = "BPB";
    }

    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);
    $saldo_terakhir = isset($data['saldo']) ? $data['saldo'] : 0;

    // Generate nomor bukti baru
    if (isset($data['no_bukti'])) {
        $last_number = (int) filter_var($data['no_bukti'], FILTER_SANITIZE_NUMBER_INT); // Mengambil angka dari string
        $new_number = $last_number + 1;
    } else {
        $new_number = 1;
    }
    $no_bukti_baru = $prefix . $new_number;

    // Kembalikan saldo terakhir dan nomor bukti baru dalam bentuk JSON
    echo json_encode(['saldo' => $saldo_terakhir, 'no_bukti' => $no_bukti_baru]);
    exit;
}

// Ambil data kategori dengan tipe 'pemasukan'
$kategori_options = "";
$query_kategori = "SELECT nama_kategori FROM kategori WHERE tipe_kategori = 'pemasukan'";
$result_kategori = mysqli_query($koneksi, $query_kategori);
if ($result_kategori && mysqli_num_rows($result_kategori) > 0) {
    while ($row = mysqli_fetch_assoc($result_kategori)) {
        $kategori_options .= "<option value='" . $row['nama_kategori'] . "'>" . $row['nama_kategori'] . "</option>";
    }
}

// Jika form disubmit
if (isset($_POST['submit'])) {
    $tgl_transaksi = $_POST['tgl_transaksi'];
    $no_bukti = $_POST['no_bukti'];
    $keterangan = $_POST['keterangan'];
    $kategori = $_POST['kategori'];
    $penerimaan_debit = $_POST['penerimaan_debit'];
    $lokasi_data = $_POST['lokasi_data'];

    // Ambil saldo terakhir dari hidden input
    $saldo_terakhir = $_POST['saldo_terakhir'];

    // Hitung saldo baru
    $saldo_baru = $saldo_terakhir + $penerimaan_debit;

    // Tentukan tabel berdasarkan pilihan lokasi data
    if ($lokasi_data == "Buku Pembantu Kas") {
        $sql = "INSERT INTO b_pembantu_kas (tgl_transaksi, no_bukti, keterangan, kategori, penerimaan_debit, pengeluaran_kredit, saldo) 
                VALUES ('$tgl_transaksi', '$no_bukti', '$keterangan', '$kategori', '$penerimaan_debit', 0, '$saldo_baru')";
    } else if ($lokasi_data == "Buku Pembantu Bank") {
        $sql = "INSERT INTO b_pembantu_bank (tgl_transaksi, no_bukti, keterangan, kategori, penerimaan_debit, pengeluaran_kredit, saldo) 
                VALUES ('$tgl_transaksi', '$no_bukti', '$keterangan', '$kategori', '$penerimaan_debit', 0, '$saldo_baru')";
    }

    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        $sukses = "Berhasil memasukkan data baru ke " . $lokasi_data;
    } else {
        $error = "Gagal memasukkan data baru";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jurnal Pemasukan</title>
    <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
    <link rel="stylesheet" href="../../plugins/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-3">
        <!-- Notifikasi error dan sukses -->
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($sukses): ?>
            <div class="alert alert-success"><?php echo $sukses; ?></div>
        <?php endif; ?>

        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Tambah Jurnal Pemasukan</h3>
            </div>

            <form action="" method="POST" id="form-jurnal">
                <div class="card-body">

                    <!-- Input Fields -->
                    <div class="form-group row">
                        <label for="tgl_transaksi" class="col-sm-2 col-form-label">TANGGAL TRANSAKSI</label>
                        <div class="col-sm-10">
                            <input type="date" class="form-control" id="tgl_transaksi" name="tgl_transaksi" required>
                        </div>
                    </div>

                    <!-- Dropdown Lokasi Data -->
                    <div class="form-group row">
                        <label for="lokasi_data" class="col-sm-2 col-form-label">Pilih Lokasi Data</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="lokasi_data" name="lokasi_data" required>
                                <option value="" selected disabled>-- Pilih Lokasi --</option>
                                <option value="Buku Pembantu Kas">Buku Pembantu Kas</option>
                                <option value="Buku Pembantu Bank">Buku Pembantu Bank</option>
                            </select>
                        </div>
                    </div>

                    <!-- Input Saldo Terakhir (Read-only) -->
                    <div class="form-group row">
                        <label for="saldo_terakhir" class="col-sm-2 col-form-label">Saldo Terakhir</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="saldo_terakhir" name="saldo_terakhir" readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="no_bukti" class="col-sm-2 col-form-label">NO BUKTI</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="no_bukti" name="no_bukti" required readonly>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="kategori" class="col-sm-2 col-form-label">KATEGORI</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="kategori" name="kategori" required>
                                <option value="" selected disabled>-- Pilih Kategori --</option>
                                <?php echo $kategori_options; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="keterangan" class="col-sm-2 col-form-label">KETERANGAN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="penerimaan_debit" class="col-sm-2 col-form-label">PENERIMAAN (DEBIT)</label>
                        <div class="col-sm-10">
                            <input type="number" step="0.01" class="form-control" id="penerimaan_debit" name="penerimaan_debit">
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-block btn-primary btn-lg" name="submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            // Saat dropdown lokasi data dipilih
            $('#lokasi_data').change(function() {
                var lokasi_data = $(this).val();
                $.ajax({
                    url: '', // Request ke file PHP ini
                    type: 'POST',
                    data: {
                        get_saldo: true,
                        lokasi_data: lokasi_data
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        $('#saldo_terakhir').val(data.saldo);
                        $('#no_bukti').val(data.no_bukti);
                    }
                });
            });
        });
    </script>
</body>

</html>
