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
                <td><?= tglBiasaIndonesia($row['tanggal_upload']); ?></td>
                <td><?= $row['judul']; ?></td>
                <td><?= uang_indo_v2($row['total_anggaran']); ?></td>
                <td class="text-center"><span class="text-white badge text-uppercase bg-<?= $row['status'] === 'diterima' ? 'success' : ($row['status'] === 'ditolak' ? 'danger' : 'warning') ?>">
                    <?= ucfirst($row['status']); ?></span></td>
                <td class="text-center">
                  <button class="btn btn-sm btn-info btn-detail" data-toggle="modal" data-target="#detailModal"
                    data-id="<?= $row['id']; ?>"
                    data-judul="<?= $row['judul']; ?>"
                    data-deskripsi="<?= htmlspecialchars($row['deskripsi']); ?>"
                    data-total="<?= uang_indo_v2($row['total_anggaran']); ?>"
                    data-tanggal_upload="<?= tglBiasaIndonesia($row['tanggal_upload']); ?>"
                    data-tanggal_disetujui="<?= $row['tanggal_disetujui'] ? tglBiasaIndonesia($row['tanggal_disetujui']) : '-'; ?>"
                    data-status="<?= ucfirst($row['status']); ?>"
                    data-catatan="<?= $row['catatan_atasan'] ?? '-'; ?>"
                    data-file="<?= BASEURL . '/uploads/rab/' . $row['file_rab']; ?>">
                    Detail
                  </button>
                  <?php if ($role === 'Pimpinan' && $isDiajukan) : ?>
                    <a href="<?= BASEURL; ?>/pengajuan_anggaran/approve/<?= $row['id']; ?>" class="btn btn-sm btn-primary">Setujui/Tolak</a>

                  <?php elseif ($role === 'Pegawai' && $isOwner && $isDiajukan) : ?>
                    <a href="<?= BASEURL; ?>/pengajuan_anggaran/edit/<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                    <a href="<?= BASEURL; ?>/pengajuan_anggaran/delete/<?= $row['id']; ?>" class="btn btn-danger btn-sm tombol-hapus">Hapus</a>

                  <?php elseif ($role === 'Pegawai' && $isOwner && $row['status'] === 'ditolak') : ?>
                    <a href="<?= BASEURL; ?>/pengajuan_anggaran/edit/<?= $row['id']; ?>" class="btn btn-sm btn-secondary">Ajukan Lagi</a>

                  <?php elseif ($role === 'Admin') : ?>
                    <a href="<?= BASEURL; ?>/pengajuan_anggaran/edit/<?= $row['id']; ?>" class="btn btn-sm btn-warning">Edit Status</a>
                    <a href="<?= BASEURL; ?>/pengajuan_anggaran/delete/<?= $row['id']; ?>" class="btn btn-danger btn-sm tombol-hapus">Hapus</a>

                  <?php else : ?>
                    <span class="text-muted">Sudah diproses</span>
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
                    <th>Tanggal Disetujui</th>
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
                    <th>File RAB</th>
                    <td><a href="#" id="modalFile" target="_blank" class="btn btn-outline-primary btn-sm">Lihat File</a></td>
                  </tr>
                </table>
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
        document.getElementById("modalFile").setAttribute("href", this.dataset.file);
      });
    });
  });
</script>