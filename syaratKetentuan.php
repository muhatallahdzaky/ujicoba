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
                        <li class="active">
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
                        <h1 class="content-title">Syarat & Ketentuan</h1>
                        <p class="content-subtitle">Terms & Conditions</p>
                    </div>

                    <!-- Content Body -->
                    <div class="content-body">

                        <!-- Section 1 -->
                        <section class="content-section">
                            <h2 class="section-heading">Ketentuan Umum</h2>
                            <p class="section-text">
                                Selamat datang di ConcerFo. Dengan mengakses atau menggunakan platform ini, Anda dianggap telah membaca, memahami, dan menyetujui seluruh Syarat dan Ketentuan yang tercantum pada halaman ini. Jika Anda tidak setuju dengan salah satu ketentuan di bawah, mohon untuk menghentikan penggunaan situs ConcerFo.
                            </p>
                        </section>

                        <!-- Section 2 -->
                        <section class="content-section">
                            <h2 class="section-heading">Definisi</h2>
                            <p class="section-text">
                                Untuk kejelasan, istilah berikut digunakan:
                            </p>
                            <ul class="terms-list">
                                <li> “Pengguna”, “Anda”, “Kamu” berarti setiap individu yang mengunjungi, mengakses, atau menggunakan layanan ConcerFo.</li>
                                <li> “Platform”, “Situs”, “Kami”, “ConcerFo” mengacu pada website penyedia informasi konser yang sedang berlangsung, akan datang, maupun telah berlalu.</li>
                                <li> “Layanan” berarti seluruh fitur, konten, informasi konser, dan media lain yang tersedia di ConcerFo.</li>
                                <li> “Pihak Ketiga” mengacu pada organisasi, website, atau entitas lain di luar ConcerFo.</li>
                            </ul>
                            <p class="section-text">
                                Semua istilah tersebut dapat digunakan dalam bentuk tunggal, jamak, atau variasi lainnya tanpa mengubah maknanya.
                            </p>
                        </section>

                        <!-- Section 3 -->
                        <section class="content-section">
                            <h2 class="section-heading">Penerimaan Syarat</h2>
                            <p class="section-text">
                                Dengan menggunakan platform ini, Anda:
                            </p>
                            <ol class="terms-list">
                                <li> “Pihak Ketiga” mengacu pada organisasi, website, atau entitas lain di luar ConcerFo.</li>
                                <li>Menyetujui seluruh Syarat dan Ketentuan ini tanpa pengecualian.</li>
                                <li>Menyetujui perubahan yang akan diterapkan secara berkala oleh ConcerFo.</li>
                            </ol>
                            <p class="section-text">
                                Kami dapat memperbarui ketentuan tanpa pemberitahuan sebelumnya. Versi terbaru akan selalu tersedia di halaman ini.
                            </p>
                        </section>


                        <!-- Section 4 -->
                        <section class="content-section">
                            <h2 class="section-heading">Cookies</h2>
                            <p class="section-text">
                                ConcerFo menggunakan cookies untuk meningkatkan kualitas pengalaman pengguna. Cookies memungkinkan kami untuk:
                            </p>
                            <ul class="terms-list">
                                <li>mengingat preferensi tampilan,</li>
                                <li>menyesuaikan fitur tertentu,</li>
                                <li>mengoptimalkan performa situs,</li>
                                <li>menganalisis interaksi pengguna.</li>
                            </ul>
                            <p class="section-text">Dengan mengakses ConcerFo, Anda menyetujui penggunaan cookies sesuai Kebijakan Privasi kami. Beberapa mitra iklan atau pihak ketiga mungkin juga menggunakan cookies mereka sendiri.</p>
                        </section>

                        <!-- Section 5 -->
                        <section class="content-section">
                            <h2 class="section-heading">Hak Kekayaan Intelektual</h2>
                            <p class="section-text">
                                Kecuali dinyatakan lain, seluruh materi dalam situs ConcerFo adalah milik ConcerFo atau pemilik lisensi kepada kami.
                            </p>
                            <ol class="terms-list">
                                <li>Anda <strong>diperbolehkan</strong> melihat atau mengunduh konten untuk keperluan pribadi non-komersial.</li>
                                <li>Anda <strong>dilarang</strong> menyalin ulang konten secara massal, memodifikasi, mendistribusikan, atau mengunggah ulang materi.</li>
                                <li>Dilarang menjual atau menyewakan konten kami, serta menggunakan nama atau logo ConcerFo tanpa izin tertulis.</li>
                                <li>Pelanggaraan dapat mengakibatkan tindakan hukum sesuai ketentuan yang berlaku.</li>
                            </ol>
                        </section>

                        <!-- Section 6 -->
                        <section class="content-section">
                            <h2 class="section-heading">Informasi Konser</h2>
                            <p class="section-text">
                                ConcerFo menyediakan informasi mengenai jadwal konser, artis, lokasi venue, dan detail tiket.
                            </p>
                            <ol class="terms-list">
                                <li>Kami berusaha menjaga keakuratan data, namun sebagian informasi berasal dari sumber pihak ketiga.</li>
                                <li>Kami <strong>tidak menjamin</strong> akurasi, kelengkapan, atau kelayakan informasi yang tersedia.</li>
                                <li>Kesalahan jadwal, perubahan venue, pembatalan konser, dan perbedaan harga tiket bukan tanggung jawab ConcerFo.</li>
                                <li>Pengguna disarankan memeriksa sumber resmi sebelum melakukan pembelian tiket.</li>
                            </ol>
                        </section>

                        <!-- Section 7 -->
                        <section class="content-section">
                            <h2 class="section-heading">Tidak Menjual Tiket</h2>
                            <p class="section-text">
                                ConcerFo <strong>bukan</strong> platform penjualan tiket, kami hanya menyediakan informasi dan tautan.
                            </p>
                            <ol class="terms-list">
                                <li>Semua transaksi tiket dilakukan di platform pihak ketiga yang tertera.</li>
                                <li>ConcerFo tidak bertanggung jawab atas kesalahan pembelian, penipuan tiket, atau pembatalan dari pihak promotor.</li>
                                <li>Kegagalan transaksi dan perubahan syarat pembelian yang ditetapkan pihak lain di luar kendali kami.</li>
                            </ol>
                        </section>

                        <!-- Section 8 -->
                        <section class="content-section">
                            <h2 class="section-heading">Tautan ke Situs Pihak Ketiga</h2>
                            <p class="section-text">
                                Situs kami dapat memuat tautan ke website lain yang dikelola oleh pihak ketiga.
                            </p>
                            <ol class="terms-list">
                                <li>ConcerFo tidak memiliki kendali atas konten atau kebijakan situs pihak ketiga.</li>
                                <li>Kami tidak bertanggung jawab atas pelanggaran data, perubahan kebijakan, atau konten menyesatkan di situs lain.</li>
                                <li>Pengguna diharapkan membaca Syarat dan Ketentuan dari situs pihak ketiga terlebih dahulu.</li>
                            </ol>
                        </section>

                        <!-- Section 9 -->
                        <section class="content-section">
                            <h2 class="section-heading">Penggunaan yang Dilarang</h2>
                            <p class="section-text">
                                Anda setuju untuk <strong>tidak</strong> menggunakan platform ini untuk aktivitas terlarang.
                            </p>
                            <ol class="terms-list">
                                <li>Melakukan aktivitas ilegal atau merugikan pihak manapun.</li>
                                <li>Memasukkan malware, script berbahaya, atau spam ke dalam sistem.</li>
                                <li>Mencoba mengakses server atau database tanpa izin resmi.</li>
                                <li>Meniru identitas ConcerFo untuk tujuan penipuan.</li>
                                <li>Mengumpulkan data pengguna tanpa persetujuan yang sah.</li>
                            </ol>
                            <p class="section-text">
                                Setiap pelanggaran dapat menyebabkan pemblokiran akses dan tindakan hukum.
                            </p>
                        </section>

                        <!-- Section 10 -->
                        <section class="content-section">
                            <h2 class="section-heading">Batasan Tanggung Jawab</h2>
                            <p class="section-text">
                                ConcerFo tidak bertanggung jawab atas berbagai kondisi di luar kendali kami.
                            </p>
                            <ol class="terms-list">
                                <li>Kerugian finansial akibat informasi yang tidak akurat.</li>
                                <li>Kegagalan transaksi pada situs pihak ketiga.</li>
                                <li>Gangguan layanan atau downtime server yang tidak terduga.</li>
                                <li>Kehilangan data atau masalah teknis pada perangkat pengguna.</li>
                                <li>Keputusan yang dibuat berdasarkan informasi di ConcerFo.</li>
                            </ol>
                            <p class="section-text">
                                Penggunaan situs sepenuhnya merupakan risiko Anda sendiri.
                            </p>
                        </section>

                        <!-- Section 11 -->
                        <section class="content-section">
                            <h2 class="section-heading">Perubahan Layanan</h2>
                            <p class="section-text">
                                ConcerFo berhak melakukan perubahan layanan sesuai kebutuhan.
                            </p>
                            <ol class="terms-list">
                                <li>Menambah atau menghapus fitur yang tersedia.</li>
                                <li>Memperbarui tampilan atau desain platform.</li>
                                <li>Menghentikan layanan sementara atau permanen.</li>
                            </ol>
                            <p class="section-text">
                                Perubahan dapat dilakukan tanpa pemberitahuan sebelumnya.
                            </p>
                        </section>

                        <!-- Section 12 -->
                        <section class="content-section">
                            <h2 class="section-heading">Hukum yang Berlaku</h2>
                            <p class="section-text">
                                Syarat dan Ketentuan ini diatur sesuai dengan hukum yang berlaku di Indonesia.
                            </p>
                            <ol class="terms-list">
                                <li>Segala perselisihan akan diselesaikan melalui jalur hukum yang sesuai.</li>
                                <li>Proses penyelesaian mengikuti ketentuan perundang-undangan Republik Indonesia.</li>
                            </ol>
                        </section>

                        <!-- Section 13 -->
                        <section class="content-section">
                            <h2 class="section-heading">Persetujuan Anda</h2>
                            <p class="section-text">
                                Dengan menggunakan situs ConcerFo, Anda menyatakan bahwa:
                            </p>
                            <ol class="terms-list">
                                <li>Telah membaca dan memahami seluruh Syarat dan Ketentuan ini.</li>
                                <li>Menyetujui semua aturan tanpa pengecualian.</li>
                                <li>Bersedia bertanggung jawab atas segala konsekuensi dari penggunaan platform.</li>
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
<link rel="stylesheet" href="about-style.css">
<?php include 'includes/footer.php'; ?>