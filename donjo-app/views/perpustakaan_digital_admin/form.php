<style>
.perpus-admin-form .box-title {
    font-weight: 700;
}

.perpus-admin-form .form-section {
    margin-bottom: 18px;
    padding-bottom: 12px;
    border-bottom: 1px solid #eee;
}

.perpus-admin-form .form-section-title {
    font-size: 15px;
    font-weight: 700;
    margin: 0 0 12px;
}

.perpus-admin-form label {
    font-size: 12px;
    font-weight: 700;
}

.perpus-admin-form .help-text {
    display: block;
    font-size: 11px;
    color: #777;
    margin-top: 4px;
}

.perpus-admin-form .cover-preview {
    width: 140px;
    height: 190px;
    background: #eef6f8;
    border: 1px solid #ddd;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin-bottom: 8px;
}

.perpus-admin-form .cover-preview img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    background: #f5fcfd;
}

.perpus-admin-form .cover-preview i {
    font-size: 42px;
    color: #3c8dbc;
}

.perpus-admin-form .preview-file {
    font-size: 12px;
    color: #555;
    margin-top: 5px;
}
</style>

<?php
    $main = $main ?? null;
    $cover_url = '';

    if (! empty($main->sampul) && is_file(FCPATH . 'desa/upload/perpustakaan/sampul/' . $main->sampul)) {
        $cover_url = base_url('desa/upload/perpustakaan/sampul/' . $main->sampul);
    }
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?= html_escape($aksi) ?> Buku Digital
            <small>Perpustakaan Digital</small>
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="<?= site_url('hom_sid') ?>">
                    <i class="fa fa-home"></i> Home
                </a>
            </li>
            <li>
                <a href="<?= site_url($controller) ?>">Perpustakaan Digital</a>
            </li>
            <li class="active"><?= html_escape($aksi) ?> Buku</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-primary perpus-admin-form">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-book"></i> <?= html_escape($aksi) ?> Buku Digital
                        </h3>

                        <div class="box-tools pull-right">
                            <a href="<?= site_url($controller) ?>" class="btn btn-default btn-sm">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <form action="<?= $form_action ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="cover_base64" id="coverBase64">

                        <div class="box-body">
                            <div class="form-section">
                                <h4 class="form-section-title">Informasi Buku</h4>

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Judul Buku</label>
                                            <input type="text" name="judul" class="form-control input-sm" required
                                                value="<?= html_escape($main->judul ?? '') ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Kategori</label>
                                            <input type="text" name="kategori" class="form-control input-sm"
                                                value="<?= html_escape($main->kategori ?? '') ?>"
                                                placeholder="Contoh: Edukasi, UMKM">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control input-sm"
                                        rows="5"><?= html_escape($main->deskripsi ?? '') ?></textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Penerbit</label>
                                            <input type="text" name="penerbit" class="form-control input-sm"
                                                value="<?= html_escape($main->penerbit ?? '') ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Kontributor</label>
                                            <input type="text" name="kontributor" class="form-control input-sm"
                                                value="<?= html_escape($main->kontributor ?? '') ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Penulis</label>
                                            <input type="text" name="penulis" class="form-control input-sm"
                                                value="<?= html_escape($main->penulis ?? '') ?>">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Sumber</label>
                                            <input type="text" name="sumber" class="form-control input-sm"
                                                value="<?= html_escape($main->sumber ?? '') ?>"
                                                placeholder="Contoh: Literasi Digital">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">File Buku</h4>

                                <div class="form-group">
                                    <label>Upload PDF</label>
                                    <input type="file" name="file_pdf_upload" id="filePdfUpload"
                                        class="form-control input-sm" accept="application/pdf">
                                    <span class="help-text">
                                        Format wajib PDF. Untuk tambah buku baru, file PDF wajib diupload.
                                    </span>

                                    <?php if (! empty($main->file_pdf)) : ?>
                                    <div class="preview-file">
                                        File saat ini:
                                        <a href="<?= base_url('desa/upload/perpustakaan/pdf/' . $main->file_pdf) ?>"
                                            target="_blank">
                                            <?= html_escape($main->file_pdf) ?>
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Cover Buku</h4>

                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="cover-preview" id="coverPreview">
                                            <?php if (! empty($cover_url)) : ?>
                                            <img src="<?= html_escape($cover_url) ?>" alt="Cover">
                                            <?php else : ?>
                                            <i class="fa fa-book"></i>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label>Generate Cover dari PDF</label><br>
                                            <button type="button" class="btn btn-info btn-sm" id="btnGenerateCover">
                                                <i class="fa fa-magic"></i> Generate Cover dari Halaman Pertama PDF
                                            </button>
                                            <span class="help-text">
                                                Pilih file PDF terlebih dahulu, lalu klik tombol ini. Cover otomatis
                                                akan dibuat dari halaman pertama PDF.
                                            </span>
                                        </div>

                                        <div class="form-group">
                                            <label>Upload Cover Manual</label>
                                            <input type="file" name="sampul_upload" class="form-control input-sm"
                                                accept="image/*">
                                            <span class="help-text">
                                                Opsional. Jika upload cover manual, cover manual akan dipakai
                                                menggantikan cover hasil generate.
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <h4 class="form-section-title">Pengaturan</h4>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="aktif" class="form-control input-sm">
                                                <option value="1"
                                                    <?= (string) ($main->aktif ?? '1') === '1' ? 'selected' : '' ?>>
                                                    Aktif</option>
                                                <option value="0"
                                                    <?= (string) ($main->aktif ?? '') === '0' ? 'selected' : '' ?>>
                                                    Nonaktif</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="box-footer text-right">
                            <a href="<?= site_url($controller) ?>" class="btn btn-default btn-sm">
                                Batal
                            </a>

                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fa fa-save"></i> Simpan Buku
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </section>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>

<script>
if (typeof pdfjsLib !== 'undefined') {
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
}

document.getElementById('btnGenerateCover').addEventListener('click', function() {
    var input = document.getElementById('filePdfUpload');
    var file = input.files[0];

    if (!file) {
        alert('Pilih file PDF terlebih dahulu.');
        return;
    }

    if (typeof pdfjsLib === 'undefined') {
        alert('PDF.js gagal dimuat. Pastikan koneksi internet aktif atau simpan library PDF.js secara lokal.');
        return;
    }

    var reader = new FileReader();

    reader.onload = function(event) {
        var typedarray = new Uint8Array(event.target.result);

        pdfjsLib.getDocument({
            data: typedarray
        }).promise.then(function(pdf) {
            return pdf.getPage(1);
        }).then(function(page) {
            var viewport = page.getViewport({
                scale: 1.6
            });
            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');

            canvas.width = viewport.width;
            canvas.height = viewport.height;

            return page.render({
                canvasContext: context,
                viewport: viewport
            }).promise.then(function() {
                var dataUrl = canvas.toDataURL('image/jpeg', 0.9);

                document.getElementById('coverBase64').value = dataUrl;

                var preview = document.getElementById('coverPreview');
                preview.innerHTML = '';

                var img = document.createElement('img');
                img.src = dataUrl;
                img.alt = 'Cover PDF';

                preview.appendChild(img);
            });
        }).catch(function(error) {
            console.error(error);
            alert('Cover gagal dibuat dari PDF. Pastikan file PDF valid.');
        });
    };

    reader.readAsArrayBuffer(file);
});
</script>