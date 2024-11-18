<?php
include "../../inc/koneksi.php";

// Fungsi format uang
function uang_indo($angka)
{
    $rupiah = "Rp " . number_format($angka, 2, ',', '.');
    return $rupiah;
}

// Set tanggal cetak
function tglIndonesia($str)
{
    $tr = trim($str);
    $str = str_replace(
        array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'),
        array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'),
        $tr
    );
    return $str;
}

// Mengambil data bendahara
$sql_cek = "SELECT * FROM kampus WHERE id_kampus";
$query_cek = mysqli_query($koneksi, $sql_cek);
$data_cek = mysqli_fetch_array($query_cek, MYSQLI_BOTH);
$nama_bendahara = $data_cek['nama_bendahara'] ?? 'NAMA';
$nipy_bendahara = $data_cek['nipy_Bendahara'] ?? 'NIP 291023912302112';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Cetak - Laporan Data Kas Umum</title>
    <style type="text/css">
        .tabel {
            border-collapse: collapse;
            width: 100%;
        }
        .tabel th, .tabel td {
            border: 1px solid black;
            padding: 8px;
        }
        .tabel th {
            background-color: #cccccc;
        }
    </style>
    <script>
        window.print();
        window.onfocus = function() { window.close(); }
    </script>
</head>

<body onload="window.print()">

    <div align="center">
        <h3>Laporan Data Kas Umum</h3>
    </div>

    <table class="tabel">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>No Bukti</th>
                <th>Keterangan</th>
                <th>Penerimaan (Debit)</th>
                <th>Pengeluaran (Kredit)</th>
                <th>Saldo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mengambil data dari tabel b_pembantu_kas dan b_pembantu_bank
            $ambildata = "
                SELECT tgl_transaksi, no_bukti, keterangan, penerimaan_debit, pengeluaran_kredit 
                FROM b_pembantu_kas
                UNION ALL
                SELECT tgl_transaksi, no_bukti, keterangan, penerimaan_debit, pengeluaran_kredit 
                FROM b_pembantu_bank
                ORDER BY tgl_transaksi ASC
            ";
            $q2 = mysqli_query($koneksi, $ambildata);
            $no = 1;
            $saldo = 0; // Mulai saldo dari 0
            while ($data = mysqli_fetch_array($q2)) {
                $tgl_transaksi = $data['tgl_transaksi'];
                $no_bukti = $data['no_bukti'];
                $keterangan = $data['keterangan'];
                $penerimaan_debit = $data['penerimaan_debit'];
                $pengeluaran_kredit = $data['pengeluaran_kredit'];

                // Update saldo
                $saldo += ($penerimaan_debit - $pengeluaran_kredit);
            ?>
                <tr>
                    <td align="center"><?php echo $no++; ?></td>
                    <td align="center"><?php echo tglIndonesia(date('d F Y', strtotime($tgl_transaksi))); ?></td>
                    <td align="center"><?php echo $no_bukti; ?></td>
                    <td><?php echo $keterangan; ?></td>
                    <td align="right"><?php echo uang_indo($penerimaan_debit); ?></td>
                    <td align="right"><?php echo uang_indo($pengeluaran_kredit); ?></td>
                    <td align="right"><?php echo uang_indo($saldo); ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <br>
    <?php $tgl = date('Y-m-d'); ?>
    <table width="100%">
        <tr>
            <td align="center"></td>
            <td align="center" width="200px">
                <?php echo tglIndonesia(date('d F Y', strtotime($tgl))); ?>
                <br />Bendahara,<br /><br /><br /><br />
                <b><u><?php echo $nama_bendahara; ?></u><br /><?php echo $nipy_bendahara; ?></b>
            </td>
        </tr>
    </table>

</body>

</html>
