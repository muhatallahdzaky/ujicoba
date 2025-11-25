<?php
session_start();
require_once 'config/database.php';
$page_title = "Beranda - Temukan Konser Favoritmu";
include 'includes/header.php';

$search = isset($_GET['search']) ? clean_input($_GET['search']) : '';
$filter_kota = isset($_GET['kota']) ? clean_input($_GET['kota']) : '';
$sort = isset($_GET['sort']) ? clean_input($_GET['sort']) : 'tanggal_asc';

$query = "SELECT k.*, v.nama_venue, v.id_kota, kt.nama_kota 
          FROM Konser k
          LEFT JOIN Venue v ON k.id_venue = v.id_venue
          LEFT JOIN Kota kt ON v.id_kota = kt.id_kota
          WHERE 1=1";

// Search filter
if (!empty($search)) {
    $query .= " AND (k.nama_konser LIKE '%$search%' 
                     OR v.nama_venue LIKE '%$search%' 
                     OR kt.nama_kota LIKE '%$search%'
                     OR EXISTS (
                         SELECT 1 FROM lineup l
                         JOIN artis a ON l.id_artis = a.id_artis
                         WHERE l.id_konser = k.id_konser 
                         AND a.nama_artis LIKE '%$search%'
                     ))";
}

// Filter Kota 
if (!empty($filter_kota)) {
    $query .= " AND kt.id_kota = '$filter_kota'";
}

// Sorting
// Sorting
switch ($sort) {
    case 'tanggal_asc':
        $query .= " ORDER BY 
                    CASE 
                        WHEN k.status_konser = 'upcoming' THEN 1
                        WHEN k.status_konser = 'ongoing' THEN 2
                        WHEN k.status_konser = 'completed' THEN 3
                        ELSE 4
                    END,
                    k.tanggal_mulai ASC";
        break;
    case 'tanggal_desc':
        $query .= " ORDER BY 
                    CASE 
                        WHEN k.status_konser = 'upcoming' THEN 1
                        WHEN k.status_konser = 'ongoing' THEN 2
                        WHEN k.status_konser = 'completed' THEN 3
                        ELSE 4
                    END,
                    k.tanggal_mulai DESC";
        break;
    case 'harga_asc':
        $query .= " ORDER BY k.harga_tiket_mulai ASC";
        break;
    case 'harga_desc':
        $query .= " ORDER BY k.harga_tiket_mulai DESC";
        break;
    default:
        $query .= " ORDER BY 
                    CASE 
                        WHEN k.status_konser = 'upcoming' THEN 1
                        WHEN k.status_konser = 'ongoing' THEN 2
                        WHEN k.status_konser = 'completed' THEN 3
                        ELSE 4
                    END,
                    k.tanggal_mulai ASC";
}
$result = $conn->query($query);

// Query untuk dropdown kota
$query_kota = "SELECT DISTINCT kt.id_kota, kt.nama_kota 
               FROM Kota kt 
               INNER JOIN Venue v ON kt.id_kota = v.id_kota
               INNER JOIN Konser k ON v.id_venue = k.id_venue
               ORDER BY kt.nama_kota ASC";
$result_kota = $conn->query($query_kota);

// Hitung total konser
$total_konser = $result->num_rows;
?>

<!-- HERO SECTION -->

<?php
// Notifikasi akun berhasil dihapus
if (isset($_GET['deleted']) && $_GET['deleted'] == 'success'):
?>
    <div class="container mt-5 pt-5">
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> <strong>Akun berhasil dihapus!</strong> Terima kasih telah menggunakan ConcerTix.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>

<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="hero-title animate-fade-in">
                    🎤 Temukan Konser <span class="highlight">Favoritmu</span>! 🎸
                </h1>
                <p class="hero-subtitle">
                    Platform informasi konser di Indonesia. <br>
                    Jelajahi konser dari artis favoritmu sekarang!
                </p>

                <!-- Search Bar -->
                <form action="index.php" method="GET" class="search-form-hero mt-4">
                    <div class="input-group input-group-lg">
                        <input type="text" class="form-control search-input-hero"
                            name="search"
                            placeholder="Cari konser, artis, atau venue..."
                            value="<?php echo htmlspecialchars($search); ?>">
                        <button class="btn btn-search-hero" type="submit">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- FILTER SECTION -->
<section class="filter-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="filter-card">
                    <form action="index.php" method="GET" class="row g-3 align-items-center">
                        <input type="hidden" name="search" value="<?php echo htmlspecialchars($search); ?>">

                        <!-- Filter by Kota -->
                        <div class="col-md-4">
                            <label class="form-label"><i class="bi bi-geo-alt"></i> Kota</label>
                            <select name="kota" class="form-select" onchange="this.form.submit()">
                                <option value="">Semua Kota</option>
                                <?php while ($kota = $result_kota->fetch_assoc()): ?>
                                    <option value="<?php echo $kota['id_kota']; ?>"
                                        <?php echo ($filter_kota == $kota['id_kota']) ? 'selected' : ''; ?>>
                                        <?php echo $kota['nama_kota']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- Sort By -->
                        <div class="col-md-4">
                            <label class="form-label"><i class="bi bi-sort-down"></i> Urutkan</label>
                            <select name="sort" class="form-select" onchange="this.form.submit()">
                                <option value="tanggal_asc" <?php echo ($sort == 'tanggal_asc') ? 'selected' : ''; ?>>
                                    Tanggal (Terdekat)
                                </option>
                                <option value="tanggal_desc" <?php echo ($sort == 'tanggal_desc') ? 'selected' : ''; ?>>
                                    Tanggal (Terjauh)
                                </option>
                                <option value="harga_asc" <?php echo ($sort == 'harga_asc') ? 'selected' : ''; ?>>
                                    Harga (Termurah)
                                </option>
                                <option value="harga_desc" <?php echo ($sort == 'harga_desc') ? 'selected' : ''; ?>>
                                    Harga (Termahal)
                                </option>
                            </select>
                        </div>

                        <!-- Reset Button -->
                        <div class="col-md-4">
                            <label class="form-label d-none d-md-block">&nbsp;</label>
                            <a href="index.php" class="btn btn-outline-light w-100">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset Filter
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- KONSER LIST SECTION -->
<section class="konser-list-section">
    <div class="container">
        <!-- Results Info -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="section-title">
                    <?php if (!empty($search)): ?>
                        Hasil Pencarian: "<?php echo htmlspecialchars($search); ?>"
                    <?php else: ?>
                        Konser Yang Tersedia
                    <?php endif; ?>
                </h2>
                <p class="text-light">Ditemukan <strong><?php echo $total_konser; ?></strong> konser</p>
            </div>
        </div>

        <!-- UPCOMING & ONGOING CONCERTS -->
        <?php
        // Filter konser yang upcoming atau ongoing
        $upcoming_konser = [];
        $completed_konser = [];

        // Reset pointer result
        $result->data_seek(0);

        while ($konser = $result->fetch_assoc()) {
            if ($konser['status_konser'] == 'upcoming' || $konser['status_konser'] == 'ongoing') {
                $upcoming_konser[] = $konser;
            } else {
                $completed_konser[] = $konser;
            }
        }
        ?>

        <?php if (count($upcoming_konser) > 0): ?>
            <div class="row mb-3">
                <div class="col-12">
                    <h3 class="text-light mb-3">
                        <i class="bi bi-calendar-event"></i> Upcoming & Ongoing
                    </h3>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <?php foreach ($upcoming_konser as $konser): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="konser-card">
                            <!-- Poster Konser -->
                            <div class="konser-poster">
                                <?php
                                // Cek wishlist
                                $is_wishlisted = false;
                                if (isset($_SESSION['user_id'])) {
                                    $check = $conn->query("SELECT * FROM wishlist WHERE id_user = '{$_SESSION['user_id']}' AND id_konser = '{$konser['id_konser']}'");
                                    $is_wishlisted = ($check->num_rows > 0);
                                }
                                ?>

                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="wishlistAction.php?action=<?php echo $is_wishlisted ? 'remove' : 'add'; ?>&id_konser=<?php echo $konser['id_konser']; ?>"
                                        class="wishlist-btn">
                                        <i class="bi <?php echo $is_wishlisted ? 'bi-heart-fill' : 'bi-heart'; ?>"></i>
                                    </a>
                                <?php else: ?>
                                    <a href="auth/login.php" class="wishlist-btn" title="Login untuk wishlist">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                <?php endif; ?>

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

                                <!-- Status Badge -->
                                <?php if ($konser['status_konser'] == 'upcoming'): ?>
                                    <span class="status-badge upcoming">Upcoming</span>
                                <?php elseif ($konser['status_konser'] == 'ongoing'): ?>
                                    <span class="status-badge ongoing">Ongoing</span>
                                <?php endif; ?>
                            </div>

                            <!-- Konser Info -->
                            <div class="konser-body">
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
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- COMPLETED CONCERTS -->
        <?php if (count($completed_konser) > 0): ?>
            <div class="row mb-3">
                <div class="col-12">
                    <h3 class="text-light mb-3">
                        <i class="bi bi-check-circle"></i> Completed
                    </h3>
                </div>
            </div>

            <div class="row g-4">
                <?php foreach ($completed_konser as $konser): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="konser-card" style="opacity: 0.8;">
                            <!-- Poster Konser -->
                            <div class="konser-poster">
                                <?php
                                // Cek wishlist
                                $is_wishlisted = false;
                                if (isset($_SESSION['user_id'])) {
                                    $check = $conn->query("SELECT * FROM wishlist WHERE id_user = '{$_SESSION['user_id']}' AND id_konser = '{$konser['id_konser']}'");
                                    $is_wishlisted = ($check->num_rows > 0);
                                }
                                ?>

                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <a href="wishlistAction.php?action=<?php echo $is_wishlisted ? 'remove' : 'add'; ?>&id_konser=<?php echo $konser['id_konser']; ?>"
                                        class="wishlist-btn">
                                        <i class="bi <?php echo $is_wishlisted ? 'bi-heart-fill' : 'bi-heart'; ?>"></i>
                                    </a>
                                <?php else: ?>
                                    <a href="auth/login.php" class="wishlist-btn" title="Login untuk wishlist">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                <?php endif; ?>
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

                                <!-- Status Badge -->
                                <span class="status-badge completed">Completed</span>
                            </div>

                            <!-- Konser Info -->
                            <div class="konser-body">
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
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- No Results -->
        <?php if ($total_konser == 0): ?>
            <div class="row">
                <div class="col-12">
                    <div class="no-results">
                        <i class="bi bi-search"></i>
                        <h3>Tidak Ada Konser Ditemukan</h3>
                        <p>Coba ubah filter atau kata kunci pencarian</p>
                        <a href="index.php" class="btn btn-warning mt-3">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset Pencarian
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ========================================
     STATISTICS SECTION (Optional)
     ======================================== -->
<section class="stats-section">
    <div class="container">
        <div class="row text-center">
            <?php
            // Query statistik
            $stats_konser = $conn->query("SELECT COUNT(*) as total FROM Konser")->fetch_assoc()['total'];
            $stats_artis = $conn->query("SELECT COUNT(*) as total FROM Artis")->fetch_assoc()['total'];
            $stats_kota = $conn->query("SELECT COUNT(*) as total FROM Kota")->fetch_assoc()['total'];
            ?>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="bi bi-calendar-event"></i>
                    <h3><?php echo $stats_konser; ?></h3>
                    <p>Konser Tersedia</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="bi bi-music-note-list"></i>
                    <h3><?php echo $stats_artis; ?></h3>
                    <p>Artis & Band</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <i class="bi bi-geo-alt"></i>
                    <h3><?php echo $stats_kota; ?></h3>
                    <p>Kota</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$conn->close();
include 'includes/footer.php';
?>