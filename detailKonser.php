<?php
session_start();
require_once 'config/database.php';

$is_logged_in = isset($_SESSION['id_user']) && !empty($_SESSION['id_user']);
$user_id = $is_logged_in ? $_SESSION['id_user'] : null;
$user_name = $is_logged_in ? $_SESSION['nama_lengkap'] : null;

$id_konser = isset($_GET['id']) ? $_GET['id'] : '';

if (empty($id_konser)) {
    header("Location: index.php");
    exit();
}

$query_konser = "SELECT k.*, v.nama_venue, v.alamat_lengkap, v.kapasitas, v.url_website,
                 kt.nama_kota, p.nama_provinsi
                 FROM konser k
                 JOIN venue v ON k.id_venue = v.id_venue
                 JOIN kota kt ON v.id_kota = kt.id_kota
                 JOIN provinsi p ON kt.id_provinsi = p.id_provinsi
                 WHERE k.id_konser = ?";

$stmt = mysqli_prepare($conn, $query_konser);
mysqli_stmt_bind_param($stmt, "s", $id_konser);
mysqli_stmt_execute($stmt);
$result_konser = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result_konser) == 0) {
    echo "Konser tidak ditemukan";
    exit();
}
$konser = mysqli_fetch_assoc($result_konser);

$query_lineup = "SELECT a.* 
                 FROM lineup l
                 JOIN artis a ON l.id_artis = a.id_artis
                 WHERE l.id_konser = ?
                 ORDER BY l.id_lineup";

$stmt_lineup = mysqli_prepare($conn, $query_lineup);
mysqli_stmt_bind_param($stmt_lineup, "s", $id_konser);
mysqli_stmt_execute($stmt_lineup);
$result_lineup = mysqli_stmt_get_result($stmt_lineup);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($konser['nama_konser']) ?> - Detail Konser</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/detail-style.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/wishlist.css">
</head>

<body>
    <?php include 'includes/header.php'; ?>

    <!-- CONCERT HEADER -->
    <div class="concert-header">
        <div class="container">
            <a href="index.php" class="back-button">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
            <h1 class="hero-title animate-fade-in"><?= htmlspecialchars($konser['nama_konser']) ?></h1>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <!-- LEFT COLUMN: POSTER -->
            <div class="col-lg-4 mb-4">
                <div class="poster-section">
                    <?php
                    // Cek wishlist
                    $is_wishlisted = false;
                    if (isset($_SESSION['user_id'])) {
                        $check = $conn->query("SELECT * FROM wishlist WHERE id_user = '{$_SESSION['user_id']}' AND id_konser = '$id_konser'");
                        $is_wishlisted = ($check->num_rows > 0);
                    }
                    ?>

                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="wishlistAction.php?action=<?php echo $is_wishlisted ? 'remove' : 'add'; ?>&id_konser=<?php echo $id_konser; ?>"
                            class="wishlist-btn" style="position: absolute; top: 10px; left: 10px;">
                            <i class="bi <?php echo $is_wishlisted ? 'bi-heart-fill' : 'bi-heart'; ?>"></i>
                        </a>
                    <?php else: ?>
                        <a href="auth/login.php" class="wishlist-btn" style="position: absolute; top: 10px; left: 10px;" title="Login untuk wishlist">
                            <i class="bi bi-heart"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (!empty($konser['poster_konser'])): ?>
                        <img src="<?= htmlspecialchars($konser['poster_konser']) ?>"
                            alt="<?= htmlspecialchars($konser['nama_konser']) ?>"
                            class="poster-img">
                    <?php else: ?>
                        <img src="assets/uploads/posters/default.png"
                            alt="No poster"
                            class="poster-img">
                    <?php endif; ?>
                </div>
            </div>

            <!-- RIGHT COLUMN: INFO -->
            <div class="col-lg-8">
                <!-- INFO SECTION -->
                <div class="info-section">
                    <div class="info-item">
                        <i class="fas fa-calendar-alt"></i>
                        <div>
                            <div class="info-label">Tanggal</div>
                            <div class="info-value">
                                <?php
                                $tanggal_mulai = format_tanggal($konser['tanggal_mulai']);
                                $tanggal_selesai = format_tanggal($konser['tanggal_selesai']);

                                if ($tanggal_mulai == $tanggal_selesai) {
                                    echo $tanggal_mulai;
                                } else {
                                    echo $tanggal_mulai . ' - ' . $tanggal_selesai;
                                }
                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <div class="info-label">Venue</div>
                            <div class="info-value">
                                <strong><?= htmlspecialchars($konser['nama_venue']) ?></strong><br>
                                <?= htmlspecialchars($konser['alamat_lengkap']) ?><br>
                                <?= htmlspecialchars($konser['nama_kota']) ?>, <?= htmlspecialchars($konser['nama_provinsi']) ?>
                                <?php if ($konser['kapasitas']): ?>
                                    <br><small class="text-muted">Kapasitas: <?= number_format($konser['kapasitas']) ?> orang</small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-ticket-alt"></i>
                        <div>
                            <div class="info-label">Harga Tiket</div>
                            <div class="info-value">
                                <?php if ($konser['harga_tiket_mulai'] > 0): ?>
                                    <strong>Mulai dari <?= format_rupiah($konser['harga_tiket_mulai']) ?></strong>
                                <?php else: ?>
                                    <strong class="text-success">GRATIS</strong>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-info-circle"></i>
                        <div>
                            <div class="info-label">Status</div>
                            <div class="info-value">
                                <?php
                                $badge_class = '';
                                $status_text = '';

                                switch ($konser['status_konser']) {
                                    case 'upcoming':
                                        $badge_class = 'status-upcoming';
                                        $status_text = 'Upcoming/Akan Datang';
                                        break;
                                    case 'ongoing':
                                        $badge_class = 'status-ongoing';
                                        $status_text = 'Ongoing/Sedang Berlangsung';
                                        break;
                                    case 'completed':
                                        $badge_class = 'status-completed';
                                        $status_text = 'Completed/Selesai';
                                        break;
                                    case 'cancelled':
                                        $badge_class = 'status-cancelled';
                                        $status_text = 'Cancelled/Dibatalkan';
                                        break;
                                    default:
                                        $badge_class = 'bg-secondary';
                                        $status_text = 'Tidak Diketahui';
                                }
                                ?>
                                <span class="badge <?= $badge_class ?> px-3 py-2 fs-6">
                                    <?= $status_text ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($konser['url_website'])): ?>
                        <div class="info-item">
                            <i class="fas fa-globe"></i>
                            <div>
                                <div class="info-label">Website Venue</div>
                                <div class="info-value">
                                    <a href="<?= htmlspecialchars($konser['url_website']) ?>" target="_blank" class="text-primary">
                                        <?= htmlspecialchars($konser['url_website']) ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- LINEUP SECTION -->
        <div class="lineup-section">
            <h2><i class="fas fa-microphone-alt"></i> Line Up Artis</h2>

            <?php if (mysqli_num_rows($result_lineup) > 0): ?>
                <div class="row">
                    <?php
                    mysqli_data_seek($result_lineup, 0);
                    while ($artist = mysqli_fetch_assoc($result_lineup)): ?>
                        <div class="col-md-4 col-sm-6 mb-4">
                            <div class="artist-card">
                                <?php if (!empty($artist['gambar_artis'])): ?>
                                    <img src="<?= htmlspecialchars($artist['gambar_artis']) ?>"
                                        alt="<?= htmlspecialchars($artist['nama_artis']) ?>"
                                        class="artist-image">
                                <?php else: ?>
                                    <img src="assets/uploads/artists/default.png"
                                        alt="No image"
                                        class="artist-image">
                                <?php endif; ?>

                                <div class="artist-name"><?= htmlspecialchars($artist['nama_artis']) ?></div>
                                <div class="artist-genre">
                                    <i class="fas fa-music"></i> <?= htmlspecialchars($artist['genre']) ?>
                                </div>
                                <div class="artist-origin">
                                    <i class="fas fa-globe"></i> <?= htmlspecialchars($artist['asal_negara']) ?>
                                </div>
                                <div class="text-muted mt-2" style="font-size: 0.85rem;">
                                    <?= htmlspecialchars($artist['tipe_entitas']) ?>
                                </div>

                                <!-- SPOTIFY PLAYLIST -->
                                <?php if (!empty($artist['spotify_playlist_url'])): ?>
                                    <div class="spotify-playlist mt-3">
                                        <?php if (!$is_logged_in): ?>
                                            <!-- BELUM LOGIN: Tampilkan Lock -->
                                            <div class="playlist-locked">
                                                <i class="fas fa-lock"></i>
                                                <p>Login untuk mendengarkan playlist</p>
                                                <a href="auth/login.php" class="btn btn-sm btn-masuk">Login</a>
                                            </div>
                                        <?php else: ?>
                                            <!-- SUDAH LOGIN: Tampilkan Playlist -->
                                            <iframe
                                                style="border-radius:12px"
                                                src="<?= htmlspecialchars($artist['spotify_playlist_url']) ?>"
                                                width="100%"
                                                height="380"
                                                frameborder="0"
                                                allowfullscreen
                                                allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                                                loading="lazy">
                                            </iframe>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="text-muted">Lineup artis belum tersedia.</p>
            <?php endif; ?>
        </div>


        <!-- VIDEO SECTION (Opsional) -->
        <?php if (!empty($konser['video'])): ?>
            <div class="video-section">
                <h2><i class="fas fa-video"></i> Video Aftermovie</h2>
                <div class="video-container">
                    <?php if (strpos($konser['video'], 'youtube.com') !== false || strpos($konser['video'], 'youtu.be') !== false): ?>
                        <iframe width="100%" height="500" src="<?= htmlspecialchars($konser['video']) ?>"
                            frameborder="0" allowfullscreen class="rounded"></iframe>
                    <?php else: ?>
                        <video width="100%" height="500" controls class="rounded">
                            <source src="<?= htmlspecialchars($konser['video']) ?>" type="video/mp4">
                            Browser tidak support video.
                        </video>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- CTA SECTION (Beli Tiket) -->
        <?php if ($konser['status_konser'] === 'upcoming' && !empty($konser['link_tiket'])): ?>
            <div class="cta-section">
                <div class="cta-card">
                    <h3><i class="fas fa-ticket-alt"></i> Jangan Sampai Kehabisan!</h3>
                    <p>Konser <?= htmlspecialchars($konser['nama_konser']) ?> akan segera dimulai.
                        Dapatkan tiketmu sekarang sebelum terlambat!</p>
                    <a href="<?= htmlspecialchars($konser['link_tiket']) ?>"
                        target="_blank"
                        class="btn btn-cta pulse-animation">
                        <i class="fas fa-shopping-cart"></i> BELI TIKET SEKARANG
                    </a>
                    <p class="mt-3 mb-0">
                        <small><i class="fas fa-shield-alt"></i> Pembelian tiket aman melalui platform resmi</small>
                    </p>
                </div>
            </div>
        <?php endif; ?>

    </div>
    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>