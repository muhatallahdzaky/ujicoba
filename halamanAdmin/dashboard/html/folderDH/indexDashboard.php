<?php
session_start();
include '../koneksi.php';

// --- LOGIC ---
$jumlahKonserOtw = 0;
$jumlahUserBulanIni = 0;

$query = @$koneksi->query("SELECT COUNT(*) FROM konser WHERE tanggal_mulai > NOW()");
if ($query) {
  $row = $query->fetch_row();
  $jumlahKonserOtw = $row[0];
}

$queryUser = @$koneksi->query("SELECT COUNT(*) FROM users WHERE MONTH(tanggal_daftar) = MONTH(NOW()) AND YEAR(tanggal_daftar) = YEAR(NOW())");
if ($queryUser) {
  $rowUser = $queryUser->fetch_row();
  $jumlahUserBulanIni = $rowUser[0];
}

$queryKonser = @$koneksi->query("SELECT nama_konser, tanggal_mulai, tanggal_selesai FROM konser WHERE tanggal_mulai > NOW() ORDER BY tanggal_mulai ASC LIMIT 5");

$queryAktivitasAtmin = @$koneksi->query("SELECT * FROM log_aktivitas ORDER BY id DESC LIMIT 8");
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <link rel="stylesheet" href="../../css/styles.css?v=<?php echo time(); ?>">
</head>

<body>

  <?php include '../header.php'; ?>

  <div class="d-flex-wrapper"><?php include '../sideBar.php'; ?>

    <div class="main-content">
      <h4 class="mb-4 fw-bold">Quick Stats</h4>

      <div class="row mb-4">
        <div class="col-md-6">
          <div class="stats-card">
            <p>Jumlah Konser Mendatang</p>
            <h2><?= htmlspecialchars($jumlahKonserOtw); ?></h2>
          </div>
        </div>
        <div class="col-md-6">
          <div class="stats-card">
            <p>Pengguna Baru (Bulan Ini)</p>
            <h2><?= htmlspecialchars($jumlahUserBulanIni); ?></h2>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-lg-8 mb-4">
          <div class="table-card">
            <div class="d-flex justify-content-between align-items-center mb-3">
              <h5 class="mb-0 text-white">Konser Mendatang</h5>
            </div>
            <div class="table-responsive">
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th>Nama Konser</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                  </tr>
                </thead>
                <tbody>
                  <?php if ($queryKonser) {
                    while ($data = $queryKonser->fetch_assoc()) { ?>
                      <tr>
                        <td><?= htmlspecialchars($data['nama_konser']); ?></td>
                        <td><?= htmlspecialchars($data['tanggal_mulai']); ?></td>
                        <td><?= htmlspecialchars($data['tanggal_selesai']); ?></td>
                      </tr>
                  <?php }
                  } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div class="col-lg-4 mb-4">
          <div class="activity-card">
            <h5 class="mb-3 border-bottom pb-2 text-white">Aktivitas Admin</h5>
            <?php if ($queryAktivitasAtmin && $queryAktivitasAtmin->num_rows > 0) {
              while ($rowLog = $queryAktivitasAtmin->fetch_assoc()) { ?>
                <div class="mb-3 small">
                  <i class="bi bi-dot text-info"></i>
                  <strong><?= isset($rowLog['admin_nama']) ? $rowLog['admin_nama'] : 'Sys'; ?></strong>
                  <?= isset($rowLog['aksi']) ? $rowLog['aksi'] : '-'; ?>
                </div>
            <?php }
            } else {
              echo "<span>Belum ada aktivitas.</span>";
            } ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include '../footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>