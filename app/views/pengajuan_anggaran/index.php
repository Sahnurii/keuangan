<div class="container-fluid">
  <div class="card card-info">
    <div class="card-header bg-primary">
      <h3 class="card-title text-center text-white">Daftar Pengajuan Anggaran</h3>
    </div>
    <div class="card-body">
      <a href="<?= BASEURL; ?>/pengajuan_anggaran/tambah" class="btn btn-success mb-3">+ Tambah Pengajuan</a>
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $no = 1; foreach ($data['pengajuan'] as $row) : ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= $row['judul']; ?></td>
              <td><?= $row['deskripsi']; ?></td>
              <td>Rp<?= number_format($row['total_anggaran'], 0, ',', '.'); ?></td>
              <td><span class="badge bg-<?= $row['status'] === 'disetujui' ? 'success' : ($row['status'] === 'ditolak' ? 'danger' : 'warning') ?>">
                  <?= ucfirst($row['status']); ?></span></td>
              <td>
                <?php if ($row['status'] === 'diajukan') : ?>
                  <a href="<?= BASEURL; ?>/pengajuan_anggaran/approve/<?= $row['id']; ?>" class="btn btn-sm btn-primary">Setujui/Tolak</a>
                <?php else : ?>
                  <span class="text-muted">Sudah diproses</span>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
