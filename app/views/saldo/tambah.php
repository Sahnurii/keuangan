<?php
$flashData = Flasher::flash();  // Ambil data flash
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">

    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Tambah Data Saldo</h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form action="<?= BASEURL; ?>/saldo/tambah" method="POST">
            <div class="container mt-2">
                <div class="form-group row">
                    <label for="tipe_buku" class="col-sm-2 col-form-label">TIPE SALDO</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="tipe_buku" name="tipe_buku" required>
                            <option value="" selected disabled>-- Pilih Tipe Buku --</option>
                            <option value="Bank">Bank</option>
                            <option value="Kas">Kas</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tanggal" class="col-sm-2 col-form-label">TANGGAL</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Masukkan Tanggal" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="saldo_awal" class="col-sm-2 col-form-label">SALDO AWAL</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="saldo_awal" name="saldo_awal" step="0.01" placeholder="Masukkan Saldo" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="keterangan" class="col-sm-2 col-form-label">KETERANGAN</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="keterangan" name="keterangan" step="0.01" placeholder="Masukkan Keterangan" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-primary btn-lg mb-4" name="submit">Tambah</button>
            </div>
        </form>


    </div>
</div>
<!-- /.card -->
</div>
<!-- /.container -->

<script>
    // Menangani perubahan pilihan tipe saldo
    document.getElementById('tipe_buku').addEventListener('change', function() {
        var tipeSaldo = this.value;
        var keteranganField = document.getElementById('keterangan');

        if (tipeSaldo === 'Kas') {
            keteranganField.value = 'Sisa Kas Tunai bulan lalu'; // Isi otomatis jika Kas dipilih
        } else if (tipeSaldo === 'Bank') {
            keteranganField.value = 'Sisa Uang di Bank bulan lalu'; // Isi otomatis jika Bank dipilih
        } else {
            keteranganField.value = ''; // Kosongkan jika tidak ada pilihan
        }
    });
</script>