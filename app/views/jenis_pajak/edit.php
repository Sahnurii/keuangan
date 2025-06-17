<div class="container-fluid">

    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Edit Data Jenis Pajak</h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form action="<?= BASEURL; ?>/jenis_pajak/update" method="POST" id="formEdit">
            <input type="hidden" name="id" id="id" value="<?= $data['jenis_pajak']['id']; ?>">
            <div class="container mt-2">
                <div class="form-group row">
                    <label for="tarif_pajak" class="col-sm-2 col-form-label">TARIF PAJAK</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="tarif_pajak" name="tarif_pajak" step="0.01" placeholder="Masukkan Tarif Pajak" value="<?= $data['jenis_pajak']['tarif_pajak']; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tipe" class="col-sm-2 col-form-label">TIPE</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="tipe" name="tipe" required>
                            <option value="" disabled>-- Pilih Tipe Pajak --</option>
                            <option value="PPN" <?= $data['jenis_pajak']['tipe'] == 'PPN' ? 'selected' : '' ?>>PPN</option>
                            <option value="PPh21" <?= $data['jenis_pajak']['tipe'] == 'PPh21' ? 'selected' : '' ?>>PPh21</option>
                            <option value="PPh22" <?= $data['jenis_pajak']['tipe'] == 'PPh22' ? 'selected' : '' ?>>PPh22</option>
                            <option value="PPh23" <?= $data['jenis_pajak']['tipe'] == 'PPh23' ? 'selected' : '' ?>>PPh23</option>
                            <option value="Pph4(2)Final" <?= $data['jenis_pajak']['tipe'] == 'Pph4(2)Final' ? 'selected' : '' ?>>Pph4(2)Final</option>
                        </select>
                    </div>
                </div>              
                <button type="submit" class="btn btn-block btn-primary btn-lg mb-4" name="submit">Edit</button>
            </div>
    </div>
    </form>
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