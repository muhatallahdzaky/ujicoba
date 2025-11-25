<?php
session_start();
include '../koneksi.php';

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

$queryCek = $koneksi->query("SELECT nama_provinsi FROM provinsi WHERE id_provinsi='$id'");
$data = $queryCek->fetch_assoc();

if ($data) {
    $namaProvinsi = $data['nama_provinsi'];

    $hapus = $koneksi->query("DELETE FROM provinsi WHERE id_provinsi='$id'");

    if ($hapus) {
        $admin = $_SESSION['nama_admin'] ?? 'Admin';
        $logQ = "INSERT INTO log_aktivitas (admin_nama, aksi, deskripsi)
                 VALUES ('$admin', 'HAPUS PROVINSI', 'Menghapus Provinsi: $namaProvinsi (ID: $id)')";
        $koneksi->query($logQ);

        header("Location: manajemenProvinsi.php");
        exit;
    } else {
        echo "<script>alert('Gagal menghapus! Mungkin ada Kota yang masih terikat dengan provinsi ini.'); window.history.back();</script>";
        exit;
    }
} else {
    header("Location: manajemenProvinsi.php");
    exit;
}
?>