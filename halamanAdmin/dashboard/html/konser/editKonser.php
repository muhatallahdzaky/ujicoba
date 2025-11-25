<?php
session_start();
include '../koneksi.php';

if (!isset($_GET['id'])) {
    die("Error: ID tidak ditemukan.");
}
$id = mysqli_real_escape_string($koneksi, $_GET['id']);

$query = mysqli_query($koneksi, "SELECT * FROM konser WHERE id_konser = '$id'");
$data = mysqli_fetch_assoc($query);
if (!$data) die("Data tidak ditemukan!");

if (isset($_POST['update'])) {
    $rootProject = dirname(__DIR__, 4);

    function processUpload($inputFile, $subFolder, $oldDbPath, $rootProject, $idKonser, $allowedExts) {
        $targetDir = $rootProject . "/assets/uploads/" . $subFolder . "/";
        $dbDir = "assets/uploads/" . $subFolder . "/";
        $finalPath = $oldDbPath;

        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        if (!empty($_FILES[$inputFile]['name'])) {
            $fileName = $_FILES[$inputFile]['name'];
            $tmpName = $_FILES[$inputFile]['tmp_name'];
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($ext, $allowedExts)) {
                $newFileName = $idKonser . '_' . $inputFile . '_' . uniqid() . '.' . $ext;
                $uploadPath = $targetDir . $newFileName;

                if (move_uploaded_file($tmpName, $uploadPath)) {
                    $finalPath = $dbDir . $newFileName;

                    $oldAbsolutePath = $rootProject . "/" . $oldDbPath;
                    if (!empty($oldDbPath) && file_exists($oldAbsolutePath) && is_file($oldAbsolutePath)) {
                        unlink($oldAbsolutePath);
                    }
                }
            } else {
                echo "<script>alert('Format file salah');</script>";
            }
        }
        return $finalPath;
    }

    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_konser']);
    $venue = mysqli_real_escape_string($koneksi, $_POST['id_venue']);
    $mulai = $_POST['tanggal_mulai'];
    $selesai = $_POST['tanggal_selesai'];
    $harga = $_POST['harga_tiket'];
    $link = mysqli_real_escape_string($koneksi, $_POST['link_tiket']);
    $status = ($mulai > date('Y-m-d H:i:s')) ? 'upcoming' : 'completed';

    $poster_fix = processUpload('poster', 'posters', $data['poster_konser'], $rootProject, $id, ['jpg', 'jpeg', 'png', 'webp']);
    $video_fix = processUpload('video_trailer', 'trailers', $data['video'], $rootProject, $id, ['mp4', 'webm', 'ogg']);

    $q = "UPDATE konser SET nama_konser='$nama', id_venue='$venue', tanggal_mulai='$mulai', tanggal_selesai='$selesai', harga_tiket_mulai='$harga', link_tiket='$link', poster_konser='$poster_fix', video='$video_fix', status_konser='$status' WHERE id_konser='$id'";

    if (mysqli_query($koneksi, $q)) {
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        mysqli_query($koneksi, "INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'EDIT KONSER', 'Edit Konser: $nama')");
        echo "<script>alert('Update Berhasil!'); window.location='manajemenKonser.php';</script>";
    } else {
        echo "<script>alert('Gagal Update: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Konser</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        .form-control, .form-select { background-color: #2c3e50; color: white; border: 1px solid #4a5f7f; }
        .form-control:focus { background-color: #34495e; color: white; border-color: #3498db; }
        label { color: #bdc3c7; margin-bottom: 5px; }
        .preview { border: 1px solid #555; margin-top: 5px; border-radius: 5px; object-fit: cover; }
        input[type=file] { background-color: #2c3e50; color: #bdc3c7; }
    </style>
</head>
<body>
    <?php include '../header.php'; ?>
    <div class="d-flex-wrapper">
        <?php include '../sideBar.php'; ?>
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-white">Edit Data Konser</h4>
                <a href="manajemenKonser.php" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
            <div class="card stats-card border-0">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row g-4">
                            <div class="col-12">
                                <label>Nama Konser</label>
                                <input type="text" class="form-control" name="nama_konser" value="<?= htmlspecialchars($data['nama_konser']) ?>" required>
                            </div>
                            <div class="col-12">
                                <label>Lokasi Venue</label>
                                <select class="form-select" name="id_venue" required>
                                    <option value="">-- Pilih Venue --</option>
                                    <?php
                                    $vQ = mysqli_query($koneksi, "SELECT id_venue, nama_venue FROM venue ORDER BY nama_venue ASC");
                                    while ($v = mysqli_fetch_assoc($vQ)) {
                                        $sel = ($v['id_venue'] == $data['id_venue']) ? 'selected' : '';
                                        echo "<option value='" . $v['id_venue'] . "' $sel>" . $v['nama_venue'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Mulai</label>
                                <input type="datetime-local" class="form-control" name="tanggal_mulai" value="<?= date('Y-m-d\TH:i', strtotime($data['tanggal_mulai'])) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label>Selesai</label>
                                <input type="datetime-local" class="form-control" name="tanggal_selesai" value="<?= date('Y-m-d\TH:i', strtotime($data['tanggal_selesai'])) ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label>Harga Tiket (Rp)</label>
                                <input type="number" class="form-control" name="harga_tiket" value="<?= $data['harga_tiket_mulai'] ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label>Link Tiket</label>
                                <input type="text" class="form-control" name="link_tiket" value="<?= $data['link_tiket'] ?>">
                            </div>
                            <div class="col-md-6">
                                <label>Ganti Poster</label>
                                <input type="file" class="form-control" name="poster" accept=".jpg,.jpeg,.png,.webp">
                                <?php if ($data['poster_konser']): ?>
                                    <img src="../../../../<?= $data['poster_konser']; ?>" class="preview" width="150">
                                    <br><small class="text-muted">Poster saat ini</small>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label>Ganti Video Trailer</label>
                                <input type="file" class="form-control" name="video_trailer" accept=".mp4,.webm,.ogg">
                                <?php if ($data['video']): ?>
                                    <video width="200" controls class="preview">
                                        <source src="../../../../<?= $data['video']; ?>" type="video/mp4">
                                    </video>
                                    <br><small class="text-muted">Video saat ini</small>
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