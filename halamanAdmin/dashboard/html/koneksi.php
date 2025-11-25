<?php
// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_konser');
define('BASE_URL', 'http://localhost/WebKonserProjek/');
date_default_timezone_set('Asia/Jakarta');

// Koneksi ke Database
try {
    $koneksi = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    // Cek koneksi
    if ($koneksi->connect_error) {
        die("Koneksi database gagal: " . $conn->connect_error);
    }
    // Set charset ke utf8mb4
    $koneksi->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}

/** Fungsi helper untuk mencegah SQL Injection */
function clean_input($data)
{
    global $koneksi;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $data = $koneksi->real_escape_string($data);
    return $data;
}

/* Fungsi untuk redirect */
function redirect($url)
{
    header("Location: " . BASE_URL . $url);
    exit();
}

/** Fungsi untuk cek apakah user sudah login */
function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

/** Fungsi untuk cek apakah user adalah admin */
function is_admin()
{
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/** Fungsi untuk memaksa login (redirect ke login jika belum login) */
function require_login()
{
    if (!is_logged_in()) {
        $_SESSION['error'] = "Silakan login terlebih dahulu!";
        redirect('auth/login.php');
    }
}

/* Fungsi untuk memaksa admin (redirect jika bukan admin) */
function require_admin()
{
    require_login();
    if (!is_admin()) {
        $_SESSION['error'] = "Anda tidak memiliki akses ke halaman ini!";
        redirect('index.php');
    }
}

/* Fungsi untuk format tanggal Indonesia */
function format_tanggal($datetime)
{
    $bulan = array(
        1 => 'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );

    $timestamp = strtotime($datetime);
    $tanggal = date('j', $timestamp);
    $bulan_idx = date('n', $timestamp);
    $tahun = date('Y', $timestamp);
    return $tanggal . ' ' . $bulan[$bulan_idx] . ' ' . $tahun;
}

/* Fungsi untuk format rupiah */
function format_rupiah($angka)
{
    return 'Rp ' . number_format($angka, 0, ',', '.');
}

/* Fungsi untuk generate ID otomatis */
function generate_id($prefix, $table, $id_column)
{
    global $conn;

    $query = "SELECT $id_column FROM $table ORDER BY $id_column DESC LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_id = $row[$id_column];
        $number = (int)substr($last_id, strlen($prefix)) + 1;
    } else {
        $number = 1;
    }

    return $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
}
