<?php
session_start();
include '../koneksi.php';

if (!isset($_GET['id'])) header("Location: manajemenKonser.php");
$id = mysqli_real_escape_string($koneksi, $_GET['id']);

$query = mysqli_query($koneksi, "SELECT * FROM konser WHERE id_konser = '$id'");
$data  = mysqli_fetch_assoc($query);
if (!$data) die("Data tidak ditemukan!");

if (isset($_POST['update'])) {
    $baseDir = dirname(__DIR__, 4) . "/uploads/";
    $dirPoster     = $baseDir . "posterPict/";
    $dirTrailer    = $baseDir . "trailerPict/";
    $dirAftermovie = $baseDir . "aftermoviePict/";

    function cekUpload($inputName, $folder, $oldFile) {
        if (!empty($_FILES[$inputName]['name'])) {
            $name = $_FILES[$inputName]['name'];
            $tmp  = $_FILES[$inputName]['tmp_name'];
            $ext  = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            $new  = uniqid() . '.' . $ext;
            if (move_uploaded_file($tmp, $folder . $new)) {
                if (!empty($oldFile) && file_exists($folder . $oldFile)) unlink($folder . $oldFile);
                return $new;
            }
        }
        return $oldFile;
    }

    $nama   = mysqli_real_escape_string($koneksi, $_POST['nama_konser']);
    $status = ($_POST['tanggal_mulai'] > date('Y-m-d H:i:s')) ? 'upcoming' : 'completed';

    $poster_fix     = cekUpload('poster', $dirPoster, $data['poster_konser']);
    $trailer_fix    = cekUpload('video_trailer', $dirTrailer, $data['video_trailer']);
    $aftermovie_fix = cekUpload('video_aftermovie', $dirAftermovie, $data['video_aftermovie']);

    $q = "UPDATE konser SET nama_konser='$nama', id_venue='".$_POST['id_venue']."', tanggal_mulai='".$_POST['tanggal_mulai']."', tanggal_selesai='".$_POST['tanggal_selesai']."', harga_tiket_mulai='".$_POST['harga_tiket']."', info_harga_tiket='".$_POST['info_harga']."', deskripsi='".$_POST['deskripsi']."', poster_konser='$poster_fix', video_trailer='$trailer_fix', video_aftermovie='$aftermovie_fix', status_konser='$status' WHERE id_konser='$id'";

    if (mysqli_query($koneksi, $q)) {
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        mysqli_query($koneksi, "INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'EDIT KONSER', 'Edit Konser: $nama')");
        echo "<script>alert('Update Berhasil!'); window.location='manajemenKonser.php';</script>";
    } else {
        echo "<script>alert('Gagal Update!');</script>";
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
        .img-preview { width: 100px; margin-top: 5px; border: 1px solid #555; }
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
                            <div class="col-12"><label>Nama Konser</label><input type="text" class="form-control" name="nama_konser" value="<?= htmlspecialchars($data['nama_konser']) ?>" required></div>
                            <div class="col-12">
                                <label>Lokasi Venue</label>
                                <select class="form-select" name="id_venue" required>
                                    <option value="">-- Pilih Venue --</option>
                                    <?php
                                    $vQ = mysqli_query($koneksi, "SELECT id_venue, nama_venue FROM venue ORDER BY nama_venue ASC");
                                    while($v = mysqli_fetch_assoc($vQ)){
                                        $sel = ($v['id_venue'] == $data['id_venue']) ? 'selected' : '';
                                        echo "<option value='".$v['id_venue']."' $sel>".$v['nama_venue']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-6"><label>Mulai</label><input type="datetime-local" class="form-control" name="tanggal_mulai" value="<?= date('Y-m-d\TH:i', strtotime($data['tanggal_mulai'])) ?>" required></div>
                            <div class="col-md-6"><label>Selesai</label><input type="datetime-local" class="form-control" name="tanggal_selesai" value="<?= date('Y-m-d\TH:i', strtotime($data['tanggal_selesai'])) ?>" required></div>
                            <div class="col-md-6"><label>Harga</label><input type="number" class="form-control" name="harga_tiket" value="<?= $data['harga_tiket_mulai'] ?>" required></div>
                            <div class="col-md-6"><label>Info</label><input type="text" class="form-control" name="info_harga" value="<?= htmlspecialchars($data['info_harga_tiket']) ?>"></div>
                            <div class="col-12"><label>Deskripsi</label><textarea class="form-control" name="deskripsi" rows="3"><?= htmlspecialchars($data['deskripsi']) ?></textarea></div>
                            <div class="col-md-4"><label>Ganti Poster</label><input type="file" class="form-control" name="poster"> <?php if($data['poster_konser']) echo "<img src='../../../../uploads/posterPict/{$data['poster_konser']}' class='img-preview'>"; ?></div>
                            <div class="col-md-4"><label>Ganti Trailer</label><input type="file" class="form-control" name="video_trailer"></div>
                            <div class="col-md-4"><label>Ganti Aftermovie</label><input type="file" class="form-control" name="video_aftermovie"></div>
                            <div class="col-12 text-end mt-4"><button type="submit" name="update" class="btn btn-primary px-4">Simpan Perubahan</button></div>
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