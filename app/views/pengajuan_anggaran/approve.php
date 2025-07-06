<div class="container-fluid">
  <div class="card card-info">
    <div class="card-header bg-primary">
      <h3 class="card-title text-center text-white">Persetujuan Pengajuan Anggaran</h3>
    </div>
    <div class="card-body">
      <form action="<?= BASEURL; ?>/pengajuan_anggaran/approve/<?= $data['pengajuan']['id']; ?>" method="post">
        <div class="form-group">
          <label>Judul</label>
          <input type="text" class="form-control" value="<?= $data['pengajuan']['judul']; ?>" readonly>
        </div>
        <div class="form-group">
          <label>Deskripsi</label>
          <textarea class="form-control" rows="3" readonly><?= $data['pengajuan']['deskripsi']; ?></textarea>
        </div>
        <div class="form-group">
          <label>Total Anggaran</label>
          <input type="text" class="form-control" value="Rp<?= number_format($data['pengajuan']['total_anggaran'], 0, ',', '.'); ?>" readonly>
        </div>
        <div class="form-group">
          <label>File RAB</label><br>
          <a href="<?= BASEURL; ?>/uploads/rab/<?= $data['pengajuan']['file_rab']; ?>" target="_blank" class="btn btn-outline-primary btn-sm">Lihat File</a>
        </div>
        <div class="form-group">
          <label>Status Persetujuan</label>
          <select name="status" class="form-control" required>
            <option value="">-- Pilih Status --</option>
            <option value="diterima">Diterima</option>
            <option value="ditolak">Ditolak</option>
          </select>
        </div>
        <div class="form-group">
          <label>Catatan Atasan</label>
          <textarea name="catatan_atasan" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="<?= BASEURL; ?>/pengajuanAnggaran" class="btn btn-secondary">Kembali</a>
      </form>
    </div>
  </div>
</div>
</div>