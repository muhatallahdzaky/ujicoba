<?php
session_start();
include '../koneksi.php';

if (!isset($_GET['id'])) {
    header("Location: manajemenVenue.php");
    exit;
}
$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// Ambil data lama
$query = $koneksi->query("SELECT * FROM venue WHERE id_venue = '$id'");
$data  = $query->fetch_assoc();
if (!$data) die("Data venue tidak ditemukan!");

// Ambil Data Kota untuk Dropdown
$dataKota = $koneksi->query("SELECT * FROM kota ORDER BY nama_kota ASC");

// PROSES UPDATE
if (isset($_POST['update'])) {
    $namaVenue = mysqli_real_escape_string($koneksi, $_POST['nama_venue']);
    $idKota    = mysqli_real_escape_string($koneksi, $_POST['id_kota']);
    $alamat    = mysqli_real_escape_string($koneksi, $_POST['alamat_lengkap']);
    $kapasitas = !empty($_POST['kapasitas']) ? $_POST['kapasitas'] : "NULL";
    $website   = mysqli_real_escape_string($koneksi, $_POST['url_website']);

    $q = "UPDATE venue SET
          nama_venue='$namaVenue', id_kota='$idKota', alamat_lengkap='$alamat',
          kapasitas=$kapasitas, url_website='$website'
          WHERE id_venue='$id'";

    if ($koneksi->query($q)) {
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $koneksi->query("INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'EDIT VENUE', 'Edit Venue: $namaVenue ($id)')");

        echo "<script>alert('Update Berhasil!'); window.location='manajemenVenue.php';</script>";
    } else {
        echo "<script>alert('Gagal Update: " . $koneksi->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Venue</title>
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
                <h4 class="fw-bold text-white">Edit Venue</h4>
                <a href="manajemenVenue.php" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
            <div class="card stats-card border-0">
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label>Nama Venue</label>
                                <input type="text" class="form-control" name="nama_venue" value="<?= htmlspecialchars($data['nama_venue']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label>Kota</label>
                                <select name="id_kota" class="form-select" required>
                                    <?php while($kota = $dataKota->fetch_assoc()): ?>
                                        <option value="<?= $kota['id_kota']; ?>" <?= ($data['id_kota'] == $kota['id_kota']) ? 'selected' : ''; ?>>
                                            <?= $kota['nama_kota']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Kapasitas (Orang)</label>
                                <input type="number" class="form-control" name="kapasitas" value="<?= $data['kapasitas']; ?>">
                            </div>
                            <div class="col-md-6">
                                <label>URL Website</label>
                                <input type="url" class="form-control" name="url_website" value="<?= htmlspecialchars($data['url_website']); ?>">
                            </div>
                            <div class="col-12">
                                <label>Alamat Lengkap</label>
                                <textarea name="alamat_lengkap" class="form-control" rows="3"><?= htmlspecialchars($data['alamat_lengkap']); ?></textarea>
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