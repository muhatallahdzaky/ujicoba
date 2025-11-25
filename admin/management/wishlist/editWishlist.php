<?php
session_start();
include '../koneksi.php';

// 1. Ambil ID dari URL dan sanitasi
$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// 2. Ambil data wishlist lama
$dataQ = $koneksi->query("SELECT * FROM wishlist WHERE id_wishlist='$id'");
$data = $dataQ->fetch_assoc();
if(!$data) die("Data tidak ditemukan");

// 3. Ambil data dropdown
$users  = $koneksi->query("SELECT id_user, nama_lengkap FROM users ORDER BY nama_lengkap ASC");
$konser = $koneksi->query("SELECT id_konser, nama_konser FROM konser ORDER BY nama_konser ASC");

// --- PROSES UPDATE ---
if (isset($_POST['update'])) {
    $idUserBaru = $_POST['id_user'];
    $idKonserBaru = $_POST['id_konser'];

    $q = "UPDATE wishlist SET id_user='$idUserBaru', id_konser='$idKonserBaru' WHERE id_wishlist='$id'";

    if ($koneksi->query($q)) {

        // 4. LOG AKTIVITAS (Ambil nama item yang baru diubah)
        $logDataQ = "SELECT u.nama_lengkap, k.nama_konser
                     FROM users u, konser k
                     WHERE u.id_user = '$idUserBaru' AND k.id_konser = '$idKonserBaru'";
        $logData = $koneksi->query($logDataQ)->fetch_assoc();

        $namaUser = $logData['nama_lengkap'] ?? 'User Unknown';
        $namaKonser = $logData['nama_konser'] ?? 'Konser Unknown';

        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $logQ = "INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi)
                 VALUES ('$admin', 'EDIT WISHLIST', 'Mengubah wishlist ID $id menjadi: $namaKonser (User: $namaUser)')";
        $koneksi->query($logQ);

        echo "<script>alert('Update Berhasil!'); window.location='manajemenWishlist.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Wishlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        /* STYLE KHUSUS BIAR FONT PUTIH */
        .form-control, .form-select {
            background-color: #2c3e50 !important;
            color: #ffffff !important;
            border: 1px solid #4a5f7f !important;
        }
        .form-control:focus, .form-select:focus {
            background-color: #34495e !important;
            color: #ffffff !important;
            border-color: #3498db !important;
            box-shadow: none;
        }
        label { color: #bdc3c7; margin-bottom: 5px; }
    </style>
</head>
<body>
    <?php include '../header.php'; ?>
    <div class="d-flex-wrapper">
        <?php include '../sideBar.php'; ?>
        <div class="main-content">
            <h4 class="fw-bold text-white mb-4">Edit Wishlist</h4>
            <div class="card stats-card border-0">
                <div class="card-body">
                    <form method="POST">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label>User</label>
                                <select name="id_user" class="form-select" required>
                                    <?php while($u = $users->fetch_assoc()) { ?>
                                        <option value="<?= $u['id_user']; ?>" <?= ($data['id_user'] == $u['id_user']) ? 'selected' : ''; ?>><?= $u['nama_lengkap']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Konser</label>
                                <select name="id_konser" class="form-select" required>
                                    <?php while($k = $konser->fetch_assoc()) { ?>
                                        <option value="<?= $k['id_konser']; ?>" <?= ($data['id_konser'] == $k['id_konser']) ? 'selected' : ''; ?>><?= $k['nama_konser']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-12 text-end mt-4">
                                <button name="update" class="btn btn-primary px-4">Simpan Perubahan</button>
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