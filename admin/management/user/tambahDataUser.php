<?php
session_start();
include '../koneksi.php';

// --- LOGIC PROSES SIMPAN ---
if (isset($_POST['simpan'])) {

    // A. GENERATE ID OTOMATIS (U001 -> U002)
    $cekId = $koneksi->query("SELECT max(id_user) as maxID FROM users");
    $dataId = $cekId->fetch_assoc();
    $idMax = $dataId['maxID'];

    $noUrut = 1;
    if ($idMax) {
        $noUrut = (int) substr($idMax, 1, 3);
        $noUrut++;
    }
    $idUserBaru = "U" . sprintf("%03s", $noUrut);

    // B. TANGKAP DATA (Menggunakan variabel camelCase untuk PHP)
    $namaLengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $email       = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password    = mysqli_real_escape_string($koneksi, $_POST['password']);
    $noTelepon   = mysqli_real_escape_string($koneksi, $_POST['no_telepon']);
    $role        = $_POST['role'];
    $statusAkun  = $_POST['status_akun'];

    // C. QUERY INSERT
    $query = "INSERT INTO users (id_user, nama_lengkap, email, password, no_telepon, role, status_akun)
              VALUES ('$idUserBaru', '$namaLengkap', '$email', '$password', '$noTelepon', '$role', '$statusAkun')";

    if ($koneksi->query($query)) {
        // D. CATAT LOG
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $logQ = "INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'TAMBAH USER', 'Menambah User: $namaLengkap ($idUserBaru)')";
        $koneksi->query($logQ);

        echo "<script>alert('User Berhasil Ditambahkan! ID: $idUserBaru'); window.location='manajemenUsers.php';</script>";
    } else {
        echo "<script>alert('Gagal: " . $koneksi->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        .form-control, .form-select { background-color: #2c3e50; color: white; border: 1px solid #4a5f7f; }
        .form-control:focus, .form-select:focus { background-color: #34495e; color: white; border-color: #3498db; }
        label { color: #bdc3c7; margin-bottom: 5px; }
    </style>
</head>

<body>
    <?php include '../header.php'; ?>
    <div class="d-flex-wrapper">
        <?php include '../sideBar.php'; ?>

        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-white">Tambah Data User</h4>
                <a href="manajemenUsers.php" class="btn btn-secondary btn-sm">Kembali</a>
            </div>

            <div class="card stats-card border-0">
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label>Nama Lengkap</label>
                                <input type="text" class="form-control" name="nama_lengkap" required>
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" required>
                            </div>
                            <div class="col-md-6">
                                <label>Password</label>
                                <input type="text" class="form-control" name="password" required>
                            </div>
                            <div class="col-md-6">
                                <label>No. Telepon</label>
                                <input type="number" class="form-control" name="no_telepon">
                            </div>
                            <div class="col-md-6">
                                <label>Role</label>
                                <select class="form-select" name="role">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Status Akun</label>
                                <select class="form-select" name="status_akun">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                    <option value="suspended">Suspended</option>
                                </select>
                            </div>
                            <div class="col-12 text-end mt-4">
                                <button type="submit" name="simpan" class="btn btn-success px-4">Simpan Data</button>
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