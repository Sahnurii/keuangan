<?php
$flashData = Flasher::flash();  // Ambil data flash
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-gradient-primary">
            <h3 class="card-title text-center text-white">Tambah User</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= BASEURL; ?>/user/tambah" id="tambahUserForm">

                <div class="form-group">
                    <label for="nama">Name</label>
                    <input type="text" name="nama" id="nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
                </div>

                <div class="form-group row">
                    <label for="role" class="col-sm-2 col-form-label">Role</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="role" name="role" required>
                            <option value="" selected disabled>-- Pilih Role --</option>
                            <option value="Admin">Admin</option>
                            <option value="Petugas">Petugas</option>
                            <option value="Pegawai">Pegawai</option>
                            <option value="Pimpinan">Pimpinan</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-success">Tambah User</button>
            </form>
        </div>
    </div>
</div>