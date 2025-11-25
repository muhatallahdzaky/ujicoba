<?php
session_start();
include '../koneksi.php';

// JOIN 3 Tabel: LineUp -> Konser -> Artis
$query = "SELECT lineup.*, konser.nama_konser, artis.nama_artis
          FROM lineup
          JOIN konser ON lineup.id_konser = konser.id_konser
          JOIN artis ON lineup.id_artis = artis.id_artis
          ORDER BY id_lineup DESC";

$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen LineUp</title>
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
                <h2 class="fw-bold text-white"><i class="bi bi-music-note-list me-2"></i>Manajemen LineUp</h2>
                <a href="tambahLineUp.php" class="btn btn-success"><i class="bi bi-plus-lg me-2"></i> Tambah LineUp</a>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-hover table-dark mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Konser</th>
                                <th>Nama Artis</th>
                                <th>Jadwal Tampil</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($result && $result->num_rows > 0) { while($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><span class="badge bg-secondary"><?= $row['id_lineup']; ?></span></td>
                                <td class="fw-bold"><?= htmlspecialchars($row['nama_konser']); ?></td>
                                <td><?= htmlspecialchars($row['nama_artis']); ?></td>
                                <td>
                                    <?php
                                    if($row['jadwal_tampil']) {
                                        echo date('d M Y, H:i', strtotime($row['jadwal_tampil'])) . " WIB";
                                    } else {
                                        echo "<span class='text-muted'>-</span>";
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="editLineUp.php?id=<?= $row['id_lineup']; ?>" class="btn btn-sm btn-warning text-white" title="Edit"><i class="bi bi-pencil"></i></a>
                                        <a href="hapusLineUp.php?id=<?= $row['id_lineup']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus LineUp ini?')"><i class="bi bi-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php }} else { echo "<tr><td colspan='5' class='text-center py-5 text-muted'>Belum ada data lineup.</td></tr>"; } ?>
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