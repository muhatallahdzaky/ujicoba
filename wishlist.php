<?php
session_start();
require_once 'config/database.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$page_title = "My Wishlist - ConcerFo";

// Query untuk mendapatkan konser yang di-wishlist
$query = "SELECT w.*, k.*, v.nama_venue, kt.nama_kota 
          FROM wishlist w
          INNER JOIN Konser k ON w.id_konser = k.id_konser
          LEFT JOIN Venue v ON k.id_venue = v.id_venue
          LEFT JOIN Kota kt ON v.id_kota = kt.id_kota
          WHERE w.id_user = '$user_id'
          ORDER BY w.tanggal_ditambahkan DESC";

$result = $conn->query($query);
$total_wishlist = $result->num_rows;

include 'includes/header.php';
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/wishlist-style.css">

<!-- HEADER SECTION -->
<section class="wishlist-header">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1><i class="bi bi-heart-fill"></i> My Wishlist</h1>
                <p>Konser favorit yang kamu simpan</p>
            </div>
        </div>
    </div>
</section>

<!-- WISHLIST SECTION -->
<section class="wishlist-section">
    <div class="container">
        <!-- Results Info -->
        <div class="row mb-4">
            <div class="col-12">
                <p class="text-light">
                    Total: <strong><?php echo $total_wishlist; ?></strong> konser
                </p>
            </div>
        </div>

        <!-- Wishlist Cards -->
        <div class="row g-4">
            <?php if ($total_wishlist > 0): ?>
                <?php while ($konser = $result->fetch_assoc()): ?>
                    <div class="col-md-6 col-lg-4" id="wishlist-item-<?php echo $konser['id_konser']; ?>">
                        <div class="konser-card">
                            <!-- Poster Konser -->
                            <div class="konser-poster">
                                <?php if (!empty($konser['poster_konser'])): ?>
                                    <img src="<?php echo BASE_URL . $konser['poster_konser']; ?>"
                                        alt="<?php echo htmlspecialchars($konser['nama_konser']); ?>"
                                        onerror="this.src='<?php echo BASE_URL; ?>assets/images/placeholder-poster.jpg'">
                                <?php else: ?>
                                    <div class="poster-placeholder">
                                        <i class="bi bi-music-note-beamed"></i>
                                        <p>No Poster</p>
                                    </div>
                                <?php endif; ?>

                                <!-- Remove Button -->
                                <a href="wishlistAction.php?action=remove&id_konser=<?php echo $konser['id_konser']; ?>"
                                    class="remove-wishlist-btn"
                                    onclick="return confirm('Hapus dari wishlist?')">
                                    <i class="bi bi-x-lg"></i>
                                </a>

                                <!-- Status Badge -->
                                <?php if ($konser['status_konser'] == 'upcoming'): ?>
                                    <span class="status-badge upcoming">Upcoming</span>
                                <?php elseif ($konser['status_konser'] == 'ongoing'): ?>
                                    <span class="status-badge ongoing">Ongoing</span>
                                <?php elseif ($konser['status_konser'] == 'completed'): ?>
                                    <span class="status-badge completed">Completed</span>
                                <?php endif; ?>
                            </div>

                            <!-- Konser Info -->
                            <div class="konser-body">
                                <span class="added-date">
                                    <i class="bi bi-clock"></i>
                                    Ditambahkan <?php echo format_tanggal($konser['tanggal_ditambahkan']); ?>
                                </span>

                                <h5 class="konser-title">
                                    <?php echo htmlspecialchars($konser['nama_konser']); ?>
                                </h5>

                                <!-- Tanggal -->
                                <div class="konser-meta">
                                    <i class="bi bi-calendar-event"></i>
                                    <span>
                                        <?php
                                        if ($konser['tanggal_mulai']) {
                                            echo format_tanggal($konser['tanggal_mulai']);
                                        } else {
                                            echo "TBA";
                                        }
                                        ?>
                                    </span>
                                </div>

                                <!-- Venue -->
                                <div class="konser-meta">
                                    <i class="bi bi-geo-alt"></i>
                                    <span>
                                        <?php echo $konser['nama_venue'] ? htmlspecialchars($konser['nama_venue']) : 'TBA'; ?>
                                        <?php if ($konser['nama_kota']): ?>
                                            , <?php echo htmlspecialchars($konser['nama_kota']); ?>
                                        <?php endif; ?>
                                    </span>
                                </div>

                                <!-- Harga -->
                                <?php if ($konser['harga_tiket_mulai']): ?>
                                    <div class="konser-price">
                                        <span class="price-label">Mulai dari</span>
                                        <span class="price-value">
                                            <?php echo format_rupiah($konser['harga_tiket_mulai']); ?>
                                        </span>
                                    </div>
                                <?php elseif ($konser['harga_tiket_mulai'] == 0): ?>
                                    <div class="konser-price">
                                        <span class="price-value text-warning">Free Entry</span>
                                    </div>
                                <?php else: ?>
                                    <div class="konser-price">
                                        <span class="price-value text-warning">Harga TBA</span>
                                    </div>
                                <?php endif; ?>

                                <!-- Button -->
                                <a href="detailKonser.php?id=<?php echo $konser['id_konser']; ?>"
                                    class="btn btn-detail w-100">
                                    <i class="bi bi-info-circle"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <!-- Empty Wishlist -->
                <div class="col-12">
                    <div class="empty-wishlist">
                        <i class="bi bi-heart"></i>
                        <h3>Wishlist Kosong</h3>
                        <p>Belum ada konser yang kamu simpan. Mulai tambahkan konser favoritmu!</p>
                        <a href="index.php" class="btn btn-primary">
                            <i class="bi bi-search"></i> Jelajahi Konser
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>


<?php include 'includes/footer.php'; ?>