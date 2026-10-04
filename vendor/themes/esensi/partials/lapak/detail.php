<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<?php
  $foto = json_decode((string) $produk->foto, true);
  $foto = is_array($foto) ? array_values(array_filter($foto)) : [];

  $harga_potongan = ($produk->tipe_potongan == 1) ? ($produk->harga * ($produk->potongan / 100)) : $produk->potongan;
  $harga_final = $produk->harga - $harga_potongan;

  $pesan = strReplaceArrayRecursive([
    '[nama_produk]' => $produk->nama,
    '[link_web]' => site_url('lapak/detail/' . $produk->id),
    '<br />' => "%0A",
  ], nl2br($this->setting->pesan_singkat_wa));
?>

<style>
.lapak-detail-wrapper {
    margin-top: 16px;
}

.lapak-detail-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 18px;
}

.lapak-detail-grid {
    display: grid;
    grid-template-columns: minmax(0, 5fr) minmax(0, 7fr);
    gap: 24px;
    align-items: start;
}

.lapak-detail-gallery {
    position: relative;
    width: 100%;
    height: 420px;
    background: #f3f7f9;
    border: 1px solid #edf2f4;
    border-radius: 10px;
    overflow: hidden;
}

.lapak-detail-slide {
    display: none;
    width: 100%;
    height: 100%;
}

.lapak-detail-slide.active {
    display: block;
}

.lapak-detail-slide img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    object-position: center;
    background: #f3f7f9;
}

.lapak-detail-empty {
    width: 100%;
    height: 420px;
    object-fit: contain;
    object-position: center;
    background: #f3f7f9;
    border-radius: 10px;
    border: 1px solid #edf2f4;
}

.lapak-detail-slider-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 38px;
    height: 38px;
    border: 0;
    border-radius: 50%;
    background: rgba(0, 0, 0, .45);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 4;
}

.lapak-detail-slider-btn:hover {
    background: rgba(0, 0, 0, .65);
}

.lapak-detail-prev {
    left: 12px;
}

.lapak-detail-next {
    right: 12px;
}

.lapak-detail-thumbs {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 8px;
    margin-top: 10px;
}

.lapak-detail-thumb {
    height: 70px;
    border: 2px solid transparent;
    border-radius: 7px;
    background: #f3f7f9;
    overflow: hidden;
    cursor: pointer;
    padding: 0;
}

.lapak-detail-thumb.active {
    border-color: #0288a7;
}

.lapak-detail-thumb img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    background: #f3f7f9;
}

.lapak-detail-category {
    display: inline-block;
    background: #e8f8fb;
    color: #00728f;
    border-radius: 20px;
    padding: 5px 10px;
    font-size: 12px;
    font-weight: 700;
    margin-bottom: 12px;
}

.lapak-detail-title {
    font-size: 30px;
    font-weight: 800;
    line-height: 1.25;
    margin: 0 0 12px;
    color: #222;
}

.lapak-detail-price {
    font-size: 28px;
    font-weight: 800;
    color: #222;
    margin-bottom: 4px;
}

.lapak-detail-unit {
    font-size: 14px;
    font-weight: 400;
    color: #777;
}

.lapak-detail-discount {
    font-size: 13px;
    color: #16803c;
    margin-top: 4px;
}

.lapak-detail-section {
    margin-top: 18px;
    padding-top: 18px;
    border-top: 1px solid #eee;
}

.lapak-detail-section h2 {
    font-size: 18px;
    font-weight: 800;
    margin: 0 0 10px;
    color: #333;
}

.lapak-detail-desc {
    font-size: 14px;
    line-height: 1.75;
    color: #555;
}

.lapak-detail-seller-box {
    background: #f9fbfc;
    border: 1px solid #e6eef1;
    border-radius: 8px;
    padding: 14px;
    margin-top: 16px;
}

.lapak-detail-seller-box h3 {
    font-size: 16px;
    font-weight: 800;
    margin: 0 0 10px;
}

.lapak-detail-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 18px;
}

.lapak-detail-actions .btn {
    min-height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.lapak-other-grid {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 18px;
    margin-top: 16px;
}

.lapak-other-card {
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 12px;
    background: #fff;
}

.lapak-other-card img {
    width: 100%;
    height: 150px;
    object-fit: contain;
    object-position: center;
    background: #f3f7f9;
    border-radius: 7px;
    border: 1px solid #edf2f4;
    margin-bottom: 10px;
}

.lapak-other-title {
    font-size: 14px;
    font-weight: 800;
    line-height: 1.35;
    margin-bottom: 4px;
    color: #222;
}

.lapak-other-meta {
    font-size: 12px;
    color: #777;
    margin-bottom: 6px;
}

.lapak-other-price {
    font-size: 14px;
    font-weight: 800;
    margin-bottom: 10px;
}

@media (max-width: 991px) {
    .lapak-detail-grid {
        grid-template-columns: 1fr;
    }

    .lapak-other-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 575px) {

    .lapak-detail-gallery,
    .lapak-detail-empty {
        height: 300px;
    }

    .lapak-detail-title {
        font-size: 24px;
    }

    .lapak-detail-price {
        font-size: 22px;
    }

    .lapak-other-grid {
        grid-template-columns: 1fr;
    }

    .lapak-detail-thumbs {
        grid-template-columns: repeat(4, 1fr);
    }
}
</style>

<nav role="navigation" aria-label="navigation" class="breadcrumb">
    <ol>
        <li><a href="<?= site_url() ?>">Beranda</a></li>
        <li><a href="<?= site_url('lapak') ?>">Lapak</a></li>
        <li aria-current="page"><?= html_escape($produk->nama) ?></li>
    </ol>
</nav>

<div class="mb-5">
    <a href="<?= site_url('lapak') ?>" class="btn btn-secondary text-xs">
        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Lapak
    </a>
</div>

<div class="lapak-detail-wrapper">
    <div class="lapak-detail-card">
        <div class="lapak-detail-grid">
            <div>
                <?php if (! empty($foto)) : ?>
                <div class="lapak-detail-gallery" data-detail-slider>
                    <?php foreach ($foto as $foto_index => $foto_item) : ?>
                    <?php if (! empty($foto_item) && is_file(LOKASI_PRODUK . $foto_item)) : ?>
                    <div class="lapak-detail-slide <?= $foto_index === 0 ? 'active' : '' ?>">
                        <img src="<?= base_url(LOKASI_PRODUK . $foto_item); ?>" alt="Foto <?= ($foto_index + 1); ?>">
                    </div>
                    <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if (count($foto) > 1) : ?>
                    <button type="button" class="lapak-detail-slider-btn lapak-detail-prev" data-detail-prev>
                        <i class="fas fa-chevron-left"></i>
                    </button>

                    <button type="button" class="lapak-detail-slider-btn lapak-detail-next" data-detail-next>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                    <?php endif; ?>
                </div>

                <?php if (count($foto) > 1) : ?>
                <div class="lapak-detail-thumbs">
                    <?php foreach ($foto as $foto_index => $foto_item) : ?>
                    <?php if (! empty($foto_item) && is_file(LOKASI_PRODUK . $foto_item)) : ?>
                    <button type="button" class="lapak-detail-thumb <?= $foto_index === 0 ? 'active' : '' ?>"
                        data-detail-thumb="<?= $foto_index ?>">
                        <img src="<?= base_url(LOKASI_PRODUK . $foto_item); ?>"
                            alt="Thumbnail <?= ($foto_index + 1); ?>">
                    </button>
                    <?php endif; ?>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <?php else : ?>
                <img class="lapak-detail-empty" src="<?= base_url('assets/images/404-image-not-found.jpg') ?>"
                    alt="Foto Produk">
                <?php endif; ?>
            </div>

            <div>
                <?php if (! empty($produk->kategori)) : ?>
                <span class="lapak-detail-category">
                    <i class="fas fa-tag mr-1"></i> <?= html_escape($produk->kategori) ?>
                </span>
                <?php endif; ?>

                <h1 class="lapak-detail-title"><?= html_escape($produk->nama) ?></h1>

                <div>
                    <?php if ($produk->potongan != 0) : ?>
                    <s class="text-sm text-red-500"><?= rupiah($produk->harga); ?></s>
                    <?php endif; ?>

                    <div class="lapak-detail-price">
                        <?= rupiah($harga_final); ?>
                        <span class="lapak-detail-unit">/ <?= html_escape($produk->satuan) ?></span>
                    </div>

                    <?php if ($produk->potongan != 0) : ?>
                    <div class="lapak-detail-discount">
                        Potongan:
                        <?php if ($produk->tipe_potongan == 1) : ?>
                        <?= html_escape($produk->potongan) ?>%
                        <?php else : ?>
                        <?= rupiah($produk->potongan) ?>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="lapak-detail-section">
                    <h2>Deskripsi Produk/Menu</h2>
                    <div class="lapak-detail-desc">
                        <?= nl2br(html_escape($produk->deskripsi ?: 'Belum ada deskripsi produk.')) ?>
                    </div>
                </div>

                <div class="lapak-detail-seller-box">
                    <h3><i class="fas fa-store mr-1"></i> Informasi Lapak</h3>

                    <div class="text-sm space-y-1">
                        <div>
                            <strong>Nama Lapak:</strong>
                            <?= html_escape($produk->pelapak ?? 'Admin') ?>
                        </div>

                        <?php if (! empty($produk->nama_pemilik)) : ?>
                        <div>
                            <strong>Pemilik:</strong>
                            <?= html_escape($produk->nama_pemilik) ?>
                        </div>
                        <?php endif; ?>

                        <?php if (! empty($produk->telepon)) : ?>
                        <div>
                            <strong>WhatsApp:</strong>
                            <?= html_escape($produk->telepon) ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="lapak-detail-actions">
                        <?php if ($produk->telepon) : ?>
                        <a href="https://api.whatsapp.com/send?phone=<?= format_telpon($produk->telepon); ?>&amp;text=<?= $pesan; ?>"
                            rel="noopener noreferrer" target="_blank" class="btn btn-primary text-sm text-center">
                            <i class="fa fa-shopping-cart mr-1"></i> Beli via WhatsApp
                        </a>
                        <?php endif; ?>

                        <button type="button" class="btn btn-secondary text-sm text-center rounded-0"
                            data-bs-toggle="modal" data-bs-target="#modalLokasiDetail" data-bs-remote="false"
                            title="Lokasi" data-lat="<?= $produk->lat ?>" data-lng="<?= $produk->lng ?>"
                            data-zoom="<?= $produk->zoom ?>" data-title="Lokasi <?= html_escape($produk->pelapak) ?>">
                            <i class="fas fa-map-marker-alt mr-1"></i> Lihat Lokasi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (! empty($produk_lain)) : ?>
<div class="mt-8">
    <h2 class="text-h3 mb-4">Produk Lain dari Pelapak Ini</h2>

    <div class="lapak-other-grid">
        <?php foreach ($produk_lain as $item) : ?>
        <?php
          $foto_lain = json_decode((string) $item->foto, true);
          $foto_lain = is_array($foto_lain) ? array_values(array_filter($foto_lain)) : [];
          $foto_utama = $foto_lain[0] ?? '';
          $harga_potongan_lain = ($item->tipe_potongan == 1) ? ($item->harga * ($item->potongan / 100)) : $item->potongan;
        ?>

        <div class="lapak-other-card">
            <?php if (! empty($foto_utama) && is_file(LOKASI_PRODUK . $foto_utama)) : ?>
            <img src="<?= base_url(LOKASI_PRODUK . $foto_utama); ?>" alt="<?= html_escape($item->nama) ?>">
            <?php else : ?>
            <img src="<?= base_url('assets/images/404-image-not-found.jpg') ?>" alt="Foto Produk">
            <?php endif; ?>

            <div class="lapak-other-title"><?= html_escape($item->nama) ?></div>
            <div class="lapak-other-meta"><?= html_escape($item->kategori ?? '-') ?></div>

            <div class="lapak-other-price">
                <?= rupiah($item->harga - $harga_potongan_lain); ?>
                <span class="text-xs font-thin">/ <?= html_escape($item->satuan) ?></span>
            </div>

            <a href="<?= site_url('lapak/detail/' . $item->id) ?>" class="btn btn-secondary text-xs text-center w-full">
                <i class="fas fa-info-circle mr-1"></i> Detail
            </a>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<div class="modal fade fixed top-0 left-0 hidden w-full h-full outline-none overflow-x-hidden overflow-y-auto"
    id="modalLokasiDetail" tabindex="-1" aria-modal="true" role="dialog">
    <div class="modal-dialog relative w-auto pointer-events-none">
        <div
            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
            <div
                class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                <h5 class="text-h6">Lokasi Penjual</h5>
            </div>

            <div class="modal-body p-4"></div>

            <div class="modal-footer flex justify-end p-4 border-t border-gray-200">
                <a href="#" id="googleMapsLinkDetail" target="_blank" rel="noopener noreferrer"
                    class="btn btn-primary text-xs">
                    <i class="fas fa-directions mr-1"></i> Buka di Google Maps
                </a>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
var token = "<?= $this->setting->mapbox_key; ?>";

function setDetailSlide(slider, index) {
    const slides = slider.querySelectorAll('.lapak-detail-slide');
    const wrapper = slider.closest('.lapak-detail-card');
    const thumbs = wrapper ? wrapper.querySelectorAll('.lapak-detail-thumb') : [];

    if (!slides.length) return;

    if (index < 0) index = slides.length - 1;
    if (index >= slides.length) index = 0;

    slider.setAttribute('data-current-slide', index);

    slides.forEach(function(slide, i) {
        slide.classList.toggle('active', i === index);
    });

    thumbs.forEach(function(thumb, i) {
        thumb.classList.toggle('active', i === index);
    });
}

document.addEventListener('click', function(event) {
    const prev = event.target.closest('[data-detail-prev]');
    const next = event.target.closest('[data-detail-next]');
    const thumb = event.target.closest('[data-detail-thumb]');

    if (prev || next || thumb) {
        event.preventDefault();

        const slider = document.querySelector('[data-detail-slider]');
        const current = parseInt(slider.getAttribute('data-current-slide') || '0', 10);

        if (prev) {
            setDetailSlide(slider, current - 1);
        }

        if (next) {
            setDetailSlide(slider, current + 1);
        }

        if (thumb) {
            setDetailSlide(slider, parseInt(thumb.getAttribute('data-detail-thumb'), 10));
        }
    }
});

$(document).ready(function() {
    document.querySelector('#modalLokasiDetail').addEventListener('shown.bs.modal', function(event) {
        const link = $(event.relatedTarget);
        const modal = $(this);

        modal.find('.modal-body').html("<div id='mapDetail' style='width: 100%; height:350px'></div>");

        const posisi = [link.data('lat'), link.data('lng')];
        const zoom = link.data('zoom') || 10;

        const googleMapsUrl = 'https://www.google.com/maps/search/?api=1&query=' + encodeURIComponent(
            link.data('lat') + ',' + link.data('lng'));
        $('#googleMapsLinkDetail').attr('href', googleMapsUrl);

        pelapak = L.map('mapDetail').setView(posisi, zoom);
        getBaseLayers(pelapak, token);

        marker = new L.Marker(posisi, {
            draggable: false
        });

        pelapak.addLayer(marker);
        L.marker(posisi).addTo(pelapak).bindPopup(link.data('title'));
        L.control.scale().addTo(pelapak);
        pelapak.invalidateSize();
    });
});
</script>