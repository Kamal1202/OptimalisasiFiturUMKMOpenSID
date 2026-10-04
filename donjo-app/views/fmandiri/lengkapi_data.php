<style>
.form-lengkapi-data .box-header.with-border {
    padding: 10px 15px;
    min-height: 50px;
}

.form-lengkapi-data .box-header .box-title {
    display: inline-block;
    margin: 0;
    line-height: 30px;
    font-size: 18px;
    font-weight: 600;
    color: #333;
}

.form-lengkapi-data .box-header .box-tools {
    top: 8px;
    right: 10px;
}

.form-lengkapi-data .btn-kembali-profil,
.form-lengkapi-data .btn-kembali-profil:visited {
    color: #444 !important;
    background-color: #f4f4f4 !important;
    border-color: #ddd !important;
}

.form-lengkapi-data .btn-kembali-profil:hover,
.form-lengkapi-data .btn-kembali-profil:focus,
.form-lengkapi-data .btn-kembali-profil:active {
    color: #222 !important;
    background-color: #e7e7e7 !important;
    border-color: #adadad !important;
}

.form-lengkapi-data .btn-kembali-profil i,
.form-lengkapi-data .btn-kembali-profil span {
    color: inherit !important;
}

.form-lengkapi-data .box-body {
    padding: 16px 18px;
}

.form-lengkapi-data .form-section {
    margin-top: 20px;
    padding-top: 16px;
    border-top: 1px solid #e5e5e5;
}

.form-lengkapi-data .form-section:first-of-type {
    margin-top: 8px;
    padding-top: 0;
    border-top: 0;
}

.form-lengkapi-data .section-title {
    margin: 0 0 14px 0;
    font-size: 16px;
    font-weight: 700;
    color: #333;
}

.form-lengkapi-data .form-group {
    margin-bottom: 16px;
}

.form-lengkapi-data label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    line-height: 1.35;
    margin-bottom: 6px;
    color: #333;
}

.form-lengkapi-data .form-control.input-sm {
    height: 32px;
    padding: 5px 8px;
    font-size: 13px;
    line-height: 1.4;
}

.form-lengkapi-data select.form-control.input-sm {
    padding: 4px 8px;
}

.form-lengkapi-data textarea.form-control.input-sm {
    height: auto;
    min-height: 64px;
    padding: 7px 8px;
    resize: vertical;
}

.form-lengkapi-data .alert {
    padding: 10px 12px;
    font-size: 13px;
    line-height: 1.45;
    margin-bottom: 12px;
}

.form-lengkapi-data .box-footer {
    padding: 12px 18px;
}

.form-lengkapi-data .btn-sm {
    font-size: 12px;
    padding: 5px 10px;
}

@media (max-width: 767px) {
    .form-lengkapi-data .box-header .box-tools {
        position: static;
        float: none !important;
        margin-top: 8px;
        text-align: left;
    }

    .form-lengkapi-data .box-header .box-title {
        display: block;
    }
}
</style>

<div class="box box-primary form-lengkapi-data">
    <div class="box-header with-border">
        <h3 class="box-title">Ajukan Pelengkapan Data Diri</h3>

        <div class="box-tools pull-right">
            <a href="<?= site_url('layanan-mandiri/profil') ?>" class="btn btn-default btn-sm btn-kembali-profil">
                <i class="fa fa-arrow-left"></i>
                <span>Kembali ke Profil</span>
            </a>
        </div>
    </div>

    <form action="<?= $form_action ?>" method="post">
        <div class="box-body">
            <div class="alert alert-info">
                Data yang Anda isi tidak langsung mengubah data resmi. Admin desa akan memeriksa dan memverifikasi
                pengajuan ini terlebih dahulu.
            </div>

            <?php if (empty($data_kosong)) : ?>
            <div class="alert alert-success">
                Data profil Anda sudah lengkap berdasarkan pengecekan awal.
            </div>
            <?php else : ?>
            <div class="alert alert-warning">
                <strong>Data yang terdeteksi belum lengkap:</strong>
                <ul style="margin-bottom: 0; margin-top: 6px;">
                    <?php foreach ($data_kosong as $label) : ?>
                    <li><?= html_escape($label) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <?php if (! empty($pengajuan_aktif)) : ?>
            <div class="alert alert-warning">
                <strong>Pengajuan sedang menunggu verifikasi.</strong><br>
                Anda belum bisa mengirim pengajuan baru sampai pengajuan sebelumnya diverifikasi oleh admin desa.
            </div>
            <?php endif; ?>

            <?php if (! empty($pengajuan_terakhir) && (int) $pengajuan_terakhir->status === 3) : ?>
            <div class="alert alert-warning">
                <strong>Pengajuan membutuhkan perbaikan.</strong><br>

                <?php if (! empty($pengajuan_terakhir->catatan_admin)) : ?>
                <strong>Catatan Admin:</strong><br>
                <?= nl2br(html_escape($pengajuan_terakhir->catatan_admin)) ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <div class="form-section">
                <h4 class="section-title">Identitas Penduduk</h4>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" name="nik" class="form-control input-sm only-number" maxlength="16"
                                inputmode="numeric"
                                value="<?= html_escape($penduduk_raw['nik'] ?? $penduduk['nik'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nomor KK</label>
                            <input type="text" name="no_kk" class="form-control input-sm only-number" maxlength="16"
                                inputmode="numeric"
                                value="<?= html_escape($penduduk_raw['no_kk'] ?? $penduduk['no_kk'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk_raw['nama'] ?? $penduduk['nama'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Hubungan dalam Keluarga</label>
                            <?php if (! empty($list_hubungan)) : ?>
                            <select name="kk_level" class="form-control input-sm">
                                <option value="">Pilih Hubungan</option>
                                <?php foreach ($list_hubungan as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['kk_level'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <?php else : ?>
                            <input type="text" name="kk_level" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk['hubungan'] ?? $penduduk_raw['kk_level'] ?? '') ?>">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jenis Kelamin</label>
                            <select name="sex" class="form-control input-sm">
                                <option value="">Pilih Jenis Kelamin</option>
                                <?php foreach ($list_sex as $row) : ?>
                                <option value="<?= $row->id ?>" <?= selected($penduduk_raw['sex'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Agama</label>
                            <select name="agama_id" class="form-control input-sm">
                                <option value="">Pilih Agama</option>
                                <?php foreach ($list_agama as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['agama_id'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status Penduduk</label>
                            <?php if (! empty($list_status)) : ?>
                            <select name="status" class="form-control input-sm">
                                <option value="">Pilih Status Penduduk</option>
                                <?php foreach ($list_status as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['status'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <?php else : ?>
                            <input type="text" name="status" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk['status'] ?? $penduduk_raw['status'] ?? '') ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Data KTP</h4>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Wajib KTP</label>
                            <input type="text" name="wajib_ktp" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk['wajib_ktp'] ?? $penduduk_raw['wajib_ktp'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>KTP-EL</label>
                            <input type="text" name="ktp_el" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk['ktp_el'] ?? $penduduk_raw['ktp_el'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status Rekam</label>
                            <input type="text" name="status_rekam" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk['status_rekam'] ?? $penduduk_raw['status_rekam'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tag ID Card</label>
                            <input type="text" name="tag_id_card" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk_raw['tag_id_card'] ?? $penduduk['tag_id_card'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Data Kelahiran</h4>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nomor Akta Lahir</label>
                            <input type="text" name="akta_lahir" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk_raw['akta_lahir'] ?? $penduduk['akta_lahir'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempatlahir" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk_raw['tempatlahir'] ?? $penduduk['tempatlahir'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggallahir" class="form-control input-sm"
                                value="<?= html_escape($penduduk_raw['tanggallahir'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tempat Dilahirkan</label>
                            <?php if (! empty($list_tempat_lahir)) : ?>
                            <select name="tempat_dilahirkan_id" class="form-control input-sm">
                                <option value="">Pilih Tempat Dilahirkan</option>
                                <?php foreach ($list_tempat_lahir as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['tempat_dilahirkan_id'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <?php else : ?>
                            <input type="text" name="tempat_dilahirkan_id" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk['tempat_dilahirkan_nama'] ?? $penduduk_raw['tempat_dilahirkan_id'] ?? '') ?>">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jenis Kelahiran</label>
                            <?php if (! empty($list_jenis_lahir)) : ?>
                            <select name="jenis_kelahiran_id" class="form-control input-sm">
                                <option value="">Pilih Jenis Kelahiran</option>
                                <?php foreach ($list_jenis_lahir as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['jenis_kelahiran_id'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <?php else : ?>
                            <input type="text" name="jenis_kelahiran_id" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk['jenis_kelahiran_nama'] ?? $penduduk_raw['jenis_kelahiran_id'] ?? '') ?>">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Kelahiran Anak Ke</label>
                            <input type="text" name="kelahiran_anak_ke" class="form-control input-sm only-number"
                                maxlength="2" inputmode="numeric"
                                value="<?= html_escape($penduduk_raw['kelahiran_anak_ke'] ?? $penduduk['kelahiran_anak_ke'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Penolong Kelahiran</label>
                            <?php if (! empty($list_penolong_lahir)) : ?>
                            <select name="penolong_kelahiran_id" class="form-control input-sm">
                                <option value="">Pilih Penolong Kelahiran</option>
                                <?php foreach ($list_penolong_lahir as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['penolong_kelahiran_id'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <?php else : ?>
                            <input type="text" name="penolong_kelahiran_id" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk['penolong_kelahiran_nama'] ?? $penduduk_raw['penolong_kelahiran_id'] ?? '') ?>">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Berat Lahir / Gram</label>
                            <input type="text" name="berat_lahir" class="form-control input-sm only-number"
                                maxlength="5" inputmode="numeric"
                                value="<?= html_escape($penduduk_raw['berat_lahir'] ?? $penduduk['berat_lahir'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Panjang Lahir / cm</label>
                            <input type="text" name="panjang_lahir" class="form-control input-sm only-number"
                                maxlength="3" inputmode="numeric"
                                value="<?= html_escape($penduduk_raw['panjang_lahir'] ?? $penduduk['panjang_lahir'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Pendidikan dan Pekerjaan</h4>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pendidikan dalam KK</label>
                            <select name="pendidikan_kk_id" class="form-control input-sm">
                                <option value="">Pilih Pendidikan</option>
                                <?php foreach ($list_pendidikan_kk as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['pendidikan_kk_id'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pendidikan Sedang Ditempuh</label>
                            <select name="pendidikan_sedang_id" class="form-control input-sm">
                                <option value="">Pilih Pendidikan</option>
                                <?php foreach ($list_pendidikan as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['pendidikan_sedang_id'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pekerjaan</label>
                            <select name="pekerjaan_id" class="form-control input-sm">
                                <option value="">Pilih Pekerjaan</option>
                                <?php foreach ($list_pekerjaan as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['pekerjaan_id'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Kewarganegaraan dan Dokumen Keimigrasian</h4>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Warga Negara</label>
                            <select name="warganegara_id" class="form-control input-sm">
                                <option value="">Pilih Warga Negara</option>
                                <?php foreach ($list_warganegara as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['warganegara_id'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nomor Paspor</label>
                            <input type="text" name="dokumen_pasport" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk_raw['dokumen_pasport'] ?? $penduduk['dokumen_pasport'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Tanggal Akhir Paspor</label>
                            <input type="date" name="tanggal_akhir_paspor" class="form-control input-sm"
                                value="<?= html_escape($penduduk_raw['tanggal_akhir_paspor'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nomor KITAS</label>
                            <input type="text" name="dokumen_kitas" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk_raw['dokumen_kitas'] ?? $penduduk['dokumen_kitas'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Data Orang Tua</h4>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>NIK Ayah</label>
                            <input type="text" name="ayah_nik" class="form-control input-sm only-number" maxlength="16"
                                inputmode="numeric"
                                value="<?= html_escape($penduduk_raw['ayah_nik'] ?? $penduduk['ayah_nik'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nama Ayah</label>
                            <input type="text" name="nama_ayah" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk_raw['nama_ayah'] ?? $penduduk['nama_ayah'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>NIK Ibu</label>
                            <input type="text" name="ibu_nik" class="form-control input-sm only-number" maxlength="16"
                                inputmode="numeric"
                                value="<?= html_escape($penduduk_raw['ibu_nik'] ?? $penduduk['ibu_nik'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Nama Ibu</label>
                            <input type="text" name="nama_ibu" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk_raw['nama_ibu'] ?? $penduduk['nama_ibu'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Kontak</h4>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nomor HP</label>
                            <input type="text" name="telepon" class="form-control input-sm only-number" maxlength="15"
                                inputmode="numeric"
                                value="<?= html_escape($penduduk_raw['telepon'] ?? $penduduk['telepon'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control input-sm lowercase"
                                value="<?= html_escape($penduduk_raw['email'] ?? $penduduk['email'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Telegram</label>
                            <input type="text" name="telegram" class="form-control input-sm"
                                value="<?= html_escape($penduduk_raw['telegram'] ?? $penduduk['telegram'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Alamat</h4>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea name="alamat" class="form-control input-sm uppercase"
                        rows="2"><?= html_escape($penduduk_raw['alamat_sekarang'] ?? $penduduk_raw['alamat'] ?? $penduduk['alamat'] ?? '') ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>Dusun / RW / RT</label>
                            <select name="id_cluster" class="form-control input-sm">
                                <option value="">Pilih Wilayah</option>
                                <?php foreach ($list_wilayah as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['id_cluster'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->dusun) ?>
                                    <?php if (! empty($row->rw) && $row->rw !== '-') : ?>
                                    - RW <?= html_escape($row->rw) ?>
                                    <?php endif; ?>
                                    / RT <?= html_escape($row->rt) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Alamat Sebelumnya</label>
                            <input type="text" name="alamat_sebelumnya" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk_raw['alamat_sebelumnya'] ?? $penduduk['alamat_sebelumnya'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Status Perkawinan</h4>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status Perkawinan</label>
                            <select name="status_kawin" class="form-control input-sm">
                                <option value="">Pilih Status Perkawinan</option>
                                <?php foreach ($list_kawin as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['status_kawin'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nomor Akta Perkawinan</label>
                            <input type="text" name="akta_perkawinan" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk_raw['akta_perkawinan'] ?? $penduduk['akta_perkawinan'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Perkawinan</label>
                            <input type="date" name="tanggalperkawinan" class="form-control input-sm"
                                value="<?= html_escape($penduduk_raw['tanggalperkawinan'] ?? '') ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Nomor Akta Perceraian</label>
                            <input type="text" name="akta_perceraian" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk_raw['akta_perceraian'] ?? $penduduk['akta_perceraian'] ?? '') ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tanggal Perceraian</label>
                            <input type="date" name="tanggalperceraian" class="form-control input-sm"
                                value="<?= html_escape($penduduk_raw['tanggalperceraian'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Kesehatan dan Asuransi</h4>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Golongan Darah</label>
                            <select name="golongan_darah_id" class="form-control input-sm">
                                <option value="">Pilih Golongan Darah</option>
                                <?php foreach ($list_golongan_darah as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['golongan_darah_id'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Disabilitas</label>
                            <?php if (! empty($list_cacat)) : ?>
                            <select name="cacat_id" class="form-control input-sm">
                                <option value="">Pilih Disabilitas</option>
                                <?php foreach ($list_cacat as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['cacat_id'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <?php else : ?>
                            <input type="text" name="cacat_id" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk['cacat'] ?? $penduduk_raw['cacat_id'] ?? '') ?>">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sakit Menahun</label>
                            <?php if (! empty($list_sakit_menahun)) : ?>
                            <select name="sakit_menahun_id" class="form-control input-sm">
                                <option value="">Pilih Sakit Menahun</option>
                                <?php foreach ($list_sakit_menahun as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['sakit_menahun_id'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <?php else : ?>
                            <input type="text" name="sakit_menahun_id" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk['sakit_menahun'] ?? $penduduk_raw['sakit_menahun_id'] ?? '') ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cara KB</label>
                            <?php if (! empty($list_cara_kb)) : ?>
                            <select name="cara_kb_id" class="form-control input-sm">
                                <option value="">Pilih Cara KB</option>
                                <?php foreach ($list_cara_kb as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['cara_kb_id'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <?php else : ?>
                            <input type="text" name="cara_kb_id" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk['cara_kb'] ?? $penduduk_raw['cara_kb_id'] ?? '') ?>">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Status Kehamilan</label>
                            <?php if (! empty($list_hamil)) : ?>
                            <select name="hamil" class="form-control input-sm">
                                <option value="">Pilih Status Kehamilan</option>
                                <?php foreach ($list_hamil as $row) : ?>
                                <option value="<?= $row->id ?>" <?= selected($penduduk_raw['hamil'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <?php else : ?>
                            <select name="hamil" class="form-control input-sm">
                                <option value="">Pilih Status Kehamilan</option>
                                <option value="1" <?= selected($penduduk_raw['hamil'] ?? '', 1) ?>>HAMIL</option>
                                <option value="2" <?= selected($penduduk_raw['hamil'] ?? '', 2) ?>>TIDAK HAMIL</option>
                            </select>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jenis Asuransi</label>
                            <select name="id_asuransi" class="form-control input-sm">
                                <option value="">Pilih Asuransi</option>
                                <?php foreach ($list_asuransi as $row) : ?>
                                <option value="<?= $row->id ?>"
                                    <?= selected($penduduk_raw['id_asuransi'] ?? '', $row->id) ?>>
                                    <?= html_escape($row->nama) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nomor Asuransi</label>
                            <input type="text" name="no_asuransi" class="form-control input-sm uppercase"
                                value="<?= html_escape($penduduk_raw['no_asuransi'] ?? $penduduk['no_asuransi'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h4 class="section-title">Catatan Pengajuan</h4>

                <div class="form-group">
                    <label>Catatan untuk Admin</label>
                    <textarea name="catatan" class="form-control input-sm" rows="3"
                        placeholder="Contoh: Saya ingin memperbarui nomor HP, pekerjaan, dan alamat."></textarea>
                </div>
            </div>
        </div>

        <div class="box-footer text-right">

            <?php if (! empty($pengajuan_aktif)) : ?>

            <button type="button" class="btn btn-warning btn-sm" disabled>
                <i class="fa fa-clock-o"></i> Menunggu Verifikasi Admin
            </button>

            <?php elseif (! empty($pengajuan_terakhir) && (int) $pengajuan_terakhir->status === 3) : ?>

            <button type="submit" class="btn btn-warning btn-sm">
                <i class="fa fa-refresh"></i> Perbaiki & Kirim Ulang
            </button>

            <?php elseif (! empty($data_kosong)) : ?>

            <button type="submit" class="btn btn-primary btn-sm">
                <i class="fa fa-send"></i> Kirim Pengajuan
            </button>

            <?php else : ?>

            <button type="button" class="btn btn-success btn-sm" disabled>
                <i class="fa fa-check"></i> Data Sudah Lengkap
            </button>

            <?php endif; ?>

        </div>
    </form>
</div>

<script>
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('uppercase')) {
        e.target.value = e.target.value.toUpperCase();
    }

    if (e.target.classList.contains('lowercase')) {
        e.target.value = e.target.value.toLowerCase();
    }

    if (e.target.classList.contains('only-number')) {
        e.target.value = e.target.value.replace(/[^0-9]/g, '');
    }
});
</script>