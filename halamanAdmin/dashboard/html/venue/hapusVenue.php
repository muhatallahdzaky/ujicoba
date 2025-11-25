<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Ambil data untuk log
    $cek = $koneksi->query("SELECT nama_venue FROM venue WHERE id_venue='$id'")->fetch_assoc();
    $namaVenue = $cek['nama_venue'] ?? 'Venue';

    // Hapus
    if ($koneksi->query("DELETE FROM venue WHERE id_venue='$id'")) {
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $koneksi->query("INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'HAPUS VENUE', 'Hapus Venue: $namaVenue ($id)')");

        echo "<script>alert('Venue Berhasil Dihapus!'); window.location='manajemenVenue.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus! Mungkin venue ini sedang dipakai di Konser.'); window.history.back();</script>";
    }
} else {
    header("Location: manajemenVenue.php");
}
?>>