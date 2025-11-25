<?php
session_start();
require_once 'config/database.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$action = isset($_GET['action']) ? $_GET['action'] : '';
$id_konser = isset($_GET['id_konser']) ? clean_input($_GET['id_konser']) : '';

if (empty($id_konser)) {
    header("Location: index.php");
    exit();
}

// ADD
if ($action == 'add') {
    // Cek sudah ada?
    $check = $conn->query("SELECT * FROM wishlist WHERE id_user = '$user_id' AND id_konser = '$id_konser'");
    
    if ($check->num_rows == 0) {
        // Generate ID
        $query_last = "SELECT id_wishlist FROM wishlist ORDER BY id_wishlist DESC LIMIT 1";
        $result_last = $conn->query($query_last);
        
        if ($result_last->num_rows > 0) {
            $last_id = $result_last->fetch_assoc()['id_wishlist'];
            $num = intval(substr($last_id, 1)) + 1;
            $new_id = 'W' . str_pad($num, 3, '0', STR_PAD_LEFT);
        } else {
            $new_id = 'W001';
        }
        
        $conn->query("INSERT INTO wishlist (id_wishlist, id_user, id_konser) VALUES ('$new_id', '$user_id', '$id_konser')");
    }
    
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

// REMOVE
elseif ($action == 'remove') {
    $conn->query("DELETE FROM wishlist WHERE id_user = '$user_id' AND id_konser = '$id_konser'");
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

else {
    header("Location: index.php");
    exit();
}
?>