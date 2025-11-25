<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Ambil data buat log
    $q = mysqli_query($koneksi, "SELECT nama_kota FROM kota WHERE id_kota = '$id'");
    $data = mysqli_fetch_assoc($q);

    if ($data) {
        $nama = $data['nama_kota'];

        // Hapus DB
        // Note: Hati-hati, kalau kota ini dipakai di tabel Venue, biasanya bakal error (Constraint)
        // Kecuali di database diset ON DELETE CASCADE
        if (mysqli_query($koneksi, "DELETE FROM kota WHERE id_kota = '$id'")) {
            $admin = $_SESSION['nama_admin'] ?? 'Admin';
            mysqli_query($koneksi, "INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'HAPUS KOTA', 'Hapus Kota: $nama')");
            echo "<script>alert('Berhasil Dihapus!'); window.location='manajemenKota.php';</script>";
        } else {
            // Tampilkan error kalau gagal (biasanya karena dipakai di tabel lain)
            echo "<script>alert('Gagal Hapus! Kota ini mungkin sedang digunakan di data Venue.'); window.history.back();</script>";
        }
    }
} else {
    header("Location: manajemenKota.php");
}
?>