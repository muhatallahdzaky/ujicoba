<?php
session_start();
include '../koneksi.php';

$query = $koneksi->query("SELECT * FROM provinsi ORDER BY id_provinsi ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Manajemen Provinsi</title>
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
                <h2 class="fw-bold text-white"><i class="bi bi-map-fill me-2"></i>Manajemen Provinsi</h2>
                <a href="tambahProvinsi.php" class="btn btn-success"><i class="bi bi-plus-lg me-2"></i> Tambah Provinsi</a>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-hover table-dark mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Provinsi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($query->num_rows > 0) { while($data = $query->fetch_assoc()) { ?>
                            <tr>
                                <td><span class="badge bg-secondary"><?= $data['id_provinsi']; ?></span></td>
                                <td class="fw-bold"><?= $data['nama_provinsi']; ?></td>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="editProvinsi.php?id=<?= $data['id_provinsi']; ?>" class="btn btn-sm btn-warning text-white"><i class="bi bi-pencil"></i></a>
                                        <a href="hapusProvinsi.php?id=<?= $data['id_provinsi']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus Provinsi <?= $data['nama_provinsi']; ?>?')"><i class="bi bi-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <?php }} else { echo "<tr><td colspan='3' class='text-center py-5 text-muted'>Belum ada data provinsi.</td></tr>"; } ?>
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