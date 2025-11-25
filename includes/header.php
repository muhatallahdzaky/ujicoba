<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$is_logged_in = isset($_SESSION['user_id']);
$user_name = $is_logged_in ? $_SESSION['nama_lengkap'] : '';
$user_role = $is_logged_in ? $_SESSION['role'] : '';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ConcerFo' : 'ConcerFo - Platform Konser Terpercaya'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo BASE_URL; ?>index.php">
                <img src="<?php echo BASE_URL; ?>assets/images/logo.png" alt="ConcerFo Logo" class="logo-img" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <span class="logo-text">ConcertFo</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-none d-lg-flex mx-auto search-form" action="<?php echo BASE_URL; ?>index.php" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control search-input" name="search" placeholder="Cari konser, artis, atau venue..." aria-label="Search">
                        <button class="btn btn-search" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo BASE_URL; ?>index.php">
                            <i class="bi bi-house"></i> Beranda
                        </a>
                    </li>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- User Logged In -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>wishlist.php">
                                <i class="bi bi-heart"></i> Wishlist
                            </a>
                        </li>

                        <?php if ($_SESSION['role'] == 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/WebKonserProjek/halamanAdmin/dashboard/html/indexDashboard.php">
                                    <i class="bi bi-speedometer2"></i> Dashboard
                                </a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i>
                                <?php echo htmlspecialchars($_SESSION['nama_lengkap']); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>user/profile.php"><i class="bi bi-person"></i> Profile</a></li>
                                <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal"><i class="bi bi-box-arrow-right"></i> Keluar</a></li>
                </ul>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link btn-daftar" href="<?php echo BASE_URL; ?>auth/register.php">
                        Daftar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn-masuk" href="<?php echo BASE_URL; ?>auth/login.php">
                        Masuk
                    </a>
                </li>
            <?php endif; ?>
            </ul>

            <form class="d-lg-none mt-3 search-form-mobile" action="<?php echo BASE_URL; ?>index.php" method="GET">
                <div class="input-group">
                    <input type="text" class="form-control search-input" name="search" placeholder="Cari konser..." aria-label="Search">
                    <button class="btn btn-search" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            </div>
        </div>
    </nav>

    <!-- Logout Confirmation Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: #1a1a2e; border: 1px solid rgba(255, 193, 7, 0.3);">
                <div class="modal-header" style="border-bottom: 1px solid rgba(255, 193, 7, 0.3);">
                    <h5 class="modal-title" id="logoutModalLabel" style="color: var(--primary-yellow);">
                        <i class="bi bi-exclamation-triangle"></i> Konfirmasi Logout
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="color: #fff;">
                    <p><strong>Apakah Anda yakin ingin keluar?</strong></p>
                    <p class="mb-0">Anda harus login kembali untuk mengakses fitur wishlist dan detail konser.</p>
                </div>
                <div class="modal-footer" style="border-top: 1px solid rgba(255, 193, 7, 0.3);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Batal
                    </button>
                    <a href="<?php echo BASE_URL; ?>auth/logout.php" class="btn btn-danger">
                        <i class="bi bi-box-arrow-right"></i> Ya, Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>