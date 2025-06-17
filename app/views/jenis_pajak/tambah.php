<?php
$flashData = Flasher::flash();  // Ambil data flash
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">

    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Tambah Data Jenis Pajak</h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form action="<?= BASEURL; ?>/jenis_pajak/tambah" method="POST">
            <div class="container mt-2">
                <div class="form-group row">
                    <label for="tarif_pajak" class="col-sm-2 col-form-label">TARIF PAJAK</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="tarif_pajak" name="tarif_pajak" step="0.01" placeholder="Masukkan Tarif Pajak" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tipe" class="col-sm-2 col-form-label">TIPE</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="tipe" name="tipe" required>
                            <option value="" selected disabled>-- Pilih Tipe Pajak --</option>
                            <option value="PPN">PPN</option>
                            <option value="PPh21">PPh21</option>
                            <option value="PPh22">PPh22</option>
                            <option value="PPh23">PPh23</option>
                            <option value="Pph4(2)Final">Pph4(2)Final</option>
                        </select>
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