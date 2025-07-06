<?php
$flashData = Flasher::flash();  // Ambil data flash
$role = $_SESSION['user']['role'];
$pengajuan = $data['pengajuan'];
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Edit Pengajuan Anggaran</h3>
        </div>
        <div class="card-body">
            <form action="<?= BASEURL; ?>/pengajuan_anggaran/update/<?= $data['pengajuan']['id']; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data['pengajuan']['id']; ?>">
                <?php if ($role === 'Admin') : ?>
                    <div class="form-group">
                        <label>Status Pengajuan</label>
                        <select name="status" class="form-control" required>
                            <option value="diajukan" <?= $pengajuan['status'] === 'diajukan' ? 'selected' : ''; ?>>DIAJUKAN</option>
                            <option value="ditolak" <?= $pengajuan['status'] === 'ditolak' ? 'selected' : ''; ?>>DITOLAK</option>
                            <option value="diterima" <?= $pengajuan['status'] === 'diterima' ? 'selected' : ''; ?>>DITERIMA</option>
                        </select>
                    </div>

                <?php else : ?>
                <div class="form-group">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control" value="<?= $data['pengajuan']['judul']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="3" required><?= $data['pengajuan']['deskripsi']; ?></textarea>
                </div>
                <div class="form-group">
                    <label>Total Anggaran</label>
                    <input type="number" name="total_anggaran" class="form-control" value="<?= $data['pengajuan']['total_anggaran']; ?>" required>
                </div>
                <div class="form-group">
                    <label>File RAB (biarkan kosong jika tidak diubah)</label><br>
                    <a href="<?= BASEURL; ?>/uploads/rab/<?= $data['pengajuan']['file_rab']; ?>" target="_blank" class="btn btn-outline-primary btn-sm mb-2">Lihat File Sebelumnya</a>
                    <input type="file" name="file_rab" class="form-control-file">
                </div>
                <input type="hidden" name="file_rab_lama" value="<?= $data['pengajuan']['file_rab']; ?>">
                <?php endif; ?>
                <button type="submit" class="btn btn-success">Update</button>
                <a href="<?= BASEURL; ?>/pengajuan_anggaran" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
</div>