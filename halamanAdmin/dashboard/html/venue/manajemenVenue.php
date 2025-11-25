<?php
session_start();
include '../koneksi.php';

// Join ke tabel kota biar muncul nama kotanya
$queryVenue = $koneksi->query("SELECT venue.*, kota.nama_kota
                               FROM venue
                               LEFT JOIN kota ON venue.id_kota = kota.id_kota
                               ORDER BY venue.id_venue DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Venue</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../css/styles.css">
    <style>
        .table-responsive { overflow-x: auto; white-space: nowrap; }
        .table th, .table td { vertical-align: middle; padding: 12px 15px; }
    </style>
</head>
<body>
    <?php include '../header.php'; ?>

    <div class="d-flex-wrapper">
        <?php include '../sideBar.php'; ?>

        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold text-white"><i class="bi bi-geo-alt-fill me-2"></i>Manajemen Venue</h2>
                <a href="tambahVenue.php" class="btn btn-success"><i class="bi bi-plus-lg me-2"></i> Tambah Venue</a>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-hover table-dark mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Venue</th>
                                <th>Kota</th>
                                <th>Kapasitas</th>
                                <th>Alamat Lengkap</th>
                                <th>Website</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($queryVenue && $queryVenue->num_rows > 0) {
                                while ($data = $queryVenue->fetch_assoc()) { ?>
                                    <tr>
                                        <td><span class="badge bg-secondary"><?= $data['id_venue']; ?></span></td>
                                        <td class="fw-bold"><?= htmlspecialchars($data['nama_venue']); ?></td>

                                        <td><?= htmlspecialchars($data['nama_kota'] ?? 'Kota Tidak Diketahui'); ?></td>

                                        <td>
                                            <?= ($data['kapasitas']) ? number_format($data['kapasitas']) . " Org" : "-"; ?>
                                        </td>

                                        <td><?= substr(htmlspecialchars($data['alamat_lengkap']), 0, 30) . '...'; ?></td>

                                        <td>
                                            <?php if(!empty($data['url_website'])): ?>
                                                <a href="<?= $data['url_website']; ?>" target="_blank" class="btn btn-sm btn-outline-info"><i class="bi bi-link-45deg"></i> Link</a>
                                            <?php else: ?>
                                                <small class="text-muted">-</small>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="editVenue.php?id=<?= $data['id_venue']; ?>" class="btn btn-sm btn-warning text-white" title="Edit"><i class="bi bi-pencil"></i></a>
                                                <a href="hapusVenue.php?id=<?= $data['id_venue']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus venue ini?')" title="Hapus"><i class="bi bi-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                            <?php } } else { ?>
                                <tr><td colspan="7" class="text-center py-5 text-muted">Belum ada data venue.</td></tr>
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