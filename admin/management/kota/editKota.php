<?php
session_start();
include '../koneksi.php';

if (!isset($_GET['id'])) header("Location: manajemenKota.php");
$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// Ambil Data Lama
$query = mysqli_query($koneksi, "SELECT * FROM kota WHERE id_kota = '$id'");
$data  = mysqli_fetch_assoc($query);
if (!$data) die("Data tidak ditemukan!");

// --- PROSES UPDATE ---
if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_kota']);
    $prov = $_POST['id_provinsi'];

    $q = "UPDATE kota SET nama_kota='$nama', id_provinsi='$prov' WHERE id_kota='$id'";

    if (mysqli_query($koneksi, $q)) {
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        mysqli_query($koneksi, "INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'EDIT KOTA', 'Edit Kota: $nama')");
        echo "<script>alert('Update Berhasil!'); window.location='manajemenKota.php';</script>";
    } else {
        echo "<script>alert('Gagal Update!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kota</title>
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
                <h4 class="fw-bold text-white">Edit Kota</h4>
                <a href="manajemenKota.php" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
            <div class="card stats-card border-0">
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="row g-4">

                            <div class="col-12">
                                <label>Nama Kota</label>
                                <input type="text" class="form-control" name="nama_kota" value="<?= htmlspecialchars($data['nama_kota']); ?>" required>
                            </div>

                            <div class="col-12">
                                <label>Provinsi</label>
                                <select class="form-select" name="id_provinsi" required>
                                    <option value="">-- Pilih Provinsi --</option>
                                    <?php
                                    $qProv = mysqli_query($koneksi, "SELECT * FROM provinsi ORDER BY nama_provinsi ASC");
                                    while($p = mysqli_fetch_assoc($qProv)){
                                        // Cek jika ID Provinsi sama dengan data lama, kasih 'selected'
                                        $sel = ($p['id_provinsi'] == $data['id_provinsi']) ? 'selected' : '';
                                        echo "<option value='".$p['id_provinsi']."' $sel>".$p['nama_provinsi']."</option>";
                                    }
                                    ?>
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