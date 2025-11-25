<?php
session_start();
include '../koneksi.php';

// Ambil data buat Dropdown
$dataKonser = $koneksi->query("SELECT id_konser, nama_konser FROM konser ORDER BY nama_konser ASC");
$dataArtis  = $koneksi->query("SELECT id_artis, nama_artis FROM artis ORDER BY nama_artis ASC");

if (isset($_POST['simpan'])) {
    // 1. ID OTOMATIS (SET001)
    $cekId = $koneksi->query("SELECT max(id_setlist) as maxID FROM setlist_konser");
    $dataId = $cekId->fetch_assoc();

    $noUrut = 1;
    if ($dataId['maxID']) {
        // Ambil angka setelah SET (index 3)
        $noUrut = (int)substr($dataId['maxID'], 3) + 1;
    }
    $idBaru = "SET" . sprintf("%03s", $noUrut);

    // 2. UPLOAD AUDIO (PATH ABSOLUTE - FIX)
    $rootPath = dirname(__DIR__, 4);
    $targetDir = $rootPath . "/uploads/setlistAudio/";
    $audioFix = NULL;

    // Cek folder ada gak, kalau gak ada buat
    if (!is_dir($targetDir)) mkdir($targetDir, 0777, true);

    if (!empty($_FILES['audio_file']['name'])) {
        $ext = strtolower(pathinfo($_FILES['audio_file']['name'], PATHINFO_EXTENSION));
        $newName = uniqid() . '.' . $ext;

        if (move_uploaded_file($_FILES['audio_file']['tmp_name'], $targetDir . $newName)) {
            $audioFix = $newName;
        }
    }

    // 3. TANGKAP DATA
    $konser = $_POST['id_konser'];
    $artis  = $_POST['id_artis'];
    $judul  = mysqli_real_escape_string($koneksi, $_POST['judul_lagu']);
    $durasi = $_POST['durasi'];
    $urutan = $_POST['urutan'];
    $ket    = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    // 4. INSERT DB
    $q = "INSERT INTO setlist_konser (id_setlist, id_konser, id_artis, judul_lagu, durasi, urutan, audio_file, keterangan)
          VALUES ('$idBaru', '$konser', '$artis', '$judul', '$durasi', '$urutan', '$audioFix', '$ket')";

    if ($koneksi->query($q)) {
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $koneksi->query("INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'TAMBAH SETLIST', 'Tambah Lagu: $judul ($idBaru)')");
        echo "<script>alert('Berhasil!'); window.location='manajemenSetlist.php';</script>";
    } else {
        echo "<script>alert('Gagal: " . $koneksi->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Tambah Setlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        /* CSS ANTI GAGAL: FONT PUTIH */
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
        /* Biar placeholder kelihatan tapi agak redup */
        ::placeholder { color: #bdc3c7 !important; opacity: 0.7; }

        label { color: #bdc3c7; margin-bottom: 5px; }
    </style>
</head>
<body>
    <?php include '../header.php'; ?>
    <div class="d-flex-wrapper">
        <?php include '../sideBar.php'; ?>

        <div class="main-content">
            <h4 class="fw-bold text-white mb-4">Tambah Lagu Setlist</h4>
            <div class="card stats-card border-0">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label>Konser</label>
                                <select name="id_konser" class="form-select" required>
                                    <option value="">-- Pilih Konser --</option>
                                    <?php while($k = $dataKonser->fetch_assoc()) {
                                        echo "<option value='{$k['id_konser']}'>{$k['nama_konser']}</option>";
                                    } ?>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label>Artis</label>
                                <select name="id_artis" class="form-select" required>
                                    <option value="">-- Pilih Artis --</option>
                                    <?php while($a = $dataArtis->fetch_assoc()) {
                                        echo "<option value='{$a['id_artis']}'>{$a['nama_artis']}</option>";
                                    } ?>
                                </select>
                            </div>

                            <div class="col-md-8">
                                <label>Judul Lagu</label>
                                <input type="text" name="judul_lagu" class="form-control" required>
                            </div>

                            <div class="col-md-2">
                                <label>Durasi (MM:SS)</label>
                                <input type="text" name="durasi" class="form-control" placeholder="03:45">
                            </div>

                            <div class="col-md-2">
                                <label>Urutan</label>
                                <input type="number" name="urutan" class="form-control" value="1">
                            </div>

                            <div class="col-12">
                                <label>File Audio (Opsional)</label>
                                <input type="file" name="audio_file" class="form-control" accept=".mp3,.wav,.ogg">
                            </div>

                            <div class="col-12">
                                <label>Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="2"></textarea>
                            </div>

                            <div class="col-12 mt-4 text-end">
                                <button type="submit" name="simpan" class="btn btn-success px-4">Simpan Data</button>
                                <a href="manajemenSetlist.php" class="btn btn-secondary">Batal</a>
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
</html>>