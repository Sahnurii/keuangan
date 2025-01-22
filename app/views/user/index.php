<?php
$flashData = Flasher::flash();  // Ambil data flash
?>
<div class="flash-data" data-flashdata='<?= json_encode($flashData); ?>'></div>
<div class="container-fluid">

    <div class="card card-info">
        <div class="card-header bg-gradient-purple">
            <h3 class="card-title text-center text-white">Manage Users</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="#" class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th>Username</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['users'] as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user['username']); ?></td>
                                <td><?= htmlspecialchars($user['nama']); ?></td>
                                <td><?= htmlspecialchars($user['email']); ?></td>
                                <td class="text-center">
                                    <a href="<?= BASEURL; ?>/user/edit/<?= $user['id']; ?>" class="btn btn-warning btn-sm">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
