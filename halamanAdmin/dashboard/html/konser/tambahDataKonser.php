<?php
session_start();
include '../koneksi.php';

if (isset($_POST['simpan'])) {

    $queryAll = $koneksi->query("SELECT id_konser FROM konser");
    $angkaTerpakai = [];
    while ($row = $queryAll->fetch_assoc()) {
        $angkaTerpakai[] = (int) substr($row['id_konser'], 1);
    }

    if (empty($angkaTerpakai)) {
        $nextNumber = 1;
    } else {
        $nextNumber = max($angkaTerpakai) + 1;
    }

    $idBaru = "K" . sprintf("%03d", $nextNumber);

    $rootProject = dirname(__DIR__, 4);

    function processUpload($inputFile, $subFolder, $rootProject, $idKonser, $allowedExts) {
        $targetDir = $rootProject . "/assets/uploads/" . $subFolder . "/";
        $dbDir     = "assets/uploads/" . $subFolder . "/";
        $finalPath = NULL;

        if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

        if (!empty($_FILES[$inputFile]['name'])) {
            $fileName = $_FILES[$inputFile]['name'];
            $tmpName  = $_FILES[$inputFile]['tmp_name'];
            $ext      = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

            if (in_array($ext, $allowedExts)) {
                $newFileName = $idKonser . '_' . $inputFile . '_' . uniqid() . '.' . $ext;
                $uploadPath  = $targetDir . $newFileName;

                if (move_uploaded_file($tmpName, $uploadPath)) {
                    $finalPath = $dbDir . $newFileName;
                }
            } else {
                echo "<script>alert('Format file $inputFile salah!');</script>";
                return false;
            }
        }
        return $finalPath;
    }

    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama_konser']);
    $venue  = mysqli_real_escape_string($koneksi, $_POST['id_venue']);
    $mulai  = $_POST['tanggal_mulai'];
    $selesai= $_POST['tanggal_selesai'];
    $harga  = $_POST['harga_tiket'];
    $link   = mysqli_real_escape_string($koneksi, $_POST['link_tiket']);
    $status = ($mulai > date('Y-m-d H:i:s')) ? 'upcoming' : 'completed';

    $poster_fix = processUpload('poster', 'posters', $rootProject, $idBaru, ['jpg', 'jpeg', 'png', 'webp']);
    $video_fix  = processUpload('video_trailer', 'trailers', $rootProject, $idBaru, ['mp4', 'webm', 'ogg']);

    if ($poster_fix === false || $video_fix === false) {
        // Stop kalau upload gagal karena format salah
    } else {
        $q = "INSERT INTO konser (id_konser, nama_konser, id_venue, tanggal_mulai, tanggal_selesai, harga_tiket_mulai, link_tiket, poster_konser, video, status_konser)
              VALUES ('$idBaru', '$nama', '$venue', '$mulai', '$selesai', '$harga', '$link', '$poster_fix', '$video_fix', '$status')";

        if (mysqli_query($koneksi, $q)) {
            $admin = $_SESSION['nama_admin'] ?? 'Admin';
            mysqli_query($koneksi, "INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'TAMBAH KONSER', 'Tambah Konser: $nama ($idBaru)')");

            echo "<script>alert('Konser Berhasil Ditambahkan!'); window.location='manajemenKonser.php';</script>";
        } else {
            echo "<script>alert('Gagal Database: " . mysqli_error($koneksi) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Konser</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        .form-control, .form-select { background-color: #2c3e50; color: white; border: 1px solid #4a5f7f; }
        .form-control:focus { background-color: #34495e; color: white; border-color: #3498db; }
        label { color: #bdc3c7; margin-bottom: 5px; }
        input[type=file] { background-color: #2c3e50; color: #bdc3c7; }
    </style>
</head>

<body>
    <?php include '../header.php'; ?>
    <div class="d-flex-wrapper">
        <?php include '../sideBar.php'; ?>
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-white">Tambah Data Konser</h4>
                <a href="manajemenKonser.php" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
            <div class="card stats-card border-0">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row g-4">
                            <div class="col-12">
                                <label>Nama Konser</label>
                                <input type="text" class="form-control" name="nama_konser" required>
                            </div>

                            <div class="col-12">
                                <label>Lokasi Venue</label>
                                <select class="form-select" name="id_venue" required>
                                    <option value="">-- Pilih Venue --</option>
                                    <?php
                                    $vQ = mysqli_query($koneksi, "SELECT id_venue, nama_venue FROM venue ORDER BY nama_venue ASC");
                                    while ($v = mysqli_fetch_assoc($vQ)) {
                                        echo "<option value='" . $v['id_venue'] . "'>" . $v['nama_venue'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Mulai</label>
                                <input type="datetime-local" class="form-control" name="tanggal_mulai" required>
                            </div>

                            <div class="col-md-6">
                                <label>Selesai</label>
                                <input type="datetime-local" class="form-control" name="tanggal_selesai" required>
                            </div>

                            <div class="col-md-6">
                                <label>Harga Tiket (Rp)</label>
                                <input type="number" class="form-control" name="harga_tiket" required>
                            </div>

                            <div class="col-md-6">
                                <label>Link Tiket</label>
                                <input type="text" class="form-control" name="link_tiket" placeholder="https://...">
                            </div>

                            <div class="col-md-6">
                                <label>Poster</label>
                                <input type="file" class="form-control" name="poster" accept=".jpg,.jpeg,.png,.webp">
                            </div>

                            <div class="col-md-6">
                                <label>Video Trailer</label>
                                <input type="file" class="form-control" name="video_trailer" accept=".mp4,.webm,.ogg">
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