<?php
session_start();
include __DIR__ . '/../../../config/database.php';

$queryUsers = $conn->query("SELECT * FROM users ORDER BY id_user ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        .table-responsive { overflow-x: auto; white-space: nowrap; }
        .table th, .table td { vertical-align: middle; padding: 12px 15px; }
        .avatar-circle { width: 35px; height: 35px; background-color: #3498db; color: white; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-weight: bold; margin-right: 10px; }
    </style>
</head>
<body>
    <?php include '../../includes/headerAdmin.php';?>
    <div class="d-flex-wrapper">
        <?php include '../../sideBar.php'; ?>

        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-white"><i class="bi bi-people-fill me-2"></i>Manajemen Users</h2>
                <a href="tambahDataUser.php" class="btn btn-success"><i class="bi bi-person-plus-fill me-2"></i> Tambah User</a>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-hover table-dark mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>No. Telepon</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Tanggal Daftar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($queryUsers && $queryUsers->num_rows > 0) {
                                while ($data = $queryUsers->fetch_assoc()) {
                                    $roleColor = ($data['role'] == 'admin') ? 'bg-danger' : 'bg-info text-dark';
                                    $statusColor = ($data['status_akun'] == 'active') ? 'bg-success' : 'bg-secondary';
                                    $inisial = strtoupper(substr($data['nama_lengkap'], 0, 1));
                            ?>
                                    <tr>
                                        <td><span class="badge bg-secondary"><?= $data['id_user']; ?></span></td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle"><?= $inisial; ?></div>
                                                <span class="fw-bold"><?= htmlspecialchars($data['nama_lengkap']); ?></span>
                                            </div>
                                        </td>
                                        <td><?= htmlspecialchars($data['email']); ?></td>
                                        <td><?= htmlspecialchars($data['no_telepon']); ?></td>
                                        <td><span class="badge <?= $roleColor; ?> text-uppercase"><?= $data['role']; ?></span></td>
                                        <td><span class="badge <?= $statusColor; ?> text-uppercase"><?= $data['status_akun']; ?></span></td>
                                        <td><?= date('d M Y H:i', strtotime($data['tanggal_daftar'])); ?></td>
                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="editUser.php?id=<?= $data['id_user']; ?>" class="btn btn-sm btn-warning text-white" title="Edit"><i class="bi bi-pencil"></i></a>

                                                <?php if ($_SESSION['nama_admin'] ?? '' != $data['nama_lengkap']): ?>
                                                <a href="hapusUser.php?id=<?= $data['id_user']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus user ini?')" title="Hapus"><i class="bi bi-trash"></i></a>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                            <?php } } else { ?>
                                <tr><td colspan="8" class="text-center py-5 text-muted">Belum ada data user.</td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <?php include '../../includes/footerAdmin.php';?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>