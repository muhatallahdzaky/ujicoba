<?php
session_start();
include '../koneksi.php'; // Mundur 1 langkah ke html/

// Query Data Artis
$queryArtis = $koneksi->query("SELECT * FROM artis ORDER BY id_artis ASC");

if (!$queryArtis) {
    die("Gagal Query: " . $koneksi->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Artis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="../../css/styles.css?v=<?php echo time(); ?>">

    <style>
        .table-responsive { overflow-x: auto; white-space: nowrap; }
        .table th, .table td { vertical-align: middle; padding: 12px 15px; }

        /* Foto Artis Bulat & Keren */
        .img-artis {
            width: 50px; height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #3498db;
        }

        /* Audio Player Minimalis */
        .audio-player { width: 200px; height: 30px; }
    </style>
</head>

<body>
    <?php include '../header.php'; ?> <div class="d-flex-wrapper">
        <?php include '../sideBar.php'; ?> <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-white">
                    <i class="bi bi-mic-fill me-2"></i>Manajemen Artis
                </h2>
                <a href="tambahDataArtis.php" class="btn btn-success">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Artis
                </a>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-hover table-dark mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Foto</th>
                                <th>Nama Artis</th>
                                <th>Genre</th>
                                <th>Negara</th>
                                <th>Tipe</th>
                                <th>Spotify Artist Playlist</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($queryArtis && $queryArtis->num_rows > 0) {
                                while ($data = $queryArtis->fetch_assoc()) { ?>
                                    <tr>
                                        <td><span class="badge bg-secondary"><?= $data['id_artis']; ?></span></td>

                                        <td>
                                            <?php if(!empty($data['gambar_artis'])): ?>
                                                <img src="/WebKonserProjek/<?= $data['gambar_artis']; ?>" class="img-artis">
                                            <?php else: ?>
                                                <div class="img-artis d-flex align-items-center justify-content-center bg-secondary text-white" style="font-size: 10px;">No Pic</div>
                                            <?php endif; ?>
                                        </td>

                                        <td class="fw-bold"><?= htmlspecialchars($data['nama_artis']); ?></td>
                                        <td><?= htmlspecialchars($data['genre']); ?></td>
                                        <td><?= htmlspecialchars($data['asal_negara']); ?></td>
                                        <td><span class="badge bg-info text-dark"><?= $data['tipe_entitas']; ?></span></td>
                                        <td>
                                            <a href="<?= $data['spotify_playlist_url']; ?>" style="color: white;"><?= $data['spotify_playlist_url']; ?></a>
                                        </td>

                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="editArtis.php?id=<?= $data['id_artis']; ?>" class="btn btn-sm btn-warning text-white" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <a href="hapusArtis.php?id=<?= $data['id_artis']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus <?= $data['nama_artis']; ?>?')" title="Hapus">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                            <?php } } else { ?>
                                <tr><td colspan="8" class="text-center py-5 text-muted">Belum ada data artis.</td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include '../footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>>