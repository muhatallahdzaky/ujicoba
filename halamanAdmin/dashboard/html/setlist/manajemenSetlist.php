<?php
session_start();
include '../koneksi.php';

// JOIN 3 Tabel: Setlist -> Konser -> Artis
$query = "SELECT setlist_konser.*, konser.nama_konser, artis.nama_artis
          FROM setlist_konser
          JOIN konser ON setlist_konser.id_konser = konser.id_konser
          JOIN artis ON setlist_konser.id_artis = artis.id_artis
          ORDER BY setlist_konser.id_konser ASC, setlist_konser.urutan ASC";

$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Setlist</title>
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
                <h2 class="fw-bold text-white"><i class="bi bi-list-ol me-2"></i>Manajemen Setlist</h2>
                <a href="tambahSetlist.php" class="btn btn-success"><i class="bi bi-plus-lg me-2"></i> Tambah Lagu</a>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-hover table-dark mb-0">
                        <thead>
                            <tr>
                                <th>Urutan</th>
                                <th>Judul Lagu</th>
                                <th>Konser</th>
                                <th>Artis</th>
                                <th>Durasi</th>
                                <th>Audio</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($result && $result->num_rows > 0) { while($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><span class="badge bg-secondary">#<?= $row['urutan']; ?></span></td>
                                <td class="fw-bold"><?= htmlspecialchars($row['judul_lagu']); ?></td>
                                <td><?= htmlspecialchars($row['nama_konser']); ?></td>
                                <td><?= htmlspecialchars($row['nama_artis']); ?></td>
                                <td><?= $row['durasi']; ?></td>
                                <td>
                                    <?php if(!empty($row['audio_file'])): ?>
                                        <audio controls style="height: 30px; width: 150px;">
                                            <source src="../../../../uploads/setlistAudio/<?= $row['audio_file']; ?>" type="audio/mpeg">
                                        </audio>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="editSetlist.php?id=<?= $row['id_setlist']; ?>" class="btn btn-sm btn-warning text-white" title="Edit"><i class="bi bi-pencil"></i></a>
                                        <a href="hapusSetlist.php?id=<?= $row['id_setlist']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus lagu ini?')"><i class="bi bi-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php }} else { echo "<tr><td colspan='7' class='text-center py-5 text-muted'>Belum ada data setlist.</td></tr>"; } ?>
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