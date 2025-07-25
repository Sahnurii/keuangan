<?php
$flashData = Flasher::flash();
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>

<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Edit Buku Pembantu Pajak</h3>
        </div>

        <form action="<?= BASEURL; ?>/buku_pajak/update" method="POST" id="form_transaksi_pajak">
            <input type="hidden" name="id" value="<?= $data['transaksi_pajak']['id']; ?>">
            <input type="hidden" name="id_transaksi_pembayaran" value="<?= $data['transaksi_pajak']['id_transaksi_pembayaran']; ?>">
            <input type="hidden" name="tipe_buku" value="<?= $data['transaksi_pajak']['tipe_buku']; ?>">

            <div class="container mt-2">
                <!-- Tipe Buku -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tipe Buku</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="tipe_buku_pajak" name="tipe_buku" disabled>
                            <option value="Kas" <?= $data['transaksi_pajak']['tipe_buku'] === 'Kas' ? 'selected' : '' ?>>Kas</option>
                            <option value="Bank" <?= $data['transaksi_pajak']['tipe_buku'] === 'Bank' ? 'selected' : '' ?>>Bank</option>
                            <option value="Pajak" <?= $data['transaksi_pajak']['tipe_buku'] === 'Pajak' ? 'selected' : '' ?>>Pajak</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row" id="div_sumber_saldo">
                    <label class="col-sm-2 col-form-label">Sumber Saldo</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="sumber_saldo" name="sumber_saldo" required>
                            <option value="" disabled <?= $data['transaksi_pajak']['sumber_saldo'] == '' ? 'selected' : ''; ?>>-- Pilih Sumber Saldo --</option>
                            <option value="Kas" <?= $data['transaksi_pajak']['sumber_saldo'] === 'Kas' ? 'selected' : ''; ?>>Kas</option>
                            <option value="Bank" <?= $data['transaksi_pajak']['sumber_saldo'] === 'Bank' ? 'selected' : ''; ?>>Bank</option>
                        </select>
                    </div>
                </div>

                <!-- Tanggal -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-10">
                        <input type="date" name="tanggal" id="tanggal_pajak" class="form-control" value="<?= $data['transaksi_pajak']['tanggal']; ?>" required>
                    </div>
                </div>

                <!-- No Bukti -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">No Bukti</label>
                    <div class="col-sm-10">
                        <input type="text" name="no_bukti" id="no_bukti_pajak" class="form-control" value="<?= $data['transaksi_pajak']['no_bukti']; ?>" readonly>
                    </div>
                </div>

                <!-- No Bukti Transaksi -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">No Bukti Transaksi</label>
                    <div class="col-sm-10">
                        <select class="form-control select2" id="no_bukti_transaksi" name="id_transaksi" required>
                            <?php foreach ($data['no_bukti_transaksi'] as $trx) : ?>
                                <option value="<?= $trx['id']; ?>" <?= $trx['id'] == $data['transaksi_pajak']['id_transaksi_sumber'] ? 'selected' : ''; ?>>
                                    <?= $trx['no_bukti']; ?> - <?= $trx['keterangan']; ?> - <?= number_format($trx['nominal_transaksi'], 2); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Jenis Pajak -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Jenis Pajak</label>
                    <div class="col-sm-10">
                        <select name="id_jenis_pajak" id="id_jenis_pajak" class="form-control select2">
                            <option value="">-- Pilih Jenis Pajak --</option>
                            <?php foreach ($data['jenis_pajak'] as $jp) : ?>
                                <option value="<?= $jp['id']; ?>" data-tarif="<?= $jp['tarif_pajak']; ?>" <?= $jp['id'] == $data['transaksi_pajak']['id_jenis_pajak'] ? 'selected' : ''; ?>>
                                    <?= $jp['id']; ?> - <?= $jp['tarif_pajak']; ?>% - <?= $jp['tipe']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <!-- Jenis Transaksi -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Jenis Transaksi</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="tipe_kategori" id="tipe_kategori_pajak" required>
                            <option value="Pemasukan" <?= $data['transaksi_pajak']['tipe_kategori'] === 'Pemasukan' ? 'selected' : '' ?>>Pemasukan</option>
                            <option value="Pengeluaran" <?= $data['transaksi_pajak']['tipe_kategori'] === 'Pengeluaran' ? 'selected' : '' ?>>Pengeluaran</option>
                        </select>
                    </div>
                </div>

                <!-- Kategori -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Kategori</label>
                    <div class="col-sm-10">
                        <select class="form-control select2" name="id_kategori" id="id_kategori_pajak" required>
                            <!-- opsi diisi via JS -->
                        </select>
                    </div>
                </div>

                <!-- Keterangan -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Keterangan</label>
                    <div class="col-sm-10">
                        <input type="text" name="keterangan" class="form-control" value="<?= $data['transaksi_pajak']['keterangan']; ?>" required>
                    </div>
                </div>

                <!-- Nominal -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nominal Transaksi</label>
                    <div class="col-sm-10">
                        <input type="number" step="0.01" name="nominal_transaksi" id="nominal_pajak" class="form-control" value="<?= $data['transaksi_pajak']['nominal_transaksi']; ?>" readonly>
                    </div>
                </div>

                <!-- Nilai Pajak -->
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Nilai Pajak</label>
                    <div class="col-sm-10">
                        <input type="number" step="0.01" name="nilai_pajak" id="nilai_pajak" class="form-control" value="<?= $data['transaksi_pajak']['nilai_pajak']; ?>" readonly>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block mb-4">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let selectedTipeKategori = null;
        let selectedNamaKategori = null;

        function updateSelectedData() {
            selectedTipeKategori = document.getElementById('tipe_kategori_pajak').value;
            updateKategoriOptions();
        }

        function updateKategoriOptions() {
            let namaKategoriDropdown = document.getElementById('id_kategori_pajak');
            let kategoriOptions = '<option value="" disabled>-- Pilih Nama Kategori --</option>';

            const selectedKategoriId = <?= json_encode($data['transaksi_pajak']['id_kategori']); ?>;

            if (selectedTipeKategori === 'Pemasukan') {
                kategoriOptions += `<?php foreach ($data['pemasukan'] as $kat): ?>
                <option value="<?= $kat['id']; ?>" <?= $kat['id'] == $data['transaksi_pajak']['id_kategori'] ? 'selected' : ''; ?>>
                    <?= $kat['nama_kategori']; ?>
                </option>
            <?php endforeach; ?>`;
            } else if (selectedTipeKategori === 'Pengeluaran') {
                kategoriOptions += `<?php foreach ($data['pengeluaran'] as $kat): ?>
                <option value="<?= $kat['id']; ?>" <?= $kat['id'] == $data['transaksi_pajak']['id_kategori'] ? 'selected' : ''; ?>>
                    <?= $kat['nama_kategori']; ?>
                </option>
            <?php endforeach; ?>`;
            }

            namaKategoriDropdown.innerHTML = kategoriOptions;
        }

        function hitungPajak() {
            const tarif = parseFloat(document.getElementById('id_jenis_pajak').selectedOptions[0]?.dataset.tarif || 0);
            const nominal = parseFloat(document.getElementById('nominal_pajak').value || 0);
            const pajak = (nominal * tarif / 100).toFixed(2);
            document.getElementById('nilai_pajak').value = pajak;
        }

        function isiDropdownKategori(tipe, idKategori) {
            let namaKategoriDropdown = document.getElementById('id_kategori_pajak');
            let kategoriOptions = '<option value="" disabled>-- Pilih Nama Kategori --</option>';
            if (tipe === 'Pemasukan') {
                kategoriOptions += `<?php foreach ($data['pemasukan'] as $kat): ?>
                <option value="<?= $kat['id']; ?>" ${<?= $kat['id']; ?> == idKategori ? 'selected' : ''}>
                    <?= $kat['nama_kategori']; ?>
                </option>
            <?php endforeach; ?>`;
            } else if (tipe === 'Pengeluaran') {
                kategoriOptions += `<?php foreach ($data['pengeluaran'] as $kat): ?>
                <option value="<?= $kat['id']; ?>" ${<?= $kat['id']; ?> == idKategori ? 'selected' : ''}>
                    <?= $kat['nama_kategori']; ?>
                </option>
            <?php endforeach; ?>`;
            }
            namaKategoriDropdown.innerHTML = kategoriOptions;
        }

        // Trigger saat pertama kali load
        updateSelectedData();
        hitungPajak();

        // Event listeners
        document.getElementById('id_jenis_pajak').addEventListener('change', hitungPajak);
        document.getElementById('nominal_pajak').addEventListener('input', hitungPajak);

        document.getElementById('no_bukti_transaksi').addEventListener('change', function() {
            const transaksiId = this.value;
            fetch(`<?= BASEURL; ?>/transaksi/getNominalById/${transaksiId}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.nominal !== undefined) {
                        document.getElementById('nominal_pajak').value = data.nominal;
                        hitungPajak();
                    }
                });
        });

        document.getElementById('tipe_kategori_pajak').addEventListener('change', updateSelectedData);
    });
</script>