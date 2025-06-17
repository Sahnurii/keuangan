<?php
$flashData = Flasher::flash();
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>

<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Edit Buku Pembantu Pajak</h3>
        </div>

        <form action="<?= BASEURL; ?>/buku_pajak/update" method="POST">
        <input type="hidden" name="id" value="<?= $data['transaksi_pajak']['id']; ?>">

        <!-- TIPE BUKU -->
        <select name="tipe_buku" class="form-control" required>
            <option disabled>-- Pilih Tipe Buku --</option>
            <option value="Bank" <?= $data['transaksi_pajak']['tipe_buku'] === 'Bank' ? 'selected' : ''; ?>>Bank</option>
            <option value="Kas" <?= $data['transaksi_pajak']['tipe_buku'] === 'Kas' ? 'selected' : ''; ?>>Kas</option>
            <option value="Pajak" <?= $data['transaksi_pajak']['tipe_buku'] === 'Pajak' ? 'selected' : ''; ?>>Pajak</option>
        </select>

        <!-- TANGGAL -->
        <input type="date" name="tanggal" class="form-control" value="<?= $data['transaksi_pajak']['tanggal']; ?>" required>

        <!-- NO BUKTI TRANSAKSI -->
        <select name="id_transaksi" class="form-control" required>
            <?php foreach ($data['no_bukti_transaksi'] as $trx) : ?>
                <option value="<?= $trx['id']; ?>" <?= $trx['id'] == $data['transaksi_pajak']['id_transaksi'] ? 'selected' : ''; ?>>
                    <?= $trx['no_bukti']; ?> - <?= $trx['keterangan']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- JENIS PAJAK -->
        <select name="id_jenis_pajak" class="form-control" id="id_jenis_pajak">
            <?php foreach ($data['jenis_pajak'] as $jp) : ?>
                <option value="<?= $jp['id']; ?>"
                    data-tarif="<?= $jp['tarif_pajak']; ?>"
                    <?= $jp['id'] == $data['transaksi_pajak']['id_jenis_pajak'] ? 'selected' : ''; ?>>
                    <?= $jp['id']; ?> - <?= $jp['tarif_pajak']; ?>% - <?= $jp['tipe']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- NO BUKTI -->
        <input type="text" name="no_bukti" class="form-control" id="no_bukti" value="<?= $data['transaksi_pajak']['no_bukti']; ?>" readonly>

        <!-- KETERANGAN -->
        <input type="text" name="keterangan" class="form-control" value="<?= $data['transaksi_pajak']['keterangan']; ?>" required>

        <!-- TIPE KATEGORI -->
        <select name="tipe_kategori" class="form-control" id="tipe_kategori" onchange="updateSelectedData()" required>
            <option disabled>-- Pilih Tipe Kategori --</option>
            <option value="Pemasukan" <?= $data['transaksi_pajak']['tipe_kategori'] === 'Pemasukan' ? 'selected' : ''; ?>>Pemasukan</option>
            <option value="Pengeluaran" <?= $data['transaksi_pajak']['tipe_kategori'] === 'Pengeluaran' ? 'selected' : ''; ?>>Pengeluaran</option>
        </select>

        <!-- NAMA KATEGORI -->
        <select name="nama_kategori" id="nama_kategori" class="form-control select2">
            <?php
            $kategoriList = $data['transaksi_pajak']['tipe_kategori'] === 'Pemasukan' ? $data['pemasukan'] : $data['pengeluaran'];
            foreach ($kategoriList as $kat) :
            ?>
                <option value="<?= $kat['nama_kategori']; ?>" <?= $kat['nama_kategori'] == $data['transaksi_pajak']['nama_kategori'] ? 'selected' : ''; ?>>
                    <?= $kat['nama_kategori']; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <!-- NOMINAL -->
        <input type="number" step="0.01" name="nominal_transaksi" id="nominal_transaksi" class="form-control" value="<?= $data['transaksi_pajak']['nominal_transaksi']; ?>" readonly>

        <!-- NILAI PAJAK -->
        <input type="number" step="0.01" name="nilai_pajak" id="nilai_pajak" class="form-control" value="<?= $data['transaksi_pajak']['nilai_pajak']; ?>" readonly>

        <button type="submit" class="btn btn-primary btn-block mt-4">Simpan Perubahan</button>
        </form>
    </div>
</div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "-- Pilih Nama Kategori --",
            allowClear: true
        });
    });

    function updateSelectedData() {
        const tipeKategori = document.getElementById('tipe_kategori').value;
        const kategoriDropdown = document.getElementById('nama_kategori');
        let options = `<option value="" disabled>-- Pilih Nama Kategori --</option>`;

        <?php
        $pemasukanJson = json_encode(array_column($data['pemasukan'], 'nama_kategori'));
        $pengeluaranJson = json_encode(array_column($data['pengeluaran'], 'nama_kategori'));
        ?>

        const pemasukan = <?= $pemasukanJson; ?>;
        const pengeluaran = <?= $pengeluaranJson; ?>;

        const list = tipeKategori === 'Pemasukan' ? pemasukan : pengeluaran;
        list.forEach(kat => {
            options += `<option value="${kat}">${kat}</option>`;
        });

        kategoriDropdown.innerHTML = options;
        $('.select2').select2({
            placeholder: "-- Pilih Nama Kategori --",
            allowClear: true
        });
    }

    document.getElementById('tipe_buku').addEventListener('change', function() {
        const tipeBuku = this.value;
        const sumberDiv = document.getElementById('div_sumber_saldo');
        sumberDiv.classList.toggle('d-none', tipeBuku !== 'Pajak');
        if (tipeBuku !== 'Pajak') {
            document.getElementById('sumber_saldo').value = '';
        }

        const tanggal = document.getElementById('tanggal').value;
        if (tipeBuku && tanggal) fetchNoBukti(tipeBuku, tanggal);
    });

    document.getElementById('tanggal').addEventListener('change', function() {
        const tipeBuku = document.getElementById('tipe_buku').value;
        const tanggal = this.value;
        if (tipeBuku && tanggal) fetchNoBukti(tipeBuku, tanggal);
    });

    function fetchNoBukti(tipeBuku, tanggal) {
        fetch(`<?= BASEURL; ?>/transaksi/getNomorBukti/${tipeBuku}/${tanggal}`)
            .then(res => res.text())
            .then(data => {
                document.getElementById('no_bukti').value = data;
            })
            .catch(err => console.error('Gagal ambil no bukti:', err));
    }

    // Trigger default kategori saat load
    window.addEventListener('load', updateSelectedData);
</script>