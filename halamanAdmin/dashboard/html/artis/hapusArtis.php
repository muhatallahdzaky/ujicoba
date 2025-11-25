<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // 1. Ambil Data Dulu (Buat hapus file fisiknya)
    $queryCek = mysqli_query($koneksi, "SELECT * FROM artis WHERE id_artis = '$id'");
    $data = mysqli_fetch_assoc($queryCek);

    if ($data) {
        $namaDihapus = $data['nama_artis'];
        $fileGambar  = $data['gambar_artis'];

        // PATH FISIK FILE (Sesuai editArtis.php)
        $baseDir = dirname(__DIR__, 4) . "/uploads/";
        $pathGambar = $baseDir . "artisPict/" . $fileGambar;

        // 2. Hapus Data dari Database
        $hapus = mysqli_query($koneksi, "DELETE FROM artis WHERE id_artis = '$id'");

        if ($hapus) {
            // 3. Hapus File Fisik Jika Ada
            if (!empty($fileGambar) && file_exists($pathGambar)) {
                unlink($pathGambar);
            }

            // 4. Log
            $admin = $_SESSION['nama_admin'] ?? 'Admin';
            mysqli_query($koneksi, "INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'HAPUS ARTIS', 'Menghapus Artis: $namaDihapus')");

            echo "<script>alert('Artis Berhasil Dihapus!'); window.location='manajemenArtis.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus database!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location='manajemenArtis.php';</script>";
    }
} else {
    header("Location: manajemenArtis.php");
}
?>>