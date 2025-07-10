<?php
$flashData = Flasher::flash();  // Ambil data flash
$role = $_SESSION['user']['role'];
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">

  <div class="card card-info">
    <div class="card-header bg-primary">
      <h3 class="card-title text-center text-white">Daftar Pengajuan Anggaran</h3>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <div class="mb-3">
          <a href="<?= BASEURL; ?>/pengajuan_anggaran/tambah" class="btn btn-success mb-3">+ Tambah Pengajuan</a>
        </div>
        <div class="mb-3">
          <form method="GET" class="form-inline mb-3">
            <select name="status" class="form-control mr-2">
              <option value="">-- Filter Status --</option>
              <option value="diajukan" <?= ($_GET['status'] ?? '') == 'diajukan' ? 'selected' : '' ?>>Diajukan</option>
              <option value="diterima" <?= ($_GET['status'] ?? '') == 'diterima' ? 'selected' : '' ?>>Diterima</option>
              <option value="ditolak" <?= ($_GET['status'] ?? '') == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
            </select>

            <?php if ($_SESSION['user']['role'] === 'Admin' || $_SESSION['user']['role'] === 'Pimpinan') : ?>
              <select name="pengaju" class="form-control mr-2">
                <option value="">-- Semua Pengaju --</option>
                <?php foreach ($data['pegawai'] as $p) : ?>
                  <option value="<?= $p['id'] ?>" <?= ($_GET['pengaju'] ?? '') == $p['id'] ? 'selected' : '' ?>>
                    <?= $p['nama'] ?>
                  </option>
                <?php endforeach; ?>
              </select>
            <?php endif; ?>

            <button type="submit" class="btn btn-primary">Tampilkan</button>
            <a href="<?= BASEURL ?>/pengajuan_anggaran" class="btn btn-secondary ml-2">Reset</a>
          </form>
        </div>
        <table id="dataTable" class="table table-bordered table-hover">
          <thead>
            <tr class="text-center">
              <th>No</th>
              <?php if ($role === 'Admin' || $role === 'Pimpinan') : ?>
                <th>Pengaju</th>
              <?php endif; ?>
              <th>Tanggal Upload</th>
              <th>Judul</th>
              <th>Total</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1;
            foreach ($data['pengajuan'] as $row) :

              $isOwner = $_SESSION['user']['id_pegawai'] == $row['id_pegawai'];
              $isDiajukan = $row['status'] === 'diajukan'; ?>

              <tr>
                <td class="text-center"><?= $no++; ?></td>
                <?php if ($role === 'Admin' || $role === 'Pimpinan') : ?>
                  <td><?= $row['nama_pegawai']; ?></td>
                <?php endif; ?>
                <td class="text-center"><?= tglBiasaIndonesia($row['tanggal_upload']); ?></td>
                <td><?= $row['judul']; ?></td>
                <td><?= uang_indo($row['total_anggaran']); ?></td>
                <td class="text-center">
                  <?php
                  $status = $row['status'];
                  $class = 'badge-status badge-' . $status;
                  echo "<span class='{$class}'>" . ucfirst($status) . "</span>";
                  ?>
                </td>
                <td class="text-center">
                  <button class="btn btn-sm btn-info btn-detail" data-toggle="modal" data-target="#detailModal"
                    data-id="<?= $row['id']; ?>"
                    data-judul="<?= $row['judul']; ?>"
                    data-deskripsi="<?= htmlspecialchars($row['deskripsi']); ?>"
                    data-total="<?= uang_indo($row['total_anggaran']); ?>"
                    data-tanggal_upload="<?= tglBiasaIndonesia($row['tanggal_upload']); ?>"
                    data-tanggal_disetujui="<?= $row['tanggal_disetujui'] ? tglBiasaIndonesia($row['tanggal_disetujui']) : '-'; ?>"
                    data-status="<?= ucfirst($row['status']); ?>"
                    data-catatan="<?= $row['catatan_atasan'] ?? '-'; ?>"
                    data-disetujui_oleh="<?= $row['nama_pimpinan'] ?? '-' ?>"
                    data-file="<?= BASEURL . '/uploads/rab/' . $row['file_rab']; ?>">
                    Detail
                  </button>
                  <?php if ($role === 'Pimpinan' && $isDiajukan) : ?>
                    <a href="<?= BASEURL; ?>/pengajuan_anggaran/approve/<?= $row['id']; ?>" class="btn btn-sm btn-primary">Setujui/Tolak</a>

                  <?php elseif (in_array($role, ['Pegawai', 'Petugas']) && $isOwner && $isDiajukan) : ?>
                    <a href="<?= BASEURL; ?>/pengajuan_anggaran/edit/<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="<?= BASEURL; ?>/pengajuan_anggaran/delete/<?= $row['id']; ?>" class="btn btn-danger btn-sm tombol-hapus">Hapus</a>

                  <?php elseif (in_array($role, ['Pegawai', 'Petugas']) && $isOwner && $row['status'] === 'ditolak') : ?>
                    <a href="<?= BASEURL; ?>/pengajuan_anggaran/edit/<?= $row['id']; ?>" class="btn btn-sm btn-secondary">Ajukan Lagi</a>

                  <?php elseif ($role === 'Admin') : ?>
                    <a href="<?= BASEURL; ?>/pengajuan_anggaran/edit/<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit Status</a>
                    <a href="<?= BASEURL; ?>/pengajuan_anggaran/delete/<?= $row['id']; ?>" class="btn btn-danger btn-sm tombol-hapus">Hapus</a>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <!-- Modal Detail -->
        <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalDetailLabel">Detail Pengajuan Anggaran</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <table class="table table-borderless">
                  <tr>
                    <th>Judul</th>
                    <td id="modalJudul"></td>
                  </tr>
                  <tr>
                    <th>Deskripsi</th>
                    <td id="modalDeskripsi"></td>
                  </tr>
                  <tr>
                    <th>Total Anggaran</th>
                    <td id="modalTotal"></td>
                  </tr>
                  <tr>
                    <th>Tanggal Upload</th>
                    <td id="modalTanggalUpload"></td>
                  </tr>
                  <tr>
                    <th>Tanggal Verifikasi</th>
                    <td id="modalTanggalDisetujui"></td>
                  </tr>
                  <tr>
                    <th>Status</th>
                    <td id="modalStatus"></td>
                  </tr>
                  <tr>
                    <th>Catatan Pimpinan</th>
                    <td id="modalCatatan"></td>
                  </tr>
                  <tr>
                    <th>Disetujui Oleh</th>
                    <td id="modalDisetujuiOleh"></td>
                  </tr>
                  <tr>
                    <th>File RAB</th>
                    <td><a href="#" id="modalFile" target="_blank" class="btn btn-outline-primary btn-sm">Lihat File</a></td>
                  </tr>
                </table>
                <div id="modalLangkahSelanjutnya"></div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<script>
  document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".btn-detail").forEach(function(btn) {
      btn.addEventListener("click", function() {
        document.getElementById("modalJudul").textContent = this.dataset.judul;
        document.getElementById("modalDeskripsi").textContent = this.dataset.deskripsi;
        document.getElementById("modalTotal").textContent = this.dataset.total;
        document.getElementById("modalTanggalUpload").textContent = this.dataset.tanggal_upload;
        document.getElementById("modalTanggalDisetujui").textContent = this.dataset.tanggal_disetujui;
        document.getElementById("modalStatus").textContent = this.dataset.status;
        document.getElementById("modalCatatan").textContent = this.dataset.catatan;
        document.getElementById("modalDisetujuiOleh").textContent = this.dataset.disetujui_oleh;
        document.getElementById("modalFile").setAttribute("href", this.dataset.file);
        // Tampilkan petunjuk jika status = Diterima dan role = Pegawai
        const langkahSelanjutnya = document.getElementById("modalLangkahSelanjutnya");
        if (this.dataset.status.toLowerCase() === "diterima" && "<?= $role ?>" === "Pegawai") {
          langkahSelanjutnya.innerHTML = `
    <div class="alert alert-info mt-3">
      <strong>Langkah Selanjutnya:</strong> Silakan cetak Lembar Persetujuan dibawah ini, kemudian serahkan ke Admin Keuangan untuk proses realisasi anggaran.
      <br>
      <a href="<?= BASEURL ?>/pengajuan_anggaran/cetak/${this.dataset.id}" target="_blank" class="btn btn-outline-primary btn-sm mt-2">Cetak Lembar Persetujuan</a>
    </div>
  `;
        } else {
          langkahSelanjutnya.innerHTML = '';
        }

      });
    });
  });
</script>