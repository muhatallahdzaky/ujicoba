<?php
session_start();
require_once '../config/database.php';

// Redirect jika sudah login
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = clean_input($_POST['email']);
    $password = clean_input($_POST['password']);
    $remember = isset($_POST['remember']) ? true : false;

    if (empty($email) || empty($password)) {
        $error = "Email dan password wajib diisi!";
    } else {
        // Query cek user
        $query = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Cek status akun
            if ($user['status_akun'] !== 'active') {
                $error = "Akun Anda tidak aktif. Hubungi admin.";
            } else {
                // Set session
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                // Remember Me - Set Cookie untuk 30 hari
                if ($remember) {
                    $cookie_value = base64_encode($user['id_user'] . ':' . $user['email']);
                    setcookie('remember_user', $cookie_value, time() + (30 * 24 * 60 * 60), '/');
                }

                // Redirect berdasarkan role
                if ($user['role'] == 'admin') {
                    header("Location: ../index.php");
                } else {
                    header("Location: ../index.php");
                }
                exit();
            }
        } else {
            $error = "Email atau password salah!";
        }
    }
}

$page_title = "Login - ConcerFo";
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

    .btn-login {
        background: var(--primary-yellow);
        color: var(--primary-dark);
        border: none;
        padding: 0.75rem;
        font-weight: 600;
        border-radius: 10px;
        width: 100%;
        transition: all 0.3s;
    }

    .btn-login:hover {
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

    .form-check-input {
        background-color: rgba(255, 255, 255, 0.1);
        border-color: rgba(255, 255, 255, 0.3);
    }

    .form-check-input:checked {
        background-color: var(--primary-yellow);
        border-color: var(--primary-yellow);
    }

    .form-check-label {
        color: #ccc;
    }

    .demo-accounts {
        background: rgba(255, 193, 7, 0.1);
        border: 1px solid rgba(255, 193, 7, 0.3);
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .demo-accounts h6 {
        color: var(--primary-yellow);
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .demo-accounts p {
        color: #ccc;
        font-size: 0.85rem;
        margin: 0;
    }
</style>

<div class="auth-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card">
                    <div class="auth-header">
                        <h2><i class="bi bi-box-arrow-in-right"></i> Login</h2>
                        <p>Masuk ke akun Anda</p>
                    </div>

                    <!-- Demo Accounts Info -->
                    <div class="demo-accounts">
                        <h6><i class="bi bi-info-circle"></i> Demo Accounts:</h6>
                        <p><strong>Admin:</strong> adminfo1@gmail.com / adminFo123</p>
                        <p><strong>User:</strong> puan@gmail.com / dprturu</p>
                    </div>

                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle"></i> <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
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
                                <i class="bi bi-lock"></i> Password
                            </label>
                            <input type="password" name="password" class="form-control"
                                placeholder="Masukkan password" required>
                        </div>

                        <div class="mb-4 form-check">
                            <input type="checkbox" name="remember" class="form-check-input" id="rememberMe" value="1">
                            <label class="form-check-label" for="rememberMe">
                                Ingat saya (30 hari)
                            </label>
                        </div>

                        <button type="submit" class="btn btn-login">
                            <i class="bi bi-box-arrow-in-right"></i> Login
                        </button>
                    </form>

                    <div class="auth-footer">
                        Belum punya akun? <a href="register.php">Daftar di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>