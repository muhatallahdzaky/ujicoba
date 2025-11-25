-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 25 Nov 2025 pada 08.40
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_konser`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `artis`
--

CREATE TABLE `artis` (
  `id_artis` varchar(10) NOT NULL,
  `nama_artis` varchar(255) NOT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `asal_negara` varchar(100) DEFAULT NULL,
  `gambar_artis` varchar(255) DEFAULT NULL,
  `tipe_entitas` varchar(100) DEFAULT NULL,
  `spotify_playlist_url` varchar(500) DEFAULT NULL COMMENT 'URL Spotify Playlist Embed artis'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `artis`
--

INSERT INTO `artis` (`id_artis`, `nama_artis`, `genre`, `asal_negara`, `gambar_artis`, `tipe_entitas`, `spotify_playlist_url`) VALUES
('A02', 'Ryokuoushoku Shakai', 'J-Pop, Pop Rock', 'Jepang', 'assets/uploads/band_pict/ryokuoushoku_shakai.webp', 'Grup Band (J-Pop/Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO2RG70A'),
('A04', 'L’Impératrice', 'Disco-pop', 'Prancis', 'assets/uploads/band_pict/l_imperatrice.webp', 'Grup Band (Nu-Disco/Pop)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO2PKuJy?si=m6NetpXPQA6qPbcZ1tP3QA'),
('A05', 'TV Girl', 'Indie Pop', 'AS', 'assets/uploads/band_pict/tv_girls.webp', 'Grup Band (Indie Pop)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO0vGw7L?si=brJo2vsZSsqiBw10a4N9fg'),
('A07', 'Calvin Harris', 'Dance, Pop', 'Inggris', 'assets/uploads/band_pict/calvin_harris.webp', 'Artis Solo (DJ/Produser)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO4vD8f6?si=5G_UCEAAQqqbEeLvWDkZkg'),
('A08', 'Charlotte De Witte', 'Techno', 'Belgia', 'assets/uploads/band_pict/charlotte_de_witte.webp', 'Artis Solo (DJ/Produser)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO0JU6Vb?si=d9ahiOKXRt692NakiEBPwg'),
('A09', 'Fisher', 'Tech House', 'Australia', 'assets/uploads/band_pict/fisher.webp', 'Artis Solo (DJ/Produser)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO15yTgv?si=JQxSphWVRW6_r4O_RoHQ_w'),
('A11', 'Skrillex', 'Dubstep, EDM', 'AS', 'assets/uploads/band_pict/skrillex.webp', 'Artis Solo (DJ/Produser)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO36pSwM?si=hoDYNWOiTkqLDT6MJu-xUA'),
('A12', 'Steve Angello', 'Progressive House', 'Swedia', 'assets/uploads/band_pict/steve_angello.webp', 'Artis Solo (DJ/Produser)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO2JG2Mo?si=J_6jJErjRWOyP4Vp5mHhSw'),
('A13', 'RIIZE', 'K-Pop', 'Korea Selatan', 'assets/uploads/band_pict/riize.webp', 'Grup Idola K-Pop', 'https://open.spotify.com/embed/playlist/37i9dQZF1DX7GyB1VTMbAk?si=PXPo6nqeSZCNOe0ApOizdg'),
('A16', 'Dream Theater', 'Progressive Metal', 'AS', 'assets/uploads/band_pict/dream_theater.webp', 'Grup Band (Progressive Metal)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO1efOAU?si=stzZfjB-SsKFyVko3RHoIQ'),
('A17', 'Michael Learns To Rock', 'Pop, Soft Rock', 'Denmark', 'assets/uploads/band_pict/michael_learns_to_rock.webp', 'Grup Band (Soft Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO4ucjQp?si=a-8zkg0HTiKHlvP7Drx0FA'),
('A18', 'Jim Brickman', 'New Age, Pop', 'AS', 'assets/uploads/band_pict/jim_brickman.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO1BY96o?si=8zRrB00ySsKzod6Z5P3jvw'),
('A19', 'Peabo Bryson', 'Soul, R&B', 'AS', 'assets/uploads/band_pict/peabo_bryson.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO2qlpNM?si=sNFXe7U_QsSvF8TdZ9WOdw'),
('A20', 'Vina Panduwinata', 'Pop', 'Indonesia', 'assets/uploads/band_pict/vina_panduwinata.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO1E8C1c?si=cnYDKXPsSuOUL7t1SKIuCQ'),
('A21', 'Rita Effendy', 'Pop', 'Indonesia', 'assets/uploads/band_pict/rita_effendy.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO3A9mp4?si=pl_EjKWiS3SsKVTHOgWm4g'),
('A22', 'aespa', 'K-Pop, Hyperpop', 'Korea Selatan', 'assets/uploads/band_pict/aespa.webp', 'Grup Idola K-Pop', 'https://open.spotify.com/embed/playlist/37i9dQZF1DX5CHJY6ZqPPz?si=TaB5ASK7S9OoTt351HsHfQ'),
('A23', 'Deep Purple', 'Hard Rock, Heavy Metal', 'Inggris', 'assets/uploads/band_pict/deep_purple.webp', 'Grup Band (Hard Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO2ZKA1i?si=5WYfjq38RN6_cCgCf3gL1A'),
('A24', 'Slank', 'Rock', 'Indonesia', 'assets/uploads/band_pict/slank.webp', 'Grup Band (Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO4xIo9z?si=l5naUrOhT7Wfcu30BL5fsw'),
('A25', 'My Chemical Romance', 'Alternative Rock', 'AS', 'assets/uploads/band_pict/my_chemical_romance.webp', 'Grup Band (Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO4xHh28?si=poM4qiFySBSQl9HV88mB1Q'),
('A26', 'Parkway Drive', 'Metalcore', 'Australia', 'assets/uploads/band_pict/parkway_drive.webp', 'Grup Band (Metalcore)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO0zVFVC?si=XvjsV1EoTGCguNpIM4GBIg'),
('A27', 'New Found Glory', 'Pop Punk', 'AS', 'assets/uploads/band_pict/new_found_glory.webp', 'Grup Band (Pop-Punk)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO2uxwRi?si=u9q4qXPZTwaA9JP2_8HQoQ'),
('A28', 'One Ok Rock', 'Rock, J-Rock', 'Jepang', 'assets/uploads/band_pict/one_ok_rock.webp', 'Grup Band (J-Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO4kLHt6?si=uSI6qVKxSf-a75aOJ-FeYw'),
('A29', 'NCT WISH', 'K-Pop', 'Korea Selatan/Jepang', 'assets/uploads/band_pict/nct_wish.webp', 'Grup Idola K-Pop', 'https://open.spotify.com/embed/playlist/37i9dQZF1DWW5unMLFzqYY?si=HExy-uCjTZq2iTaLFdZcpQ'),
('A31', 'BLACKPINK', 'K-Pop, Hip Hop', 'Korea Selatan', 'assets/uploads/band_pict/blackpink.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DX8kP0ioXjxIA'),
('A32', 'Libera', 'Classical, Choral', 'Inggris', 'assets/uploads/band_pict/libera.webp', 'Paduan Suara Anak', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO19ZyAV'),
('A33', 'THE BOYZ', 'K-Pop', 'Korea Selatan', 'assets/uploads/band_pict/the_boyz.webp', 'Grup Idola K-Pop', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO0iBATD?si=GoQNBY1lRZmd3JIdjoTXgA'),
('A34', 'Maher Zain', 'Islamic Pop, R&B', 'Swedia/Lebanon', 'assets/uploads/band_pict/maher_zain.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO42B6Fr'),
('A35', 'Harris J', 'Islamic Pop', 'Inggris', 'assets/uploads/band_pict/harris_j.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO31kKtP'),
('A36', 'King Nassar', 'Dangdut, Koplo', 'Indonesia', 'assets/uploads/band_pict/king_nassar.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO35este?si=WIW3AJb5T_SqUXhWZ4D19A'),
('A37', 'Efek Rumah Kaca', 'Alternative Rock, Indie', 'Indonesia', 'assets/uploads/band_pict/efek_rumah_kaca.webp', 'Grup Band (Alternative Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DXd7uITdhVZsf'),
('A38', 'Doel Sumbang', 'Pop Sunda', 'Indonesia', 'assets/uploads/band_pict/doel_sumbang.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO4ratTW'),
('A39', 'Rocket Rockers', 'Pop Punk', 'Indonesia', 'assets/uploads/band_pict/rocket_rockers.webp', 'Grup Band (Pop-Punk)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO1VxUYN'),
('A40', 'The Changcuters', 'Rock, Pop Rock', 'Indonesia', 'assets/uploads/band_pict/the_changcuters.webp', 'Grup Band (Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO0UTf44'),
('A41', 'Kunto Aji', 'Indie Folk, Pop', 'Indonesia', 'assets/uploads/band_pict/kunto_aji.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO4gDXyq'),
('A42', 'Sheila on 7', 'Pop Rock, Alternative', 'Indonesia', 'assets/uploads/band_pict/sheila_on_7.webp', 'Grup Band (Pop Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DXbA1Z3p2kzCF'),
('A43', 'Letto', 'Pop Rock', 'Indonesia', 'assets/uploads/band_pict/letto.webp', 'Grup Band (Pop Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO1rjmzS'),
('A44', 'The Rain', 'Pop, Ballad', 'Indonesia', 'assets/uploads/band_pict/the_rain.webp', 'Grup Band (Pop)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO4cGCQC?si=diEsd87WTxiQJ_2_2Q6RcA'),
('A45', 'Ungu', 'Pop Rock, Ballad', 'Indonesia', 'assets/uploads/band_pict/ungu.webp', 'Grup Band (Pop Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO2L2zRm'),
('A46', 'Kangen Band', 'Pop, Dangdut', 'Indonesia', 'assets/uploads/band_pict/kangen_band.webp', 'Grup Band (Pop)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO1yEbte'),
('A47', 'Wali', 'Pop, Dangdut', 'Indonesia', 'assets/uploads/band_pict/wali.webp', 'Grup Band (Pop)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO3bkykW?si=OERo8l9YT0iAG17LYLwxIw'),
('A48', 'ST12', 'Pop, Ballad', 'Indonesia', 'assets/uploads/band_pict/st12.webp', 'Grup Band (Pop)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO01ed2w'),
('A49', 'Hijau Daun', 'Pop Rock', 'Indonesia', 'assets/uploads/band_pict/hijau_daun.webp', 'Grup Band (Pop Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO4ecJ5m?si=HMHhf1HvQpyhmokzqOOBkQ'),
('A50', 'Via Vallen', 'Dangdut Koplo', 'Indonesia', 'assets/uploads/band_pict/via_vallen.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO3QfhmF?si=39xPQ5R6TM287z9lr0JEuA'),
('A51', 'Woro Widowati', 'Dangdut Koplo', 'Indonesia', 'assets/uploads/band_pict/woro_widowati.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO0eXPK9?si=8hZjFEuBT-KNfVadFEUgpQ'),
('A52', 'Clean Bandit', 'Electronic, Dance Pop', 'Inggris', 'assets/uploads/band_pict/clean_bandit.webp', 'Grup Band (Electronic)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO40D0nC'),
('A53', 'Rich Brian', 'Hip Hop, Rap', 'Indonesia', 'assets/uploads/band_pict/rich_brian.webp', 'Artis Solo (Rapper)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DX0eg5lGPtFS1'),
('A54', 'Soccer Mommy', 'Indie Rock, Alternative', 'AS', 'assets/uploads/band_pict/soccer_mommy.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO2EzOxj'),
('A55', 'Bernadya', 'Indie Pop, R&B', 'Indonesia', 'assets/uploads/band_pict/bernadya.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO2piv3d'),
('A56', 'Reality Club', 'Indie Pop, Alternative', 'Indonesia', 'assets/uploads/band_pict/reality_club.webp', 'Grup Band (Indie Pop)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO0UuuFd?si=QM7R-hO8QPqXWeIz45qo2Q'),
('A57', 'Maliq & D\'Essentials', 'Jazz, Soul, Funk', 'Indonesia', 'assets/uploads/band_pict/maliq_d_essentials.webp', 'Grup Band (Jazz/Soul)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DX8wKUKjIiKox'),
('A58', 'Nadin Amizah', 'Indie Pop, Folk', 'Indonesia', 'assets/uploads/band_pict/nadin_amizah.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO18tvRS'),
('A59', 'HIVI!', 'Pop', 'Indonesia', 'assets/uploads/band_pict/hivi.webp', 'Grup Band (Pop)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DXa7IFrriGfPG'),
('A60', 'Yovie & Nuno', 'Pop, Ballad', 'Indonesia', 'assets/uploads/band_pict/yovie_&_nuno.webp', 'Duo (Pop)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO27kxVv'),
('A61', 'The Panturas', 'Surf Rock, Indie', 'Indonesia', 'assets/uploads/band_pict/the_panturas.webp', 'Grup Band (Surf Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO0FmwQe'),
('A62', 'Lomba Sihir', 'Indie Pop, Alternative', 'Indonesia', 'assets/uploads/band_pict/lomba_sihir.webp', 'Grup Band (Indie Pop)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO0FmwQe'),
('A63', 'Playground', 'Indie Pop', 'Indonesia', 'assets/uploads/band_pict/playground.webp', 'Grup Band (Indie Pop)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO1rSHNG'),
('A64', 'Hasyakyla', 'Indie Pop', 'Indonesia', 'assets/uploads/band_pict/hasyakyla.webp', 'Artis Solo (Vokalis/Musisi)', NULL),
('A65', 'Rossa', 'Pop, Ballad', 'Indonesia', 'assets/uploads/band_pict/rossa.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DX1oaIzocvQlo'),
('A66', 'Barasuara', 'Alternative Rock, Progressive', 'Indonesia', 'assets/uploads/band_pict/barasuara.webp', 'Grup Band (Alternative Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO3s3w9b'),
('A67', 'Rizky Febian', 'Pop, R&B', 'Indonesia', 'assets/uploads/band_pict/rizky_febian.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO1dknZb'),
('A68', 'For Revenge', 'Indie Rock, Alternative', 'Indonesia', 'assets/uploads/band_pict/for_revenge.webp', 'Grup Band (Indie Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO04CiDT'),
('A69', 'Denny Caknan', 'Dangdut Koplo, Pop', 'Indonesia', 'assets/uploads/band_pict/denny_caknan.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO28Yz4s'),
('A70', 'Secondhand Serenade', 'Acoustic Pop, Emo', 'AS', 'assets/uploads/band_pict/secondhand_serenade.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO3G1r9L'),
('A71', 'ATEEZ', 'K-Pop, Hip Hop', 'Korea Selatan', 'assets/uploads/band_pict/ateez.webp', 'Grup Idola K-Pop', 'https://open.spotify.com/embed/playlist/37i9dQZF1DXdlpBrO6fF3s'),
('A72', 'TREASURE', 'K-Pop, Hip Hop', 'Korea Selatan', 'assets/uploads/band_pict/treasure.webp', 'Grup Idola K-Pop', 'https://open.spotify.com/embed/playlist/37i9dQZF1DWVoVEUmIsa1Y'),
('A73', 'Killswitch Engage', 'Metalcore', 'AS', 'assets/uploads/band_pict/killswitch_engage.webp', 'Grup Band (Metalcore)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO1NGngA?si=eqe3AadBRkixF82LIpFN7g'),
('A74', 'Honne', 'Electronic, R&B', 'Inggris', 'assets/uploads/band_pict/honne.webp', 'Duo (Electronic)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO0u8h0s'),
('A75', 'Juicy Luicy', 'Indie Pop', 'Indonesia', 'assets/uploads/band_pict/juicy_luicy.webp', 'Grup Band (Indie Pop)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO21mH97'),
('A76', 'Tulus', 'Pop, Jazz', 'Indonesia', 'assets/uploads/band_pict/tulus.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO1jm2Q1'),
('A77', 'Gigi', 'Rock, Pop Rock', 'Indonesia', 'assets/uploads/band_pict/gigi.webp', 'Grup Band (Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO1xEqNn'),
('A78', 'Lyodra', 'Pop, Soul', 'Indonesia', 'assets/uploads/band_pict/lyodra.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO449Cgi'),
('A79', 'Guyon Waton', 'Pop, Koplo', 'Indonesia', 'assets/uploads/band_pict/guyon_waton.webp', 'Grup Band (Pop)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO3jre7u?si=IyLeqipoRNmg3OPiWfRx0w'),
('A80', 'Fakedopp', 'Hip Hop, Rap', 'Indonesia', 'assets/uploads/band_pict/fakedopp.webp', 'Artis Solo (Rapper)', 'https://open.spotify.com/embed/playlist/37i9dQZF1EIYhqWea6iSgQ?si=yek9G3GUSQqv2FST2fU-Iw'),
('A81', 'Afgan', 'Pop, R&B', 'Indonesia', 'assets/uploads/band_pict/afgan.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DXbtm0qutWaYc'),
('A82', 'Vierratale', 'Pop Rock', 'Indonesia', 'assets/uploads/band_pict/vierratale.webp', 'Grup Band (Pop Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO16iLU8'),
('A83', 'Rebellion Rose', 'Punk Rock', 'Indonesia', 'assets/uploads/band_pict/rebellion_rose.webp', 'Grup Band (Punk Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO0hpCJY'),
('A84', 'Stand Here Alone', 'Ska Punk, Reggae', 'Indonesia', 'assets/uploads/band_pict/stand_here_alone.webp', 'Grup Band (Ska Punk)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO2jRn5G'),
('A85', 'Threesixty', 'Ska, Reggae', 'Indonesia', 'assets/uploads/band_pict/threesixty.webp', 'Grup Band (Ska)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO1nkYL5'),
('A86', 'Sukatani', 'Indie Rock', 'Indonesia', 'assets/uploads/band_pict/sukatani.webp', 'Grup Band (Indie Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1EIYMegH8g4xE0?si=D2peooRfSJmW_GrHRCgnKA'),
('A87', 'YUPS', 'Pop Punk', 'Indonesia', 'assets/uploads/band_pict/yups.webp', 'Grup Band (Pop-Punk)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO46A3UK'),
('A88', 'NDX AKA', 'Dangdut Koplo, Hip Hop', 'Indonesia', 'assets/uploads/band_pict/ndx_aka.webp', 'Grup Band (Dangdut Koplo)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO0XGKVr'),
('A89', 'Lavora', 'Dangdut', 'Indonesia', 'assets/uploads/band_pict/lavora.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO3H3MBo'),
('A90', 'Aftershine', 'Pop Rock', 'Indonesia', 'assets/uploads/band_pict/aftershine.webp', 'Grup Band (Pop Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO3FhN2p'),
('A91', 'Dinda Laras', 'Dangdut Koplo', 'Indonesia', 'assets/uploads/band_pict/dinda_laras.webp', 'Artis Solo (Vokalis/Musisi)', 'https://open.spotify.com/embed/playlist/37i9dQZF1EIYTBUxS8syQ6?si=KNRs1oyiTTWH3Vq_2BAMSw'),
('A92', 'The Adams', 'Pop Rock', 'Indonesia', 'assets/uploads/band_pict/the_adams.webp', 'Grup Band (Pop Rock)', 'https://open.spotify.com/embed/playlist/37i9dQZF1DZ06evO0gSCS9?si=x3nFwkO8Q7WRFrk2glBeMA');

-- --------------------------------------------------------

--
-- Struktur dari tabel `konser`
--

CREATE TABLE `konser` (
  `id_konser` varchar(10) NOT NULL,
  `nama_konser` varchar(255) NOT NULL,
  `id_venue` varchar(10) DEFAULT NULL,
  `tanggal_mulai` datetime DEFAULT NULL,
  `tanggal_selesai` datetime DEFAULT NULL,
  `harga_tiket_mulai` int(11) DEFAULT NULL,
  `link_tiket` varchar(255) DEFAULT NULL COMMENT 'Link ke website pembelian tiket',
  `poster_konser` varchar(255) DEFAULT NULL,
  `video` varchar(255) DEFAULT NULL COMMENT 'Path file video atau URL YouTube/Vimeo untuk aftermovie konser',
  `status_konser` enum('upcoming','ongoing','completed','cancelled') DEFAULT 'upcoming' COMMENT 'Status konser: upcoming=akan datang, ongoing=sedang berlangsung, completed=selesai, cancelled=dibatalkan'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `konser`
--

INSERT INTO `konser` (`id_konser`, `nama_konser`, `id_venue`, `tanggal_mulai`, `tanggal_selesai`, `harga_tiket_mulai`, `link_tiket`, `poster_konser`, `video`, `status_konser`) VALUES
('K001', 'BLACKPINK World Tour DEADLINE', 'V005', '2025-11-01 00:00:00', '2025-11-02 00:00:00', 2225000, NULL, 'assets/uploads/posters/k001.png', NULL, 'completed'),
('K002', 'Libera in Concert Jakarta', 'V013', '2025-11-01 00:00:00', '2025-11-01 00:00:00', 500000, NULL, 'assets/uploads/posters/k002.png', NULL, 'completed'),
('K003', 'THE BOYZ THE BLAZE World Tour', 'V001', '2025-11-08 00:00:00', '2025-11-08 00:00:00', 1200000, NULL, 'assets/uploads/posters/k003.png', NULL, 'completed'),
('K004', 'BSI Maher Zain Live in Concert', 'V006', '2025-11-09 00:00:00', '2025-11-09 00:00:00', 750000, NULL, 'assets/uploads/posters/k004.png', NULL, 'completed'),
('K005', 'West Java Festival 2025', 'V050', '2025-11-08 00:00:00', '2025-11-09 00:00:00', 200000, NULL, 'assets/uploads/posters/k005.png', NULL, 'completed'),
('K006', 'Remember November 2025', 'V014', '2025-11-22 00:00:00', '2025-11-23 00:00:00', 300000, NULL, 'assets/uploads/posters/k006.png', NULL, 'completed'),
('K007', 'KOPLING (Koplo Keliling) Jakarta', 'V012', '2025-11-08 00:00:00', '2025-11-09 00:00:00', 250000, NULL, 'assets/uploads/posters/k007.png', NULL, 'completed'),
('K008', 'Clean Bandit Live in Jakarta', 'V016', '2025-11-26 00:00:00', '2025-11-26 00:00:00', 1000000, 'https://www.cleanbanditindonesia.com/', 'assets/uploads/posters/k008.png', NULL, 'upcoming'),
('K009', 'Rich Brian Where Is My Head Tour', 'V015', '2025-11-29 00:00:00', '2025-11-29 00:00:00', 950000, 'https://www.loket.com/event/rich-brian-where-is-my-head-asian-tour_kTD4', 'assets/uploads/posters/k009.png', NULL, 'upcoming'),
('K010', 'Joyland Sessions 2025', 'V010', '2025-11-29 00:00:00', '2025-11-30 00:00:00', 500000, 'https://joylandfest.com/festival/joylandsessions/', 'assets/uploads/posters/k010.png', NULL, 'upcoming'),
('K011', 'Indonesia Hijabfest 2025 Butterfly Era', 'V022', '2025-11-01 00:00:00', '2025-11-01 00:00:00', 300000, NULL, 'assets/uploads/posters/k011.png', NULL, 'completed'),
('K013', 'Blazture 2025 Unpad', 'V024', '2025-11-15 00:00:00', '2025-11-15 00:00:00', 90000, NULL, 'assets/uploads/posters/k013.png', NULL, 'completed'),
('K014', 'Konser Rossa Amara Dansar', 'V020', '2025-11-15 00:00:00', '2025-11-15 00:00:00', 250000, NULL, 'assets/uploads/posters/k014.png', NULL, 'completed'),
('K016', 'Now Playing Festival Bandung 2025', 'V023', '2025-11-30 00:00:00', '2025-11-30 00:00:00', 150000, 'https://www.goersapp.com/events/now-playing-festival--nowplayingfestival', 'assets/uploads/posters/k016.png', NULL, 'upcoming'),
('K017', 'Secondhand Serenade Jakarta', 'V007', '2025-12-06 00:00:00', '2025-12-06 00:00:00', 335000, 'https://artatix.co.id/event/secondhand_serenade_awake_20_year_anniversary_jakarta', 'assets/uploads/posters/k017k020.png', NULL, 'upcoming'),
('K020', 'Secondhand Serenade Yogyakarta', 'V040', '2025-12-05 00:00:00', '2025-12-05 00:00:00', 335000, 'https://artatix.co.id/event/secondhand_serenade_20_year_awake_anniversary_yogyakarta', 'assets/uploads/posters/k017k020.png', NULL, 'upcoming'),
('K021', 'Djakarta Warehouse Project 2025', 'V047', '2025-12-12 00:00:00', '2025-12-14 00:00:00', 2500000, 'https://dwpfest.com/', 'assets/uploads/posters/k021.png', NULL, 'upcoming'),
('K022', 'RIIZE 2026 RIIZING LOUD Concert', 'V002', '2026-01-10 00:00:00', '2026-01-10 00:00:00', 1400000, 'https://riizeinjakarta.com/', 'assets/uploads/posters/k022.png', NULL, 'upcoming'),
('K023', 'ATEEZ 2026 World Tour In Your Fantasy', 'V009', '2026-01-31 00:00:00', '2026-01-31 00:00:00', 1500000, 'https://ateezinjakarta.com/', 'assets/uploads/posters/k023.png', NULL, 'upcoming'),
('K024', 'Dream Theater 40th Anniversary Tour', 'V008', '2026-02-07 00:00:00', '2026-02-07 00:00:00', 800000, 'https://dreamtheaterjakarta2026.com/', 'assets/uploads/posters/k024.png', NULL, 'upcoming'),
('K025', 'The 90s Intimate 2nd Edition Jakarta', 'V018', '2026-02-07 00:00:00', '2026-02-07 00:00:00', 1000000, 'https://www.the90sintimate.com/', 'assets/uploads/posters/k025k026.png', NULL, 'upcoming'),
('K026', 'The 90s Intimate 2nd Edition Solo', 'V030', '2026-02-08 00:00:00', '2026-02-08 00:00:00', 900000, 'https://www.the90sintimate.com/', 'assets/uploads/posters/k025k026.png', NULL, 'upcoming'),
('K027', 'aespa 2025-26 LIVE TOUR SYNK aeXIS LINE', 'V002', '2026-04-04 00:00:00', '2026-04-04 00:00:00', 1500000, 'https://dyandraglobal.com/id/event/2025-26-aespa-live-tour-synk-aexis-line-in-jakarta-2/', 'assets/uploads/posters/k027.png', NULL, 'upcoming'),
('K028', 'NCT WISH INTO THE WISH Concert', 'V001', '2026-04-11 00:00:00', '2026-04-11 00:00:00', 1300000, 'https://dyandraglobal.com/id/event/nct-wish-2/', 'assets/uploads/posters/k028.png', NULL, 'upcoming'),
('K029', 'Deep Purple & Slank All Greatest Hits', 'V009', '2026-04-18 00:00:00', '2026-04-18 00:00:00', 700000, 'https://deeppurplejakarta.com/', 'assets/uploads/posters/k029.png', NULL, 'upcoming'),
('K030', 'TREASURE 2025-26 TOUR PULSE ON', 'V009', '2026-04-25 00:00:00', '2026-04-26 00:00:00', 1400000, 'https://weverse.io/treasure/notice/31096', 'assets/uploads/posters/k030.png', NULL, 'upcoming'),
('K031', 'Hammersonic Festival 2026 Decade of Dominion', 'V004', '2026-05-02 00:00:00', '2026-05-03 00:00:00', 1200000, 'https://www.hammersonic.com/', 'assets/uploads/posters/k031.png', NULL, 'upcoming'),
('K032', 'ONE OK ROCK DETOX ASIA TOUR 2026', 'V015', '2026-05-16 00:00:00', '2026-05-16 00:00:00', 1200000, 'https://www.oneokrock.com/en/tour/', 'assets/uploads/posters/k032.png', NULL, 'upcoming'),
('K035', 'Sound of Downtown Festival Surabaya', 'V035', '2025-08-01 00:00:00', '2025-08-03 00:00:00', 125000, NULL, 'assets/uploads/posters/k035.png', NULL, 'completed'),
('K036', 'Disko Fest 2025 Surabaya', 'V035', '2025-09-11 00:00:00', '2025-09-14 00:00:00', 0, NULL, 'assets/uploads/posters/k036.png', NULL, 'completed'),
('K040', 'Preston Fest Riuh Riang Vol. 3', 'V038', '2025-10-18 00:00:00', '2025-10-18 00:00:00', 100000, NULL, 'assets/uploads/posters/k040.png', NULL, 'completed'),
('K041', 'Chierra Fest Malang', 'V037', '2025-10-19 00:00:00', '2025-10-19 00:00:00', 75000, NULL, 'assets/uploads/posters/k041.png', NULL, 'completed'),
('K042', 'Bela Negara Festival 2025', 'V005', '2025-11-16 00:00:00', '2025-11-16 00:00:00', 150000, NULL, 'assets/uploads/posters/k042.png', NULL, 'completed');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kota`
--

CREATE TABLE `kota` (
  `id_kota` varchar(10) NOT NULL,
  `nama_kota` varchar(255) NOT NULL,
  `id_provinsi` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kota`
--

INSERT INTO `kota` (`id_kota`, `nama_kota`, `id_provinsi`) VALUES
('C001', 'Tangerang', 'P001'),
('C002', 'Jakarta', 'P002'),
('C003', 'Bandung', 'P003'),
('C004', 'Semarang', 'P004'),
('C005', 'Solo', 'P004'),
('C006', 'Surabaya', 'P005'),
('C007', 'Malang', 'P005'),
('C008', 'Yogyakarta', 'P006'),
('C009', 'Denpasar', 'P007'),
('C010', 'Tabanan', 'P007');

-- --------------------------------------------------------

--
-- Struktur dari tabel `lineup`
--

CREATE TABLE `lineup` (
  `id_lineup` varchar(10) NOT NULL,
  `id_konser` varchar(10) NOT NULL,
  `id_artis` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `lineup`
--

INSERT INTO `lineup` (`id_lineup`, `id_konser`, `id_artis`) VALUES
('L001', 'K001', 'A31'),
('L002', 'K002', 'A32'),
('L003', 'K003', 'A33'),
('L004', 'K004', 'A34'),
('L005', 'K004', 'A35'),
('L006', 'K005', 'A36'),
('L007', 'K005', 'A37'),
('L008', 'K005', 'A38'),
('L009', 'K005', 'A39'),
('L010', 'K005', 'A40'),
('L011', 'K005', 'A41'),
('L012', 'K006', 'A42'),
('L013', 'K006', 'A43'),
('L014', 'K006', 'A44'),
('L015', 'K006', 'A45'),
('L016', 'K006', 'A46'),
('L017', 'K006', 'A47'),
('L018', 'K006', 'A48'),
('L019', 'K006', 'A49'),
('L020', 'K007', 'A50'),
('L021', 'K007', 'A51'),
('L022', 'K008', 'A52'),
('L023', 'K009', 'A53'),
('L025', 'K010', 'A04'),
('L024', 'K010', 'A05'),
('L026', 'K010', 'A54'),
('L027', 'K010', 'A55'),
('L028', 'K010', 'A56'),
('L029', 'K011', 'A57'),
('L030', 'K011', 'A58'),
('L031', 'K011', 'A59'),
('L032', 'K013', 'A60'),
('L033', 'K013', 'A61'),
('L034', 'K013', 'A62'),
('L035', 'K013', 'A63'),
('L036', 'K013', 'A64'),
('L037', 'K014', 'A65'),
('L041', 'K016', 'A55'),
('L039', 'K016', 'A57'),
('L038', 'K016', 'A66'),
('L040', 'K016', 'A67'),
('L042', 'K016', 'A68'),
('L043', 'K016', 'A69'),
('L044', 'K017', 'A70'),
('L045', 'K020', 'A70'),
('L046', 'K021', 'A07'),
('L048', 'K021', 'A08'),
('L049', 'K021', 'A09'),
('L047', 'K021', 'A11'),
('L050', 'K021', 'A12'),
('L051', 'K022', 'A13'),
('L052', 'K023', 'A71'),
('L053', 'K024', 'A16'),
('L054', 'K025', 'A17'),
('L056', 'K025', 'A18'),
('L055', 'K025', 'A19'),
('L057', 'K025', 'A20'),
('L058', 'K025', 'A21'),
('L059', 'K026', 'A17'),
('L061', 'K026', 'A18'),
('L060', 'K026', 'A19'),
('L062', 'K027', 'A22'),
('L063', 'K028', 'A29'),
('L064', 'K029', 'A23'),
('L065', 'K029', 'A24'),
('L066', 'K030', 'A72'),
('L067', 'K031', 'A25'),
('L068', 'K031', 'A26'),
('L069', 'K031', 'A27'),
('L070', 'K031', 'A73'),
('L071', 'K032', 'A28'),
('L076', 'K035', 'A36'),
('L074', 'K035', 'A55'),
('L077', 'K035', 'A62'),
('L072', 'K035', 'A74'),
('L073', 'K035', 'A75'),
('L075', 'K035', 'A76'),
('L084', 'K036', 'A40'),
('L085', 'K036', 'A59'),
('L078', 'K036', 'A77'),
('L079', 'K036', 'A78'),
('L080', 'K036', 'A79'),
('L081', 'K036', 'A80'),
('L082', 'K036', 'A81'),
('L083', 'K036', 'A82'),
('L086', 'K040', 'A83'),
('L087', 'K040', 'A84'),
('L088', 'K040', 'A85'),
('L089', 'K040', 'A86'),
('L090', 'K040', 'A87'),
('L091', 'K041', 'A88'),
('L092', 'K041', 'A89'),
('L093', 'K041', 'A90'),
('L094', 'K041', 'A91'),
('L096', 'K042', 'A59'),
('L099', 'K042', 'A62'),
('L098', 'K042', 'A68'),
('L095', 'K042', 'A76'),
('L097', 'K042', 'A92');

-- --------------------------------------------------------

--
-- Struktur dari tabel `log_aktivitas`
--

CREATE TABLE `log_aktivitas` (
  `id` int(11) NOT NULL,
  `admin_nama` varchar(100) NOT NULL,
  `aksi` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `log_aktivitas`
--

INSERT INTO `log_aktivitas` (`id`, `admin_nama`, `aksi`, `deskripsi`, `waktu`) VALUES
(1, 'Admin', 'EDIT USER', 'Edit user: AdminFo1 (U001)', '2025-11-25 06:35:21'),
(2, 'Admin', 'TAMBAH USER', 'Menambah User: AdminFo2 (U005)', '2025-11-25 06:36:13'),
(3, 'Admin', 'EDIT USER', 'Edit user: AdminFo2 (U005)', '2025-11-25 06:36:37'),
(4, 'Admin', 'HAPUS USER', 'Menghapus user: AdminFo2 (ID: U005)', '2025-11-25 06:36:44'),
(5, 'Admin', 'EDIT ARTIS', 'Edit Artis: BLACKPINK (A31)', '2025-11-25 07:32:44');

-- --------------------------------------------------------

--
-- Struktur dari tabel `provinsi`
--

CREATE TABLE `provinsi` (
  `id_provinsi` varchar(10) NOT NULL,
  `nama_provinsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `provinsi`
--

INSERT INTO `provinsi` (`id_provinsi`, `nama_provinsi`) VALUES
('P001', 'Banten'),
('P002', 'DKI Jakarta'),
('P003', 'Jawa Barat'),
('P004', 'Jawa Tengah'),
('P005', 'Jawa Timur'),
('P006', 'Daerah Istimewa Yogyakarta'),
('P007', 'Bali');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` varchar(10) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL COMMENT 'Password plain text untuk pembelajaran',
  `no_telepon` varchar(20) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `tanggal_daftar` timestamp NULL DEFAULT current_timestamp(),
  `status_akun` enum('active','inactive','suspended') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama_lengkap`, `email`, `password`, `no_telepon`, `role`, `tanggal_daftar`, `status_akun`) VALUES
('U001', 'AdminFo1', 'adminfo1@gmail.com', 'adminFo123', '081234567890', 'admin', '2025-11-12 01:50:50', 'active'),
('U002', 'Bahlil Santoso', 'bahlil@gmail.com', 'pertaminarugi', '081298765432', 'user', '2025-11-12 01:50:50', 'active'),
('U003', 'Puan Nurhaliza', 'puan@gmail.com', 'dprturu', '081234567891', 'user', '2025-11-12 01:50:50', 'active'),
('U004', 'Muhamad Atallah Alfa Dzaky', 'muhatallah2005@gmail.com', 'muhatallah', '08213578078', 'user', '2025-11-22 13:26:47', 'active');

-- --------------------------------------------------------

--
-- Struktur dari tabel `venue`
--

CREATE TABLE `venue` (
  `id_venue` varchar(10) NOT NULL,
  `nama_venue` varchar(255) NOT NULL,
  `alamat_lengkap` text DEFAULT NULL,
  `id_kota` varchar(10) NOT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `url_website` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `venue`
--

INSERT INTO `venue` (`id_venue`, `nama_venue`, `alamat_lengkap`, `id_kota`, `kapasitas`, `url_website`) VALUES
('V001', 'ICE BSD Hall 5', 'Jl. BSD Grand Boulevard, Pagedangan, Tangerang', 'C001', 10000, 'https://ice-indonesia.com'),
('V002', 'ICE BSD Hall 5-6', 'Jl. BSD Grand Boulevard, Pagedangan, Tangerang', 'C001', 12000, 'https://ice-indonesia.com'),
('V003', 'Uptown Park Summarecon Serpong', 'Jl. Gading Serpong Boulevard, Kelapa Dua, Tangerang', 'C001', 10000, 'https://summarecon.com'),
('V004', 'NICE PIK 2', 'Jl. Pantai Indah Kapuk, PIK 2, Jakarta Utara', 'C001', 25000, 'https://nicepik2.com'),
('V005', 'Stadium Utama Gelora Bung Karno', 'Jl. Pintu Satu Senayan, Jakarta Pusat', 'C002', 77193, 'https://gbk.id'),
('V006', 'Istora Senayan', 'Jl. Pintu Satu Senayan, Jakarta Pusat', 'C002', 7166, 'https://gbk.id'),
('V007', 'Tennis Indoor Senayan', 'Jl. Pintu Satu Senayan, Jakarta Pusat', 'C002', 7200, 'https://gbk.id'),
('V008', 'Stadion Madya GBK', 'Komplek GBK, Senayan, Jakarta Pusat', 'C002', 30000, 'https://gbk.id'),
('V009', 'Indonesia Arena GBK', 'Komplek GBK, Senayan, Jakarta Pusat', 'C002', 16500, 'https://gbk.id'),
('V010', 'GBK Baseball Stadium', 'Komplek GBK, Senayan, Jakarta Pusat', 'C002', 10000, 'https://gbk.id'),
('V011', 'GBK City Park Senayan', 'Komplek GBK, Senayan, Jakarta Pusat', 'C002', 5000, 'https://gbk.id'),
('V012', 'JIEXPO Kemayoran Hall C', 'Jl. Benyamin Sueb, Kemayoran, Jakarta Pusat', 'C002', 12000, 'https://jiexpo.com'),
('V013', 'JIEXPO Kemayoran Hall D', 'Jl. Benyamin Sueb, Kemayoran, Jakarta Pusat', 'C002', 15000, 'https://jiexpo.com'),
('V014', 'Gambir Expo Kemayoran', 'Jl. Benyamin Sueb, Kemayoran, Jakarta Pusat', 'C002', 20000, 'https://gambirexpo.com'),
('V015', 'Beach City International Stadium', 'Jl. Pantai Indah Utara, Ancol, Jakarta Utara', 'C002', 15000, 'https://beachcitystadium.com'),
('V016', 'Jakarta International Velodrome', 'Jl. Pemuda Rawamangun, Jakarta Timur', 'C002', 3500, 'https://www.jakartainternationalvelodrome.com'),
('V017', 'Balai Sarbini Plaza Semanggi', 'Plaza Semanggi, Jakarta Selatan', 'C002', 1300, 'https://balaisarbini.co.id/'),
('V018', 'The Kasablanka Hall', 'Kota Kasablanka Mall Lt.6, Jakarta Selatan', 'C002', 5500, 'https://kotakasablanka.com'),
('V019', 'Auditorium RRI Jakarta', 'Jl. Medan Merdeka Barat No.4-5, Jakarta Pusat', 'C002', 1500, 'https://rri.co.id'),
('V020', 'Eldorado Convention Hall', 'Jl. Dr. Setiabudhi No.438, Bandung', 'C003', 8000, 'https://eldorado.co.id'),
('V021', 'The Venue Concert Hall', 'Jl. Dr. Setiabudhi No.438, Bandung', 'C003', 3500, 'https://venueconcerthall.com'),
('V022', 'Sasana Budaya Ganesha (Sabuga ITB)', 'Jl. Tamansari No.73, Bandung', 'C003', 2500, 'https://itb.ac.id'),
('V023', 'Trans Studio Bandung', 'Jl. Gatot Subroto No.289, Bandung', 'C003', 5000, 'https://tsbdg.com'),
('V024', 'Lapangan PPI Pussenif Bandung', 'Jl. Kompol R. Soekanto, Bandung', 'C003', 15000, 'Unknown'),
('V025', 'Radjawali Semarang Cultural Center', 'Jl. Kelud Raya No.2, Semarang', 'C004', 1000, 'https://radjawaliscc.co.id'),
('V026', 'UTC Convention Hall Semarang', 'Jl. Kelud Raya No.2, Semarang', 'C004', 5000, 'https://utc-semarang.com'),
('V027', 'Stadion Diponegoro Semarang', 'Jl. Simongan No.129, Semarang', 'C004', 20000, 'https://ppid.semarangkota.go.id'),
('V028', 'Citra Grand Ballroom Semarang', 'Jl. Kompol R. Soekanto, Sambiroto, Semarang', 'C004', 3000, 'https://citragrand-semarang.com'),
('V029', 'Kelenteng Sam Poo Kong', 'Jl. Simongan No.129, Semarang', 'C004', 5000, 'https://sampookong.co.id'),
('V030', 'Edutorium UMS Solo', 'Jl. Ahmad Yani, Pabelan, Kartasura, Sukoharjo', 'C005', 3000, 'https://ums.ac.id'),
('V031', 'Solo Paragon Ballroom', 'Jl. Yosodipuro No.133, Solo', 'C005', 2000, 'https://www.soloparagonhotel.com'),
('V032', 'Stadion Manahan Solo', 'Jl. Jend. Ahmad Yani, Solo', 'C005', 20000, 'https://www.instagram.com/manahan.solo/'),
('V033', 'Grand City Convention Hall', 'Jl. Gubeng Pojok No.1, Surabaya', 'C006', 5000, 'https://grandcitysurabaya.com'),
('V034', 'JX International Surabaya', 'Jl. Gubeng Pojok, Surabaya', 'C006', 10000, 'https://jxinternational.com'),
('V035', 'Jatim Expo', 'Jl. Gubernur Suryo, Surabaya', 'C006', 15000, 'https://jatimexpo.com'),
('V036', 'Stadion Gelora Bung Tomo', 'Jl. Tambak Segaran Wetan, Surabaya', 'C006', 30000, 'https://www.instagram.com/disbudporaparsby/'),
('V037', 'Graha Cakrawala Universitas Negeri Malang', 'Jl. Semarang No.5, Malang', 'C007', 2500, 'https://um.ac.id'),
('V038', 'Dome Universitas Brawijaya', 'Jl. Veteran, Malang', 'C007', 3000, 'https://ub.ac.id'),
('V039', 'Stadion Gajayana Malang', 'Jl. Tenes No.1, Malang', 'C007', 25000, 'https://disporapar.malangkota.go.id/'),
('V040', 'GOR UNY Yogyakarta', 'Jl. Colombo No.1, Yogyakarta', 'C008', 5000, 'https://uny.ac.id'),
('V041', 'Jogja Expo Center (JEC)', 'Jl. Janti, Banguntapan, Bantul, Yogyakarta', 'C008', 10000, 'https://jogjaexpocenter.com'),
('V042', 'Auditorium Universitas Gadjah Mada', 'Jl. Bulaksumur, Yogyakarta', 'C008', 2000, 'https://ugm.ac.id'),
('V043', 'Stadion Mandala Krida', 'Jl. Kenari No.6, Semaki, Kec. Umbulharjo, Kota Yogyakarta, Daerah Istimewa Yogyakarta 55166', 'C008', 30000, 'https://www.instagram.com/mandala_krida/'),
('V044', 'Bali Nusa Dua Convention Center', 'Kawasan Pariwisata Nusa Dua, Badung, Bali', 'C009', 5000, 'https://bndcc.com'),
('V045', 'Trans Studio Bali', 'Jl. Imam Bonjol, Denpasar, Bali', 'C009', 3000, 'https://tsbali.com'),
('V046', 'Savaya Bali', 'Jl. Belimbing Sari, Ungasan, Bali', 'C009', 2000, 'https://savayabali.com'),
('V047', 'GWK Cultural Park', 'Jl. Raya Uluwatu, Ungasan, Badung, Bali', 'C010', 70000, 'https://gwkbali.com'),
('V048', 'Nuanu Creative City Tabanan', 'Jl. Raya Baturiti, Tabanan, Bali', 'C010', 5000, 'https://nuanu.id'),
('V049', 'Pura Tanah Lot Area', 'Beraban, Tabanan, Bali', 'C010', 10000, 'https://www.instagram.com/tanahlotid/'),
('V050', 'Kiara Artha Park, Bandung', 'Jl. Banten, Kebonwaru, Kec. Batununggal, Kota Bandung, Jawa Barat', 'C003', 15000, 'https://www.instagram.com/kiaraarthapark/');

-- --------------------------------------------------------

--
-- Struktur dari tabel `wishlist`
--

CREATE TABLE `wishlist` (
  `id_wishlist` varchar(10) NOT NULL,
  `id_user` varchar(10) NOT NULL,
  `id_konser` varchar(10) NOT NULL,
  `tanggal_ditambahkan` timestamp NULL DEFAULT current_timestamp() COMMENT 'Tanggal user menambahkan konser ke wishlist'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `wishlist`
--

INSERT INTO `wishlist` (`id_wishlist`, `id_user`, `id_konser`, `tanggal_ditambahkan`) VALUES
('W002', 'U003', 'K009', '2025-11-24 11:58:10');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `artis`
--
ALTER TABLE `artis`
  ADD PRIMARY KEY (`id_artis`);

--
-- Indeks untuk tabel `konser`
--
ALTER TABLE `konser`
  ADD PRIMARY KEY (`id_konser`),
  ADD KEY `idx_id_venue` (`id_venue`);

--
-- Indeks untuk tabel `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id_kota`),
  ADD KEY `idx_id_provinsi` (`id_provinsi`);

--
-- Indeks untuk tabel `lineup`
--
ALTER TABLE `lineup`
  ADD PRIMARY KEY (`id_lineup`),
  ADD UNIQUE KEY `uq_konser_artis` (`id_konser`,`id_artis`),
  ADD KEY `idx_id_konser` (`id_konser`),
  ADD KEY `idx_id_artis` (`id_artis`);

--
-- Indeks untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id_provinsi`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `uq_email` (`email`),
  ADD KEY `idx_role` (`role`),
  ADD KEY `idx_email` (`email`);

--
-- Indeks untuk tabel `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`id_venue`),
  ADD KEY `idx_id_kota` (`id_kota`);

--
-- Indeks untuk tabel `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id_wishlist`),
  ADD UNIQUE KEY `uq_user_konser` (`id_user`,`id_konser`) COMMENT 'Satu user tidak bisa wishlist konser yang sama 2x',
  ADD KEY `idx_id_user` (`id_user`),
  ADD KEY `idx_id_konser` (`id_konser`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `log_aktivitas`
--
ALTER TABLE `log_aktivitas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `konser`
--
ALTER TABLE `konser`
  ADD CONSTRAINT `Konser_ibfk_1_new` FOREIGN KEY (`id_venue`) REFERENCES `venue` (`id_venue`);

--
-- Ketidakleluasaan untuk tabel `kota`
--
ALTER TABLE `kota`
  ADD CONSTRAINT `Kota_ibfk_1_new` FOREIGN KEY (`id_provinsi`) REFERENCES `provinsi` (`id_provinsi`);

--
-- Ketidakleluasaan untuk tabel `lineup`
--
ALTER TABLE `lineup`
  ADD CONSTRAINT `Lineup_ibfk_1_new` FOREIGN KEY (`id_konser`) REFERENCES `konser` (`id_konser`),
  ADD CONSTRAINT `Lineup_ibfk_2_new` FOREIGN KEY (`id_artis`) REFERENCES `artis` (`id_artis`);

--
-- Ketidakleluasaan untuk tabel `venue`
--
ALTER TABLE `venue`
  ADD CONSTRAINT `Venue_ibfk_1_new` FOREIGN KEY (`id_kota`) REFERENCES `kota` (`id_kota`);

--
-- Ketidakleluasaan untuk tabel `wishlist`
--
ALTER TABLE `wishlist`
  ADD CONSTRAINT `Wishlist_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Wishlist_ibfk_2` FOREIGN KEY (`id_konser`) REFERENCES `konser` (`id_konser`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
