<?php
$current_page = basename($_SERVER['PHP_SELF']);
$directoryURI = $_SERVER['REQUEST_URI'];

// Function untuk cek active menu
function isActive($segment) {
    return (strpos($_SERVER['REQUEST_URI'], $segment) !== false) ? 'active' : '';
}

// Tentukan base path
if ($current_page == 'indexDashboardAdmin.php') {
    $path = "./"; // Dari dashboard
} else {
    $path = "../"; // Dari halaman lain
}
?>

<div class="sidebar bg-dark-sidebar">
    <ul class="nav flex-column">

        <li class="nav-item">
            <a class="nav-link <?php echo ($current_page == 'indexDashboardAdmin.php') ? 'active' : ''; ?>" href="<?php echo $path; ?>indexDashboardAdmin.php">
                <i class="bi bi-speedometer2 me-2"></i>
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/user/'); ?>" href="<?php echo $path; ?>management/user/manajemenUsers.php">
                <i class="bi bi-people-fill me-2"></i>
                Management Users
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/artis/'); ?>" href="<?php echo $path; ?>management/artis/manajemenArtis.php">
                <i class="bi bi-mic-fill me-2"></i>
                Management Artis
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/konser/'); ?>" href="<?php echo $path; ?>management/konser/manajemenKonser.php">
                <i class="bi bi-ticket-perforated-fill me-2"></i>
                Management Konser
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/venue/'); ?>" href="<?php echo $path; ?>venue/manajemenVenue.php">
                <i class="bi bi-geo-alt-fill me-2"></i>
                Management Venue
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/kota/'); ?>" href="<?php echo $path; ?>management/kota/manajemenKota.php">
                <i class="bi bi-building me-2"></i>
                Management Kota
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/provinsi/'); ?>" href="<?php echo $path; ?>management/provinsi/manajemenProvinsi.php">
                <i class="bi bi-map-fill me-2"></i>
                Management Provinsi
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/lineup/'); ?>" href="<?php echo $path; ?>management/lineup/manajemenLineup.php">
                <i class="bi bi-music-note-list me-2"></i>
                Management LineUp
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/setlist/'); ?>" href="<?php echo $path; ?>management/setlist/manajemenSetlist.php">
                <i class="bi bi-list-ol me-2"></i>
                Management Setlist
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link <?php echo isActive('/wishlist/'); ?>" href="<?php echo $path; ?>wishlist/manajemenWishlist.php">
                <i class="bi bi-heart-fill me-2"></i>
                Management WishList
            </a>
        </li>

    </ul>
</div>