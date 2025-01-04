<div class="container-fluid">

    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Edit Buku Kas</h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form action="<?= BASEURL; ?>/transaksi/edit" method="POST">
            <input type="hidden" name="id" id="id" value="<?= $data['kas']['id']; ?>">
            <div class="container mt-2">
                <div class="form-group row">
                    <label for="tipe_buku" class="col-sm-2 col-form-label">TIPE BUKU</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="tipe_buku" name="tipe_buku" required>
                            <option value="" selected disabled>-- Pilih Tipe Buku --</option>
                            <option value="Bank" <?= $data['kas']['tipe_buku'] === 'Bank' ? 'selected' : ''; ?>>Bank</option>
                            <option value="Kas" <?= $data['kas']['tipe_buku'] === 'Kas' ? 'selected' : ''; ?>>Kas</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tanggal" class="col-sm-2 col-form-label">TANGGAL</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tanggal" name="tanggal" placeholder="Masukkan Tanggal" value="<?= $data['kas']['tanggal']; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="no_bukti" class="col-sm-2 col-form-label">NO BUKTI</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="no_bukti" name="no_bukti" value="<?= $data['kas']['no_bukti']; ?>" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="keterangan" class="col-sm-2 col-form-label">KETERANGAN</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan" value="<?= $data['kas']['keterangan']; ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tipe_kategori" class="col-sm-2 col-form-label">JENIS TRANSAKSI</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="tipe_kategori" name="tipe_kategori" required>
                            <option value="" selected disabled>-- Pilih Tipe Kategori --</option>
                            <option value="Pemasukan" <?= $data['kas']['tipe_kategori'] === 'Pemasukan' ? 'selected' : ''; ?>>Pemasukan</option>
                            <option value="Pengeluaran" <?= $data['kas']['tipe_kategori'] === 'Pengeluaran' ? 'selected' : ''; ?>>Pengeluaran</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_kategori" class="col-sm-2 col-form-label">NAMA KATEGORI</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="nama_kategori" name="nama_kategori">
                            <!-- data diisi dari function updateKategoriOptions() -->
                            <option value="" selected disabled><?= $data['kas']['kategori']; ?></option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nominal_transaksi" class="col-sm-2 col-form-label">NOMINAL</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="nominal_transaksi" name="nominal_transaksi" value="<?= $data['kas']['nominal_transaksi']; ?>" placeholder="Masukkan Nominal" required>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-block btn-primary btn-lg mb-4" name="submit">Tambah</button>
        </form>
    </div>
</div>

<!-- /.card -->
</div>
<!-- /.container -->

<script>
    // Variabel untuk menyimpan data yang dipilih
    let selectedTipeKategori = null;
    let selectedNamaKategori = null;

    function updateSelectedData() {
        // Menyimpan nilai yang dipilih dari dropdown tipe_kategori
        selectedTipeKategori = document.getElementById('tipe_kategori').value;
        console.log("Tipe Kategori Terpilih:", selectedTipeKategori);

        // Jika tipe kategori sudah dipilih, kita dapat memperbarui dropdown nama_kategori (optional)
        updateKategoriOptions();
    }

    function updateKategoriOptions() {
        // Menyesuaikan pilihan nama_kategori berdasarkan tipe_kategori
        let namaKategoriDropdown = document.getElementById('nama_kategori');

        // Contoh: jika tipe_kategori adalah "Pemasukan", tampilkan kategori pemasukan
        if (selectedTipeKategori === 'Pemasukan') {
            // Isi nama_kategori dengan kategori pemasukan
            namaKategoriDropdown.innerHTML = `
            <option value="" selected disabled>-- Pilih Nama Kategori --</option>
        <?php foreach ($data['pemasukan'] as $kat) : ?>
                                <option value="<?= $kat['nama_kategori']; ?>"><?= $kat['nama_kategori']; ?></option>
                            <?php endforeach; ?>
        `;
        } else if (selectedTipeKategori === 'Pengeluaran') {
            // Isi nama_kategori dengan kategori pengeluaran
            namaKategoriDropdown.innerHTML = `
            <option value="" selected disabled>-- Pilih Nama Kategori --</option>
            <?php foreach ($data['pengeluaran'] as $kat) : ?>
                                <option value="<?= $kat['nama_kategori']; ?>"><?= $kat['nama_kategori']; ?></option>
                            <?php endforeach; ?>>
        `;
        } else {
            namaKategoriDropdown.innerHTML = `<option value="" selected disabled>-- Pilih Nama Kategori --</option>`;
        }
    }

    // Event listener untuk nama_kategori
    document.getElementById('nama_kategori').addEventListener('change', function() {
        selectedNamaKategori = this.value;
        // console.log("Nama Kategori Terpilih:", selectedNamaKategori);
    });
</script>