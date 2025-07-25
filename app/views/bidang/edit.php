<div class="container-fluid">

    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Edit Data Jabatan dan Bidang</h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form action="<?= BASEURL; ?>/bidang/update" method="POST" id="formEdit">
            <input type="hidden" name="id" id="id" value="<?= $data['bidang']['id']; ?>">
            <div class="container mt-2">
                <div class="form-group row">
                    <label for="jabatan" class="col-sm-2 col-form-label">JABATAN</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukkan Nama Bidang" value="<?= $data['bidang']['jabatan']; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama_bidang" class="col-sm-2 col-form-label">NAMA BIDANG</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_bidang" name="nama_bidang" placeholder="Masukkan Nama Bidang" value="<?= $data['bidang']['nama_bidang']; ?>" required>
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