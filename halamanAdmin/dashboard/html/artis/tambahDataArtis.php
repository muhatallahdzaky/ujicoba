<?php
session_start();
include '../koneksi.php';

// --- LOGIC PROSES SIMPAN ---
if (isset($_POST['simpan'])) {

    $queryAll = $koneksi->query("SELECT id_artis FROM artis");
    $angkaTerpakai = [];

    while ($row = $queryAll->fetch_assoc()) {
        $angkaTerpakai[] = (int) substr($row['id_artis'], 1);
    }

    if (empty($angkaTerpakai)) {
        $nextNumber = 1;
    } else {
        $nextNumber = max($angkaTerpakai) + 1;
    }

    $idArtisBaru = "A" . $nextNumber;

    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama_artis']);
    $genre    = mysqli_real_escape_string($koneksi, $_POST['genre']);
    $negara   = mysqli_real_escape_string($koneksi, $_POST['asal_negara']);
    $playlist = mysqli_real_escape_string($koneksi, $_POST['spotify_playlist_url']);
    $tipe     = $_POST['tipe_entitas'];


    // 3. PROSES UPLOAD GAMBAR (Pakai Logika Path Absolut biar aman)
    $rootProject = dirname(__DIR__, 4); // Mundur ke root project
    $targetDir   = $rootProject . "/assets/uploads/band_pict/";
    $dbPath      = "assets/uploads/band_pict/";
    $fotoFix     = "";

    // Buat folder kalau belum ada
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (!empty($_FILES['gambar_artis']['name'])) {
        $fileName = $_FILES['gambar_artis']['name'];
        $tmpName  = $_FILES['gambar_artis']['tmp_name'];
        $ext      = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowed  = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($ext, $allowed)) {
            // Rename file: A99_unik.jpg
            $newFileName = $idArtisBaru . '_' . uniqid() . '.' . $ext;
            $uploadPath  = $targetDir . $newFileName;

            if (move_uploaded_file($tmpName, $uploadPath)) {
                $fotoFix = $dbPath . $newFileName;
            } else {
                echo "<script>alert('Gagal upload gambar (Permission Error). Data tetap disimpan tanpa gambar.');</script>";
            }
        } else {
            echo "<script>alert('Format gambar salah! Harap pakai JPG/PNG/WEBP.');</script>";
        }
    }


    // 4. INSERT DATABASE
    $query = "INSERT INTO artis (id_artis, nama_artis, genre, asal_negara, tipe_entitas, gambar_artis, spotify_playlist_url)
              VALUES ('$idArtisBaru', '$nama', '$genre', '$negara', '$tipe', '$fotoFix', '$playlist')";

    if ($koneksi->query($query)) {
        // Log Aktivitas
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $koneksi->query("INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'TAMBAH ARTIS', 'Menambah Artis: $nama ($idArtisBaru)')");

        echo "<script>alert('Sukses! Artis Berhasil Ditambahkan (ID: $idArtisBaru).'); window.location='manajemenArtis.php';</script>";
    } else {
        echo "<script>alert('Gagal Database: " . $koneksi->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Artis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        .form-control, .form-select {
            background-color: #2c3e50;
            color: white;
            border: 1px solid #4a5f7f;
        }
        .form-control:focus, .form-select:focus {
            background-color: #34495e;
            color: white;
            border-color: #3498db;
        }
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
                <h4 class="fw-bold text-white">Tambah Data Artis</h4>
                <a href="manajemenArtis.php" class="btn btn-secondary btn-sm">Kembali</a>
            </div>

            <div class="card stats-card border-0">
                <div class="card-body">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="row g-4">

                            <div class="col-12">
                                <label>Nama Artis</label>
                                <input type="text" class="form-control" name="nama_artis" required>
                            </div>

                            <div class="col-md-6">
                                <label>Genre</label>
                                <input type="text" class="form-control" name="genre">
                            </div>

                            <div class="col-md-6">
                                <label>Negara</label>
                                <input type="text" class="form-control" name="asal_negara">
                            </div>

                            <div class="col-md-6">
                                <label>Tipe Entitas</label>
                                <select class="form-select" name="tipe_entitas">
                                    <option value="Artis Solo (Vokalis/Musisi)">Artis Solo</option>
                                    <option value="Grup Band">Grup Band</option>
                                    <option value="Grup Idola">Grup Idola</option>
                                    <option value="DJ/Produser">DJ/Produser</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Foto Artis</label>
                                <input type="file" class="form-control" name="gambar_artis" accept=".jpg,.png,.jpeg,.webp">
                            </div>

                            <div class="col-md-6">
                                <label>Playlist Spotify</label>
                                <input type="text" class="form-control" name="spotify_playlist_url">
                            </div>

                            <div class="col-12 text-end mt-4">
                                <button type="submit" name="simpan" class="btn btn-primary px-4">Simpan Data</button>
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