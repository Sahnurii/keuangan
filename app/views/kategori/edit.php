<div class="container-fluid">

    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Edit Data Kategori</h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form action="<?= BASEURL; ?>/kategori/update" method="POST" id="formEdit">
            <input type="hidden" name="id" id="id" value="<?= $data['ktg']['id']; ?>">
            <div class="container mt-2">
                <div class="form-group row">
                    <label for="nama_kategori" class="col-sm-2 col-form-label">NAMA KATEGORI</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Masukkan Nama Kategori" value="<?= $data['ktg']['nama_kategori']; ?>" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tipe_kategori" class="col-sm-2 col-form-label">TIPE KATEGORI</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="tipe_kategori" name="tipe_kategori" required>
                            <option value="Pemasukan" <?= $data['ktg']['tipe_kategori'] === 'Pemasukan' ? 'selected' : ''; ?>>Pemasukan</option>
                            <option value="Pengeluaran" <?= $data['ktg']['tipe_kategori'] === 'Pengeluaran' ? 'selected' : ''; ?>>Pengeluaran</option>
                        </select>
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