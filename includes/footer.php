<!-- Footer -->
<footer class="footer mt-5">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-md-4 mb-4">
                <h5 class="footer-title">Tentang ConcerFo</h5>
                <p class="footer-text"> ConcerFo adalah platform terpercaya untuk melihat informasi konser yang sedang berlangsung, berlalu, maupun yang akan datang🎵 </p>
                <p class="footer-text">Nikmati pengalaman live music terbaik bersama ConcerFo! Temukan jadwal konser terbaru dari artis favoritmu dan rasakan sensasi serunya konser tanpa khawatir kehabisan tempat🎤

                <p class="footer-text">Dengan ConcerFo, kamu selalu up to date dengan dunia musik dan hiburan!✨</p>
                </p>
                <!-- Social Media -->
                <div class="social-links mt-3">
                    <a href="https://www.instagram.com/muhatallahdzaky/" class="social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.instagram.com/sirhisyam01/" class="social-icon"><i class="bi bi-instagram"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-md-3 mb-4">
                <h5 class="footer-title">Menu</h5>
                <ul class="footer-links">
                    <li><a href="<?php echo BASE_URL; ?>index.php"><i class="bi bi-house-door"></i> Beranda</a></li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li>
                            <a href="<?php echo BASE_URL; ?>wishlist.php">
                                <i class="bi bi-heart"></i> Wishlist Saya</a>
                        </li>
                    <?php endif ?>
                </ul>
            </div>

            <!-- Info -->
            <div class="col-md-3 mb-4">
                <h5 class="footer-title">Informasi</h5>
                <ul class="footer-links">
                    <li><a href="aboutUs.php"><i class="bi bi-info-circle"></i> Tentang Kami</a></li>
                    <li><a href="syaratKetentuan.php"><i class="bi bi-file-text"></i> Syarat & Ketentuan</a></li>
                    <li><a href="kebijakanPrivasi.php"><i class="bi bi-shield-check"></i> Kebijakan Privasi</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-md-2 mb-4">
                <h5 class="footer-title">Kontak</h5>
                <ul class="footer-links">
                    <li><a href="https://mail.google.com/mail/?view=cm&fs=1&to=muhatallahdzaky@email.com"><i class="bi bi-envelope"></i> Email</a></li>
                    <li><a href="https://wa.me/6282134418171"><i class="bi bi-whatsapp"></i> WhatsApp</a></li>
                    <li><a href="tel:+6282134418171"><i class="bi bi-telephone"></i> Telepon</a></li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="row mt-4">
            <div class="col-12">
                <hr class="footer-divider">
                <div class="text-center footer-copyright">
                    <p class="mb-0">
                        &copy; <?php echo date('Y'); ?> <strong>ConcerFo</strong>. All Rights Reserved.
                    </p>
                    <p class="mb-0 mt-1 small">
                        Made with <i class="bi bi-heart-fill text-danger"></i> for Music Lovers
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BASE_URL; ?>assets/js/script.js"></script>

</body>

</html>