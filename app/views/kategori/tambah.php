<div class="container-fluid">

    <!-- Horizontal Form -->
    <div class="card card-info">
        <div class="card-header bg-primary">
            <h3 class="card-title text-center text-white">Tambah Data Kategori</h3>
        </div>
        <!-- /.card-header -->

        <!-- form start -->
        <form action="<?= BASEURL; ?>/kategori/tambah" method="POST">
            <div class="container mt-2">
                <div class="form-group row">
                    <label for="nama_kategori" class="col-sm-2 col-form-label">NAMA KATEGORI</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="Masukkan Nama Kategori" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="tipe_kategori" class="col-sm-2 col-form-label">TIPE KATEGORI</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="tipe_kategori" name="tipe_kategori" required>
                            <option value="" selected disabled>-- Pilih Tipe Kategori --</option>
                            <option value="Pemasukan">Pemasukan</option>
                            <option value="Pengeluaran">Pengeluaran</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-block btn-primary btn-lg mb-4" name="submit">Tambah</button>
            </div>
        </form>


    </div>
</div>
<!-- /.card -->
</div>
<!-- /.container -->