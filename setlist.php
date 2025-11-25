<!-- SETLIST SECTION -->
        <?php if ($has_setlist): ?>
            <section class="setlist-section">
                <div class="container">
                    <h2>🎵 Setlist</h2>

                    <?php if (!$is_logged_in): ?>
                        <!-- BELUM LOGIN: Tampilkan daftar lagu tapi tanpa player -->
                        <div class="alert alert-warning">
                            <i class="fas fa-lock"></i>
                            <strong>Login untuk mendengarkan preview musik</strong>
                            <a href="login.php" class="btn btn-sm btn-primary">Login Sekarang</a>
                        </div>

                        <div class="setlist-locked">
                            <?php
                            mysqli_data_seek($result_setlist, 0); // Reset pointer
                            while ($song = mysqli_fetch_assoc($result_setlist)):
                            ?>
                                <div class="song-item locked">
                                    <div class="song-info">
                                        <span class="song-number"><?= $song['urutan'] ?>.</span>
                                        <span class="song-title"><?= htmlspecialchars($song['judul_lagu']) ?></span>
                                        <span class="song-artist"><?= htmlspecialchars($song['nama_artis']) ?></span>
                                        <span class="song-duration"><?= $song['durasi'] ?></span>
                                    </div>
                                    <div class="song-lock">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>

                    <?php else: ?>
                        <!-- SUDAH LOGIN: Tampilkan dengan audio player -->
                        <div class="setlist-unlocked">
                            <?php
                            mysqli_data_seek($result_setlist, 0); // Reset pointer
                            while ($song = mysqli_fetch_assoc($result_setlist)):
                            ?>
                                <div class="song-item">
                                    <div class="song-info">
                                        <span class="song-number"><?= $song['urutan'] ?>.</span>
                                        <span class="song-title"><?= htmlspecialchars($song['judul_lagu']) ?></span>
                                        <span class="song-artist"><?= htmlspecialchars($song['nama_artis']) ?></span>
                                        <span class="song-duration"><?= $song['durasi'] ?></span>
                                    </div>

                                    <?php if (!empty($song['audio_file'])): ?>
                                        <div class="song-player">
                                            <?php
                                            // Render audio player berdasarkan tipe link
                                            $audio_url = $song['audio_file'];

                                            if (strpos($audio_url, 'spotify.com') !== false) {
                                                // Spotify Embed
                                                $embed_url = str_replace('/track/', '/embed/track/', $audio_url);
                                                echo '<iframe src="' . $embed_url . '" width="100%" height="80" frameborder="0" allowtransparency="true" allow="encrypted-media"></iframe>';
                                            } elseif (strpos($audio_url, 'youtube.com') !== false || strpos($audio_url, 'youtu.be') !== false) {
                                                // YouTube Embed
                                                echo '<iframe width="100%" height="200" src="' . $audio_url . '" frameborder="0" allowfullscreen></iframe>';
                                            } else {
                                                // File lokal (MP3)
                                                echo '<audio controls style="width:100%">
                                        <source src="' . $audio_url . '" type="audio/mpeg">
                                        Browser tidak support audio.
                                      </audio>';
                                            }
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>