<?php
session_start();
// Nyalakan Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../koneksi.php';

if (!isset($_GET['id'])) {
    // Jangan redirect, matiin aja biar gak looping
    die("Error: ID tidak ditemukan di URL. Silakan kembali ke halaman manajemen.");
}
$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// Ambil data lama
$query = mysqli_query($koneksi, "SELECT * FROM artis WHERE id_artis = '$id'");
$data  = mysqli_fetch_assoc($query);
if (!$data) die("Data artis tidak ditemukan!");

// --- PROSES UPDATE ---
if (isset($_POST['update'])) {

    // ==============================================================
    // 1. PENGATURAN PATH (ABSOLUTE / ALAMAT LENGKAP)
    // ==============================================================
    // __DIR__ adalah folder dimana file ini berada (html/artis)
    // Kita mundur 4 level ke belakang untuk cari Root Project
    $rootProject = dirname(__DIR__, 4);

    // Gabungkan jadi alamat lengkap
    $dirPict  = $rootProject . "/uploads/artisPict/";
    $dirAudio = $rootProject . "/uploads/artisAudio/";

    // DEBUG: Coba lihat ini kalau masih gagal, path-nya bener gak?
    // echo "Target Upload: " . $dirPict; die();

    // Fungsi Upload Aman
    function uploadFile($inputName, $targetDir, $oldFile, $allowExt) {
        // Pastikan folder tujuan ada
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (!empty($_FILES[$inputName]['name'])) {
            $fileName = $_FILES[$inputName]['name'];
            $tmpName  = $_FILES[$inputName]['tmp_name'];
            $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            // Cek Error Upload PHP
            if ($_FILES[$inputName]['error'] !== 0) {
                return "ERROR_PHP_" . $_FILES[$inputName]['error'];
            }

            if (in_array($fileExt, $allowExt)) {
                $newFileName = uniqid() . '.' . $fileExt;
                $targetFile = $targetDir . $newFileName;

                // Pindahkan file pakai path lengkap
                if (move_uploaded_file($tmpName, $targetFile)) {
                    // Hapus file lama
                    if (!empty($oldFile) && file_exists($targetDir . $oldFile)) {
                        unlink($targetDir . $oldFile);
                    }
                    return $newFileName;
                } else {
                    // Gagal memindahkan file
                    return "GAGAL_MOVE";
                }
            } else {
                return "SALAH_EKSTENSI";
            }
        }
        return $oldFile; // Pakai file lama
    }

    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama_artis']);
    $genre  = mysqli_real_escape_string($koneksi, $_POST['genre']);
    $negara = mysqli_real_escape_string($koneksi, $_POST['asal_negara']);
    $tipe   = $_POST['tipe_entitas'];

    // Eksekusi Upload
    $foto_fix  = uploadFile('gambar_artis', $dirPict, $data['gambar_artis'], ['jpg','png','webp','jpeg']);
    $audio_fix = uploadFile('audio_sample', $dirAudio, $data['audio_sample'], ['mp3','wav','ogg']);

    // Cek jika ada error upload
    if ($foto_fix == "GAGAL_MOVE") {
        die("Error: Gagal menyimpan gambar ke folder $dirPict. Cek Permission folder.");
    }

    // Update Database
    $q = "UPDATE artis SET
          nama_artis='$nama', genre='$genre', asal_negara='$negara', tipe_entitas='$tipe',
          gambar_artis='$foto_fix', audio_sample='$audio_fix'
          WHERE id_artis='$id'";

    if (mysqli_query($koneksi, $q)) {
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        mysqli_query($koneksi, "INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'EDIT ARTIS', 'Edit Artis: $nama ($id)')");

        echo "<script>alert('Update Berhasil!'); window.location='manajemenArtis.php';</script>";
    } else {
        echo "<script>alert('Gagal Update Database: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Artis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        .form-control, .form-select { background-color: #2c3e50; color: white; border: 1px solid #4a5f7f; }
        .form-control:focus { background-color: #34495e; color: white; border-color: #3498db; }
        label { color: #bdc3c7; margin-bottom: 5px; }
        .preview { width: 100px; border-radius: 5px; margin-top: 10px; border: 1px solid #555; display: block; }
        input[type=file] { background-color: #2c3e50; color: #bdc3c7; }
    </style>
</head>
<body>
    <?php include '../header.php'; ?>
    <div class="d-flex-wrapper">
        <?php include '../sideBar.php'; ?>

        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-white">Edit Artis</h4>
                <a href="manajemenArtis.php" class="btn btn-secondary btn-sm">Kembali</a>
            </div>

            <div class="card stats-card border-0">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row g-4">
                            <div class="col-12">
                                <label>Nama Artis</label>
                                <input type="text" class="form-control" name="nama_artis" value="<?= htmlspecialchars($data['nama_artis']); ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label>Genre</label>
                                <input type="text" class="form-control" name="genre" value="<?= htmlspecialchars($data['genre']); ?>">
                            </div>
                            <div class="col-md-6">
                                <label>Negara</label>
                                <input type="text" class="form-control" name="asal_negara" value="<?= htmlspecialchars($data['asal_negara']); ?>">
                            </div>
                            <div class="col-md-6">
                                <label>Tipe</label>
                                <select class="form-select" name="tipe_entitas">
                                    <option value="Artis Solo (Vokalis/Musisi)" <?= $data['tipe_entitas'] == 'Artis Solo (Vokalis/Musisi)' ? 'selected' : '' ?>>Artis Solo</option>
                                    <option value="Grup Band" <?= $data['tipe_entitas'] == 'Grup Band' ? 'selected' : '' ?>>Grup Band</option>
                                    <option value="Grup Idola" <?= $data['tipe_entitas'] == 'Grup Idola' ? 'selected' : '' ?>>Grup Idola</option>
                                    <option value="DJ/Produser" <?= $data['tipe_entitas'] == 'DJ/Produser' ? 'selected' : '' ?>>DJ/Produser</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Ganti Foto</label>
                                <input type="file" class="form-control" name="gambar_artis" accept=".jpg,.png,.jpeg,.webp">
                                <?php if($data['gambar_artis']): ?>
                                    <img src="../../../../uploads/artisPict/<?= $data['gambar_artis']; ?>" class="preview">
                                    <small class="text-muted">Foto saat ini</small>
                                <?php endif; ?>
                            </div>

                            <div class="col-12">
                                <label>Ganti Audio</label>
                                <input type="file" class="form-control" name="audio_sample" accept=".mp3,.wav,.ogg">
                                <?php if($data['audio_sample']): ?>
                                    <div class="mt-2">
                                        <audio controls src="../../../../uploads/artisAudio/<?= $data['audio_sample']; ?>" style="height: 30px;"></audio>
                                        <br><small class="text-muted">Audio saat ini: <?= $data['audio_sample']; ?></small>
                                    </div>
                                <?php endif; ?>
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