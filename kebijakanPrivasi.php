<?php
define('BASE_URL', 'http://localhost/WebKonserProjek/');
include 'includes/header.php';
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/about-style.css">

<!-- About Page Container -->
<div class="about-page-container">
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar Menu -->
            <div class="col-lg-3 col-md-4">
                <div class="about-sidebar">
                    <h4 class="sidebar-title">Informasi</h4>
                    <ul class="sidebar-menu">
                        <li>
                            <a href="aboutUs.php">
                                <i class="fas fa-info-circle"></i>
                                Tentang Kami
                            </a>
                        </li>
                        <li>
                            <a href="syaratKetentuan.php">
                                <i class="fas fa-file-contract"></i>
                                Syarat & Ketentuan
                            </a>
                        </li>
                        <li class="active">
                            <a href="kebijakanPrivasi.php">
                                <i class="fas fa-shield-alt"></i>
                                Kebijakan Privasi
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Content Area -->
            <div class="col-lg-9 col-md-8">
                <div class="about-content">

                    <!-- Header -->
                    <div class="content-header">
                        <h1 class="content-title">Kebijakan Privasi</h1>
                        <p class="content-subtitle">Privacy Policy</p>
                    </div>

                    <!-- Content Body -->
                    <div class="content-body">

                        <section class="content-section">
                            <h2 class="section-heading">Informasi yang Kami Kumpulkan</h2>
                            <p class="section-text">
                                Kami dapat mengumpulkan beberapa jenis informasi dari dan tentang pengguna untuk meningkatkan layanan ConcerFo.
                            </p>
                            <ol class="terms-list">
                                <li><strong>Informasi yang Anda Berikan Secara Langsung:</strong> Nama, alamat email, nomor telepon, dan informasi melalui formulir kontak.</li>
                                <li><strong>Informasi Otomatis:</strong> Alamat IP, jenis browser, informasi perangkat, sistem operasi, waktu kunjungan, dan halaman yang diakses.</li>
                                <li><strong>Cookies & Teknologi Pelacakan:</strong> Digunakan untuk meningkatkan pengalaman pengguna, menyesuaikan konten, dan menganalisis penggunaan situs.</li>
                            </ol>
                            <p class="section-text">
                                Pengguna dapat menonaktifkan cookies melalui pengaturan browser masing-masing.
                            </p>
                        </section>

                        <section class="content-section">
                            <h2 class="section-heading">Bagaimana Kami Menggunakan Informasi Anda</h2>
                            <p class="section-text">
                                ConcerFo mengolah data pengguna secara bertanggung jawab untuk tujuan berikut:
                            </p>
                            <ol class="terms-list">
                                <li>Menyediakan dan mengoperasikan layanan platform dengan optimal.</li>
                                <li>Memperbarui informasi konser secara relevan dan tepat waktu.</li>
                                <li>Meningkatkan pengalaman dan personalisasi konten untuk pengguna.</li>
                                <li>Menganalisis pola penggunaan untuk optimasi platform secara berkelanjutan.</li>
                                <li>Mengirimkan pemberitahuan terkait layanan (dengan persetujuan pengguna).</li>
                                <li>Menjaga keamanan dan mencegah aktivitas berbahaya di platform.</li>
                                <li>Mematuhi kewajiban hukum yang berlaku di Indonesia.</li>
                            </ol>
                            <p class="section-text">
                                Kami <strong>tidak menjual</strong> informasi pribadi Anda kepada pihak mana pun.
                            </p>
                        </section>

                        <section class="content-section">
                            <h2 class="section-heading">Berbagi Informasi dengan Pihak Ketiga</h2>
                            <p class="section-text">
                                Kami membagikan data pengguna dalam kondisi terbatas dan terkendali:
                            </p>
                            <ol class="terms-list">
                                <li><strong>Pihak Ketiga Penyedia Layanan:</strong> Layanan analitik, penyedia cloud/server, dan platform pengirim email.</li>
                                <li><strong>Pihak Berwenang:</strong> Apabila diwajibkan oleh hukum, perintah pengadilan, atau proses hukum lainnya.</li>
                                <li><strong>Tautan ke Situs Pihak Ketiga:</strong> ConcerFo menyediakan tautan ke halaman promotor atau platform penjualan tiket.</li>
                            </ol>
                            <p class="section-text">
                                Pihak ketiga <strong>tidak memiliki izin</strong> untuk menggunakan data di luar kebutuhan operasional ConcerFo.
                            </p>
                        </section>

                        <section class="content-section">
                            <h2 class="section-heading">Keamanan Informasi Anda</h2>
                            <p class="section-text">
                                Kami menerapkan langkah-langkah keamanan komprehensif untuk melindungi data pengguna:
                            </p>
                            <ol class="terms-list">
                                <li>Enkripsi data untuk melindungi informasi sensitif.</li>
                                <li>Firewall server untuk mencegah akses tidak sah.</li>
                                <li>Pembatasan akses internal berdasarkan kebutuhan.</li>
                                <li>Sistem deteksi aktivitas mencurigakan secara real-time.</li>
                            </ol>
                            <p class="section-text">
                                Walaupun upaya terbaik telah dilakukan, <strong>tidak ada sistem yang sepenuhnya aman</strong> di dunia digital.
                            </p>
                        </section>

                        <section class="content-section">
                            <h2 class="section-heading">Penyimpanan dan Penghapusan Data</h2>
                            <p class="section-text">
                                Data pribadi Anda disimpan dengan pertimbangan waktu dan keperluan:
                            </p>
                            <ol class="terms-list">
                                <li>Disimpan selama diperlukan untuk tujuan operasional yang sah.</li>
                                <li>Disimpan sesuai dengan ketentuan hukum yang berlaku di Indonesia.</li>
                                <li>Anda berhak meminta penghapusan data, koreksi data, atau salinan data tertentu.</li>
                            </ol>
                            <p class="section-text">
                                Permintaan dapat diajukan melalui email admin kami dengan verifikasi identitas.
                            </p>
                        </section>

                        <section class="content-section">
                            <h2 class="section-heading">Hak-Hak Pengguna</h2>
                            <p class="section-text">
                                Sebagai pengguna ConcerFo, Anda memiliki hak-hak berikut:
                            </p>
                            <ol class="terms-list">
                                <li>Hak untuk mengetahui data apa saja yang disimpan oleh sistem.</li>
                                <li>Hak untuk memperbarui atau mengoreksi informasi yang tidak akurat.</li>
                                <li>Hak untuk meminta penghapusan data pribadi (hak untuk dilupakan).</li>
                                <li>Hak untuk menarik persetujuan penggunaan data kapan saja.</li>
                                <li>Hak untuk menolak penggunaan data untuk tujuan pemasaran tertentu.</li>
                            </ol>
                            <p class="section-text">
                                Kami akan memproses permintaan dalam waktu wajar sesuai ketentuan yang berlaku.
                            </p>
                        </section>

                        <section class="content-section">
                            <h2 class="section-heading">Privasi Anak di Bawah Umur</h2>
                            <p class="section-text">
                                ConcerFo sangat memperhatikan perlindungan data anak di bawah umur:
                            </p>
                            <ol class="terms-list">
                                <li>Platform tidak ditujukan untuk anak berusia di bawah 13 tahun.</li>
                                <li>Kami tidak secara sengaja mengumpulkan data dari anak di bawah umur.</li>
                                <li>Jika mengetahui adanya pengumpulan data tanpa izin orang tua, kami akan segera menghapus informasi tersebut.</li>
                            </ol>
                        </section>

                        <section class="content-section">
                            <h2 class="section-heading">Perubahan pada Kebijakan Privasi</h2>
                            <p class="section-text">
                                Kebijakan Privasi dapat diperbarui sesuai perkembangan layanan:
                            </p>
                            <ol class="terms-list">
                                <li>Perubahan akan diumumkan pada halaman ini secara transparan.</li>
                                <li>Kebijakan baru berlaku efektif setelah dipublikasikan di platform.</li>
                                <li>Pengguna disarankan meninjau halaman ini secara rutin untuk update terbaru.</li>
                            </ol>
                        </section>

                        <section class="content-section">
                            <h2 class="section-heading">Persetujuan Anda</h2>
                            <p class="section-text">
                                Dengan menggunakan situs ConcerFo, Anda menyatakan bahwa:
                            </p>
                            <ol class="terms-list">
                                <li>Telah membaca dan memahami seluruh Kebijakan Privasi ini.</li>
                                <li>Menyetujui semua prosedur pengelolaan data yang kami terapkan.</li>
                                <li>Bersedia bertanggung jawab atas konsekuensi dari penggunaan platform.</li>
                            </ol>
                        </section>

                        <section class="content-section">
                            <h2 class="section-heading">Kontak Kami</h2>
                            <p class="section-text">
                                Jika Anda memiliki pertanyaan terkait kebijakan privasi, hubungi kami melalui:
                            </p>
                            <ol class="terms-list">
                                <li><strong>Email:</strong> muhatallahdzaky@gmail.com</li>
                                <li><strong>Lokasi:</strong> Daerah Istimewa Yogyakarta, Indonesia</li>
                                <li>Kami akan merespons pertanyaan dalam waktu 1x24 jam pada hari kerja.</li>
                            </ol>
                        </section>

                        <!-- Last Updated -->
                        <div class="last-updated">
                            <i class="fas fa-calendar-alt"></i>
                            Terakhir diperbarui: [14 November 2025]
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- CSS Khusus About Page -->
<link rel="stylesheet" href="about-style.css">

<?php include 'includes/footer.php'; ?>