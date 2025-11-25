<?php
session_start();
include '../koneksi.php';

if (!isset($_GET['id'])) {
    die("Error: ID tidak ditemukan.");
}
$id = mysqli_real_escape_string($koneksi, $_GET['id']);

$query = $koneksi->query("SELECT * FROM artis WHERE id_artis = '$id'");
$data = $query->fetch_assoc();
if (!$data) die("Data tidak ditemukan.");

if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_artis']);
    $genre = mysqli_real_escape_string($koneksi, $_POST['genre']);
    $negara = mysqli_real_escape_string($koneksi, $_POST['asal_negara']);
    $playlist = mysqli_real_escape_string($koneksi, $_POST['spotify_playlist_url']);
    $tipe = $_POST['tipe_entitas'];

    $fotoFix = $data['gambar_artis'];

    if (!empty($_FILES['gambar_artis']['name'])) {
        $rootProject = dirname(__DIR__, 4);
        $targetDir = $rootProject . "/assets/uploads/band_pict/";
        $dbPath = "assets/uploads/band_pict/";

        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        $fileName = $_FILES['gambar_artis']['name'];
        $tmpName = $_FILES['gambar_artis']['tmp_name'];
        $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $allowed)) {
            $newFileName = $id . '_' . uniqid() . '.' . $ext;
            $uploadPath = $targetDir . $newFileName;

            if (move_uploaded_file($tmpName, $uploadPath)) {
                $fotoFix = $dbPath . $newFileName;

                $oldFilePath = $rootProject . "/" . $data['gambar_artis'];
                if ($data['gambar_artis'] && file_exists($oldFilePath) && is_file($oldFilePath)) {
                    unlink($oldFilePath);
                }
            } else {
                echo "<script>alert('Gagal upload gambar.');</script>";
            }
        } else {
            echo "<script>alert('Format gambar salah.');</script>";
        }
    }

    $q = "UPDATE artis SET nama_artis='$nama', genre='$genre', asal_negara='$negara', tipe_entitas='$tipe', gambar_artis='$fotoFix', spotify_playlist_url='$playlist' WHERE id_artis='$id'";

    if ($koneksi->query($q)) {
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $koneksi->query("INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'EDIT ARTIS', 'Edit Artis: $nama ($id)')");
        echo "<script>alert('Update Berhasil!'); window.location='manajemenArtis.php';</script>";
    } else {
        echo "<script>alert('Gagal: " . $koneksi->error . "');</script>";
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
        .form-control:focus, .form-select:focus { background-color: #34495e; color: white; border-color: #3498db; }
        label { color: #bdc3c7; margin-bottom: 5px; }
        .preview { width: 100px; border-radius: 5px; margin-top: 10px; border: 1px solid #555; display: block; object-fit: cover; }
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
                                <?php if ($data['gambar_artis']): ?>
                                    <img src="../../../../<?= $data['gambar_artis']; ?>" class="preview" alt="Foto Lama">
                                <?php endif; ?>
                            </div>
                            <div class="col-12">
                                <label>Ganti Playlist Spotify</label>
                                <input type="text" class="form-control" name="spotify_playlist_url" value="<?= htmlspecialchars($data['spotify_playlist_url']); ?>">
                                <?php if ($data['spotify_playlist_url']): ?>
                                    <div class="mt-2">
                                        <iframe style="border-radius:12px" src="<?= htmlspecialchars($data['spotify_playlist_url']) ?>" width="100%" height="80" frameborder="0" allowfullscreen allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
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