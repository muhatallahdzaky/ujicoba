<?php
session_start();
require_once '../config/database.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$page_title = "Profile Saya - ConcerFo";

// Ambil data user
$query_user = "SELECT * FROM users WHERE id_user = '$user_id'";
$result_user = $conn->query($query_user);
$user = $result_user->fetch_assoc();

// Hitung total wishlist
$query_wishlist = "SELECT COUNT(*) as total FROM wishlist WHERE id_user = '$user_id'";
$total_wishlist = $conn->query($query_wishlist)->fetch_assoc()['total'];

// Handle Update Profile
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updateProfile'])) {
    $nama_lengkap = clean_input($_POST['nama_lengkap']);
    $email = clean_input($_POST['email']);
    $no_telepon = clean_input($_POST['no_telepon']);
    $password_lama = isset($_POST['password_lama']) ? clean_input($_POST['password_lama']) : '';
    $password_baru = isset($_POST['password_baru']) ? clean_input($_POST['password_baru']) : '';
    $konfirmasi_password = isset($_POST['konfirmasi_password']) ? clean_input($_POST['konfirmasi_password']) : '';

    // Validasi
    if (empty($nama_lengkap) || empty($email)) {
        $error = "Nama dan email wajib diisi!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid!";
    } else {
        // Cek email sudah dipakai user lain
        $check_email = $conn->query("SELECT id_user FROM users WHERE email = '$email' AND id_user != '$user_id'");
        if ($check_email->num_rows > 0) {
            $error = "Email sudah digunakan user lain!";
        } else {
            // Update tanpa password
            if (empty($password_baru)) {
                $update = "UPDATE users SET nama_lengkap = '$nama_lengkap', email = '$email', no_telepon = '$no_telepon' WHERE id_user = '$user_id'";
                
                if ($conn->query($update)) {
                    $_SESSION['nama_lengkap'] = $nama_lengkap;
                    $_SESSION['email'] = $email;
                    $success = "Profile berhasil diperbarui!";
                    // Refresh data
                    $result_user = $conn->query($query_user);
                    $user = $result_user->fetch_assoc();
                } else {
                    $error = "Gagal memperbarui profile!";
                }
            } 
            // Update dengan password
            else {
                if (empty($password_lama)) {
                    $error = "Masukkan password lama untuk mengubah password!";
                } elseif ($password_lama !== $user['password']) {
                    $error = "Password lama salah!";
                } elseif (strlen($password_baru) < 6) {
                    $error = "Password baru minimal 6 karakter!";
                } elseif ($password_baru !== $konfirmasi_password) {
                    $error = "Password baru dan konfirmasi tidak cocok!";
                } else {
                    $update = "UPDATE users SET nama_lengkap = '$nama_lengkap', email = '$email', no_telepon = '$no_telepon', password = '$password_baru' WHERE id_user = '$user_id'";
                    
                    if ($conn->query($update)) {
                        $_SESSION['nama_lengkap'] = $nama_lengkap;
                        $_SESSION['email'] = $email;
                        $success = "Profile dan password berhasil diperbarui!";
                        // Refresh data
                        $result_user = $conn->query($query_user);
                        $user = $result_user->fetch_assoc();
                    } else {
                        $error = "Gagal memperbarui profile!";
                    }
                }
            }
        }
    }
}

include '../includes/header.php';
?>

<style>
.profile-header {
    background: linear-gradient(#090040 0%, #471396 100%);
    padding: 120px 0 60px;
}

.profile-header h1 {
    color: var(--primary-yellow);
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.profile-section {
    padding: 60px 0;
    background: var(--primary-dark);
    min-height: 60vh;
}

.profile-card {
    background: var(--primary-purple);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.1);
    margin-bottom: 2rem;
}

.profile-card h5 {
    color: var(--primary-yellow);
    margin-bottom: 1.5rem;
    font-weight: 600;
}

.stat-box {
    background: var(--primary-purple);
    border: 1px solid rgba(255, 193, 7, 0.3);
    border-radius: 15px;
    padding: 1.5rem;
    text-align: center;
}

.stat-box i {
    font-size: 2.5rem;
    color: var(--primary-yellow);
    margin-bottom: 0.5rem;
}

.stat-box h3 {
    color: var(--primary-yellow);
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.stat-box p {
    color: #ccc;
    margin: 0;
}

.form-label {
    color: #fff;
    font-weight: 500;
    margin-bottom: 0.5rem;
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

.form-control:disabled {
    background: rgba(255, 255, 255, 0.05);
    color: #888;
}

.btn-update {
    background: var(--primary-yellow);
    color: var(--primary-dark);
    border: none;
    padding: 0.75rem 2rem;
    font-weight: 600;
    border-radius: 10px;
    transition: all 0.3s;
}

.btn-update:hover {
    background: #ffc107;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
}

.danger-zone {
    background: rgba(220, 53, 69, 0.1);
    border: 1px solid rgba(220, 53, 69, 0.3);
    border-radius: 20px;
    padding: 2rem;
}

.danger-zone h5 {
    color: #dc3545;
}

.alert {
    border-radius: 10px;
    border: none;
}

.divider {
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    margin: 2rem 0;
}
</style>

<!-- HEADER SECTION -->
<section class="profile-header">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1><i class="bi bi-person-circle"></i> Profile Saya</h1>
                <p style="color: #ccc;">Kelola informasi akun Anda</p>
            </div>
        </div>
    </div>
</section>

<!-- PROFILE SECTION -->
<section class="profile-section">
    <div class="container">
        <div class="row">
            <!-- STATS -->
            <div class="col-md-4 mb-4">
                <div class="stat-box">
                    <i class="bi bi-heart-fill"></i>
                    <h3><?php echo $total_wishlist; ?></h3>
                    <p>Konser di Wishlist</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="stat-box">
                    <i class="bi bi-calendar-check"></i>
                    <h3><?php echo date('d M Y', strtotime($user['tanggal_daftar'])); ?></h3>
                    <p>Bergabung Sejak</p>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="stat-box">
                    <i class="bi bi-shield-check"></i>
                    <h3><?php echo ucfirst($user['status_akun']); ?></h3>
                    <p>Status Akun</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- ALERTS -->
                <?php if ($success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> <?php echo $success; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-circle"></i> <?php echo $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- PROFILE FORM -->
                <div class="profile-card">
                    <h5><i class="bi bi-person-circle"></i> Informasi Akun</h5>
                    
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" 
                                       value="<?php echo htmlspecialchars($user['nama_lengkap']); ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" 
                                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. Telepon</label>
                                <input type="tel" name="no_telepon" class="form-control" 
                                       value="<?php echo htmlspecialchars($user['no_telepon']); ?>" 
                                       placeholder="08xxxxxxxxxx">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Role</label>
                                <input type="text" class="form-control" 
                                       value="<?php echo ucfirst($user['role']); ?>" disabled>
                            </div>
                        </div>

                        <div class="divider"></div>

                        <h5><i class="bi bi-key"></i> Ubah Password</h5>
                        <p>Kosongkan jika tidak ingin mengubah password</p>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Password Lama</label>
                                <input type="password" name="password_lama" class="form-control" 
                                       placeholder="Masukkan password lama">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password_baru" class="form-control" 
                                       placeholder="Minimal 6 karakter">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="konfirmasi_password" class="form-control" 
                                       placeholder="Ulangi password baru">
                            </div>
                        </div>

                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" name="updateProfile" class="btn btn-update">
                                <i class="bi bi-check-circle"></i> Simpan Perubahan
                            </button>
                            <a href="../index.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>

                <!-- DANGER ZONE -->
                <div class="danger-zone">
                    <h5><i class="bi bi-exclamation-triangle"></i> Danger Zone</h5>
                    <p class="mb-3">Setelah akun dihapus, semua data wishlist Anda akan ikut terhapus dan tidak dapat dikembalikan.</p>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        <i class="bi bi-trash"></i> Hapus Akun
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DELETE ACCOUNT MODAL -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: #1a1a2e; border: 1px solid rgba(220, 53, 69, 0.3);">
            <div class="modal-header" style="border-bottom: 1px solid rgba(220, 53, 69, 0.3);">
                <h5 class="modal-title text-danger" id="deleteAccountLabel">
                    <i class="bi bi-exclamation-triangle"></i> Konfirmasi Hapus Akun
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="color: #fff;">
                <p><strong>Apakah Anda yakin ingin menghapus akun ini?</strong></p>
                <p class="text-danger mb-0">
                    <i class="bi bi-exclamation-circle"></i> Peringatan: Tindakan ini tidak dapat dibatalkan! 
                    Semua data wishlist Anda akan ikut terhapus.
                </p>
            </div>
            <div class="modal-footer" style="border-top: 1px solid rgba(220, 53, 69, 0.3);">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle"></i> Batal
                </button>
                <a href="delete_account.php" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Ya, Hapus Akun Saya
                </a>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>