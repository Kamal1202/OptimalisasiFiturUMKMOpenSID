<style>
.lapak-public {
    margin-bottom: 36px;
}

.lapak-public .lapak-hero {
    position: relative;
    overflow: hidden;
    border-radius: 16px;
    background: linear-gradient(135deg, #0f7892 0%, #1b9bb8 46%, #eaf7fb 100%);
    padding: 30px;
    margin-bottom: 18px;
    color: #fff;
    border: 1px solid rgba(255, 255, 255, .18);
}

.lapak-public .lapak-hero:after {
    content: "";
    position: absolute;
    right: -70px;
    top: -70px;
    width: 220px;
    height: 220px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .20);
}

.lapak-public .lapak-hero:before {
    content: "";
    position: absolute;
    right: 80px;
    bottom: -90px;
    width: 180px;
    height: 180px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .12);
}

.lapak-public .lapak-hero-content {
    position: relative;
    z-index: 2;
    max-width: 760px;
}

.lapak-public .lapak-hero-kicker {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 20px;
    background: rgba(255, 255, 255, .18);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 12px;
}

.lapak-public .lapak-hero h2 {
    margin: 0 0 10px;
    font-size: 30px;
    line-height: 1.2;
    font-weight: 800;
    color: #fff;
}

.lapak-public .lapak-hero p {
    margin: 0;
    color: rgba(255, 255, 255, .92);
    line-height: 1.7;
    font-size: 15px;
}

.lapak-public .lapak-toolbar {
    border: 1px solid #e7e7e7;
    border-radius: 14px;
    background: #fff;
    padding: 16px;
    margin-bottom: 20px;
    box-shadow: 0 6px 18px rgba(0, 0, 0, .035);
}

.lapak-public .lapak-search-form {
    display: flex;
    gap: 10px;
    align-items: center;
}

.lapak-public .lapak-search-input {
    flex: 1;
    height: 44px;
    border: 1px solid #dcdcdc;
    border-radius: 8px;
    padding: 8px 13px;
    font-size: 14px;
    box-shadow: none;
}

.lapak-public .lapak-search-input:focus {
    border-color: #0d8ca7;
    outline: none;
    box-shadow: 0 0 0 3px rgba(13, 140, 167, .10);
}

.lapak-public .lapak-search-actions {
    display: flex;
    gap: 8px;
    align-items: center;
}

.lapak-public .lapak-search-actions .btn {
    height: 44px;
    border-radius: 8px;
    font-weight: 700;
    padding-left: 18px;
    padding-right: 18px;
}

.lapak-public .lapak-summary-row {
    margin-top: 12px;
    display: flex;
    justify-content: space-between;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
}

.lapak-public .lapak-summary {
    font-size: 13px;
    color: #777;
}

.lapak-public .lapak-mini-stat {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.lapak-public .lapak-mini-badge {
    display: inline-block;
    padding: 5px 10px;
    border-radius: 16px;
    background: #f5f8fa;
    border: 1px solid #e8eef2;
    color: #555;
    font-size: 12px;
}

.lapak-public .lapak-mini-badge i {
    color: #0d8ca7;
}

.lapak-public .lapak-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
}

.lapak-public .lapak-card {
    border: 1px solid #e5e5e5;
    border-radius: 16px;
    background: #fff;
    overflow: hidden;
    min-height: 350px;
    display: flex;
    flex-direction: column;
    transition: box-shadow .2s ease, border-color .2s ease, transform .2s ease;
    box-shadow: 0 4px 14px rgba(0, 0, 0, .035);
}

.lapak-public .lapak-card:hover {
    border-color: #bddfec;
    box-shadow: 0 12px 28px rgba(0, 0, 0, .09);
    transform: translateY(-2px);
}

.lapak-public .lapak-cover {
    height: 130px;
    background: linear-gradient(135deg, #eaf4fb 0%, #d9edf7 100%);
    background-size: cover;
    background-position: center;
    position: relative;
}

.lapak-public .lapak-cover-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(180deg, rgba(0, 0, 0, .03), rgba(0, 0, 0, .42));
}

.lapak-public .lapak-avatar {
    width: 72px;
    height: 72px;
    border-radius: 18px;
    background: #fff;
    color: #0d8ca7;
    border: 4px solid #fff;
    box-shadow: 0 8px 18px rgba(0, 0, 0, .18);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    overflow: hidden;
    position: absolute;
    left: 16px;
    bottom: -34px;
    z-index: 2;
}

.lapak-public .lapak-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.lapak-public .lapak-card-body {
    padding: 46px 16px 16px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.lapak-public .lapak-name {
    font-size: 17px;
    font-weight: 800;
    color: #333;
    line-height: 1.35;
    margin-bottom: 5px;
}

.lapak-public .lapak-owner {
    color: #777;
    font-size: 12px;
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: .2px;
}

.lapak-public .lapak-desc {
    color: #555;
    font-size: 13px;
    line-height: 1.65;
    flex: 1;
    margin-bottom: 14px;
    min-height: 44px;
}

.lapak-public .lapak-meta {
    display: flex;
    gap: 7px;
    flex-wrap: wrap;
    margin-bottom: 15px;
}

.lapak-public .lapak-badge {
    display: inline-block;
    padding: 6px 10px;
    background: #f7f9fa;
    border: 1px solid #edf0f2;
    border-radius: 16px;
    font-size: 12px;
    color: #555;
}

.lapak-public .lapak-badge i {
    color: #0d8ca7;
}

.lapak-public .btn-lapak {
    border-radius: 8px;
    font-weight: 800;
    padding-top: 9px;
    padding-bottom: 9px;
    background: #0d8ca7;
    border-color: #0d8ca7;
}

.lapak-public .btn-lapak:hover,
.lapak-public .btn-lapak:focus {
    background: #08788f;
    border-color: #08788f;
}

.lapak-public .empty-state {
    border: 1px dashed #ccd7dd;
    border-radius: 14px;
    padding: 24px;
    background: #fbfdfe;
    color: #666;
}

@media (max-width: 991px) {
    .lapak-public .lapak-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 575px) {
    .lapak-public .lapak-hero {
        padding: 20px;
    }

    .lapak-public .lapak-hero h2 {
        font-size: 24px;
    }

    .lapak-public .lapak-grid {
        grid-template-columns: 1fr;
    }

    .lapak-public .lapak-search-form {
        display: block;
    }

    .lapak-public .lapak-search-input {
        width: 100%;
        margin-bottom: 10px;
    }

    .lapak-public .lapak-search-actions {
        width: 100%;
    }

    .lapak-public .lapak-search-actions .btn {
        flex: 1;
    }
}
</style>

<div class="lapak-public">
    <div class="lapak-hero">
        <div class="lapak-hero-content">
            <div class="lapak-hero-kicker">
                <i class="fa fa-shopping-bag"></i> Katalog UMKM Desa
            </div>

            <h2>Temukan Lapak dan Produk Warga Desa</h2>

            <p>
                Jelajahi lapak UMKM warga, lihat produk/menu yang tersedia, lalu hubungi pelapak secara langsung untuk
                pemesanan.
            </p>
        </div>
    </div>

    <div class="lapak-toolbar">
        <form method="get" action="<?= site_url('lapak') ?>" class="lapak-search-form">
            <input type="text" name="keyword" class="lapak-search-input" value="<?= html_escape($keyword ?? '') ?>"
                placeholder="Cari nama lapak, pemilik, telepon, atau deskripsi...">

            <div class="lapak-search-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i> Cari
                </button>

                <?php if (! empty($keyword)) : ?>
                <a href="<?= site_url('lapak') ?>" class="btn btn-default">
                    Reset
                </a>
                <?php endif; ?>
            </div>
        </form>

        <div class="lapak-summary-row">
            <div class="lapak-summary">
                Menampilkan <?= (int) ($total_lapak ?? count($lapak ?? [])) ?> lapak aktif.
            </div>

            <div class="lapak-mini-stat">
                <span class="lapak-mini-badge">
                    <i class="fa fa-store"></i> Lapak warga
                </span>
                <span class="lapak-mini-badge">
                    <i class="fa fa-phone"></i> Hubungi langsung
                </span>
            </div>
        </div>
    </div>

    <?php if (empty($lapak)) : ?>
    <div class="empty-state">
        <strong>Belum ada lapak aktif yang sesuai dengan pencarian.</strong><br>
        Coba gunakan kata kunci lain atau reset pencarian.
    </div>
    <?php else : ?>
    <div class="lapak-grid">
        <?php foreach ($lapak as $row) : ?>
        <?php
            $nama_lapak = trim((string) ($row->nama_lapak ?? ''));
            $nama_lapak = $nama_lapak !== '' ? $nama_lapak : ($row->nama_pemilik ?? 'Lapak Warga');

            $deskripsi = trim((string) ($row->deskripsi_lapak ?? ''));
            $deskripsi = $deskripsi !== '' ? mb_strimwidth($deskripsi, 0, 135, '...') : 'Belum ada deskripsi lapak.';

            $logo = trim((string) ($row->logo ?? ''));
            $banner = trim((string) ($row->banner ?? ''));

            $logo_url = $logo !== '' ? base_url('desa/upload/lapak/logo/' . $logo) : '';
            $banner_url = $banner !== '' ? base_url('desa/upload/lapak/banner/' . $banner) : '';
        ?>

        <div class="lapak-card">
            <div class="lapak-cover"
                style="<?= $banner_url !== '' ? "background-image: url('" . html_escape($banner_url) . "');" : '' ?>">
                <div class="lapak-cover-overlay"></div>

                <div class="lapak-avatar">
                    <?php if ($logo_url !== '') : ?>
                    <img src="<?= $logo_url ?>" alt="<?= html_escape($nama_lapak) ?>">
                    <?php else : ?>
                    <i class="fa fa-shopping-bag"></i>
                    <?php endif; ?>
                </div>
            </div>

            <div class="lapak-card-body">
                <div class="lapak-name">
                    <?= html_escape($nama_lapak) ?>
                </div>

                <div class="lapak-owner">
                    <i class="fa fa-user"></i>
                    <?= html_escape($row->nama_pemilik ?: '-') ?>
                </div>

                <div class="lapak-desc">
                    <?= html_escape($deskripsi) ?>
                </div>

                <div class="lapak-meta">
                    <span class="lapak-badge">
                        <i class="fa fa-cube"></i>
                        <?= (int) $row->jumlah_produk ?> produk
                    </span>

                    <?php if (! empty($row->telepon)) : ?>
                    <span class="lapak-badge">
                        <i class="fa fa-phone"></i>
                        <?= html_escape($row->telepon) ?>
                    </span>
                    <?php endif; ?>
                </div>

                <a href="<?= site_url('lapak/toko/' . (int) $row->id) ?>"
                    class="btn btn-primary btn-sm btn-block btn-lapak">
                    Lihat Produk <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>