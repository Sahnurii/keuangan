  <?php
  $flashData = Flasher::flash();  // Ambil data flash
  ?>
  <div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
  <div class="container-fluid">
    <div class="card card-info">
      <div class="card-header bg-primary">
        <h3 class="card-title text-center text-white">Form Tambah Pengajuan Anggaran</h3>
      </div>
      <div class="card-body">
        <form action="<?= BASEURL; ?>/pengajuan_anggaran/tambah" method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="judul">Judul Pengajuan</label>
            <input type="text" class="form-control" name="judul" id="judul" required>
          </div>
          <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="3" class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label for="total_anggaran">Total Anggaran</label>
            <input type="number" class="form-control" name="total_anggaran" id="total_anggaran" required>
          </div>
          <div class="form-group">
            <label for="file_rab">Upload File RAB</label>
            <input type="file" class="form-control" name="file_rab" id="file_rab" accept=".pdf,.doc,.docx" required>
          </div>
          <button type="submit" class="btn btn-success">Ajukan</button>
          <a href="<?= BASEURL; ?>/pengajuanAnggaran" class="btn btn-secondary">Kembali</a>
        </form>
      </div>
    </div>
  </div>
