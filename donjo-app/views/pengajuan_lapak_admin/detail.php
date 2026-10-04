<style>
.pengajuan-detail .box-title {
    font-weight: 700;
}

.pengajuan-detail .info-row {
    margin-bottom: 8px;
}

.pengajuan-detail .label-info-custom {
    display: inline-block;
    min-width: 130px;
    font-weight: 700;
}

.pengajuan-detail .compare-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

.pengajuan-detail .compare-box {
    border: 1px solid #e5e5e5;
    border-radius: 6px;
    background: #fff;
}

.pengajuan-detail .compare-title {
    padding: 10px 12px;
    border-bottom: 1px solid #e5e5e5;
    font-weight: 700;
    background: #f7f7f7;
}

.pengajuan-detail .compare-body {
    padding: 12px;
}

.pengajuan-detail table {
    margin-bottom: 0;
}

.pengajuan-detail .json-empty {
    color: #777;
    font-style: italic;
}

.pengajuan-detail .status-box {
    margin-top: 15px;
}

.pengajuan-detail .catatan-admin-box {
    background: #fff8e5;
    border: 1px solid #f0d58c;
    border-radius: 6px;
    padding: 12px;
    margin-top: 10px;
}

.pengajuan-detail .catatan-admin-box strong {
    display: block;
    margin-bottom: 6px;
}

.pengajuan-detail .foto-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.pengajuan-detail .foto-card {
    width: 160px;
    border: 1px solid #ddd;
    border-radius: 6px;
    padding: 8px;
    background: #fff;
}

.pengajuan-detail .foto-card img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 4px;
    background: #f5f5f5;
}

.pengajuan-detail .foto-caption {
    font-size: 11px;
    margin-top: 6px;
    word-break: break-all;
    color: #555;
}

.pengajuan-detail .foto-empty {
    color: #777;
    font-style: italic;
}

.pengajuan-detail .media-lapak-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 14px;
}

.pengajuan-detail .media-lapak-card {
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    background: #fff;
    padding: 12px;
}

.pengajuan-detail .media-lapak-title {
    font-weight: 700;
    margin-bottom: 10px;
    color: #333;
}

.pengajuan-detail .media-lapak-preview {
    width: 100%;
    height: 190px;
    border-radius: 6px;
    border: 1px solid #ddd;
    background: #f5f5f5;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    color: #777;
}

.pengajuan-detail .media-lapak-preview.logo {
    width: 150px;
    height: 150px;
}

.pengajuan-detail .media-lapak-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.pengajuan-detail .media-lapak-file {
    margin-top: 8px;
    font-size: 11px;
    color: #777;
    word-break: break-all;
}

@media (max-width: 991px) {
    .pengajuan-detail .compare-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 767px) {
    .pengajuan-detail .media-lapak-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
    $data_lama = $main->data_lama_array ?? [];
    $data_baru = $main->data_baru_array ?? [];

    if (! function_exists('label_field_pengajuan_lapak')) {
        function label_field_pengajuan_lapak($key)
        {
            $labels = [
                'nama'               => 'Nama',
                'nama_lapak'         => 'Nama Lapak',
                'nama_produk'        => 'Nama Produk',
                'deskripsi'          => 'Deskripsi',
                'deskripsi_lapak'    => 'Deskripsi Lapak',
                'keterangan'         => 'Keterangan',
                'harga'              => 'Harga',
                'satuan'             => 'Satuan',
                'kategori'           => 'Kategori',
                'id_kategori'        => 'Kategori',
                'id_produk_kategori' => 'Kategori Produk',
                'id_pend'            => 'ID Penduduk',
                'id_lapak'           => 'ID Lapak',
                'id_pelapak'         => 'ID Pelapak',
                'id_produk'          => 'ID Produk',
                'telepon'            => 'Telepon',
                'no_hp'              => 'Nomor HP',
                'alamat'             => 'Alamat',
                'lokasi'             => 'Lokasi',
                'lat'                => 'Latitude',
                'lng'                => 'Longitude',
                'zoom'               => 'Zoom Peta',
                'tipe_potongan'      => 'Tipe Potongan',
                'potongan'           => 'Potongan',
                'status'             => 'Status',
                'created_at'         => 'Dibuat Pada',
                'updated_at'         => 'Diperbarui Pada',
            ];

            return $labels[$key] ?? ucwords(str_replace('_', ' ', $key));
        }
    }

    if (! function_exists('foto_url_pengajuan_lapak')) {
        function foto_url_pengajuan_lapak($file, $jenis = 'pengajuan')
        {
            $file = trim((string) $file);

            if ($file === '') {
                return '';
            }

            if (preg_match('/^https?:\/\//i', $file)) {
                return $file;
            }

            $file = ltrim($file, '/');

            if ($jenis === 'produk') {
                $candidates = [
                    'desa/upload/produk/' . $file,
                    'desa/upload/lapak/produk/' . $file,
                    'desa/upload/lapak/' . $file,
                    'desa/upload/' . $file,
                    $file,
                ];
            } else {
                $candidates = [
                    'desa/upload/lapak/pengajuan/' . $file,
                    'desa/upload/produk/' . $file,
                    'desa/upload/lapak/produk/' . $file,
                    'desa/upload/lapak/' . $file,
                    'desa/upload/' . $file,
                    $file,
                ];
            }

            foreach ($candidates as $path) {
                if (defined('FCPATH') && file_exists(FCPATH . $path)) {
                    return base_url($path);
                }
            }

            return base_url($candidates[0]);
        }
    }

    if (! function_exists('ambil_foto_dari_data')) {
        function ambil_foto_dari_data($value)
        {
            $hasil = [];

            if (empty($value)) {
                return $hasil;
            }

            if (is_string($value)) {
                $value = trim($value);

                if ($value === '') {
                    return $hasil;
                }

                $decoded = json_decode($value, true);

                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    foreach ($decoded as $item) {
                        if (is_string($item) && trim($item) !== '') {
                            $hasil[] = trim($item);
                        } elseif (is_array($item)) {
                            foreach (['file', 'foto', 'gambar', 'nama_file', 'filename'] as $kolom) {
                                if (! empty($item[$kolom])) {
                                    $hasil[] = trim((string) $item[$kolom]);
                                }
                            }
                        }
                    }

                    return array_values(array_unique(array_filter($hasil)));
                }

                $hasil[] = $value;

                return $hasil;
            }

            if (is_array($value)) {
                foreach ($value as $item) {
                    if (is_string($item) && trim($item) !== '') {
                        $hasil[] = trim($item);
                    } elseif (is_array($item)) {
                        foreach (['file', 'foto', 'gambar', 'nama_file', 'filename'] as $kolom) {
                            if (! empty($item[$kolom])) {
                                $hasil[] = trim((string) $item[$kolom]);
                            }
                        }
                    }
                }
            }

            return array_values(array_unique(array_filter($hasil)));
        }
    }

    if (! function_exists('render_foto_cards_pengajuan_lapak')) {
        function render_foto_cards_pengajuan_lapak($files, $jenis = 'pengajuan')
        {
            if (empty($files)) {
                echo '<div class="foto-empty">Tidak ada foto.</div>';
                return;
            }

            echo '<div class="foto-grid">';

            foreach ($files as $file) {
                $nama_file = '';

                if (is_object($file)) {
                    $nama_file = $file->file ?? '';
                } elseif (is_array($file)) {
                    $nama_file = $file['file'] ?? ($file['foto'] ?? ($file['gambar'] ?? ''));
                } else {
                    $nama_file = (string) $file;
                }

                $nama_file = trim((string) $nama_file);

                if ($nama_file === '') {
                    continue;
                }

                $url = foto_url_pengajuan_lapak($nama_file, $jenis);

                echo '<div class="foto-card">';
                echo '<a href="' . html_escape($url) . '" target="_blank">';
                echo '<img src="' . html_escape($url) . '" alt="' . html_escape($nama_file) . '">';
                echo '</a>';
                echo '<div class="foto-caption">' . html_escape($nama_file) . '</div>';
                echo '</div>';
            }

            echo '</div>';
        }
    }

    if (! function_exists('media_lapak_url_pengajuan')) {
        function media_lapak_url_pengajuan($jenis, $file)
        {
            $file = trim((string) $file);

            if ($file === '') {
                return '';
            }

            if (preg_match('/^https?:\/\//i', $file)) {
                return $file;
            }

            $jenis = $jenis === 'banner' ? 'banner' : 'logo';

            return base_url('desa/upload/lapak/' . $jenis . '/' . ltrim($file, '/'));
        }
    }

    if (! function_exists('render_media_lapak_pengajuan')) {
        function render_media_lapak_pengajuan($judul, $jenis, $file)
        {
            $file = trim((string) $file);
            $class = $jenis === 'logo' ? ' logo' : '';

            echo '<div class="media-lapak-card">';
            echo '<div class="media-lapak-title">' . html_escape($judul) . '</div>';
            echo '<div class="media-lapak-preview' . $class . '">';

            if ($file !== '') {
                $url = media_lapak_url_pengajuan($jenis, $file);

                echo '<a href="' . html_escape($url) . '" target="_blank" style="display:block;width:100%;height:100%;">';
                echo '<img src="' . html_escape($url) . '" alt="' . html_escape($judul) . '">';
                echo '</a>';
            } else {
                echo '<span>Tidak ada gambar</span>';
            }

            echo '</div>';

            if ($file !== '') {
                echo '<div class="media-lapak-file">' . html_escape($file) . '</div>';
            }

            echo '</div>';
        }
    }

    if (! function_exists('render_pengajuan_table')) {
        function render_pengajuan_table($data)
        {
            $hidden_keys = [
                'foto',
                'foto_rencana',
                'gambar',
                'file',
                'logo',
                'banner',
            ];

            if (! is_array($data)) {
                $data = [];
            }

            foreach ($hidden_keys as $hidden_key) {
                if (array_key_exists($hidden_key, $data)) {
                    unset($data[$hidden_key]);
                }
            }

            if (empty($data)) {
                echo '<div class="json-empty">Tidak ada data.</div>';
                return;
            }

            echo '<div class="table-responsive">';
            echo '<table class="table table-bordered table-striped">';
            echo '<tbody>';

            foreach ($data as $key => $value) {
                echo '<tr>';
                echo '<th style="width: 220px;">' . html_escape(label_field_pengajuan_lapak($key)) . '</th>';

                if (is_array($value)) {
                    echo '<td><pre style="white-space: pre-wrap; margin:0;">' . html_escape(json_encode($value, JSON_PRETTY_PRINT)) . '</pre></td>';
                } else {
                    $value = trim((string) $value);
                    echo '<td>' . ($value !== '' ? nl2br(html_escape($value)) : '-') . '</td>';
                }

                echo '</tr>';
            }

            echo '</tbody>';
            echo '</table>';
            echo '</div>';
        }
    }

    $foto_lama = [];

    if (! empty($data_lama['foto'])) {
        $foto_lama = array_merge($foto_lama, ambil_foto_dari_data($data_lama['foto']));
    }

    if (empty($foto_lama) && ! empty($main->foto_produk_lama)) {
        $foto_lama[] = $main->foto_produk_lama;
    }

    $foto_baru = [];

    if (! empty($main->files)) {
        foreach ($main->files as $file) {
            if (! empty($file->file)) {
                $foto_baru[] = $file->file;
            }
        }
    }

    if (! empty($data_baru['foto'])) {
        $foto_baru = array_merge($foto_baru, ambil_foto_dari_data($data_baru['foto']));
    }

    if (! empty($data_baru['foto_rencana'])) {
        $foto_baru = array_merge($foto_baru, ambil_foto_dari_data($data_baru['foto_rencana']));
    }

    $foto_lama = array_values(array_unique(array_filter($foto_lama)));
    $foto_baru = array_values(array_unique(array_filter($foto_baru)));

    $logo_lama = $data_lama['logo'] ?? '';
    $logo_baru = $data_baru['logo'] ?? '';

    $banner_lama = $data_lama['banner'] ?? '';
    $banner_baru = $data_baru['banner'] ?? '';

    $ada_media_lapak = $main->jenis === 'profil_ubah' && (
        ! empty($logo_lama) ||
        ! empty($logo_baru) ||
        ! empty($banner_lama) ||
        ! empty($banner_baru)
    );
?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Detail Pengajuan Lapak
            <small>Review perubahan sebelum disetujui</small>
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="<?= site_url('hom_sid') ?>">
                    <i class="fa fa-home"></i> Home
                </a>
            </li>
            <li>
                <a href="<?= site_url($controller) ?>">Pengajuan Lapak</a>
            </li>
            <li class="active">Detail</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-primary pengajuan-detail">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-file-text-o"></i> Detail Pengajuan
                        </h3>

                        <div class="box-tools pull-right">
                            <a href="<?= site_url($controller) ?>" class="btn btn-default btn-sm">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="info-row">
                            <span class="label-info-custom">Jenis</span>
                            <?= html_escape($this->pengajuan_lapak_model->jenis_label($main->jenis)) ?>
                        </div>

                        <div class="info-row">
                            <span class="label-info-custom">Warga</span>
                            <?= html_escape($main->nama_penduduk ?: '-') ?>
                        </div>

                        <div class="info-row">
                            <span class="label-info-custom">Lapak</span>
                            <?= html_escape($main->nama_lapak ?: '-') ?>
                        </div>

                        <div class="info-row">
                            <span class="label-info-custom">Produk</span>
                            <?= html_escape($main->nama_produk ?: '-') ?>
                        </div>

                        <div class="info-row">
                            <span class="label-info-custom">Status</span>

                            <?php if ((int) $main->status === 0) : ?>
                            <span class="label label-info">
                                <?= html_escape($this->pengajuan_lapak_model->status_label($main->status)) ?>
                            </span>
                            <?php elseif ((int) $main->status === 1) : ?>
                            <span class="label label-success">
                                <?= html_escape($this->pengajuan_lapak_model->status_label($main->status)) ?>
                            </span>
                            <?php elseif ((int) $main->status === 2) : ?>
                            <span class="label label-danger">
                                <?= html_escape($this->pengajuan_lapak_model->status_label($main->status)) ?>
                            </span>
                            <?php elseif ((int) $main->status === 3) : ?>
                            <span class="label label-warning">
                                <?= html_escape($this->pengajuan_lapak_model->status_label($main->status)) ?>
                            </span>
                            <?php else : ?>
                            <span class="label label-default">
                                <?= html_escape($this->pengajuan_lapak_model->status_label($main->status)) ?>
                            </span>
                            <?php endif; ?>
                        </div>

                        <div class="info-row">
                            <span class="label-info-custom">Tanggal Pengajuan</span>
                            <?= html_escape($main->created_at ?: '-') ?>
                        </div>

                        <?php if (! empty($main->catatan_admin)) : ?>
                        <div class="info-row">
                            <span class="label-info-custom">Catatan Admin</span>
                            <?= nl2br(html_escape($main->catatan_admin)) ?>
                        </div>
                        <?php endif; ?>

                        <hr>

                        <div class="compare-grid">
                            <div class="compare-box">
                                <div class="compare-title">Data Lama</div>
                                <div class="compare-body">
                                    <?php render_pengajuan_table($data_lama); ?>
                                </div>
                            </div>

                            <div class="compare-box">
                                <div class="compare-title">Data Baru / Diajukan</div>
                                <div class="compare-body">
                                    <?php render_pengajuan_table($data_baru); ?>
                                </div>
                            </div>
                        </div>

                        <?php if ($ada_media_lapak) : ?>
                        <hr>

                        <h4><strong>Media Profil Lapak</strong></h4>

                        <div class="media-lapak-grid">
                            <?php render_media_lapak_pengajuan('Logo Saat Ini', 'logo', $logo_lama); ?>
                            <?php render_media_lapak_pengajuan('Logo yang Diajukan', 'logo', $logo_baru); ?>
                            <?php render_media_lapak_pengajuan('Banner Saat Ini', 'banner', $banner_lama); ?>
                            <?php render_media_lapak_pengajuan('Banner yang Diajukan', 'banner', $banner_baru); ?>
                        </div>

                        <p class="text-muted" style="margin-top: 10px;">
                            Bagian ini membantu admin membandingkan logo dan banner lapak saat ini dengan media baru
                            yang diajukan.
                        </p>
                        <?php endif; ?>

                        <?php if (! empty($foto_lama) || ! empty($foto_baru)) : ?>
                        <hr>

                        <h4><strong>Perbandingan Foto Produk</strong></h4>

                        <div class="compare-grid">
                            <div class="compare-box">
                                <div class="compare-title">Foto Produk Saat Ini</div>
                                <div class="compare-body">
                                    <?php render_foto_cards_pengajuan_lapak($foto_lama, 'produk'); ?>
                                </div>
                            </div>

                            <div class="compare-box">
                                <div class="compare-title">Foto Setelah Pengajuan Disetujui</div>
                                <div class="compare-body">
                                    <?php render_foto_cards_pengajuan_lapak($foto_baru, 'pengajuan'); ?>
                                </div>
                            </div>
                        </div>

                        <p class="text-muted" style="margin-top: 10px;">
                            Bagian ini membantu admin membandingkan foto produk aktif saat ini dengan susunan foto yang
                            akan berlaku jika pengajuan disetujui.
                        </p>
                        <?php endif; ?>
                    </div>

                    <?php if ((int) $main->status === 0) : ?>
                    <div class="box box-warning status-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Verifikasi Pengajuan</h3>
                        </div>

                        <div class="box-body">
                            <div class="alert alert-warning">
                                Tombol <strong>Setujui</strong> akan menerapkan data baru ke data lapak/produk resmi.
                                Periksa perbandingan data dengan teliti sebelum menyetujui.
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <form action="<?= site_url("{$controller}/ubah-status/{$main->id}/1") ?>"
                                        method="post">
                                        <div class="form-group">
                                            <label>Catatan Admin</label>
                                            <textarea name="catatan_admin" class="form-control input-sm" rows="3"
                                                placeholder="Catatan persetujuan"></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-success btn-sm"
                                            onclick="return confirm('Setujui pengajuan ini dan terapkan perubahan ke data lapak/produk?')">
                                            <i class="fa fa-check"></i> Setujui
                                        </button>
                                    </form>
                                </div>

                                <div class="col-md-4">
                                    <form action="<?= site_url("{$controller}/ubah-status/{$main->id}/2") ?>"
                                        method="post">
                                        <div class="form-group">
                                            <label>Catatan Admin</label>
                                            <textarea name="catatan_admin" class="form-control input-sm" rows="3"
                                                placeholder="Alasan penolakan"></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Tolak pengajuan ini?')">
                                            <i class="fa fa-times"></i> Tolak
                                        </button>
                                    </form>
                                </div>

                                <?php if ($main->jenis !== 'produk_hapus') : ?>
                                <div class="col-md-4">
                                    <form action="<?= site_url("{$controller}/ubah-status/{$main->id}/3") ?>"
                                        method="post">
                                        <div class="form-group">
                                            <label>Catatan Admin <span class="text-danger">*</span></label>
                                            <textarea name="catatan_admin" class="form-control input-sm" rows="3"
                                                placeholder="Tuliskan data yang perlu diperbaiki" required></textarea>
                                            <small class="text-muted">
                                                Catatan ini akan menjadi instruksi perbaikan untuk pelapak/warga.
                                            </small>
                                        </div>

                                        <button type="submit" class="btn btn-warning btn-sm"
                                            onclick="return confirm('Tandai pengajuan ini sebagai butuh perbaikan?')">
                                            <i class="fa fa-refresh"></i> Butuh Perbaikan
                                        </button>
                                    </form>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <?php elseif ((int) $main->status === 3) : ?>
                    <div class="box box-warning status-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa-refresh"></i> Menunggu Perbaikan
                            </h3>
                        </div>

                        <div class="box-body">
                            <div class="alert alert-warning">
                                <strong>Pengajuan ini membutuhkan perbaikan.</strong><br>
                                Admin sudah meminta pelapak/warga untuk memperbaiki data yang diajukan.
                            </div>

                            <div class="catatan-admin-box">
                                <strong>Catatan Perbaikan dari Admin</strong>

                                <?php if (! empty($main->catatan_admin)) : ?>
                                <?= nl2br(html_escape($main->catatan_admin)) ?>
                                <?php else : ?>
                                <em class="text-muted">Belum ada catatan perbaikan dari admin.</em>
                                <?php endif; ?>
                            </div>

                            <p class="text-muted" style="margin-top: 10px; margin-bottom: 0;">
                                Tombol verifikasi disembunyikan sementara karena pengajuan sedang menunggu perbaikan
                                dari pelapak/warga. Setelah pelapak/warga mengirim ulang perbaikan, pengajuan dapat
                                diverifikasi kembali.
                            </p>
                        </div>
                    </div>

                    <?php elseif ((int) $main->status === 1) : ?>
                    <div class="box box-success status-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa-check"></i> Pengajuan Disetujui
                            </h3>
                        </div>

                        <div class="box-body">
                            <div class="alert alert-success" style="margin-bottom:0;">
                                <strong>Pengajuan ini sudah disetujui.</strong><br>
                                Data baru sudah diterapkan ke data lapak/produk resmi.
                            </div>
                        </div>
                    </div>

                    <?php elseif ((int) $main->status === 2) : ?>
                    <div class="box box-danger status-box">
                        <div class="box-header with-border">
                            <h3 class="box-title">
                                <i class="fa fa-times"></i> Pengajuan Ditolak
                            </h3>
                        </div>

                        <div class="box-body">
                            <div class="alert alert-danger" style="margin-bottom:0;">
                                <strong>Pengajuan ini sudah ditolak.</strong><br>
                                Data baru tidak diterapkan ke data lapak/produk resmi.
                            </div>
                        </div>
                    </div>

                    <?php else : ?>
                    <div class="box box-info status-box">
                        <div class="box-body">
                            <div class="alert alert-info" style="margin-bottom:0;">
                                Pengajuan ini sudah diproses dengan status:
                                <strong><?= html_escape($this->pengajuan_lapak_model->status_label($main->status)) ?></strong>.
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </section>
</div>