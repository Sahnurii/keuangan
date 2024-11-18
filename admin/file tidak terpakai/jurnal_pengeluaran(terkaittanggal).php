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

// Jika form disubmit
if (isset($_POST['submit'])) {
    $tgl_transaksi = $_POST['tgl_transaksi'];
    $no_bukti = $_POST['no_bukti'];
    $keterangan = $_POST['keterangan'];
    $pengeluaran_kredit = $_POST['pengeluaran_kredit'];
    $lokasi_data = $_POST['lokasi_data'];

    // Ambil saldo terakhir dari hidden input
    $saldo_terakhir = $_POST['saldo_terakhir'];

    // Hitung saldo baru (saldo dikurangi pengeluaran)
    $saldo_baru = $saldo_terakhir - $pengeluaran_kredit;

    // Tentukan tabel berdasarkan pilihan lokasi data
    if ($lokasi_data == "Buku Pembantu Kas") {
        $sql = "INSERT INTO b_pembantu_kas (tgl_transaksi, no_bukti, keterangan, penerimaan_debit, pengeluaran_kredit, saldo) 
                VALUES ('$tgl_transaksi', '$no_bukti', '$keterangan', 0, '$pengeluaran_kredit', '$saldo_baru')";
    } else if ($lokasi_data == "Buku Pembantu Bank") {
        $sql = "INSERT INTO b_pembantu_bank (tgl_transaksi, no_bukti, keterangan, penerimaan_debit, pengeluaran_kredit, saldo) 
                VALUES ('$tgl_transaksi', '$no_bukti', '$keterangan', 0, '$pengeluaran_kredit', '$saldo_baru')";
    }

    $query = mysqli_query($koneksi, $sql);

    if ($query) {
        $sukses = "Berhasil memasukkan data pengeluaran ke " . $lokasi_data;
    } else {
        $error = "Gagal memasukkan data pengeluaran";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jurnal Pengeluaran</title>
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
                <h3 class="card-title">Tambah Jurnal Pengeluaran</h3>
            </div>

            <form action="" method="POST" id="form-jurnal">
                <div class="card-body">
                    <div>
                        <a href="data_pegawai.php" class="btn btn-primary">Kembali</a>
                    </div>
                    <br>

                    <!-- Input Fields -->
                    <div class="form-group row">
                        <label for="tgl_transaksi" class="col-sm-2 col-form-label">TANGGAL TRANSAKSI</label>
                        <div class="col-sm-10">
                            <!-- Elemen input type="date" -->
                            <input type="date" class="form-control" id="tgl_transaksi" name="tgl_transaksi" required>

                            <!-- Hidden input untuk menyimpan tanggal asli (yyyy-mm-dd) -->
                            <input type="hidden" id="tgl_transaksi_hidden" name="tgl_transaksi_hidden">

                            <!-- Elemen untuk menampilkan tanggal yang diformat -->
                            <span id="formatted_date"></span>
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
                        <label for="keterangan" class="col-sm-2 col-form-label">KETERANGAN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="keterangan" name="keterangan" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pengeluaran_kredit" class="col-sm-2 col-form-label">PENGELUARAN (KREDIT)</label>
                        <div class="col-sm-10">
                            <input type="number" step="0.01" class="form-control" id="pengeluaran_kredit" name="pengeluaran_kredit" required>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-block btn-primary btn-lg" name="submit">Tambah</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Include Scripts -->
    <script src="../../js/jquery-3.6.0.min.js"></script>
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

        // Fungsi untuk memformat tanggal
        function formatTanggal(tanggal) {
            const options = {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            };
            return new Date(tanggal).toLocaleDateString('id-ID', options);
        }

        $(document).ready(function() {
            // Tangkap perubahan pada input date
            $('#tgl_transaksi').change(function() {
                var tanggalAsli = $(this).val(); // Format yyyy-mm-dd

                // Simpan tanggal asli di hidden input
                $('#tgl_transaksi_hidden').val(tanggalAsli);

                // Format tanggal ke format "15 Okt 2024"
                var tanggalFormatted = formatTanggal(tanggalAsli);

                // Tampilkan tanggal yang sudah diformat di <span>
                $('#formatted_date').text(tanggalFormatted);
            });
        });
    </script>
</body>

</html>