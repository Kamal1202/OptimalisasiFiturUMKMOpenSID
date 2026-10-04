<style>
.profil-lapak {
    border-top: 3px solid #3c8dbc;
}

.profil-lapak .box-header.with-border {
    padding: 12px 16px;
    min-height: 54px;
}

.profil-lapak .box-title {
    font-size: 18px;
    font-weight: 700;
    line-height: 30px;
    color: #333;
}

.profil-lapak .box-body {
    padding: 18px 20px;
}

.profil-lapak .box-footer {
    padding: 14px 20px;
    background: #fafafa;
    border-top: 1px solid #eee;
}

.profil-lapak .form-section {
    margin-bottom: 22px;
}

.profil-lapak .form-section-title {
    font-size: 15px;
    font-weight: 700;
    color: #333;
    margin: 0 0 14px;
    padding-bottom: 8px;
    border-bottom: 1px solid #eee;
}

.profil-lapak label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #333;
    margin-bottom: 6px;
}

.profil-lapak .form-control.input-sm {
    height: 34px;
    padding: 6px 9px;
    font-size: 13px;
    border-radius: 3px;
}

.profil-lapak textarea.form-control.input-sm {
    height: auto;
    min-height: 105px;
    resize: vertical;
}

.profil-lapak .help-text {
    display: block;
    color: #777;
    font-size: 12px;
    margin-top: 5px;
    line-height: 1.45;
}

.profil-lapak .media-upload-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
}

.profil-lapak .media-box {
    border: 1px solid #eee;
    border-radius: 8px;
    background: #fafafa;
    padding: 12px;
}

.profil-lapak .media-preview {
    width: 100%;
    border-radius: 8px;
    background: #eef6f8;
    border: 1px solid #ddd;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #3c8dbc;
    margin-bottom: 10px;
}

.profil-lapak .media-preview.logo-preview {
    width: 110px;
    height: 110px;
    font-size: 42px;
}

.profil-lapak .media-preview.banner-preview {
    height: 170px;
    font-size: 42px;
}

.profil-lapak .media-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.profil-lapak .media-title {
    font-weight: 700;
    margin-bottom: 6px;
    color: #333;
}

.profil-lapak #mapLapak {
    width: 100%;
    height: 360px;
    border: 1px solid #ddd;
    border-radius: 8px;
    overflow: hidden;
    background: #f3f7f9;
}

.profil-lapak .map-note {
    margin-top: 8px;
    font-size: 12px;
    color: #666;
    line-height: 1.5;
}

.profil-lapak .btn-kembali-lapak,
.profil-lapak .btn-kembali-lapak:visited,
.profil-lapak .btn-batal-lapak,
.profil-lapak .btn-batal-lapak:visited {
    color: #444 !important;
    background-color: #f4f4f4 !important;
    border-color: #ddd !important;
    opacity: 1 !important;
}

.profil-lapak .btn-primary,
.profil-lapak .btn-primary:visited {
    color: #fff !important;
    background-color: #3c8dbc !important;
    border-color: #367fa9 !important;
    opacity: 1 !important;
}

.profil-lapak .btn-primary:hover,
.profil-lapak .btn-primary:focus {
    color: #fff !important;
    background-color: #367fa9 !important;
    border-color: #2f6f94 !important;
}

.profil-lapak .btn i {
    color: inherit !important;
}

@media (max-width: 767px) {
    .profil-lapak .media-upload-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="box box-primary profil-lapak">
    <div class="box-header with-border">
        <h3 class="box-title">Kelola Profil Lapak</h3>

        <div class="box-tools pull-right">
            <a href="<?= site_url($controller) ?>" class="btn btn-default btn-sm btn-kembali-lapak">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <form action="<?= $form_action ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">
            <div class="alert alert-info">
                Profil lapak digunakan untuk menampilkan identitas usaha, kontak WhatsApp, logo, banner/foto lapak, dan
                lokasi lapak pada halaman Lapak publik desa.
            </div>

            <div class="form-section">
                <h4 class="form-section-title">Media Lapak</h4>

                <div class="media-upload-grid">
                    <div class="media-box">
                        <div class="media-title">Logo Lapak</div>

                        <div class="media-preview logo-preview" id="logoPreview">
                            <?php if (! empty($pelapak->logo)) : ?>
                            <img src="<?= base_url('desa/upload/lapak/logo/' . $pelapak->logo) ?>" alt="Logo Lapak">
                            <?php else : ?>
                            <i class="fa fa-shopping-bag"></i>
                            <?php endif; ?>
                        </div>

                        <input type="file" name="logo" id="logoLapak" class="form-control input-sm"
                            accept="image/jpeg,image/png,image/webp">

                        <span class="help-text">
                            Logo tampil sebagai identitas kecil lapak. Gunakan gambar kotak/square agar hasilnya rapi.
                            Maksimal 5 MB.
                        </span>

                        <?php if (! empty($pelapak->logo)) : ?>
                        <label style="margin-top:10px; font-weight:400;">
                            <input type="checkbox" name="hapus_logo" value="1">
                            Hapus logo saat ini
                        </label>
                        <?php endif; ?>
                    </div>

                    <div class="media-box">
                        <div class="media-title">Banner / Foto Lapak</div>

                        <div class="media-preview banner-preview" id="bannerPreview">
                            <?php if (! empty($pelapak->banner)) : ?>
                            <img src="<?= base_url('desa/upload/lapak/banner/' . $pelapak->banner) ?>"
                                alt="Banner Lapak">
                            <?php else : ?>
                            <i class="fa fa-image"></i>
                            <?php endif; ?>
                        </div>

                        <input type="file" name="banner" id="bannerLapak" class="form-control input-sm"
                            accept="image/jpeg,image/png,image/webp">

                        <span class="help-text">
                            Banner tampil sebagai foto sampul halaman lapak. Gunakan gambar lebar seperti foto
                            warung/toko. Maksimal 8 MB.
                        </span>

                        <?php if (! empty($pelapak->banner)) : ?>
                        <label style="margin-top:10px; font-weight:400;">
                            <input type="checkbox" name="hapus_banner" value="1">
                            Hapus banner saat ini
                        </label>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="form-section-title">Identitas Lapak</h4>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Lapak / Nama Usaha</label>
                            <input type="text" name="nama_lapak" class="form-control input-sm" required
                                value="<?= html_escape($pelapak->nama_lapak ?? '') ?>"
                                placeholder="Contoh: Aldi's Burger">
                            <span class="help-text">
                                Nama ini akan digunakan sebagai identitas usaha pada halaman lapak.
                            </span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nomor WhatsApp</label>
                            <input type="text" name="telepon" class="form-control input-sm only-number" required
                                value="<?= html_escape($pelapak->telepon ?? '') ?>" placeholder="Contoh: 081234567890">
                            <span class="help-text">
                                Isi angka saja. Nomor ini dipakai untuk tombol beli via WhatsApp.
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Deskripsi Lapak</label>
                    <textarea name="deskripsi_lapak" class="form-control input-sm" rows="4"
                        placeholder="Contoh: Menyediakan aneka burger rumahan, minuman dingin, dan camilan."><?= html_escape($pelapak->deskripsi_lapak ?? '') ?></textarea>
                    <span class="help-text">
                        Tulis deskripsi singkat agar pengunjung memahami jenis usaha atau produk yang dijual.
                    </span>
                </div>
            </div>

            <div class="form-section">
                <h4 class="form-section-title">Lokasi Lapak</h4>

                <div id="mapLapak"></div>

                <div class="map-note">
                    Geser marker atau klik titik lokasi pada peta untuk menentukan lokasi lapak. Koordinat akan disimpan
                    otomatis oleh sistem.
                </div>

                <input type="hidden" name="lat" id="latLapak" value="<?= html_escape($lokasi['lat']) ?>">
                <input type="hidden" name="lng" id="lngLapak" value="<?= html_escape($lokasi['lng']) ?>">
                <input type="hidden" name="zoom" id="zoomLapak" value="<?= html_escape($lokasi['zoom']) ?>">
            </div>
        </div>

        <div class="box-footer text-right">
            <a href="<?= site_url($controller) ?>" class="btn btn-default btn-sm btn-batal-lapak">
                Batal
            </a>

            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-save"></i> Simpan Profil Lapak
            </button>
        </div>
    </form>
</div>

<link rel="stylesheet" href="<?= base_url('assets/css/leaflet.css') ?>">

<script>
(function() {
    function loadScript(src, callback, errorCallback) {
        var existing = document.querySelector('script[src="' + src + '"]');

        if (existing) {
            existing.addEventListener('load', callback);
            callback();
            return;
        }

        var script = document.createElement('script');
        script.src = src;
        script.onload = callback;
        script.onerror = errorCallback || function() {};
        document.head.appendChild(script);
    }

    function initOnlyNumber() {
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('only-number')) {
                e.target.value = e.target.value.replace(/[^0-9]/g, '');
            }
        });
    }

    function initMediaPreview(inputId, previewId) {
        var input = document.getElementById(inputId);
        var preview = document.getElementById(previewId);

        if (!input || !preview) {
            return;
        }

        input.addEventListener('change', function() {
            var file = input.files && input.files[0] ? input.files[0] : null;

            if (!file) {
                return;
            }

            if (!file.type.match(/^image\//)) {
                alert('File harus berupa gambar.');
                input.value = '';
                return;
            }

            var reader = new FileReader();

            reader.onload = function(e) {
                preview.innerHTML = '<img src="' + e.target.result + '" alt="Preview">';
            };

            reader.readAsDataURL(file);
        });
    }

    function initLapakMap() {
        var mapEl = document.getElementById('mapLapak');

        if (!mapEl) {
            return;
        }

        if (typeof L === 'undefined') {
            mapEl.innerHTML =
                '<div style="padding: 20px; color: #a94442;">Peta gagal dimuat. Leaflet JS tidak tersedia.</div>';
            return;
        }

        var latInput = document.getElementById('latLapak');
        var lngInput = document.getElementById('lngLapak');
        var zoomInput = document.getElementById('zoomLapak');

        var lat = parseFloat(latInput.value || '-6.200000');
        var lng = parseFloat(lngInput.value || '106.816666');
        var zoom = parseInt(zoomInput.value || '10', 10);

        if (isNaN(lat)) {
            lat = -6.200000;
        }

        if (isNaN(lng)) {
            lng = 106.816666;
        }

        if (isNaN(zoom) || zoom < 1 || zoom > 20) {
            zoom = 10;
        }

        var map = L.map('mapLapak').setView([lat, lng], zoom);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        var marker = L.marker([lat, lng], {
            draggable: true
        }).addTo(map);

        function updateLatLng(position) {
            latInput.value = position.lat.toFixed(8);
            lngInput.value = position.lng.toFixed(8);
            zoomInput.value = map.getZoom();
        }

        marker.on('dragend', function() {
            updateLatLng(marker.getLatLng());
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            updateLatLng(e.latlng);
        });

        map.on('zoomend', function() {
            zoomInput.value = map.getZoom();
        });

        setTimeout(function() {
            map.invalidateSize();
        }, 300);
    }

    document.addEventListener('DOMContentLoaded', function() {
        initOnlyNumber();
        initMediaPreview('logoLapak', 'logoPreview');
        initMediaPreview('bannerLapak', 'bannerPreview');

        if (typeof L !== 'undefined') {
            initLapakMap();
            return;
        }

        loadScript(
            '<?= base_url('assets/js/leaflet.js') ?>',
            initLapakMap,
            function() {
                var mapEl = document.getElementById('mapLapak');

                if (mapEl) {
                    mapEl.innerHTML =
                        '<div style="padding: 20px; color: #a94442;">Peta gagal dimuat. File assets/js/leaflet.js tidak ditemukan.</div>';
                }
            }
        );
    });
})();
</script>