<?php
session_start();
require_once '../config/database.php';
$page_title = "Daftar Akun - ConcerFo";

// Redirect jika sudah login
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = clean_input($_POST['nama_lengkap']);
    $email = clean_input($_POST['email']);
    $password = clean_input($_POST['password']);
    $confirm_password = clean_input($_POST['confirm_password']);
    $no_telepon = clean_input($_POST['no_telepon']);
    
    // Validasi
    if (empty($nama_lengkap) || empty($email) || empty($password)) {
        $error = "Nama, email, dan password wajib diisi!";
    } elseif ($password !== $confirm_password) {
        $error = "Password dan konfirmasi password tidak cocok!";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal 6 karakter!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    } else {
        // Cek email sudah terdaftar
        $check_email = $conn->query("SELECT id_user FROM users WHERE email = '$email'");
        
        if ($check_email->num_rows > 0) {
            $error = "Email sudah terdaftar! Silakan login.";
        } else {
            // Generate ID User
            $query_last_id = "SELECT id_user FROM users ORDER BY id_user DESC LIMIT 1";
            $result_last = $conn->query($query_last_id);
            
            if ($result_last->num_rows > 0) {
                $last_id = $result_last->fetch_assoc()['id_user'];
                $num = intval(substr($last_id, 1)) + 1;
                $new_id = 'U' . str_pad($num, 3, '0', STR_PAD_LEFT);
            } else {
                $new_id = 'U001';
            }
            
            // Insert user baru
            $insert = "INSERT INTO users (id_user, nama_lengkap, email, password, no_telepon, role, status_akun) 
                      VALUES ('$new_id', '$nama_lengkap', '$email', '$password', '$no_telepon', 'user', 'active')";
            
            if ($conn->query($insert)) {
                $success = "Pendaftaran berhasil! Silakan login.";
                // Redirect ke login setelah 2 detik
                header("refresh:2;url=login.php");
            } else {
                $error = "Terjadi kesalahan. Silakan coba lagi.";
            }
        }
    }
}

$page_title = "Daftar Akun - ConcerFo";
include '../includes/header.php';
?>

<style>
.auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    padding: 80px 0 40px;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
}

.auth-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 3rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
}

.auth-header {
    text-align: center;
    margin-bottom: 2rem;
}

.auth-header h2 {
    color: var(--primary-yellow);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.auth-header p {
    color: #ccc;
}

.form-control {
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: white;
    padding: 0.75rem 1rem;
    border-radius: 10px;
}

.form-control:focus {
    background: rgba(255, 255, 255, 0.15);
    border-color: var(--primary-yellow);
    color: white;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.form-control::placeholder {
    color: #aaa;
}

.form-label {
    color: #fff;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.btn-register {
    background: var(--primary-yellow);
    color: var(--primary-dark);
    border: none;
    padding: 0.75rem;
    font-weight: 600;
    border-radius: 10px;
    width: 100%;
    transition: all 0.3s;
}

.btn-register:hover {
    background: #ffc107;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
}

.alert {
    border-radius: 10px;
    border: none;
}

.auth-footer {
    text-align: center;
    margin-top: 2rem;
    color: #ccc;
}

.auth-footer a {
    color: var(--primary-yellow);
    text-decoration: none;
    font-weight: 600;
}

.auth-footer a:hover {
    text-decoration: underline;
}

.password-toggle {
    position: relative;
}

.password-toggle .toggle-icon {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    color: #aaa;
}
</style>

<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card">
                    <div class="auth-header">
                        <h2><i class="bi bi-person-plus-fill"></i> Daftar Akun</h2>
                        <p>Buat akun untuk booking konser favoritmu</p>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle"></i> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle"></i> <?php echo $success; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-person"></i> Nama Lengkap
                            </label>
                            <input type="text" name="nama_lengkap" class="form-control" 
                                   placeholder="Masukkan nama lengkap" required
                                   value="<?php echo isset($_POST['nama_lengkap']) ? htmlspecialchars($_POST['nama_lengkap']) : ''; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-envelope"></i> Email
                            </label>
                            <input type="email" name="email" class="form-control" 
                                   placeholder="contoh@email.com" required
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-phone"></i> No. Telepon
                            </label>
                            <input type="tel" name="no_telepon" class="form-control" 
                                   placeholder="08xxxxxxxxxx"
                                   value="<?php echo isset($_POST['no_telepon']) ? htmlspecialchars($_POST['no_telepon']) : ''; ?>">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-lock"></i> Password
                            </label>
                            <input type="password" name="password" class="form-control" 
                                   placeholder="Minimal 6 karakter" required>
                            <small class="text-muted">Minimal 6 karakter</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">
                                <i class="bi bi-lock-fill"></i> Konfirmasi Password
                            </label>
                            <input type="password" name="confirm_password" class="form-control" 
                                   placeholder="Ulangi password" required>
                        </div>

                        <button type="submit" class="btn btn-register">
                            <i class="bi bi-check-circle"></i> Daftar Sekarang
                        </button>
                    </form>

                    <div class="auth-footer">
                        Sudah punya akun? <a href="login.php">Login di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>