<?php
session_start();
include '../koneksi.php';

// 1. Ambil ID dari URL dan amankan
if (!isset($_GET['id'])) {
    header("Location: manajemenLineUp.php");
    exit();
}
$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// 2. Ambil Data Lama
$data = $koneksi->query("SELECT * FROM lineup WHERE id_lineup='$id'")->fetch_assoc();
if (!$data) die("Data tidak ditemukan");

// 3. Data Dropdown
$dataKonser = $koneksi->query("SELECT id_konser, nama_konser FROM konser ORDER BY nama_konser ASC");
$dataArtis  = $koneksi->query("SELECT id_artis, nama_artis FROM artis ORDER BY nama_artis ASC");

// 4. Proses Update
if (isset($_POST['update'])) {
    $konser = mysqli_real_escape_string($koneksi, $_POST['id_konser']);
    $artis  = mysqli_real_escape_string($koneksi, $_POST['id_artis']);

    $cekDuplikat = $koneksi->query("SELECT id_lineup FROM lineup
                                    WHERE id_konser = '$konser'
                                    AND id_artis = '$artis'
                                    AND id_lineup != '$id'");

    if ($cekDuplikat->num_rows > 0) {
        echo "<script>alert('GAGAL: Artis ini sudah ada di lineup konser tersebut!');</script>";
    } else {
        // UPDATE DATA (Perhatikan: Tidak ada koma sebelum WHERE)
        $q = "UPDATE lineup SET
              id_konser = '$konser',
              id_artis  = '$artis'
              WHERE id_lineup = '$id'";

        if ($koneksi->query($q)) {
            $admin = $_SESSION['nama_admin'] ?? 'Admin';
            $koneksi->query("INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'EDIT LINEUP', 'Edit LineUp ID: $id')");

            echo "<script>alert('Update Berhasil!'); window.location='manajemenLineUp.php';</script>";
        } else {
            echo "<script>alert('Gagal Update: " . $koneksi->error . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit LineUp</title>
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
                <h4 class="fw-bold text-white">Edit LineUp</h4>
                <a href="manajemenLineUp.php" class="btn btn-secondary btn-sm">Kembali</a>
            </div>

            <div class="card stats-card border-0">
                <div class="card-body">
                    <form method="POST">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label>Konser</label>
                                <select name="id_konser" class="form-select" required>
                                    <?php while($k = $dataKonser->fetch_assoc()) { ?>
                                        <option value="<?= $k['id_konser']; ?>" <?= ($data['id_konser'] == $k['id_konser']) ? 'selected' : ''; ?>>
                                            <?= $k['nama_konser']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Artis</label>
                                <select name="id_artis" class="form-select" required>
                                    <?php while($a = $dataArtis->fetch_assoc()) { ?>
                                        <option value="<?= $a['id_artis']; ?>" <?= ($data['id_artis'] == $a['id_artis']) ? 'selected' : ''; ?>>
                                            <?= $a['nama_artis']; ?>
                                        </option>
                                    <?php } ?>
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