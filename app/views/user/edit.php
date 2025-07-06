<?php
$flashData = Flasher::flash();  // Ambil data flash
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-gradient-primary">
            <h3 class="card-title text-center text-white ">Edit User</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= BASEURL; ?>/user/update/<?= $data['user']['id']; ?>" id="editUserForm">
                <input type="hidden" name="id" id="id" value="<?= $data['user']['id']; ?>">
                <input type="hidden" name="id_pegawai" value="<?= $data['pegawai']['id']; ?>">
                <div class="form-group">
                    <label for="nama">Nama Pegawai:</label>
                    <input type="text" id="nama" class="form-control" value="<?= $data['pegawai']['nama']; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="email">Email Pegawai:</label>
                    <input type="email" id="email" class="form-control" value="<?= $data['pegawai']['email']; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="username" name="username" id="username" class="form-control" value="<?= htmlspecialchars($data['user']['username']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="newPass">New Password:</label>
                    <input type="password" name="newPass" id="newPass" class="form-control">
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirm Password:</label>
                    <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                </div>

                <?php if ($_SESSION['user']['role'] === 'Admin'): ?>
                    <div class="form-group row">
                        <label for="role" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="role" name="role" required>
                                <option value="Admin" <?= $data['user']['role'] == 'Admin' ? 'selected' : ''; ?>>Admin</option>
                                <option value="Petugas" <?= $data['user']['role'] == 'Petugas' ? 'selected' : ''; ?>>Petugas</option>
                                <option value="Pegawai" <?= $data['user']['role'] == 'Pegawai' ? 'selected' : ''; ?>>Pegawai</option>
                                <option value="Pimpinan" <?= $data['user']['role'] == 'Pimpinan' ? 'selected' : ''; ?>>Pimpinan</option>
                            </select>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($_SESSION['user']['role'] !== 'Admin'): ?>
                    <input type="hidden" name="role" value="<?= $data['user']['role']; ?>">
                <?php endif; ?>


                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
</div>