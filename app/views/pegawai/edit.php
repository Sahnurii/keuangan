<div class="container-fluid">

    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Edit Data Pegawai</h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form action="<?= BASEURL; ?>/pegawai/update" method="POST" id="formEdit">
            <input type="hidden" name="id" id="id" value="<?= $data['pegawai']['id']; ?>">
            <div class="container mt-2">
                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">NAMA PEGAWAI</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Pegawai" value="<?= $data['pegawai']['nama']; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nipy" class="col-sm-2 col-form-label">NIPY</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="nipy" name="nipy" placeholder="Masukkan Nipy Pegawai" value="<?= $data['pegawai']['nipy']; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bidang" class="col-sm-2 col-form-label">BIDANG</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="bidang" name="bidang" required>
                            <option value="" disabled <?= empty($data['pegawai']['bidang']) ? 'selected' : '' ?>>Pilih Bidang</option>
                            <?php foreach ($data['bidang'] as $b) : ?>
                                <option value="<?= $b['id']; ?>" <?= ($b['id'] == $data['pegawai']['bidang']) ? 'selected' : '' ?>>
                                    <?= $b['nama_bidang']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="rekening" class="col-sm-2 col-form-label">REKENING</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="rekening" name="rekening" placeholder="Masukkan Rekening Pegawai" value="<?= $data['pegawai']['rekening']; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="bank" class="col-sm-2 col-form-label">BANK</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="bank" name="bank" placeholder="Masukkan Bank Pegawai" value="<?= $data['pegawai']['bank']; ?>" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-primary btn-lg mb-4" name="submit">Edit</button>
            </div>
        </form>


    </div>
</div>
<!-- /.card -->
</div>
<!-- /.container -->