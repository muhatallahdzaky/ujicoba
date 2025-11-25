<?php
session_start();
include '../koneksi.php'; // Mundur 1 langkah

// Query Data Kota JOIN Provinsi biar muncul nama provinsinya
$query = $koneksi->query("
    SELECT kota.*, provinsi.nama_provinsi
    FROM kota
    JOIN provinsi ON kota.id_provinsi = provinsi.id_provinsi
    ORDER BY kota.id_kota DESC
");

if (!$query) {
    die("Gagal Query: " . $koneksi->error);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Kota</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../css/styles.css?v=<?php echo time(); ?>">

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
                <h2 class="fw-bold text-white">
                    <i class="bi bi-building me-2"></i>Manajemen Kota
                </h2>
                <a href="tambahKota.php" class="btn btn-success">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Kota
                </a>
            </div>

            <div class="table-card">
                <div class="table-responsive">
                    <table class="table table-hover table-dark mb-0">
                        <thead>
                            <tr>
                                <th>ID Kota</th>
                                <th>Nama Kota</th>
                                <th>Provinsi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($query && $query->num_rows > 0) {
                                while ($data = $query->fetch_assoc()) { ?>
                                    <tr>
                                        <td><span class="badge bg-secondary"><?= $data['id_kota']; ?></span></td>
                                        <td class="fw-bold"><?= htmlspecialchars($data['nama_kota']); ?></td>

                                        <td><span class="badge bg-info text-dark"><?= htmlspecialchars($data['nama_provinsi']); ?></span></td>

                                        <td class="text-center">
                                            <div class="d-flex gap-2 justify-content-center">
                                                <a href="editKota.php?id=<?= $data['id_kota']; ?>" class="btn btn-sm btn-warning text-white" title="Edit"><i class="bi bi-pencil"></i></a>
                                                <a href="hapusKota.php?id=<?= $data['id_kota']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus kota <?= $data['nama_kota']; ?>?')" title="Hapus"><i class="bi bi-trash"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                            <?php } } else { ?>
                                <tr><td colspan="4" class="text-center py-5 text-muted">Belum ada data kota.</td></tr>
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