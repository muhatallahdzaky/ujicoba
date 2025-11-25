<?php
define('BASE_URL', 'http://localhost/WebKonserProjek/');
include 'includes/header.php';
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/about-style.css">

<!-- About Page Container -->
<div class="about-page-container" style="color: red;">
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar Menu -->
            <div class="col-lg-3 col-md-4">
                <div class="about-sidebar">
                    <h4 class="sidebar-title">Informasi</h4>
                    <ul class="sidebar-menu">
                        <li class="active">
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
                        <li>
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
                        <h1 class="content-title">About Us</h1>
                        <p class="content-subtitle">Tentang ConcerFo</p>
                    </div>

                    <!-- Content Body -->
                    <div class="content-body">
                        <!-- Section 1 -->
                        <section class="content-section">
                            <h2 class="section-heading">Siapa Kami?</h2>
                            <p class="section-text">
                                ConcerFo adalah platform terpercaya untuk melihat informasi konser yang sedang berlangsung, yang telah berlalu, maupun yang akan datang. Kami hadir untuk memudahkan penggemar musik dalam menemukan jadwal konser, detail artis, lokasi pertunjukan, hingga informasi tiket terbaru dalam satu tempat. Dengan tampilan yang sederhana dan mudah digunakan, ConcerFo berkomitmen memberikan data yang akurat dan selalu diperbarui agar setiap pengguna dapat merencanakan pengalaman menonton konser dengan lebih praktis. Melalui platform ini, kami berharap dapat menjadi jembatan antara musisi dan para penggemarnya, sekaligus mendukung industri pertunjukan musik agar semakin berkembang.
                            </p>
                        </section>

                        <!-- Section 2 -->
                        <section class="content-section">
                            <h2 class="section-heading">Hubungi Kami</h2>
                            <div class="contact-info">
                                <div class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <span>Email 1: muhatallahdzaky@gmail.com</span>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-envelope"></i>
                                    <span>Email 2: .............@gmail.com</span>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-phone"></i>
                                    <span>Phone 1: +62 821 3441 8171</span>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-phone"></i>
                                    <span>Phone 2: +62 896 5570 5151</span>
                                </div>
                                <div class="contact-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>Address: Daerah Istimewa Yogyakarta, Indonesia</span>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<link rel="stylesheet" href="about-style.css">
<?php include 'includes/footer.php'; ?>