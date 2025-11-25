<?php
session_start();
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    if ($koneksi->query("DELETE FROM lineup WHERE id_lineup='$id'")) {
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $koneksi->query("INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi) VALUES ('$admin', 'HAPUS LINEUP', 'Hapus LineUp ID: $id')");

        echo "<script>alert('Berhasil Dihapus!'); window.location='manajemenLineUp.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus!'); window.history.back();</script>";
    }
} else {
    header("Location: manajemenLineUp.php");
}
?>