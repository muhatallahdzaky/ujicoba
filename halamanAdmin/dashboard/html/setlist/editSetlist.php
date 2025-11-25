<?php
session_start();
include '../koneksi.php';

$id = mysqli_real_escape_string($koneksi, $_GET['id']);
$data = $koneksi->query("SELECT * FROM setlist_konser WHERE id_setlist='$id'")->fetch_assoc();
if(!$data) die("Data tidak ditemukan");

$dataKonser = $koneksi->query("SELECT id_konser, nama_konser FROM konser ORDER BY nama_konser ASC");
$dataArtis  = $koneksi->query("SELECT id_artis, nama_artis FROM artis ORDER BY nama_artis ASC");

if (isset($_POST['update'])) {
    // Path Upload
    $rootPath = dirname(__DIR__, 4);
    $targetDir = $rootPath . "/uploads/setlistAudio/";
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    $audioFix = $data['audio_file'];
    if (!empty($_FILES['audio_file']['name'])) {
        $ext = strtolower(pathinfo($_FILES['audio_file']['name'], PATHINFO_EXTENSION));
        $newName = uniqid() . '.' . $ext;
        if (move_uploaded_file($_FILES['audio_file']['tmp_name'], $targetDir . $newName)) {
            if ($data['audio_file'] && file_exists($targetDir . $data['audio_file'])) {
                unlink($targetDir . $data['audio_file']);
            }
            $audioFix = $newName;
        }
    }

    $konser = $_POST['id_konser'];
    $artis  = $_POST['id_artis'];
    $judul  = mysqli_real_escape_string($koneksi, $_POST['judul_lagu']);
    $durasi = $_POST['durasi'];
    $urutan = $_POST['urutan'];
    $ket    = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    $q = "UPDATE setlist_konser SET id_konser='$konser', id_artis='$artis', judul_lagu='$judul',
          durasi='$durasi', urutan='$urutan', audio_file='$audioFix', keterangan='$ket'
          WHERE id_setlist='$id'";

    if ($koneksi->query($q)) {
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $koneksi->query("INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'EDIT SETLIST', 'Edit Lagu: $judul')");
        echo "<script>alert('Update Berhasil!'); window.location='manajemenSetlist.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Edit Setlist</title>
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
            <h4 class="fw-bold text-white mb-4">Edit Lagu Setlist</h4>
            <div class="card stats-card border-0">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label>Konser</label>
                                <select name="id_konser" class="form-select" required>
                                    <?php while($k = $dataKonser->fetch_assoc()) { ?>
                                        <option value="<?= $k['id_konser']; ?>" <?= ($data['id_konser'] == $k['id_konser']) ? 'selected' : ''; ?>><?= $k['nama_konser']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Artis</label>
                                <select name="id_artis" class="form-select" required>
                                    <?php while($a = $dataArtis->fetch_assoc()) { ?>
                                        <option value="<?= $a['id_artis']; ?>" <?= ($data['id_artis'] == $a['id_artis']) ? 'selected' : ''; ?>><?= $a['nama_artis']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label>Judul Lagu</label>
                                <input type="text" name="judul_lagu" class="form-control" value="<?= htmlspecialchars($data['judul_lagu']); ?>" required>
                            </div>
                            <div class="col-md-2">
                                <label>Durasi</label>
                                <input type="text" name="durasi" class="form-control" value="<?= htmlspecialchars($data['durasi']); ?>">
                            </div>
                            <div class="col-md-2">
                                <label>Urutan</label>
                                <input type="number" name="urutan" class="form-control" value="<?= htmlspecialchars($data['urutan']); ?>">
                            </div>
                            <div class="col-12">
                                <label>Ganti Audio</label>
                                <input type="file" name="audio_file" class="form-control" accept=".mp3,.wav,.ogg">
                                <?php if($data['audio_file']): ?>
                                    <small class="text-secondary d-block mt-1">File saat ini: <?= $data['audio_file']; ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="col-12">
                                <label>Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="2"><?= htmlspecialchars($data['keterangan']); ?></textarea>
                            </div>
                            <div class="col-12 mt-3 text-end">
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