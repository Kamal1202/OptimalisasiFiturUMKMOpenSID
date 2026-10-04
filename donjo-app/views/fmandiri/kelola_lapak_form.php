<style>
.form-kelola-lapak {
    border-top: 3px solid #3c8dbc;
}

.form-kelola-lapak .box-header.with-border {
    padding: 12px 16px;
    min-height: 54px;
}

.form-kelola-lapak .box-header .box-title {
    font-size: 18px;
    font-weight: 700;
    line-height: 30px;
    color: #333;
}

.form-kelola-lapak .box-tools {
    top: 10px;
    right: 12px;
}

.form-kelola-lapak .box-body {
    padding: 18px 20px;
}

.form-kelola-lapak .box-footer {
    padding: 14px 20px;
    background: #fafafa;
    border-top: 1px solid #eee;
}

.form-kelola-lapak .alert {
    margin-bottom: 20px;
    padding: 11px 13px;
    line-height: 1.5;
}

.form-kelola-lapak .form-section {
    margin-bottom: 22px;
}

.form-kelola-lapak .form-section-title {
    font-size: 15px;
    font-weight: 700;
    color: #333;
    margin: 0 0 14px;
    padding-bottom: 8px;
    border-bottom: 1px solid #eee;
}

.form-kelola-lapak .form-grid {
    display: grid;
    grid-template-columns: repeat(12, 1fr);
    gap: 16px;
    align-items: start;
}

.form-kelola-lapak .field-col-3 {
    grid-column: span 3;
}

.form-kelola-lapak .field-col-4 {
    grid-column: span 4;
}

.form-kelola-lapak .field-col-6 {
    grid-column: span 6;
}

.form-kelola-lapak .field-col-8 {
    grid-column: span 8;
}

.form-kelola-lapak .field-col-12 {
    grid-column: span 12;
}

.form-kelola-lapak .form-group {
    margin-bottom: 0;
}

.form-kelola-lapak label {
    display: block;
    font-size: 13px;
    font-weight: 700;
    color: #333;
    margin-bottom: 6px;
    line-height: 1.4;
}

.form-kelola-lapak .form-control.input-sm {
    height: 34px;
    padding: 6px 9px;
    font-size: 13px;
    line-height: 1.4;
    border-radius: 3px;
}

.form-kelola-lapak textarea.form-control.input-sm {
    height: auto;
    min-height: 105px;
    resize: vertical;
}

.form-kelola-lapak .help-text {
    display: block;
    color: #777;
    font-size: 12px;
    margin-top: 5px;
    line-height: 1.45;
}

.form-kelola-lapak .foto-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

.form-kelola-lapak .foto-box {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 12px;
    background: #fafafa;
}

.form-kelola-lapak .foto-box label {
    margin-bottom: 8px;
}

.form-kelola-lapak .foto-preview {
    height: 132px;
    background: #eef6f8;
    border-radius: 6px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border: 1px solid #e5eef1;
}

.form-kelola-lapak .foto-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.form-kelola-lapak .foto-preview i {
    font-size: 38px;
    color: #3c8dbc;
}

.form-kelola-lapak .btn-kembali-lapak,
.form-kelola-lapak .btn-kembali-lapak:visited,
.form-kelola-lapak .btn-batal-lapak,
.form-kelola-lapak .btn-batal-lapak:visited {
    color: #444 !important;
    background-color: #f4f4f4 !important;
    border-color: #ddd !important;
    opacity: 1 !important;
}

.form-kelola-lapak .btn-kembali-lapak:hover,
.form-kelola-lapak .btn-kembali-lapak:focus,
.form-kelola-lapak .btn-batal-lapak:hover,
.form-kelola-lapak .btn-batal-lapak:focus {
    color: #222 !important;
    background-color: #e7e7e7 !important;
    border-color: #adadad !important;
}

.form-kelola-lapak .btn-primary,
.form-kelola-lapak .btn-primary:visited {
    color: #fff !important;
    background-color: #3c8dbc !important;
    border-color: #367fa9 !important;
    opacity: 1 !important;
}

.form-kelola-lapak .btn-primary:hover,
.form-kelola-lapak .btn-primary:focus {
    color: #fff !important;
    background-color: #367fa9 !important;
    border-color: #2f6f94 !important;
}

.form-kelola-lapak .btn i {
    color: inherit !important;
}

@media (max-width: 991px) {

    .form-kelola-lapak .field-col-3,
    .form-kelola-lapak .field-col-4,
    .form-kelola-lapak .field-col-6,
    .form-kelola-lapak .field-col-8 {
        grid-column: span 6;
    }

    .form-kelola-lapak .foto-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 767px) {
    .form-kelola-lapak .box-header .box-tools {
        position: static;
        float: none !important;
        margin-top: 10px;
        text-align: left;
    }

    .form-kelola-lapak .box-header .box-title {
        display: block;
    }

    .form-kelola-lapak .field-col-3,
    .form-kelola-lapak .field-col-4,
    .form-kelola-lapak .field-col-6,
    .form-kelola-lapak .field-col-8,
    .form-kelola-lapak .field-col-12 {
        grid-column: span 12;
    }

    .form-kelola-lapak .foto-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
    $main = $main ?? null;
    $foto = [];

    if (! empty($main->foto)) {
        $decoded = json_decode((string) $main->foto, true);
        $foto = is_array($decoded) ? array_values($decoded) : [];
    }

    $tipe_potongan = $main->tipe_potongan ?? 1;
    $potongan      = $main->potongan ?? '';
?>

<div class="box box-primary form-kelola-lapak">
    <div class="box-header with-border">
        <h3 class="box-title"><?= html_escape($aksi) ?> Produk/Menu Lapak</h3>

        <div class="box-tools pull-right">
            <a href="<?= site_url($controller) ?>" class="btn btn-default btn-sm btn-kembali-lapak">
                <i class="fa fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <form action="<?= $form_action ?>" method="post" enctype="multipart/form-data">
        <div class="box-body">
            <div class="alert alert-info">
                Produk/menu yang disimpan akan terhubung dengan lapak Anda dan dapat tampil pada halaman Lapak publik
                desa.
            </div>

            <div class="form-section">
                <h4 class="form-section-title">Informasi Produk/Menu</h4>

                <div class="form-grid">
                    <div class="form-group field-col-8">
                        <label>Nama Produk/Menu</label>
                        <input type="text" name="nama" class="form-control input-sm" required
                            value="<?= html_escape($main->nama ?? '') ?>"
                            placeholder="Contoh: Soto Ayam, Keripik Singkong, Es Jeruk">
                    </div>

                    <div class="form-group field-col-4">
                        <label>Kategori</label>
                        <select name="id_produk_kategori" class="form-control input-sm" required>
                            <option value="">Pilih Kategori</option>
                            <?php foreach ($kategori as $row) : ?>
                            <option value="<?= $row->id ?>"
                                <?= ((string) ($main->id_produk_kategori ?? '') === (string) $row->id) ? 'selected' : '' ?>>
                                <?= html_escape($row->kategori) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group field-col-4">
                        <label>Harga</label>
                        <input type="text" name="harga" class="form-control input-sm only-number" required
                            value="<?= html_escape($main->harga ?? '') ?>" placeholder="Contoh: 15000">
                        <span class="help-text">Isi angka saja, tanpa titik atau Rp.</span>
                    </div>

                    <div class="form-group field-col-4">
                        <label>Satuan</label>
                        <select name="satuan" class="form-control input-sm" required>
                            <option value="">Pilih Satuan</option>
                            <?php foreach ($satuan as $item) : ?>
                            <option value="<?= html_escape($item) ?>"
                                <?= ((string) ($main->satuan ?? '') === (string) $item) ? 'selected' : '' ?>>
                                <?= html_escape($item) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group field-col-4">
                        <label>Tipe Potongan</label>
                        <select name="tipe_potongan" class="form-control input-sm" id="tipePotongan">
                            <option value="1" <?= ((string) $tipe_potongan === '1') ? 'selected' : '' ?>>Persen</option>
                            <option value="2" <?= ((string) $tipe_potongan === '2') ? 'selected' : '' ?>>Nominal
                            </option>
                        </select>
                    </div>

                    <div class="form-group field-col-4" id="potonganPersen"
                        style="<?= ((string) $tipe_potongan === '2') ? 'display:none;' : '' ?>">
                        <label>Potongan Persen</label>
                        <input type="text" name="persen" class="form-control input-sm only-number"
                            value="<?= ((string) $tipe_potongan === '1') ? html_escape($potongan) : '' ?>"
                            placeholder="Contoh: 10">
                    </div>

                    <div class="form-group field-col-4" id="potonganNominal"
                        style="<?= ((string) $tipe_potongan === '2') ? '' : 'display:none;' ?>">
                        <label>Potongan Nominal</label>
                        <input type="text" name="nominal" class="form-control input-sm only-number"
                            value="<?= ((string) $tipe_potongan === '2') ? html_escape($potongan) : '' ?>"
                            placeholder="Contoh: 5000">
                    </div>

                    <div class="form-group field-col-12">
                        <label>Deskripsi Produk/Menu</label>
                        <textarea name="deskripsi" class="form-control input-sm" rows="4"
                            placeholder="Tuliskan deskripsi singkat produk/menu."><?= html_escape($main->deskripsi ?? '') ?></textarea>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="form-section-title">Foto Produk/Menu</h4>

                <div class="foto-grid">
                    <?php for ($i = 1; $i <= (int) $this->setting->banyak_foto_tiap_produk; $i++) : ?>
                    <?php
                            $index = $i - 1;
                            $old_foto = $foto[$index] ?? '';
                        ?>

                    <div class="foto-box">
                        <label>Foto <?= $i ?></label>

                        <div class="foto-preview">
                            <?php if (! empty($old_foto) && defined('LOKASI_PRODUK')) : ?>
                            <img src="<?= base_url(LOKASI_PRODUK . $old_foto) ?>" alt="Foto produk <?= $i ?>">
                            <?php else : ?>
                            <i class="fa fa-image"></i>
                            <?php endif; ?>
                        </div>

                        <input type="hidden" name="old_foto_<?= $i ?>" value="<?= html_escape($old_foto) ?>">
                        <input type="file" name="foto_<?= $i ?>" class="form-control input-sm" accept="image/*">

                        <?php if (! empty($old_foto)) : ?>
                        <label style="margin-top: 8px; font-weight: normal;">
                            <input type="checkbox" name="hapus_foto_<?= $i ?>" value="1">
                            Hapus foto ini
                        </label>
                        <?php endif; ?>
                    </div>
                    <?php endfor; ?>
                </div>

                <span class="help-text">
                    Format yang disarankan: JPG, JPEG, PNG. Untuk mengubah foto, pilih file baru pada posisi foto yang
                    ingin diganti.
                </span>
            </div>
        </div>

        <div class="box-footer text-right">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-save"></i> Simpan Produk/Menu
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('only-number')) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    }
});

document.addEventListener('change', function(e) {
    if (e.target.id === 'tipePotongan') {
        var persen = document.getElementById('potonganPersen');
        var nominal = document.getElementById('potonganNominal');

        if (e.target.value === '2') {
            persen.style.display = 'none';
            nominal.style.display = '';
        } else {
            persen.style.display = '';
            nominal.style.display = 'none';
        }
    }
});
</script>