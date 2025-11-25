<?php
session_start();
include '../koneksi.php';

if (isset($_POST['simpan'])) {

$queryAll = $koneksi->query("SELECT id_venue FROM venue");
    $angkaTerpakai = [];

    while ($row = $queryAll->fetch_assoc()) {
        $angkaTerpakai[] = (int) substr($row['id_venue'], 1);
    }

    if (empty($angkaTerpakai)) {
        $nextNumber = 1;
    } else {
        $nextNumber = max($angkaTerpakai) + 1;
    }

    $idVenueBaru = "V" . sprintf("%03d", $nextNumber);

    // 2. TANGKAP DATA SESUAI KOLOM DATABASE
    $namaVenue = mysqli_real_escape_string($koneksi, $_POST['nama_venue']);
    $idKota    = mysqli_real_escape_string($koneksi, $_POST['id_kota']);
    $alamat    = mysqli_real_escape_string($koneksi, $_POST['alamat_lengkap']);
    $kapasitas = !empty($_POST['kapasitas']) ? $_POST['kapasitas'] : "NULL"; // Handle NULL
    $website   = mysqli_real_escape_string($koneksi, $_POST['url_website']);

    // 3. INSERT
    $query = "INSERT INTO venue (id_venue, nama_venue, alamat_lengkap, id_kota, kapasitas, url_website)
              VALUES ('$idVenueBaru', '$namaVenue', '$alamat', '$idKota', $kapasitas, '$website')";

    if ($koneksi->query($query)) {
        // Log
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $koneksi->query("INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'TAMBAH VENUE', 'Tambah Venue: $namaVenue ($idVenueBaru)')");

        echo "<script>alert('Venue Berhasil Ditambahkan!'); window.location='manajemenVenue.php';</script>";
    } else {
        echo "<script>alert('Gagal: " . $koneksi->error . "');</script>";
    }
}

// Ambil Data Kota untuk Dropdown
$dataKota = $koneksi->query("SELECT * FROM kota ORDER BY nama_kota ASC");
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Venue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        .form-control,
        .form-select {
            background-color: #2c3e50;
            color: white;
            border: 1px solid #4a5f7f;
        }

        .form-control:focus,
        .form-select:focus {
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
                <h4 class="fw-bold text-white">Tambah Data Venue</h4>
                <a href="manajemenVenue.php" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
            <div class="card stats-card border-0">
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label>Nama Venue</label>
                                <input type="text" class="form-control" name="nama_venue" required>
                            </div>
                            <div class="col-md-6">
                                <label>Kota</label>
                                <select name="id_kota" class="form-select" required>
                                    <option value="">-- Pilih Kota --</option>
                                    <?php while ($kota = $dataKota->fetch_assoc()): ?>
                                        <option value="<?= $kota['id_kota']; ?>"><?= $kota['nama_kota']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Kapasitas (Orang)</label>
                                <input type="number" class="form-control" name="kapasitas">
                            </div>
                            <div class="col-md-6">
                                <label>URL Website (Opsional)</label>
                                <input type="url" class="form-control" name="url_website" placeholder="https://...">
                            </div>
                            <div class="col-12">
                                <label>Alamat Lengkap</label>
                                <textarea name="alamat_lengkap" class="form-control" rows="3"></textarea>
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

</html>>