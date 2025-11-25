<?php
$current_page = basename($_SERVER['PHP_SELF']);
$directoryURI = $_SERVER['REQUEST_URI'];

$path = "../"; // Mundur satu langkah dulu

// Fungsi cek aktif
function isActive($searchString)
{
    global $directoryURI;
    if (strpos($directoryURI, $searchString) !== false) {
        return 'active';
    }
    return '';
}
?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<div class="sidebar bg-dark-sidebar">
    <ul class="nav flex-column">

        <li class="nav-item">
            <a class="nav-link <?php echo ($current_page == 'indexDashboard.php') ? 'active' : ''; ?>" href="<?php echo $path; ?>folderDH/indexDashboard.php">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/user/'); ?>" href="<?php echo $path; ?>user/manajemenUsers.php">
                <i class="bi bi-people-fill me-2"></i>
                Manajemen Users
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/artis/'); ?>" href="<?php echo $path; ?>artis/manajemenArtis.php">
                <i class="bi bi-mic-fill me-2"></i>
                Manajemen Artis
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/konser/'); ?>" href="<?php echo $path; ?>konser/manajemenKonser.php">
                <i class="bi bi-ticket-perforated-fill me-2"></i>
                Manajemen Konser
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/venue/'); ?>" href="<?php echo $path; ?>venue/manajemenVenue.php">
                <i class="bi bi-geo-alt-fill me-2"></i>
                Manajemen Venue
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/kota/'); ?>" href="<?php echo $path; ?>kota/manajemenKota.php">
                <i class="bi bi-building me-2"></i>
                Manajemen Kota
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/provinsi/'); ?>" href="<?php echo $path; ?>provinsi/manajemenProvinsi.php">
                <i class="bi bi-map-fill me-2"></i>
                Manajemen Provinsi
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/lineup/'); ?>" href="<?php echo $path; ?>lineup/manajemenLineUp.php">
                <i class="bi bi-music-note-list me-2"></i>
                Manajemen LineUp
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/wishlist/'); ?>" href="<?php echo $path; ?>wishlist/manajemenWishlist.php">
                <i class="bi bi-heart-fill me-2"></i>
                Manajemen WishList
            </a>
        </li>

        <li class="nav-item mt-3 border-top border-secondary pt-2">
            <a class="nav-link text-danger" href="<?php echo $path; ?>logout.php">
                <i class="bi bi-box-arrow-right me-2"></i>
                Logout
            </a>
        </li>

    </ul>
</div>