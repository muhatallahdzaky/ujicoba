<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // 1. AMBIL DATA DULU (Buat Log)
    $queryCek = $koneksi->query("SELECT nama_lengkap FROM users WHERE id_user = '$id'");
    $data = $queryCek->fetch_assoc();

    if ($data) {
        $namaDihapus = $data['nama_lengkap'];

        // 2. HAPUS DATA
        $hapus = $koneksi->query("DELETE FROM users WHERE id_user = '$id'");

        if ($hapus) {
            // 3. CATAT LOG
            $admin = $_SESSION['nama_admin'] ?? 'Admin';
            $logQ = "INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'HAPUS USER', 'Menghapus user: $namaDihapus (ID: $id)')";
            $koneksi->query($logQ);

            echo "<script>alert('User Berhasil Dihapus!'); window.location='manajemenUsers.php';</script>";
        } else {
            echo "<script>alert('Gagal menghapus database!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location='manajemenUsers.php';</script>";
    }
} else {
    header("Location: manajemenUsers.php");
}
?>