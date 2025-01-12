<div class="container-fluid">
    <?php
    $flashData = Flasher::flash();  // Ambil data flash
    ?>
    <div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>

    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Tambah Data Transaksi</h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form action="<?= BASEURL; ?>/transaksi/tambah" method="POST">
            <div class="container mt-2">
                <div class="form-group row">
                    <label for="tipe_buku" class="col-sm-2 col-form-label">TIPE BUKU</label>
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
                    <label for="no_bukti" class="col-sm-2 col-form-label">NO BUKTI</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="no_bukti" name="no_bukti" placeholder="Masukkan No Bukti" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="keterangan" class="col-sm-2 col-form-label">KETERANGAN</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="keterangan" name="keterangan" placeholder="Masukkan Keterangan" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tipe_kategori" class="col-sm-2 col-form-label">JENIS TRANSAKSI</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="tipe_kategori" name="tipe_kategori" onchange="updateSelectedData()">
                            <option value="" selected disabled>-- Pilih Tipe Kategori --</option>
                            <option value="Pemasukan">Pemasukan</option>
                            <option value="Pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_kategori" class="col-sm-2 col-form-label">NAMA KATEGORI</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="nama_kategori" name="nama_kategori">
                            <!-- data diisi dari function updateKategoriOptions() -->
                            <option value="" selected disabled>-- Pilih Nama Kategori --</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nominal_transaksi" class="col-sm-2 col-form-label">NOMINAL</label>
                    <div class="col-sm-10">
                        <input type="input" class="form-control" id="nominal_transaksi" name="nominal_transaksi" placeholder="Masukkan Nominal" required>
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
    // Variabel untuk menyimpan data yang dipilih
    let selectedTipeKategori = null;
    let selectedNamaKategori = null;

    function updateSelectedData() {
        // Menyimpan nilai yang dipilih dari dropdown tipe_kategori
        selectedTipeKategori = document.getElementById('tipe_kategori').value;
        // console.log("Tipe Kategori Terpilih:", selectedTipeKategori);

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

    //nomor bukti otomatis

    document.getElementById('tipe_buku').addEventListener('change', function() {
        const tipeBuku = this.value;
        const tanggal = document.getElementById('tanggal').value;

        if (tipeBuku && tanggal) {
            fetchNoBukti(tipeBuku, tanggal);
        }
    });

    document.getElementById('tanggal').addEventListener('change', function() {
        const tipeBuku = document.getElementById('tipe_buku').value;
        const tanggal = this.value;

        if (tipeBuku && tanggal) {
            fetchNoBukti(tipeBuku, tanggal);
        }
    });

    function fetchNoBukti(tipeBuku, tanggal) {
        fetch(`<?= BASEURL; ?>/transaksi/getNomorBukti/${tipeBuku}/${tanggal}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('no_bukti').value = data;
            })
            .catch(error => console.error('Error:', error));
    }
</script>