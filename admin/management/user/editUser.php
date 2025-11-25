<?php
session_start();
include '../koneksi.php';

// 1. CEK ID
if (!isset($_GET['id'])) {
    header("Location: manajemenUsers.php");
    exit;
}
$idUser = mysqli_real_escape_string($koneksi, $_GET['id']);

// 2. AMBIL DATA LAMA
$query = $koneksi->query("SELECT * FROM users WHERE id_user = '$idUser'");
$data  = $query->fetch_assoc();

if (!$data) { die("Data user tidak ditemukan!"); }

// --- PROSES UPDATE ---
if (isset($_POST['update'])) {
    $namaLengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $email       = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password    = mysqli_real_escape_string($koneksi, $_POST['password']);
    $noTelepon   = mysqli_real_escape_string($koneksi, $_POST['no_telepon']);
    $role        = $_POST['role'];
    $statusAkun  = $_POST['status_akun'];

    $updateQ = "UPDATE users SET
                nama_lengkap='$namaLengkap', email='$email', password='$password',
                no_telepon='$noTelepon', role='$role', status_akun='$statusAkun'
                WHERE id_user='$idUser'";

    if ($koneksi->query($updateQ)) {
        // Log
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $logQ = "INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'EDIT USER', 'Edit user: $namaLengkap ($idUser)')";
        $koneksi->query($logQ);

        echo "<script>alert('Data Berhasil Diupdate!'); window.location='manajemenUsers.php';</script>";
    } else {
        echo "<script>alert('Gagal Update: " . $koneksi->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        .form-control, .form-select { background-color: #2c3e50; color: white; border: 1px solid #4a5f7f; }
        .form-control:focus { background-color: #34495e; color: white; border-color: #3498db; }
        label { color: #bdc3c7; margin-bottom: 5px; }
    </style>
</head>

<body>
    <?php include '../header.php'; ?>
    <div class="d-flex-wrapper">
        <?php include '../sideBar.php'; ?>

        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-white">Edit User</h4>
                <a href="manajemenUsers.php" class="btn btn-secondary btn-sm">Kembali</a>
            </div>

            <div class="card stats-card border-0">
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama_lengkap" value="<?= htmlspecialchars($data['nama_lengkap']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($data['email']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label>Password</label>
                                <input type="text" class="form-control" name="password" value="<?= htmlspecialchars($data['password']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label>No. Telepon</label>
                                <input type="number" class="form-control" name="no_telepon" value="<?= htmlspecialchars($data['no_telepon']); ?>">
                            </div>
                            <div class="col-md-6">
                                <label>Role</label>
                                <select class="form-select" name="role">
                                    <option value="user" <?= ($data['role'] == 'user') ? 'selected' : ''; ?>>User</option>
                                    <option value="admin" <?= ($data['role'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Status Akun</label>
                                <select class="form-select" name="status_akun">
                                    <option value="active" <?= ($data['status_akun'] == 'active') ? 'selected' : ''; ?>>Active</option>
                                    <option value="inactive" <?= ($data['status_akun'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                                    <option value="suspended" <?= ($data['status_akun'] == 'suspended') ? 'selected' : ''; ?>>Suspended</option>
                                </select>
                            </div>
                            <div class="col-12 text-end mt-4">
                                <button type="submit" name="update" class="btn btn-primary px-4">Simpan Perubahan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include '../footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>