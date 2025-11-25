<?php
session_start();
include '../koneksi.php';

$users  = $koneksi->query("SELECT id_user, nama_lengkap FROM users ORDER BY nama_lengkap ASC");
$konser = $koneksi->query("SELECT id_konser, nama_konser FROM konser ORDER BY nama_konser ASC");

if (isset($_POST['simpan'])) {
    // ID Otomatis W001
    $cek = $koneksi->query("SELECT max(id_wishlist) as maxID FROM wishlist");
    $dataId = $cek->fetch_assoc();
    $no = $dataId['maxID'] ? (int)substr($dataId['maxID'], 1) + 1 : 1;
    $idBaru = "W" . sprintf("%03s", $no);

    $idUser = $_POST['id_user'];
    $idKonser = $_POST['id_konser'];

    // Ambil nama user dan konser untuk log
    $userQ = $koneksi->query("SELECT nama_lengkap FROM users WHERE id_user='$idUser'")->fetch_assoc();
    $konserQ = $koneksi->query("SELECT nama_konser FROM konser WHERE id_konser='$idKonser'")->fetch_assoc();

    $namaUser = $userQ['nama_lengkap'] ?? 'User Tidak Dikenal';
    $namaKonser = $konserQ['nama_konser'] ?? 'Konser Tidak Dikenal';

    // Cek Duplikat
    $cekDouble = $koneksi->query("SELECT * FROM wishlist WHERE id_user='$idUser' AND id_konser='$idKonser'");
    if ($cekDouble->num_rows > 0) {
        echo "<script>alert('User ini sudah menambahkan konser tersebut!');</script>";
    } else {
        $q = "INSERT INTO wishlist (id_wishlist, id_user, id_konser) VALUES ('$idBaru', '$idUser', '$idKonser')";

        if ($koneksi->query($q)) {
            // >>>>>> LOG AKTIVITAS DITAMBAHKAN DISINI <<<<<<
            $admin = $_SESSION['nama_admin'] ?? 'Admin';
            $logQ = "INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi)
                     VALUES ('$admin', 'TAMBAH WISHLIST', 'Menambahkan konser $namaKonser ke wishlist $namaUser (ID: $idBaru)')";
            $koneksi->query($logQ);

            echo "<script>alert('Berhasil!'); window.location='manajemenWishlist.php';</script>";
        } else {
            echo "<script>alert('Gagal: " . $koneksi->error . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Wishlist</title>
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
            <h4 class="fw-bold text-white mb-4">Tambah Wishlist</h4>
            <div class="card stats-card border-0">
                <div class="card-body">
                    <form method="POST">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label>Pilih User</label>
                                <select name="id_user" class="form-select" required>
                                    <option value="">-- Pilih User --</option>
                                    <?php while($u = $users->fetch_assoc()) { echo "<option value='{$u['id_user']}'>{$u['nama_lengkap']}</option>"; } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Pilih Konser</label>
                                <select name="id_konser" class="form-select" required>
                                    <option value="">-- Pilih Konser --</option>
                                    <?php while($k = $konser->fetch_assoc()) { echo "<option value='{$k['id_konser']}'>{$k['nama_konser']}</option>"; } ?>
                                </select>
                            </div>
                            <div class="col-12 text-end mt-4">
                                <button name="simpan" class="btn btn-success px-4">Simpan Data</button>
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