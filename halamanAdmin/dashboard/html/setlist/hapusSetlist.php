<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Ambil nama file buat dihapus
    $data = $koneksi->query("SELECT audio_file, judul_lagu FROM setlist_konser WHERE id_setlist='$id'")->fetch_assoc();

    if ($data) {
        // Path Absolute
        $path = dirname(__DIR__, 4) . "/uploads/setlistAudio/" . $data['audio_file'];

        // Hapus File Fisik
        if (!empty($data['audio_file']) && file_exists($path)) {
            unlink($path);
        }

        // Hapus Database
        $koneksi->query("DELETE FROM setlist_konser WHERE id_setlist='$id'");

        // Log
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $koneksi->query("INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'HAPUS SETLIST', 'Hapus Lagu: {$data['judul_lagu']}')");

        echo "<script>alert('Berhasil Dihapus!'); window.location='manajemenSetlist.php';</script>";
    }
}
?>