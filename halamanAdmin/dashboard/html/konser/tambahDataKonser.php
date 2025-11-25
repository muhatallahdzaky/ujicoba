<?php
session_start();
include '../koneksi.php'; // Mundur 1 langkah ke html/

// AKTIFKAN PELAPORAN ERROR (DEBUGGING)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// --- LOGIC PROSES SIMPAN ---
if (isset($_POST['simpan'])) {

    // A. SIAPKAN PATH FOLDER UPLOAD
    // Mundur 4 langkah: konser/ -> html/ -> dashboard/ -> halamanAdmin/ -> ROOT
    $baseDir = dirname(__DIR__, 4) . "/uploads/";

    $dirPoster     = $baseDir . "posterPict/";
    $dirTrailer    = $baseDir . "trailerPict/";

    // B. BUAT FOLDER KALAU BELUM ADA
    if (!is_dir($dirPoster)) mkdir($dirPoster, 0777, true);
    if (!is_dir($dirTrailer)) mkdir($dirTrailer, 0777, true);
    if (!is_dir($dirAftermovie)) mkdir($dirAftermovie, 0777, true);

    // C. FUNGSI UPLOAD
    function prosesUpload($inputName, $folderTujuan)
    {
        if (!empty($_FILES[$inputName]['name'])) {
            $namaFile   = $_FILES[$inputName]['name'];
            $tmpName    = $_FILES[$inputName]['tmp_name'];
            $ext        = strtolower(pathinfo($namaFile, PATHINFO_EXTENSION));

            $allowed    = ['jpg', 'jpeg', 'png', 'webp', 'mp4', 'mkv', 'avi'];

            if (in_array($ext, $allowed)) {
                $namaBaru = uniqid() . '.' . $ext;
                if (move_uploaded_file($tmpName, $folderTujuan . $namaBaru)) {
                    return $namaBaru;
                }
            }
        }
        return "";
    }

    // D. GENERATE ID OTOMATIS (K01 -> K02)
    $cekId = mysqli_query($koneksi, "SELECT max(id_konser) as maxID FROM konser");
    $dataId = mysqli_fetch_array($cekId);
    $idMax = $dataId['maxID'];

    $noUrut = 1;
    if ($idMax) {
        $noUrut = (int) substr($idMax, 1, 3);
        $noUrut++;
    }
    $id_konser_baru = "K" . sprintf("%02s", $noUrut);

    // E. TANGKAP DATA TEXT
    $nama_konser      = mysqli_real_escape_string($koneksi, $_POST['nama_konser']);
    $id_venue         = $_POST['id_venue'];
    $tanggal_mulai    = $_POST['tanggal_mulai'];
    $tanggal_selesai  = $_POST['tanggal_selesai'];
    $harga_tiket      = $_POST['harga_tiket'];
    $link_tiket       = $_POST['link_tiket'];

    // Tentukan Status
    $status_konser    = ($tanggal_mulai > date('Y-m-d H:i:s')) ? 'upcoming' : 'completed';

    // F. JALANKAN UPLOAD
    $poster_nama     = prosesUpload('poster', $dirPoster);
    $video    = prosesUpload('video', $dirTrailer);

    // G. INSERT DATABASE
    $query = "INSERT INTO konser (
                id_konser, nama_konser, id_venue, tanggal_mulai, tanggal_selesai, harga_tiket_mulai, link_tiket,
                poster_konser, video, status_konser
              ) VALUES (
                '$id_konser_baru', '$nama_konser', '$id_venue', '$tanggal_mulai', '$tanggal_selesai', '$harga_tiket', '$link_tiket',
                '$poster_nama', '$video', '$status_konser'
              )";

    if (mysqli_query($koneksi, $query)) {
        // Catat Log
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        mysqli_query($koneksi, "INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'TAMBAH KONSER', 'Menambah konser: $nama_konser')");

        echo "<script>alert('Berhasil! ID: $id_konser_baru'); window.location='manajemenKonser.php';</script>";
    } else {
        echo "<script>alert('Gagal Database: " . mysqli_error($koneksi) . "');</script>";
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

        input[type=file] {
            background-color: #2c3e50;
            color: #bdc3c7;
        }
    </style>
</head>

<body>

    <?php include '../header.php'; ?> <div class="d-flex-wrapper">

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
                                    <option value="" disabled selected>-- Pilih Venue --</option>
                                    <?php
                                    // Query Data Venue
                                    $vQ = mysqli_query($koneksi, "SELECT id_venue, nama_venue FROM venue ORDER BY nama_venue ASC");
                                    while ($v = mysqli_fetch_assoc($vQ)) {
                                        echo "<option value='" . $v['id_venue'] . "'>" . $v['nama_venue'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-6"><label>Mulai</label><input type="datetime-local" class="form-control" name="tanggal_mulai" required></div>
                            <div class="col-md-6"><label>Selesai</label><input type="datetime-local" class="form-control" name="tanggal_selesai" required></div>
                            <div class="col-md-6"><label>Harga Tiket (Rp)</label><input type="number" class="form-control" name="harga_tiket" required></div>
                            <div class="col-md-6"><label>Link Tiket</label><input type="text" class="form-control" name="link_tiket" required></div>

                            <div class="col-md-4"><label>Poster (Gambar)</label><input type="file" class="form-control" name="poster" accept="image/*" required></div>
                            <div class="col-md-4"><label>Video</label><input type="file" class="form-control" name="video" accept="video/*"></div>

                            <div class="col-12 text-end mt-4">
                                <button type="submit" name="simpan" class="btn btn-success px-4">Simpan Data</button>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <?php include '../footer.php'; ?> <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>