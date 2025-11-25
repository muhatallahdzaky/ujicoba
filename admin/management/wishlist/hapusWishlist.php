<?php
session_start();
include '../koneksi.php';

// 1. Sanitize ID
$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// 2. Ambil data User dan Konser sebelum dihapus (untuk Log)
$queryCek = "SELECT u.nama_lengkap, k.nama_konser
             FROM wishlist w
             JOIN users u ON w.id_user = u.id_user
             JOIN konser k ON w.id_konser = k.id_konser
             WHERE w.id_wishlist = '$id'";

$data = $koneksi->query($queryCek)->fetch_assoc();

if ($data) {
    $namaUser = $data['nama_lengkap'];
    $namaKonser = $data['nama_konser'];

    // 3. HAPUS DATA
    $hapus = $koneksi->query("DELETE FROM wishlist WHERE id_wishlist='$id'");

    if ($hapus) {
        // 4. CATAT LOG
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $logQ = "INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi)
                 VALUES ('$admin', 'HAPUS WISHLIST', 'Menghapus wishlist: Konser $namaKonser dari user $namaUser (ID: $id)')";
        $koneksi->query($logQ);

        // Redirect
        header("Location: manajemenWishlist.php");
        exit;
    } else {
        // Gagal menghapus dari DB
        echo "<script>alert('Gagal menghapus wishlist! Cek integritas database.'); window.history.back();</script>";
        exit;
    }
} else {
    // Data tidak ditemukan
    header("Location: manajemenWishlist.php");
    exit;
}
?>