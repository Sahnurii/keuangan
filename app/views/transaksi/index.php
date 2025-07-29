<div class="container-fluid">
    <?php
    $flashData = Flasher::flash();  // Ambil data flash
    ?>
    <div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>

    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Transaksi</h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form action="<?= BASEURL; ?>/transaksi/tambah" method="POST" id="form_transaksi_umum">
            <div class="card card-info">
                <div class="container mt-2">
                    <!-- Tipe Buku -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tipe Buku</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="tipe_buku_umum" name="tipe_buku" required>
                                <option value="" selected disabled>-- Pilih Tipe Buku --</option>
                                <option value="Kas">Kas</option>
                                <option value="Bank">Bank</option>
                                <option value="Pajak">Pajak</option>
                            </select>
                        </div>
                    </div>

                    <!-- Form umum -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-10">
                            <input type="date" name="tanggal" id="tanggal_umum" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">No Bukti</label>
                        <div class="col-sm-10">
                            <input type="text" name="no_bukti" id="no_bukti_umum" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <input type="text" name="keterangan" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Jenis Transaksi</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tipe_kategori" id="tipe_kategori_umum">
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Pemasukan">Pemasukan</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" name="id_kategori" id="id_kategori_umum" required>

                                <!-- JS akan isi berdasarkan tipe -->
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nominal</label>
                        <div class="col-sm-10">
                            <input type="number" name="nominal_transaksi" class="form-control" step="0.01" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mb-4">Simpan Transaksi Umum</button>
                </div>
            </div>
        </form>

        <!-- FORM TRANSAKSI PAJAK -->
        <form action="<?= BASEURL; ?>/transaksi/tambahPajak" method="POST" id="form_transaksi_pajak" class="d-none">
            <div class="card card-danger">
                <div class="container mt-2">
                    <!-- Form Pajak -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tipe Buku</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="tipe_buku_pajak" name="tipe_buku" required>
                                <option value="" selected disabled>-- Pilih Tipe Buku --</option>
                                <option value="Kas">Kas</option>
                                <option value="Bank">Bank</option>
                                <option value="Pajak">Pajak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Sumber Saldo</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="sumber_saldo" name="sumber_saldo" required>
                                <option value="" selected disabled>-- Pilih Sumber Saldo --</option>
                                <option value="Kas">Kas</option>
                                <option value="Bank">Bank</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tanggal</label>
                        <div class="col-sm-10">
                            <input type="date" name="tanggal" id="tanggal_pajak" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">No Bukti</label>
                        <div class="col-sm-10">
                            <input type="text" name="no_bukti" id="no_bukti_pajak" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">No Bukti Transaksi</label>
                        <div class="col-sm-10">
                            <select class="form-control select2" id="no_bukti_transaksi" name="id_transaksi" required>
                                <option value="" selected disabled>-- Pilih Transaksi --</option>
                                <?php foreach ($data['no_bukti_transaksi'] as $trx) : ?>
                                    <option value="<?= $trx['id']; ?>"><?= tglSingkatIndonesia($trx['tanggal']); ?> - <?= $trx['no_bukti']; ?> - <?= $trx['keterangan']; ?> - <?= uang_indo($trx['nominal_transaksi']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Jenis Pajak</label>
                        <div class="col-sm-10">
                            <select name="id_jenis_pajak" id="id_jenis_pajak" class="form-control select2">
                                <option value="">-- Pilih Jenis Pajak --</option>
                                <?php foreach ($data['jenis_pajak'] as $jp) : ?>
                                    <option
                                        value="<?= $jp['id']; ?>"
                                        data-tarif="<?= $jp['tarif_pajak']; ?>">
                                        <?= $jp['id']; ?> - <?= $jp['tarif_pajak'], ' %'; ?> - <?= $jp['tipe']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Jenis Transaksi</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="tipe_kategori" id="tipe_kategori_pajak">
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Pemasukan">Pemasukan</option>
                                <option value="Pengeluaran">Pengeluaran</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Kategori</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="id_kategori" id="id_kategori_pajak" required>
                                <!-- akan diisi secara dinamis oleh JS -->
                            </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                            <input type="text" name="keterangan" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nominal Transaksi</label>
                        <div class="col-sm-10">
                            <input type="number" name="nominal_transaksi" id="nominal_pajak" class="form-control" step="0.01" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nilai Pajak</label>
                        <div class="col-sm-10">
                            <input type="number" name="nilai_pajak" id="nilai_pajak" class="form-control" step="0.01" readonly>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-danger btn-block mb-4">Simpan Transaksi Pajak</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- /.card -->
</div>
<!-- /.container -->

<script>
    // Fungsi fetch nomor bukti otomatis
    function fetchNoBukti(tipeBuku, tanggal) {
        const sumberSaldo = document.getElementById('sumber_saldo')?.value || '';

        const url = tipeBuku === 'Pajak' ?
            `<?= BASEURL; ?>/transaksi/getNomorBuktiPajak/${tipeBuku}/${tanggal}` :
            `<?= BASEURL; ?>/transaksi/getNomorBukti/${tipeBuku}/${tanggal}`;

        fetch(url)
            .then(response => response.text())
            .then(noBukti => {
                const inputId = tipeBuku === 'Pajak' ? 'no_bukti_pajak' : 'no_bukti_umum';
                document.getElementById(inputId).value = noBukti.trim();
            })
            .catch(error => console.error('Gagal fetch nomor bukti:', error));
    }


    // Event saat Tipe Buku dipilih
    document.querySelectorAll('#tipe_buku_umum, #tipe_buku_pajak').forEach(select => {
        select.addEventListener('change', function() {
            const tipe = this.value;
            const formUmum = document.getElementById('form_transaksi_umum');
            const formPajak = document.getElementById('form_transaksi_pajak');

            // Sinkronisasi nilai ke kedua select
            document.querySelectorAll('#tipe_buku_umum, #tipe_buku_pajak').forEach(otherSelect => {
                if (otherSelect !== this) {
                    otherSelect.value = tipe;
                }
            });

            if (tipe === 'Pajak') {
                formUmum.classList.add('d-none');
                formUmum.reset(); // reset form umum
                formPajak.classList.remove('d-none');
            } else {
                formUmum.classList.remove('d-none');
                formPajak.reset(); // reset form pajak
                formPajak.classList.add('d-none');
            }

            const tanggal = tipe === 'Pajak' ?
                document.getElementById('tanggal_pajak').value :
                document.getElementById('tanggal_umum')?.value;

            if (tipe && tanggal) {
                fetchNoBukti(tipe, tanggal);
            }
        });

    });


    document.getElementById('tanggal_umum').addEventListener('change', function() {
        const tipe = document.getElementById('tipe_buku_umum').value;
        const tanggal = this.value;
        if (tipe && tanggal) {
            fetchNoBukti(tipe, tanggal);
        }
    });

    document.getElementById('tanggal_pajak').addEventListener('change', function() {
        const tipe = document.getElementById('tipe_buku_pajak').value;
        const tanggal = this.value;
        if (tipe && tanggal) {
            fetchNoBukti(tipe, tanggal);
        }
    });

    // Dropdown kategori berdasarkan tipe kategori (Pemasukan/Pengeluaran)
    function updateKategoriDropdown(tipeKategori, targetDropdownId) {
        let options = `<option value="">-- Pilih Kategori --</option>`;
        if (tipeKategori === 'Pemasukan') {
            <?php foreach ($data['pemasukan'] as $kat) : ?>
                options += `<option value="<?= $kat['id']; ?>"><?= $kat['nama_kategori']; ?></option>`;
            <?php endforeach; ?>
        } else if (tipeKategori === 'Pengeluaran') {
            <?php foreach ($data['pengeluaran'] as $kat) : ?>
                options += `<option value="<?= $kat['id']; ?>"><?= $kat['nama_kategori']; ?></option>`;
            <?php endforeach; ?>
        }
        document.getElementById(targetDropdownId).innerHTML = options;
    }

    // Event untuk form umum
    document.getElementById('tipe_kategori_umum').addEventListener('change', function() {
        updateKategoriDropdown(this.value, 'id_kategori_umum');
    });

    // Event untuk form pajak
    document.getElementById('tipe_kategori_pajak').addEventListener('change', function() {
        updateKategoriDropdown(this.value, 'id_kategori_pajak');
    });


    // // Fungsi hitung nilai pajak otomatis
    // function hitungPajak() {
    //     const tarif = parseFloat(document.getElementById('id_jenis_pajak').selectedOptions[0]?.dataset.tarif || 0);
    //     const nominal = parseFloat(document.getElementById('nominal_pajak').value || 0);
    //     const pajak = (nominal * tarif / 100).toFixed(2);
    //     document.getElementById('nilai_pajak').value = pajak;
    // }

    // // Hitung ulang pajak saat jenis pajak atau nominal berubah
    // document.getElementById('id_jenis_pajak').addEventListener('change', hitungPajak);
    // document.getElementById('nominal_pajak').addEventListener('input', hitungPajak);

    // // Ambil nominal dari transaksi utama saat No Bukti Transaksi dipilih
    // document.getElementById('no_bukti_transaksi').addEventListener('change', function() {
    //     const transaksiId = this.value;

    //     fetch(`<?= BASEURL; ?>/transaksi/getNominalById/${transaksiId}`)
    //         .then(response => response.json())
    //         .then(data => {
    //             if (data && data.nominal !== undefined && data.nominal !== null) {
    //                 document.getElementById('nominal_pajak').value = data.nominal;
    //                 hitungPajak(); // panggil ulang fungsi hitung
    //             } else {
    //                 document.getElementById('nominal_pajak').value = '';
    //                 document.getElementById('nilai_pajak').value = '';
    //             }
    //         })

    //         .catch(error => {
    //             console.error('Gagal fetch nominal transaksi:', error);
    //         });
    // });
</script>