<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
.perpus-detail {
    padding: 10px 0 25px;
}

.perpus-detail-card {
    background: #fff;
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    padding: 20px;
}

.perpus-detail-grid {
    display: grid;
    grid-template-columns: 320px 1fr;
    gap: 24px;
    align-items: start;
}

.perpus-detail-cover {
    width: 100%;
    height: 430px;
    background: #e9f8fb;
    border-radius: 10px;
    border: 1px solid #d7edf2;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.perpus-detail-cover img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    background: #f5fcfd;
}

.perpus-detail-cover i {
    font-size: 82px;
    color: #0288a7;
}

.perpus-detail-category {
    display: inline-block;
    background: #e8f8fb;
    color: #00728f;
    border-radius: 20px;
    padding: 5px 10px;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 12px;
}

.perpus-detail-title {
    font-size: 30px;
    font-weight: 800;
    line-height: 1.3;
    margin: 0 0 14px;
    color: #222;
}

.perpus-detail-meta {
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
    padding: 12px 0;
    margin: 14px 0;
    font-size: 14px;
    color: #555;
}

.perpus-detail-meta div {
    margin-bottom: 5px;
}

.perpus-detail-desc {
    font-size: 14px;
    line-height: 1.75;
    color: #555;
    margin-bottom: 18px;
}

.perpus-detail-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.perpus-btn {
    display: inline-block;
    border-radius: 5px;
    padding: 9px 15px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none !important;
}

.perpus-btn-primary {
    color: #fff !important;
    background: #0288a7;
    border: 1px solid #0288a7;
}

.perpus-btn-light {
    color: #0288a7 !important;
    background: #fff;
    border: 1px solid #d7edf2;
}

.perpus-related-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-top: 16px;
}

.perpus-related-card {
    border: 1px solid #e5e5e5;
    border-radius: 10px;
    padding: 12px;
    background: #fff;
}

.perpus-related-cover {
    height: 150px;
    border-radius: 8px;
    background: #e9f8fb;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin-bottom: 10px;
}

.perpus-related-cover img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.perpus-related-cover i {
    font-size: 38px;
    color: #0288a7;
}

.perpus-related-title {
    font-size: 14px;
    font-weight: 700;
    line-height: 1.35;
    margin-bottom: 8px;
    color: #222;
}

@media (max-width: 991px) {
    .perpus-detail-grid {
        grid-template-columns: 1fr;
    }

    .perpus-detail-cover {
        height: 360px;
    }

    .perpus-related-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 575px) {
    .perpus-related-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="perpus-detail">
    <div style="margin-bottom: 15px;">
        <a href="<?= site_url('perpustakaan-digital?tab=koleksi') ?>" class="perpus-btn perpus-btn-light">
            <i class="fa fa-arrow-left"></i> Kembali ke Koleksi
        </a>
    </div>

    <div class="perpus-detail-card">
        <div class="perpus-detail-grid">
            <div class="perpus-detail-cover">
                <?php if (! empty($buku->cover_url)) : ?>
                <img src="<?= html_escape($buku->cover_url) ?>" alt="<?= html_escape($buku->judul) ?>">
                <?php else : ?>
                <i class="fa fa-book"></i>
                <?php endif; ?>
            </div>

            <div>
                <?php if (! empty($buku->kategori)) : ?>
                <span class="perpus-detail-category"><?= html_escape($buku->kategori) ?></span>
                <?php endif; ?>

                <h1 class="perpus-detail-title"><?= html_escape($buku->judul) ?></h1>

                <div class="perpus-detail-meta">
                    <?php if (! empty($buku->penulis)) : ?>
                    <div><strong>Penulis:</strong> <?= html_escape($buku->penulis) ?></div>
                    <?php endif; ?>

                    <?php if (! empty($buku->penerbit)) : ?>
                    <div><strong>Penerbit:</strong> <?= html_escape($buku->penerbit) ?></div>
                    <?php endif; ?>

                    <?php if (! empty($buku->kontributor)) : ?>
                    <div><strong>Kontributor:</strong> <?= html_escape($buku->kontributor) ?></div>
                    <?php endif; ?>

                    <?php if (! empty($buku->sumber)) : ?>
                    <div><strong>Sumber:</strong> <?= html_escape($buku->sumber) ?></div>
                    <?php endif; ?>

                    <div><strong>Dibaca:</strong> <?= (int) $buku->dilihat ?> kali</div>
                </div>

                <div class="perpus-detail-desc">
                    <?= nl2br(html_escape($buku->deskripsi ?: 'Belum ada deskripsi buku.')) ?>
                </div>

                <div class="perpus-detail-actions">
                    <a href="<?= html_escape($buku->baca_url) ?>" class="perpus-btn perpus-btn-primary">
                        <i class="fa fa-book"></i> Baca Buku
                    </a>
                </div>
            </div>
        </div>
    </div>

    <?php if (! empty($buku_terkait)) : ?>
    <div style="margin-top: 24px;">
        <h2 style="font-weight: 800;">Buku Terkait</h2>

        <div class="perpus-related-grid">
            <?php foreach ($buku_terkait as $item) : ?>
            <div class="perpus-related-card">
                <div class="perpus-related-cover">
                    <?php if (! empty($item->cover_url)) : ?>
                    <img src="<?= html_escape($item->cover_url) ?>" alt="<?= html_escape($item->judul) ?>">
                    <?php else : ?>
                    <i class="fa fa-book"></i>
                    <?php endif; ?>
                </div>

                <div class="perpus-related-title"><?= html_escape($item->judul) ?></div>

                <a href="<?= html_escape($item->detail_url) ?>" class="perpus-btn perpus-btn-light"
                    style="width: 100%; text-align: center;">
                    Detail
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>