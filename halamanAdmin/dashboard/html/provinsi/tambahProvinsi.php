<?php
session_start();
include '../koneksi.php';

if (isset($_POST['simpan'])) {
    $queryAll = $koneksi->query("SELECT id_provinsi FROM provinsi");
    $angkaTerpakai = [];

    while ($row = $queryAll->fetch_assoc()) {
        $angkaTerpakai[] = (int) substr($row['id_provinsi'], 1);
    }

    if (empty($angkaTerpakai)) {
        $nextNumber = 1;
    } else {
        $nextNumber = max($angkaTerpakai) + 1;
    }

    $idBaru = "P" . sprintf("%03d", $nextNumber);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_provinsi']);

    if ($koneksi->query("INSERT INTO provinsi VALUES ('$idBaru', '$nama')")) {
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $koneksi->query("INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'TAMBAH PROVINSI', 'Tambah: $nama')");

        echo "<script>alert('Berhasil!'); window.location='manajemenProvinsi.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <title>Tambah Provinsi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        .form-control {
            background-color: #2c3e50;
            color: white;
            border: 1px solid #4a5f7f;
        }

        .form-control:focus {
            background-color: #34495e;
            color: white;
            border-color: #3498db;
        }

        label {
            color: #bdc3c7;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <?php include '../header.php'; ?>
    <div class="d-flex-wrapper">
        <?php include '../sideBar.php'; ?>

        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-white">Tambah Provinsi</h4>
                <a href="manajemenProvinsi.php" class="btn btn-secondary btn-sm">Kembali</a>
            </div>

            <div class="card stats-card border-0">
                <div class="card-body">
                    <form method="POST">
                        <div class="row g-4">
                            <div class="col-12">
                                <label>Nama Provinsi</label>
                                <input type="text" name="nama_provinsi" class="form-control" required>
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