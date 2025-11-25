<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    $q = mysqli_query($koneksi, "SELECT * FROM konser WHERE id_konser = '$id'");
    $data = mysqli_fetch_assoc($q);

    if ($data) {
        $nama = $data['nama_konser'];
        // Mundur 4 langkah dari html/konser/hapusKonser.php ke root/uploads
        $baseDir = dirname(__DIR__, 4) . "/uploads/";

        if (!empty($data['poster_konser'])) {
            $f = $baseDir . "posterPict/" . $data['poster_konser'];
            if (file_exists($f)) unlink($f);
        }
        if (!empty($data['video'])) {
            $f = $baseDir . "trailerPict/" . $data['video'];
            if (file_exists($f)) unlink($f);
        }

        if (mysqli_query($koneksi, "DELETE FROM konser WHERE id_konser = '$id'")) {
            $admin = $_SESSION['nama_admin'] ?? 'Admin';
            mysqli_query($koneksi, "INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'HAPUS KONSER', 'Hapus Konser: $nama')");
            echo "<script>alert('Berhasil Dihapus!'); window.location='manajemenKonser.php';</script>";
        } else {
            echo "<script>alert('Gagal Hapus DB!'); window.history.back();</script>";
        }
    }
} else {
    header("Location: manajemenKonser.php");
}
?>