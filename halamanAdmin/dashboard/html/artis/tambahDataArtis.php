<?php
session_start();
include '../koneksi.php';

if (isset($_POST['simpan'])) {

    // 1. GENERATE ID OTOMATIS (A001)
    $cekId = $koneksi->query("SELECT max(id_artis) as maxID FROM artis");
    $dataId = $cekId->fetch_assoc();
    $idMax = $dataId['maxID'];

    $noUrut = 1;
    if ($idMax) {
        $noUrut = (int) substr($idMax, 1, 3);
        $noUrut++;
    }
    $idArtisBaru = "A" . sprintf("%03s", $noUrut);

    // 2. TANGKAP DATA
    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama_artis']);
    $genre  = mysqli_real_escape_string($koneksi, $_POST['genre']);
    $negara = mysqli_real_escape_string($koneksi, $_POST['asal_negara']);
    $playlist = mysqli_real_escape_string($koneksi, $_POST['spotify_playlist_url']);
    $tipe   = $_POST['tipe_entitas'];

    // 3. SETUP PATH UPLOAD (Sesuai script editArtis.php lu)
    $baseDir = dirname(__DIR__, 4) . "/uploads/";
    $dirPict  = $baseDir . "artisPict/";

    // Fungsi Upload Sederhana
    function uploadFile($inputName, $folder, $exts)
    {
        if (!empty($_FILES[$inputName]['name'])) {
            $name = $_FILES[$inputName]['name'];
            $tmp  = $_FILES[$inputName]['tmp_name'];
            $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));

            if (in_array($ext, $exts)) {
                $newName = uniqid() . '.' . $ext;
                if (move_uploaded_file($tmp, $folder . $newName)) {
                    return $newName;
                }
            }
        }
        return ""; // Return kosong jika gagal/gak upload
    }

    // Proses Upload
    $fotoFix  = uploadFile('gambar_artis', $dirPict, ['jpg', 'png', 'webp', 'jpeg']);

    // 4. INSERT DATABASE
    $query = "INSERT INTO artis (id_artis, nama_artis, genre, asal_negara, tipe_entitas, gambar_artis, spotify_playlist_url)
              VALUES ('$idArtisBaru', '$nama', '$genre', '$negara', '$tipe', '$fotoFix', '$playlist')";

    if ($koneksi->query($query)) {
        // Log
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $koneksi->query("INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'TAMBAH ARTIS', 'Menambah Artis: $nama ($idArtisBaru)')");

        echo "<script>alert('Artis Berhasil Ditambahkan!'); window.location='manajemenArtis.php';</script>";
    } else {
        echo "<script>alert('Gagal: " . $koneksi->error . "');</script>";
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
        .form-control,
        .form-select {
            background-color: #2c3e50;
            color: white;
            border: 1px solid #4a5f7f;
        }

        .form-control:focus {
            background-color: #34495e;
            color: white;
            border-color: #3498db;
        }

        label {
            color: #bdc3c7;
            margin-bottom: 5px;
        }

        input[type=file] {
            background-color: #2c3e50;
            color: #bdc3c7;
        }
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