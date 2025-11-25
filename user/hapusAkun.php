<?php
session_start();
require_once '../config/database.php';
//cek user id sudah login atau belum
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$id_user = $_SESSION['user_id'];

$query_hapus_wishlist = "DELETE FROM wishlist WHERE id_user = '$id_user'";
$conn->query($query_hapus_wishlist);

$query_hapus_user = "DELETE FROM users WHERE id_user = '$id_user'";

if ($conn->query($query_hapus_user)) {
    //paksa session unset dan destroy agar kembali ke menu index.php
    session_unset();
    session_destroy();
    echo "<script>
            alert('Akun Anda dan seluruh data wishlist berhasil dihapus secara permanen. Sampai jumpa!');
            window.location.href = '../index.php';
          </script>";
    exit();
} else {
    echo "<script>
            alert('Gagal menghapus akun. Silakan coba lagi atau hubungi admin.');
            window.location.href = 'profile.php';
          </script>";
    exit();
}
?>