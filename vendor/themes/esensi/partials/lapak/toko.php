<style>
.lapak-toko {
    margin-bottom: 32px;
}

.lapak-toko .toko-topbar {
    display: flex;
    justify-content: flex-end;
    margin-bottom: 14px;
}

.lapak-toko .toko-topbar .btn {
    border-radius: 6px;
    font-weight: 600;
    padding: 9px 14px;
}

.lapak-toko .toko-hero {
    min-height: 310px;
    border-radius: 14px;
    background: #eaf4fb;
    background-size: cover;
    background-position: center;
    overflow: hidden;
    margin-bottom: 18px;
    border: 1px solid #e5e5e5;
}

.lapak-toko .toko-hero-overlay {
    min-height: 310px;
    background: linear-gradient(90deg, rgba(0, 0, 0, .74), rgba(0, 0, 0, .38), rgba(0, 0, 0, .10));
    display: flex;
    align-items: flex-end;
    padding: 30px;
}

.lapak-toko .toko-hero-content {
    display: flex;
    align-items: center;
    gap: 20px;
    color: #fff;
    width: 100%;
}

.lapak-toko .toko-logo {
    width: 104px;
    height: 104px;
    border-radius: 20px;
    background: #fff;
    border: 4px solid rgba(255, 255, 255, .9);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #337ab7;
    font-size: 42px;
    flex: 0 0 104px;
    box-shadow: 0 8px 22px rgba(0, 0, 0, .22);
}

.lapak-toko .toko-logo img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.lapak-toko .toko-hero-text {
    min-width: 0;
}

.lapak-toko .toko-hero-text h2 {
    margin: 0 0 9px;
    color: #fff;
    font-size: 34px;
    font-weight: 700;
    line-height: 1.2;
}

.lapak-toko .toko-owner {
    color: rgba(255, 255, 255, .92);
    font-size: 16px;
    margin-bottom: 9px;
}

.lapak-toko .toko-desc {
    color: rgba(255, 255, 255, .93);
    font-size: 16px;
    line-height: 1.65;
    margin-bottom: 0;
    max-width: 820px;
}

.lapak-toko .toko-info-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 340px;
    gap: 16px;
    margin-bottom: 24px;
}

.lapak-toko .info-card {
    border: 1px solid #e5e5e5;
    border-radius: 12px;
    background: #fff;
    padding: 16px;
}

.lapak-toko .info-card-title {
    font-weight: 700;
    color: #333;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 7px;
}

.lapak-toko .info-card-title i {
    color: #337ab7;
}

.lapak-toko .info-card-value {
    color: #555;
    font-size: 13px;
    line-height: 1.6;
}

.lapak-toko .stats-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
}

.lapak-toko .stat-box {
    border: 1px solid #eeeeee;
    border-radius: 10px;
    background: #fafafa;
    padding: 13px 14px;
}

.lapak-toko .stat-label {
    font-size: 12px;
    color: #777;
    margin-bottom: 5px;
}

.lapak-toko .stat-value {
    font-size: 17px;
    font-weight: 700;
    color: #333;
}

.lapak-toko .stat-value i {
    color: #337ab7;
}

.lapak-toko .section-title-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    gap: 12px;
    margin-bottom: 14px;
}

.lapak-toko .section-title {
    margin: 0;
    font-weight: 700;
    color: #333;
}

.lapak-toko .section-subtitle {
    color: #777;
    font-size: 13px;
}

.lapak-toko .produk-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
}

.lapak-toko .produk-card {
    border: 1px solid #e5e5e5;
    border-radius: 12px;
    background: #fff;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    min-height: 340px;
    transition: box-shadow .2s ease, border-color .2s ease;
}

.lapak-toko .produk-card:hover {
    border-color: #c9dff0;
    box-shadow: 0 8px 20px rgba(0, 0, 0, .07);
}

.lapak-toko .produk-cover {
    height: 165px;
    background: #eef6f8;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}

.lapak-toko .produk-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.lapak-toko .produk-cover i {
    font-size: 42px;
    color: #337ab7;
}

.lapak-toko .produk-body {
    padding: 14px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.lapak-toko .produk-title {
    font-size: 15px;
    font-weight: 700;
    line-height: 1.35;
    color: #333;
    margin-bottom: 7px;
}

.lapak-toko .produk-price {
    font-size: 14px;
    font-weight: 700;
    color: #337ab7;
    margin-bottom: 6px;
}

.lapak-toko .produk-cat {
    font-size: 12px;
    color: #777;
    margin-bottom: 8px;
}

.lapak-toko .produk-desc {
    font-size: 12px;
    color: #555;
    line-height: 1.55;
    flex: 1;
    margin-bottom: 12px;
}

.lapak-toko .btn-detail {
    font-weight: 600;
    border-radius: 6px;
}

@media (max-width: 1199px) {
    .lapak-toko .produk-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 991px) {
    .lapak-toko .toko-info-grid {
        grid-template-columns: 1fr;
    }

    .lapak-toko .produk-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 575px) {
    .lapak-toko .toko-topbar {
        justify-content: stretch;
    }

    .lapak-toko .toko-topbar .btn {
        width: 100%;
    }

    .lapak-toko .toko-hero,
    .lapak-toko .toko-hero-overlay {
        min-height: 260px;
    }

    .lapak-toko .toko-hero-overlay {
        padding: 18px;
    }

    .lapak-toko .toko-hero-content {
        display: block;
    }

    .lapak-toko .toko-logo {
        width: 76px;
        height: 76px;
        border-radius: 16px;
        font-size: 30px;
        margin-bottom: 14px;
    }

    .lapak-toko .toko-hero-text h2 {
        font-size: 24px;
    }

    .lapak-toko .toko-owner,
    .lapak-toko .toko-desc {
        font-size: 14px;
    }

    .lapak-toko .stats-row {
        grid-template-columns: 1fr;
    }

    .lapak-toko .section-title-row {
        display: block;
    }

    .lapak-toko .section-subtitle {
        margin-top: 4px;
    }

    .lapak-toko .produk-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
    if (! function_exists('lapak_public_foto_utama')) {
        function lapak_public_foto_utama($foto)
        {
            $decoded = json_decode((string) $foto, true);

            if (is_array($decoded) && ! empty($decoded[0])) {
                return $decoded[0];
            }

            return '';
        }
    }

    $nama_lapak = trim((string) ($lapak->nama_lapak ?? ''));
    $nama_lapak = $nama_lapak !== '' ? $nama_lapak : ($lapak->nama_pemilik ?? 'Lapak Warga');

    $deskripsi_lapak = trim((string) ($lapak->deskripsi_lapak ?? ''));

    $logo = trim((string) ($lapak->logo ?? ''));
    $banner = trim((string) ($lapak->banner ?? ''));

    $logo_url = $logo !== '' ? base_url('desa/upload/lapak/logo/' . $logo) : '';
    $banner_url = $banner !== '' ? base_url('desa/upload/lapak/banner/' . $banner) : '';

    $lat = trim((string) ($lapak->lat ?? ''));
    $lng = trim((string) ($lapak->lng ?? ''));

    $punya_lokasi = $lat !== '' && $lng !== '' && $lat !== '-' && $lng !== '-';
?>

<div class="lapak-toko">
    <div class="toko-topbar">
        <a href="<?= site_url('lapak') ?>" class="btn btn-default btn-sm">
            <i class="fa fa-arrow-left"></i> Kembali ke Katalog Produk
        </a>
    </div>

    <div class="toko-hero"
        style="<?= $banner_url !== '' ? "background-image: url('" . html_escape($banner_url) . "');" : '' ?>">
        <div class="toko-hero-overlay">
            <div class="toko-hero-content">
                <div class="toko-logo">
                    <?php if ($logo_url !== '') : ?>
                    <img src="<?= $logo_url ?>" alt="<?= html_escape($nama_lapak) ?>">
                    <?php else : ?>
                    <i class="fa fa-shopping-bag"></i>
                    <?php endif; ?>
                </div>

                <div class="toko-hero-text">
                    <h2><?= html_escape($nama_lapak) ?></h2>

                    <div class="toko-owner">
                        <i class="fa fa-user"></i>
                        Pemilik: <?= html_escape($lapak->nama_pemilik ?: '-') ?>
                    </div>

                    <?php if ($deskripsi_lapak !== '') : ?>
                    <p class="toko-desc"><?= nl2br(html_escape($deskripsi_lapak)) ?></p>
                    <?php else : ?>
                    <p class="toko-desc">Belum ada deskripsi lapak.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="toko-info-grid">
        <div class="info-card">
            <div class="info-card-title">
                <i class="fa fa-map-marker"></i> Lokasi Lapak
            </div>

            <?php if ($punya_lokasi) : ?>
            <div class="info-card-value">
                Koordinat: <?= html_escape($lat) ?>, <?= html_escape($lng) ?>
            </div>

            <div style="margin-top: 10px;">
                <a href="https://www.google.com/maps?q=<?= urlencode($lat . ',' . $lng) ?>" target="_blank"
                    class="btn btn-primary btn-sm">
                    <i class="fa fa-map"></i> Lihat Maps
                </a>
            </div>
            <?php else : ?>
            <div class="info-card-value">
                Lokasi lapak belum tersedia.
            </div>
            <?php endif; ?>
        </div>

        <div class="stats-row">
            <div class="stat-box">
                <div class="stat-label">Produk Aktif</div>
                <div class="stat-value">
                    <i class="fa fa-cube"></i>
                    <?= (int) ($lapak->jumlah_produk ?? 0) ?>
                </div>
            </div>

            <div class="stat-box">
                <div class="stat-label">Kontak</div>
                <div class="stat-value" style="font-size: 14px;">
                    <i class="fa fa-phone"></i>
                    <?= ! empty($lapak->telepon) ? html_escape($lapak->telepon) : '-' ?>
                </div>
            </div>
        </div>
    </div>

    <div class="section-title-row">
        <h3 class="section-title">Produk/Menu</h3>
        <div class="section-subtitle">
            Menampilkan produk aktif dari lapak ini.
        </div>
    </div>

    <?php if (empty($produk)) : ?>
    <div class="alert alert-warning">
        Belum ada produk/menu aktif pada lapak ini.
    </div>
    <?php else : ?>
    <div class="produk-grid">
        <?php foreach ($produk as $row) : ?>
        <?php $foto_utama = lapak_public_foto_utama($row->foto); ?>

        <div class="produk-card">
            <div class="produk-cover">
                <?php if (! empty($foto_utama) && defined('LOKASI_PRODUK')) : ?>
                <img src="<?= base_url(LOKASI_PRODUK . $foto_utama) ?>" alt="<?= html_escape($row->nama) ?>">
                <?php else : ?>
                <i class="fa fa-image"></i>
                <?php endif; ?>
            </div>

            <div class="produk-body">
                <div class="produk-title">
                    <?= html_escape($row->nama) ?>
                </div>

                <div class="produk-price">
                    Rp <?= number_format((float) $row->harga, 0, ',', '.') ?>
                    <?php if (! empty($row->satuan)) : ?>
                    / <?= html_escape($row->satuan) ?>
                    <?php endif; ?>
                </div>

                <div class="produk-cat">
                    <i class="fa fa-tag"></i>
                    <?= html_escape($row->kategori ?? '-') ?>
                </div>

                <div class="produk-desc">
                    <?= html_escape(mb_strimwidth((string) $row->deskripsi, 0, 95, '...')) ?>
                </div>

                <a href="<?= site_url('lapak/detail/' . (int) $row->id) ?>"
                    class="btn btn-primary btn-sm btn-block btn-detail">
                    Detail Produk <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>