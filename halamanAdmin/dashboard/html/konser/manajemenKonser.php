<?php
session_start();
include '../koneksi.php'; // Mundur 1 langkah ke html/

// Query Data
$queryTampilkanSemua = $koneksi->query("SELECT * FROM konser ORDER BY id_konser ASC");

if (!$queryTampilkanSemua) {
    die("Gagal Query: " . $koneksi->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Konser</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../css/styles.css?v=<?php echo time(); ?>">

    <style>
        .table-responsive { overflow-x: auto; white-space: nowrap; }
        .table th, .table td { vertical-align: middle; padding: 12px 15px; }
        .col-deskripsi { max-width: 250px; overflow: hidden; text-overflow: ellipsis; }
        .col-nama { min-width: 200px; font-weight: bold; }
        .link-media { text-decoration: none; display: inline-flex; align-items: center; gap: 5px; padding: 5px 10px; border-radius: 5px; background-color: rgba(255,255,255,0.05); transition: 0.3s; }
        .link-media:hover { background-color: rgba(255,255,255,0.1); }
    </style>
</head>

<body>
    <?php include '../header.php'; ?>
    <div class="d-flex-wrapper">
        <?php include '../sideBar.php'; ?>
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-white"><i class="bi bi-music-note-list me-2"></i>Daftar Konser</h2>
                <a href="tambahDataKonser.php" class="btn btn-success"><i class="bi bi-plus-lg me-2"></i> Tambah Konser</a>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-hover table-dark mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="col-nama">Nama Konser</th>
                                <th>Venue</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th>Harga Tiket Mulai</th>
                                <th>Link Tiket</th>
                                <th>Poster</th>
                                <th>Video</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($queryTampilkanSemua && $queryTampilkanSemua->num_rows > 0) {
                                while ($data = $queryTampilkanSemua->fetch_assoc()) {
                                    $badgeColor = ($data['status_konser'] == 'upcoming') ? 'bg-success' : 'bg-secondary';
                            ?>
                                    <tr>
                                        <td><span class="badge bg-secondary"><?= $data['id_konser']; ?></span></td>
                                        <td><?= htmlspecialchars($data['nama_konser']); ?></td>
                                        <td><span class="badge bg-info text-dark"><?= $data['id_venue']; ?></span></td>
                                        <td><?= date('d M Y H:i', strtotime($data['tanggal_mulai'])); ?></td>
                                        <td><?= date('d M Y H:i', strtotime($data['tanggal_selesai'])); ?></td>
                                        <td>Rp <?= number_format($data['harga_tiket_mulai'], 0, ',', '.'); ?></td>
                                        <td><a href="<?= $data['link_tiket']; ?>" style="color: white;"><?= $data['link_tiket']; ?></a></td>

                                        <td>
                                            <?php if(!empty($data['poster_konser'])): ?>
                                                <a href="../../../../<?= $data['poster_konser']; ?>" target="_blank" class="link-media text-info"><i class="bi bi-image"></i> Lihat</a>
                                            <?php else: ?> - <?php endif; ?>
                                        </td>

                                        <td>
                                            <?php if(!empty($data['video'])): ?>
                                                <a href="../../../../<?= $data['video']; ?>" target="_blank" class="link-media text-warning"><i class="bi bi-film"></i> Play</a>
                                            <?php else: ?> - <?php endif; ?>
                                        </td>

                                        <td><span class="badge <?= $badgeColor; ?> text-uppercase"><?= $data['status_konser']; ?></span></td>
                                        <td>
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="editKonser.php?id=<?= $data['id_konser']; ?>" class="btn btn-sm btn-warning text-white" title="Edit"><i class="bi bi-pencil"></i></a>

                                                <a href="hapusKonser.php?id=<?= $data['id_konser']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus <?= $data['nama_konser']; ?>?')" title="Hapus"><i class="bi bi-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                            <?php } } else { ?>
                                <tr><td colspan="11" class="text-center py-5 text-muted">Belum ada data konser.</td></tr>
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
</html>