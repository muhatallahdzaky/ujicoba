<?php
session_start();
include '../koneksi.php';

// Ambil data Provinsi untuk Dropdown
$dataProvinsi = $koneksi->query("SELECT id_provinsi, nama_provinsi FROM provinsi ORDER BY nama_provinsi ASC");

if (isset($_POST['simpan'])) {

    // 1. ID OTOMATIS (C01, C02, dst)
    $cekId = $koneksi->query("SELECT max(id_kota) as maxID FROM kota");
    $dataId = $cekId->fetch_assoc();

    $noUrut = 1;
    if ($dataId['maxID']) {
        // Ambil angka setelah C (index 1)
        $noUrut = (int)substr($dataId['maxID'], 1) + 1;
    }
    $idBaru = "C" . sprintf("%02s", $noUrut); // Format C01

    // 2. TANGKAP DATA
    $namaKota = mysqli_real_escape_string($koneksi, $_POST['nama_kota']);
    $idProvinsi = mysqli_real_escape_string($koneksi, $_POST['id_provinsi']);

    // 3. INSERT DATABASE
    $query = "INSERT INTO kota (id_kota, nama_kota, id_provinsi)
              VALUES ('$idBaru', '$namaKota', '$idProvinsi')";

    if ($koneksi->query($query)) {
        // Log Aktivitas
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $koneksi->query("INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'TAMBAH KOTA', 'Tambah Kota: $namaKota ($idBaru)')");

        echo "<script>alert('Kota Berhasil Ditambahkan!'); window.location='manajemenKota.php';</script>";
    } else {
        echo "<script>alert('Gagal: " . $koneksi->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kota</title>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-white">Tambah Data Kota</h4>
                <a href="manajemenKota.php" class="btn btn-secondary btn-sm">Kembali</a>
            </div>

            <div class="card stats-card border-0">
                <div class="card-body">
                    <form method="POST">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label>Nama Kota</label>
                                <input type="text" name="nama_kota" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label>Pilih Provinsi</label>
                                <select name="id_provinsi" class="form-select" required>
                                    <option value="">-- Pilih Provinsi --</option>
                                    <?php while($p = $dataProvinsi->fetch_assoc()) { ?>
                                        <option value="<?= $p['id_provinsi']; ?>"><?= $p['nama_provinsi']; ?></option>
                                    <?php } ?>
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