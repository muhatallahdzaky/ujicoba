<?php
session_start();
include '../koneksi.php';

// Ambil Data Konser & Artis untuk Dropdown
$dataKonser = $koneksi->query("SELECT id_konser, nama_konser FROM konser ORDER BY nama_konser ASC");
$dataArtis  = $koneksi->query("SELECT id_artis, nama_artis FROM artis ORDER BY nama_artis ASC");

if (isset($_POST['simpan'])) {
    // 1. ID OTOMATIS (L001, L002...)
    $cekId = $koneksi->query("SELECT max(id_lineup) as maxID FROM lineup");
    $dataId = $cekId->fetch_assoc();

    $noUrut = 1;
    if ($dataId['maxID']) {
        $noUrut = (int)substr($dataId['maxID'], 1) + 1;
    }
    $idBaru = "L" . sprintf("%03s", $noUrut); // Format L001

    // 2. TANGKAP DATA
    $konser = $_POST['id_konser'];
    $artis  = $_POST['id_artis'];

    if (empty($_POST['jadwal_tampil'])) {
        $jadwal = "NULL"; // Nilai NULL SQL (tanpa kutip)
    } else {
        $jadwal = "'" . mysqli_real_escape_string($koneksi, $_POST['jadwal_tampil']) . "'"; // Nilai DATETIME (dengan kutip)
    }

    $query = "INSERT INTO lineup (id_lineup, id_konser, id_artis, jadwal_tampil)
              VALUES ('$idBaru', '$konser', '$artis', $jadwal)";

    if ($koneksi->query($query)) {
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $koneksi->query("INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'TAMBAH LINEUP', 'Tambah LineUp ID: $idBaru')");

        echo "<script>alert('LineUp Berhasil Ditambahkan!'); window.location='manajemenLineUp.php';</script>";
    } else {
        echo "<script>alert('Gagal: " . $koneksi->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah LineUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        .form-control, .form-select { background-color: #2c3e50 !important; color: #ffffff !important; border: 1px solid #4a5f7f !important; }
        .form-control:focus, .form-select:focus { background-color: #34495e !important; color: #ffffff !important; border-color: #3498db !important; box-shadow: none; }
        label { color: #bdc3c7; margin-bottom: 5px; }
    </style>
</head>
<body>
    <?php include '../header.php'; ?>
    <div class="d-flex-wrapper">
        <?php include '../sideBar.php'; ?>

        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-white">Tambah LineUp Konser</h4>
                <a href="manajemenLineUp.php" class="btn btn-secondary btn-sm">Kembali</a>
            </div>

            <div class="card stats-card border-0">
                <div class="card-body">
                    <form method="POST">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label>Pilih Konser</label>
                                <select name="id_konser" class="form-select" required>
                                    <option value="">-- Pilih Konser --</option>
                                    <?php while($k = $dataKonser->fetch_assoc()) { ?>
                                        <option value="<?= $k['id_konser']; ?>"><?= $k['nama_konser']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Pilih Artis</label>
                                <select name="id_artis" class="form-select" required>
                                    <option value="">-- Pilih Artis --</option>
                                    <?php while($a = $dataArtis->fetch_assoc()) { ?>
                                        <option value="<?= $a['id_artis']; ?>"><?= $a['nama_artis']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label>Jadwal Tampil</label>
                                <input type="datetime-local" name="jadwal_tampil" class="form-control">
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