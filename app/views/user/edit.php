<?php
$flashData = Flasher::flash();  // Ambil data flash
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">
    <div class="card card-info">
        <div class="card-header bg-gradient-purple">
            <h3 class="card-title text-center text-white">Edit User</h3>
        </div>
        <div class="card-body">
            <form method="POST" action="<?= BASEURL; ?>/user/update" id="editUserForm">                
                <input type="hidden" name="id" id="id" value="<?= $data['user']['id']; ?>">
                <input type="hidden" name="password" id="password" value="<?= $data['user']['password']; ?>">

                <div class="form-group">
                    <label for="nama">Name:</label>
                    <input type="text" name="nama" id="nama" class="form-control" value="<?= $data['user']['nama']; ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($data['user']['email']); ?>" required>
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

                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>

