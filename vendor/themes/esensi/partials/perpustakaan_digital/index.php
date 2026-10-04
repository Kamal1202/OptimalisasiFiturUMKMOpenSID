<style>
.perpus-digital {
    padding: 10px 0 25px;
}

.perpus-hero {
    background: linear-gradient(135deg, #0288a7, #00a6bd);
    color: #fff;
    border-radius: 10px;
    padding: 28px;
    margin-bottom: 20px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.10);
}

.perpus-hero h1 {
    margin: 0 0 10px;
    font-size: 30px;
    font-weight: 700;
}

.perpus-hero p {
    max-width: 1500px;
    font-size: 15px;
    line-height: 1.7;
    margin-top: 18px;
    margin-bottom: 18px;
    text-align: justify;
}

.perpus-btn {
    display: inline-block;
    border-radius: 5px;
    padding: 9px 15px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none !important;
    margin-right: 8px;
    margin-bottom: 8px;
    transition: all .2s ease;
}

.perpus-btn-primary {
    color: #fff !important;
    background: #D08E0D;
    border: 1px solid #D08E0D;
}

.perpus-btn-primary:hover,
.perpus-btn-primary:focus {
    color: #fff !important;
    background: #a56f03;
    border-color: #a56f03;
}

.perpus-btn-light {
    color: #0288a7 !important;
    background: #fff;
    border: 1px solid #d7edf2;
}

.perpus-btn-light:hover,
.perpus-btn-light:focus {
    color: #006f8a !important;
    background: #eefaff;
}

.perpus-tabs {
    display: flex;
    flex-wrap: wrap;
    border-bottom: 1px solid #ddd;
    margin-bottom: 18px;
    gap: 6px;
}

.perpus-tab-btn {
    border: 0;
    background: #f5f5f5;
    color: #333;
    padding: 10px 14px;
    border-radius: 5px 5px 0 0;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all .2s ease;
}

.perpus-tab-btn:hover {
    background: #e8f8fb;
    color: #00728f;
}

.perpus-tab-btn.active {
    background: #0288a7;
    color: #fff;
}

.perpus-tab-content {
    display: none;
}

.perpus-tab-content.active {
    display: block;
}

.perpus-section {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 18px;
}

.perpus-section h2 {
    margin-top: 0;
    margin-bottom: 12px;
    font-size: 22px;
    font-weight: 700;
    color: #333;
}

.perpus-section p {
    color: #555;
    line-height: 1.7;
    font-size: 14px;
    text-align: justify;
}

.perpus-benefit-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
    margin-top: 16px;
}

.perpus-benefit-card {
    background: #f3fbfd;
    border: 1px solid #d7edf2;
    border-radius: 10px;
    padding: 16px;
}

.perpus-benefit-card i {
    font-size: 24px;
    color: #0288a7;
    margin-bottom: 8px;
}

.perpus-benefit-card h3 {
    margin: 0 0 6px;
    font-size: 15px;
    font-weight: 700;
}

.perpus-benefit-card p {
    margin: 0;
    font-size: 13px;
}

.perpus-book-toolbar {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 18px;
    flex-wrap: wrap;
}

.perpus-search-wrap {
    flex: 1 1 320px;
    max-width: 430px;
}

.perpus-search {
    width: 100%;
    border: 1px solid #d9d9d9;
    border-radius: 6px;
    padding: 9px 11px;
    font-size: 13px;
    height: 38px;
}

.perpus-book-actions {
    display: flex;
    align-items: center;
    gap: 8px;
}

.perpus-book-actions .perpus-btn {
    height: 38px;
    line-height: 18px;
    margin: 0;
    padding: 9px 14px;
}

.perpus-book-count {
    margin-left: auto;
    font-size: 13px;
    color: #444;
    white-space: nowrap;
}

.perpus-book-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.perpus-book-card {
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    padding: 14px;
    background: #fff;
    display: flex;
    flex-direction: column;
    min-height: 310px;
    transition: all .2s ease;
}

.perpus-book-card:hover {
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.08);
    transform: translateY(-2px);
}

.perpus-book-cover {
    height: 112px;
    border-radius: 8px;
    background: linear-gradient(135deg, #e9f8fb, #f5fcfd);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 12px;
    overflow: hidden;
}

.perpus-book-cover i {
    font-size: 42px;
    color: #0288a7;
}

.perpus-book-cover img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    border-radius: 8px;
    background: #f5fcfd;
}

.perpus-book-cover .cover-fallback {
    width: 100%;
    height: 100%;
    display: none;
    align-items: center;
    justify-content: center;
}

.perpus-book-card h3 {
    font-size: 15px;
    font-weight: 700;
    line-height: 1.35;
    margin: 0 0 8px;
    color: #222;
}

.perpus-book-meta {
    font-size: 12px;
    color: #777;
    margin-bottom: 8px;
}

.perpus-book-category {
    display: inline-block;
    background: #e8f8fb;
    color: #00728f;
    border-radius: 20px;
    padding: 4px 8px;
    font-size: 11px;
    font-weight: 600;
    margin-bottom: 8px;
}

.perpus-book-desc {
    font-size: 12px;
    color: #555;
    line-height: 1.55;
    flex: 1;
    margin-bottom: 12px;
}

.perpus-book-card .perpus-btn {
    text-align: center;
    margin: 0;
}

.perpus-pagination {
    margin-top: 20px;
    text-align: center;
}

.perpus-pagination a {
    display: inline-block;
    padding: 7px 11px;
    margin: 2px;
    border: 1px solid #ddd;
    border-radius: 5px;
    color: #0288a7;
    background: #fff;
    text-decoration: none !important;
    font-size: 13px;
}

.perpus-pagination a.active,
.perpus-pagination a:hover {
    background: #0288a7;
    color: #fff;
    border-color: #0288a7;
}

.perpus-steps {
    counter-reset: step;
    margin: 18px 0 0;
    padding: 0;
    list-style: none;
}

.perpus-steps li {
    position: relative;
    padding: 0 0 18px 48px;
    min-height: 42px;
}

.perpus-steps li:before {
    counter-increment: step;
    content: counter(step);
    position: absolute;
    left: 0;
    top: 0;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: #0288a7;
    color: #fff;
    text-align: center;
    line-height: 32px;
    font-weight: 700;
}

.perpus-steps strong {
    display: block;
    color: #333;
    margin-bottom: 3px;
}

.perpus-steps span {
    color: #666;
    font-size: 13px;
    line-height: 1.6;
}

.perpus-book-actions {
    display: flex;
    gap: 8px;
    margin-top: 10px;
}

.perpus-book-actions .perpus-btn {
    flex: 1;
    text-align: center;
    margin: 0;
    padding-left: 8px;
    padding-right: 8px;
}

@media (max-width: 991px) {
    .perpus-book-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .perpus-benefit-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 767px) {
    .perpus-search-wrap {
        max-width: none;
        flex-basis: 100%;
    }

    .perpus-book-actions {
        width: 100%;
    }

    .perpus-book-count {
        margin-left: 0;
        width: 100%;
    }
}

@media (max-width: 575px) {
    .perpus-hero {
        padding: 20px;
    }

    .perpus-hero h1 {
        font-size: 24px;
    }

    .perpus-book-grid,
    .perpus-benefit-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
    $active_tab = $active_tab ?? 'perpus';
    $base_url   = site_url('perpustakaan-digital');
?>

<div class="perpus-digital">
    <div class="perpus-hero">
        <h1>Perpustakaan Digital</h1>
        <p>
            Perpustakaan Digital Desa Kondangjaya merupakan layanan informasi dan akses bacaan digital
            untuk mendukung budaya literasi masyarakat. Melalui halaman ini, warga dapat mengenal layanan
            SI KANCIL, melihat koleksi buku digital, dan mengikuti panduan penggunaan aplikasi.
        </p>

        <a href="<?= html_escape($link_sikancil) ?>" target="_blank" rel="noopener"
            class="perpus-btn perpus-btn-primary">
            <i class="fa fa-android"></i> Unduh SI KANCIL
        </a>
    </div>

    <div class="perpus-tabs">
        <button type="button" class="perpus-tab-btn <?= $active_tab === 'perpus' ? 'active' : '' ?>"
            onclick="openPerpusTab(event, 'tab-perpus')">
            <i class="fa fa-university"></i> Perpustakaan Digital
        </button>

        <button type="button" class="perpus-tab-btn <?= $active_tab === 'koleksi' ? 'active' : '' ?>"
            onclick="openPerpusTab(event, 'tab-koleksi')">
            <i class="fa fa-book"></i> Koleksi Buku Digital
        </button>

        <button type="button" class="perpus-tab-btn <?= $active_tab === 'panduan' ? 'active' : '' ?>"
            onclick="openPerpusTab(event, 'tab-panduan')">
            <i class="fa fa-list-ol"></i> Panduan SI KANCIL
        </button>
    </div>

    <div id="tab-perpus" class="perpus-tab-content <?= $active_tab === 'perpus' ? 'active' : '' ?>">
        <div class="perpus-section">
            <h2>Tentang Perpustakaan Digital</h2>
            <p>
                Perpustakaan Digital menjadi ruang informasi bagi warga untuk memperoleh akses bacaan
                yang lebih mudah dan praktis. Layanan ini mendukung kebutuhan belajar pelajar, pelaku UMKM,
                keluarga, dan masyarakat umum melalui bahan bacaan digital yang dapat diakses dari perangkat
                masing-masing. Halaman ini juga menghubungkan warga dengan aplikasi SI KANCIL serta menyediakan pilihan
                koleksi buku digital yang dapat dibaca secara daring.
            </p>

            <div class="perpus-benefit-grid">
                <div class="perpus-benefit-card">
                    <i class="fa fa-book"></i>
                    <h3>Akses Bacaan Digital</h3>
                    <p>Warga dapat menemukan bahan bacaan edukatif, cerita anak, UMKM, dan keamanan digital.</p>
                </div>

                <div class="perpus-benefit-card">
                    <i class="fa fa-mobile"></i>
                    <h3>Praktis Digunakan</h3>
                    <p>Bacaan dan aplikasi dapat diakses melalui perangkat pribadi sesuai kebutuhan pengguna.</p>
                </div>

                <div class="perpus-benefit-card">
                    <i class="fa fa-users"></i>
                    <h3>Dukung Literasi Desa</h3>
                    <p>Layanan ini diharapkan membantu meningkatkan minat baca dan literasi digital masyarakat.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="tab-koleksi" class="perpus-tab-content <?= $active_tab === 'koleksi' ? 'active' : '' ?>">
        <div class="perpus-section">
            <h2>Koleksi Buku Digital</h2>
            <p>
                Berikut adalah koleksi buku digital yang dapat dibaca secara daring.
                Gunakan kolom pencarian untuk mencari judul, kategori, penulis, atau penerbit.
            </p>

            <form method="get" action="<?= $base_url ?>" class="perpus-book-toolbar">
                <input type="hidden" name="tab" value="koleksi">

                <div class="perpus-search-wrap">
                    <input type="text" name="keyword" class="perpus-search" value="<?= html_escape($keyword ?? '') ?>"
                        placeholder="Cari judul, kategori, penulis, atau penerbit...">
                </div>

                <div class="perpus-book-actions">
                    <button type="submit" class="perpus-btn perpus-btn-primary">
                        <i class="fa fa-search"></i> Cari
                    </button>

                    <?php if (! empty($keyword)) : ?>
                    <a href="<?= $base_url . '?tab=koleksi' ?>" class="perpus-btn perpus-btn-light">
                        Reset
                    </a>
                    <?php endif; ?>
                </div>

                <div class="perpus-book-count">
                    <?= (int) ($total_buku ?? 0) ?> koleksi buku tersedia
                </div>
            </form>

            <?php if (empty($koleksi_buku)) : ?>
            <div class="alert alert-warning">
                Koleksi buku tidak ditemukan.
            </div>
            <?php else : ?>
            <div class="perpus-book-grid">
                <?php foreach ($koleksi_buku as $buku) : ?>
                <?php
                            $meta = [];

                            if (! empty($buku->penulis)) {
                                $meta[] = 'Penulis: ' . $buku->penulis;
                            }

                            if (! empty($buku->penerbit)) {
                                $meta[] = 'Penerbit: ' . $buku->penerbit;
                            }

                            if (! empty($buku->kontributor)) {
                                $meta[] = 'Kontributor: ' . $buku->kontributor;
                            }
                        ?>

                <div class="perpus-book-card">
                    <div class="perpus-book-cover">
                        <?php if (! empty($buku->cover_url)) : ?>
                        <img src="<?= html_escape($buku->cover_url) ?>" alt="<?= html_escape($buku->judul) ?>"
                            onerror="this.style.display='none'; this.parentNode.querySelector('.cover-fallback').style.display='flex';">

                        <div class="cover-fallback">
                            <i class="fa fa-book"></i>
                        </div>
                        <?php else : ?>
                        <div class="cover-fallback" style="display:flex;">
                            <i class="fa fa-book"></i>
                        </div>
                        <?php endif; ?>
                    </div>

                    <?php if (! empty($buku->kategori)) : ?>
                    <span class="perpus-book-category">
                        <?= html_escape($buku->kategori) ?>
                    </span>
                    <?php endif; ?>

                    <h3><?= html_escape($buku->judul) ?></h3>

                    <?php if (! empty($meta)) : ?>
                    <div class="perpus-book-meta">
                        <?= html_escape(implode(' | ', $meta)) ?>
                    </div>
                    <?php endif; ?>

                    <div class="perpus-book-desc">
                        <?= html_escape(mb_strimwidth($buku->deskripsi, 0, 180, '...')) ?>
                    </div>

                    <div class="perpus-book-actions">
                        <a href="<?= html_escape($buku->detail_url) ?>" class="perpus-btn perpus-btn-light">
                            <i class="fa fa-info-circle"></i> Detail
                        </a>

                        <a href="<?= html_escape($buku->baca_url) ?>" class="perpus-btn perpus-btn-primary">
                            <i class="fa fa-book"></i> Baca Buku
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (($total_page ?? 0) > 1) : ?>
            <div class="perpus-pagination">
                <?php if ($page > 1) : ?>
                <a
                    href="<?= $base_url . '?tab=koleksi&page=' . ($page - 1) . '&keyword=' . urlencode($keyword ?? '') ?>">
                    &laquo; Sebelumnya
                </a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_page; $i++) : ?>
                <a class="<?= $i == $page ? 'active' : '' ?>"
                    href="<?= $base_url . '?tab=koleksi&page=' . $i . '&keyword=' . urlencode($keyword ?? '') ?>">
                    <?= $i ?>
                </a>
                <?php endfor; ?>

                <?php if ($page < $total_page) : ?>
                <a
                    href="<?= $base_url . '?tab=koleksi&page=' . ($page + 1) . '&keyword=' . urlencode($keyword ?? '') ?>">
                    Berikutnya &raquo;
                </a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div id="tab-panduan" class="perpus-tab-content <?= $active_tab === 'panduan' ? 'active' : '' ?>">
        <div class="perpus-section">
            <h2>Panduan Menggunakan SI KANCIL</h2>
            <p>
                SI KANCIL dapat digunakan warga untuk mengakses layanan bacaan digital melalui perangkat Android.
                Ikuti langkah berikut untuk mulai menggunakan layanan.
            </p>

            <ol class="perpus-steps">
                <li>
                    <strong>Klik tombol Unduh SI KANCIL</strong>
                    <span>Tekan tombol yang tersedia pada halaman ini untuk membuka aplikasi SI KANCIL di Play
                        Store.</span>
                </li>
                <li>
                    <strong>Instal aplikasi</strong>
                    <span>Unduh dan pasang aplikasi SI KANCIL pada perangkat Android yang digunakan.</span>
                </li>
                <li>
                    <strong>Buka aplikasi</strong>
                    <span>Jalankan aplikasi SI KANCIL dan ikuti arahan yang muncul pada layar.</span>
                </li>
                <li>
                    <strong>Login atau daftar akun</strong>
                    <span>Jika aplikasi meminta akun, ikuti proses login atau pendaftaran sesuai petunjuk.</span>
                </li>
                <li>
                    <strong>Cari buku yang ingin dibaca</strong>
                    <span>Gunakan fitur pencarian atau kategori untuk menemukan buku digital yang sesuai
                        kebutuhan.</span>
                </li>
                <li>
                    <strong>Mulai membaca</strong>
                    <span>Pilih buku yang diinginkan dan mulai membaca melalui perangkat masing-masing.</span>
                </li>
            </ol>

            <a href="<?= html_escape($link_sikancil) ?>" target="_blank" rel="noopener"
                class="perpus-btn perpus-btn-primary">
                <i class="fa fa-android"></i> Unduh SI KANCIL
            </a>
        </div>
    </div>
</div>

<script>
function openPerpusTab(event, tabId) {
    if (event) {
        event.preventDefault();
    }

    var contents = document.querySelectorAll('.perpus-tab-content');
    var buttons = document.querySelectorAll('.perpus-tab-btn');

    for (var i = 0; i < contents.length; i++) {
        contents[i].classList.remove('active');
    }

    for (var j = 0; j < buttons.length; j++) {
        buttons[j].classList.remove('active');
    }

    var target = document.getElementById(tabId);

    if (target) {
        target.classList.add('active');
    }

    if (event && event.currentTarget) {
        event.currentTarget.classList.add('active');
    }
}
</script>