<style>
.kelola-lapak .box-header .box-title {
    font-size: 18px;
    font-weight: 600;
}

.kelola-lapak .info-card {
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    padding: 14px;
    margin-bottom: 14px;
    background: #fff;
}

.kelola-lapak .info-card h4 {
    margin-top: 0;
    font-weight: 700;
}

.kelola-lapak .summary-row {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 16px;
}

.kelola-lapak .summary-box {
    flex: 1 1 180px;
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    padding: 14px;
    background: #f9f9f9;
}

.kelola-lapak .summary-box .label-title {
    color: #777;
    font-size: 12px;
    margin-bottom: 6px;
}

.kelola-lapak .summary-box .value {
    font-size: 20px;
    font-weight: 700;
    color: #333;
}

.kelola-lapak .summary-box.warning {
    border-color: #f0ad4e;
    background: #fff8e5;
}

.kelola-lapak .summary-box.warning .value {
    color: #8a6d3b;
}

.kelola-lapak .produk-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
}

.kelola-lapak .produk-card {
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    background: #fff;
    padding: 12px;
    min-height: 270px;
    display: flex;
    flex-direction: column;
}

.kelola-lapak .produk-cover {
    height: 130px;
    border-radius: 6px;
    background: #eef6f8;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin-bottom: 10px;
}

.kelola-lapak .produk-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.kelola-lapak .produk-cover i {
    font-size: 42px;
    color: #337ab7;
}

.kelola-lapak .produk-card h4 {
    font-size: 15px;
    font-weight: 700;
    line-height: 1.35;
    margin: 0 0 6px;
}

.kelola-lapak .produk-meta {
    font-size: 12px;
    color: #777;
    margin-bottom: 8px;
}

.kelola-lapak .produk-desc {
    font-size: 12px;
    color: #555;
    line-height: 1.5;
    margin-bottom: 10px;
    flex: 1;
}

.kelola-lapak .produk-actions {
    display: flex;
    gap: 6px;
    flex-wrap: wrap;
}

.kelola-lapak .status-badge {
    display: inline-block;
    padding: 3px 8px;
    border-radius: 12px;
    font-size: 11px;
    font-weight: 600;
}

.kelola-lapak .status-aktif {
    background: #dff0d8;
    color: #3c763d;
}

.kelola-lapak .status-nonaktif {
    background: #f2dede;
    color: #a94442;
}

.kelola-lapak .pengajuan-list {
    display: grid;
    grid-template-columns: 1fr;
    gap: 10px;
}

.kelola-lapak .pengajuan-item {
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    padding: 12px;
    background: #fff;
}

.kelola-lapak .pengajuan-head {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 8px;
}

.kelola-lapak .pengajuan-title {
    font-weight: 700;
    font-size: 14px;
}

.kelola-lapak .pengajuan-meta {
    font-size: 12px;
    color: #777;
    margin-top: 3px;
}

.kelola-lapak .pengajuan-catatan {
    margin-top: 10px;
    padding: 10px;
    border-radius: 6px;
    background: #fff8e5;
    border: 1px solid #f0d58c;
    font-size: 12px;
}

.kelola-lapak .pengajuan-catatan strong {
    display: block;
    margin-bottom: 4px;
}

.kelola-lapak .status-menunggu {
    background: #d9edf7;
    color: #31708f;
}

.kelola-lapak .status-disetujui {
    background: #dff0d8;
    color: #3c763d;
}

.kelola-lapak .status-ditolak {
    background: #f2dede;
    color: #a94442;
}

.kelola-lapak .status-perbaikan {
    background: #fcf8e3;
    color: #8a6d3b;
}

@media (max-width: 991px) {
    .kelola-lapak .produk-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 575px) {
    .kelola-lapak .produk-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php
    $pengajuan = $pengajuan ?? [];

    if (! function_exists('kelola_lapak_status_class')) {
        function kelola_lapak_status_class($status)
        {
            $status = (int) $status;

            if ($status === 1) {
                return 'status-disetujui';
            }

            if ($status === 2) {
                return 'status-ditolak';
            }

            if ($status === 3) {
                return 'status-perbaikan';
            }

            return 'status-menunggu';
        }
    }

    if (! function_exists('kelola_lapak_status_label')) {
        function kelola_lapak_status_label($status)
        {
            $status = (int) $status;

            if ($status === 1) {
                return 'Disetujui';
            }

            if ($status === 2) {
                return 'Ditolak';
            }

            if ($status === 3) {
                return 'Butuh Perbaikan';
            }

            return 'Menunggu Verifikasi';
        }
    }

    if (! function_exists('kelola_lapak_jenis_label')) {
        function kelola_lapak_jenis_label($jenis)
        {
            $labels = [
                'profil_ubah'   => 'Perubahan Profil Lapak',
                'produk_tambah' => 'Tambah Produk/Menu',
                'produk_ubah'   => 'Perubahan Produk/Menu',
                'produk_hapus'  => 'Penghapusan Produk/Menu',
            ];

            return $labels[$jenis] ?? $jenis;
        }
    }

    $jumlah_pengajuan_aktif = 0;
    $jumlah_butuh_perbaikan = 0;

    foreach ($pengajuan as $row) {
        if (in_array((int) $row->status, [0, 3], true)) {
            $jumlah_pengajuan_aktif++;
        }

        if ((int) $row->status === 3) {
            $jumlah_butuh_perbaikan++;
        }
    }
?>

<div class="box box-solid kelola-lapak">
    <div class="box-header with-border bg-aqua">
        <h4 class="box-title">KELOLA LAPAK</h4>
    </div>

    <div class="box-body">
        <?php if (empty($pelapak)) : ?>
        <div class="alert alert-warning">
            <strong>Anda belum terdaftar sebagai pelapak.</strong><br>
            Silakan hubungi admin desa untuk mengaktifkan data pelapak Anda sebelum mengelola produk.
        </div>
        <?php else : ?>

        <div class="info-card">
            <div class="clearfix">
                <div class="pull-left">
                    <h4>Informasi Lapak</h4>
                </div>

                <div class="pull-right">
                    <a href="<?= site_url($controller . '/profil') ?>" class="btn btn-primary btn-sm">
                        <i class="fa fa-edit"></i> Kelola Profil Lapak
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th width="180">Nama Lapak</th>
                            <td><?= html_escape($pelapak->nama_lapak ?: '-') ?></td>
                        </tr>
                        <tr>
                            <th>Nama Warga</th>
                            <td><?= html_escape($pelapak->nama ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>NIK</th>
                            <td><?= html_escape($pelapak->nik ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Telepon / WhatsApp</th>
                            <td><?= html_escape($pelapak->telepon ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Deskripsi Lapak</th>
                            <td><?= nl2br(html_escape($pelapak->deskripsi_lapak ?: '-')) ?></td>
                        </tr>
                    </table>
                </div>

                <div class="col-md-6">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th width="180">Status Lapak</th>
                            <td>
                                <?php if ((int) $pelapak->status === 1) : ?>
                                <span class="status-badge status-aktif">Aktif</span>
                                <?php else : ?>
                                <span class="status-badge status-nonaktif">Nonaktif</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Latitude</th>
                            <td><?= html_escape($pelapak->lat ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th>Longitude</th>
                            <td><?= html_escape($pelapak->lng ?? '-') ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="summary-row">
            <div class="summary-box">
                <div class="label-title">Jumlah Produk/Menu</div>
                <div class="value"><?= (int) $jumlah_produk ?></div>
            </div>

            <div class="summary-box">
                <div class="label-title">Pengajuan Aktif</div>
                <div class="value"><?= (int) $jumlah_pengajuan_aktif ?></div>
            </div>

            <div class="summary-box <?= $jumlah_butuh_perbaikan > 0 ? 'warning' : '' ?>">
                <div class="label-title">Butuh Perbaikan</div>
                <div class="value"><?= (int) $jumlah_butuh_perbaikan ?></div>
            </div>

            <div class="summary-box">
                <div class="label-title">Status Pengelolaan</div>
                <div class="value"><?= (int) $pelapak->status === 1 ? 'Aktif' : 'Nonaktif' ?></div>
            </div>
        </div>

        <?php if ((int) $pelapak->status !== 1) : ?>
        <div class="alert alert-warning">
            Lapak Anda belum aktif. Produk belum dapat dikelola sampai lapak diaktifkan oleh admin desa.
        </div>
        <?php else : ?>

        <div class="clearfix" style="margin-bottom: 12px;">
            <div class="pull-left">
                <h4 style="margin: 6px 0 0; font-weight: 700;">Produk/Menu Lapak Saya</h4>
            </div>

            <div class="pull-right">
                <a href="<?= site_url($controller . '/produk/tambah') ?>" class="btn btn-primary btn-sm">
                    <i class="fa fa-plus"></i> Tambah Produk/Menu
                </a>
            </div>
        </div>

        <div class="alert alert-info">
            Anda dapat menambahkan produk/menu baru untuk ditampilkan pada halaman Lapak publik desa.
        </div>

        <?php if (empty($produk)) : ?>
        <div class="alert alert-warning">
            Belum ada produk/menu pada lapak Anda.
        </div>
        <?php else : ?>
        <div class="produk-grid">
            <?php foreach ($produk as $row) : ?>
            <?php
                $foto = json_decode((string) $row->foto, true);
                $foto_utama = is_array($foto) && ! empty($foto[0]) ? $foto[0] : '';
            ?>

            <div class="produk-card">
                <div class="produk-cover">
                    <?php if (! empty($foto_utama) && defined('LOKASI_PRODUK')) : ?>
                    <img src="<?= base_url(LOKASI_PRODUK . $foto_utama) ?>" alt="<?= html_escape($row->nama) ?>">
                    <?php else : ?>
                    <i class="fa fa-image"></i>
                    <?php endif; ?>
                </div>

                <h4><?= html_escape($row->nama) ?></h4>

                <div class="produk-meta">
                    <?= html_escape($row->kategori ?? '-') ?>
                    <?php if (! empty($row->harga)) : ?>
                    <br>Rp <?= number_format((float) $row->harga, 0, ',', '.') ?> /
                    <?= html_escape($row->satuan ?? '-') ?>
                    <?php endif; ?>
                </div>

                <div class="produk-desc">
                    <?= html_escape(mb_strimwidth((string) $row->deskripsi, 0, 120, '...')) ?>
                </div>

                <div style="margin-bottom: 8px;">
                    <?php if ((int) $row->status === 1) : ?>
                    <span class="status-badge status-aktif">Produk Aktif</span>
                    <?php else : ?>
                    <span class="status-badge status-nonaktif">Produk Nonaktif</span>
                    <?php endif; ?>
                </div>

                <div class="produk-actions">
                    <a href="<?= site_url($controller . '/produk/ubah/' . $row->id) ?>" class="btn btn-info btn-xs">
                        <i class="fa fa-pencil"></i> Ubah
                    </a>

                    <?php if ((int) $row->status === 1) : ?>
                    <a href="<?= site_url($controller . '/produk/status/' . $row->id . '/0') ?>"
                        class="btn btn-warning btn-xs"
                        onclick="return confirm('Nonaktifkan produk ini dari halaman Lapak publik?')">
                        <i class="fa fa-eye-slash"></i> Nonaktifkan
                    </a>
                    <?php else : ?>
                    <a href="<?= site_url($controller . '/produk/status/' . $row->id . '/1') ?>"
                        class="btn btn-success btn-xs"
                        onclick="return confirm('Aktifkan kembali produk ini ke halaman Lapak publik?')">
                        <i class="fa fa-eye"></i> Aktifkan
                    </a>
                    <?php endif; ?>

                    <a href="<?= site_url($controller . '/produk/hapus/' . $row->id) ?>" class="btn btn-danger btn-xs"
                        onclick="return confirm('Hapus produk/menu ini secara permanen? Foto produk juga akan ikut dihapus.')">
                        <i class="fa fa-trash"></i> Hapus
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
        <?php endif; ?>

        <div class="info-card" style="margin-top: 16px;">
            <div class="clearfix">
                <div class="pull-left">
                    <h4 style="margin-bottom: 0;">Pengajuan Saya</h4>
                    <small class="text-muted">
                        Riwayat dan status pengajuan perubahan lapak/produk.
                    </small>
                </div>

                <div class="pull-right">
                    <button type="button" class="btn btn-default btn-sm" data-toggle="collapse"
                        data-target="#pengajuanSayaCollapse">
                        <i class="fa fa-list"></i> Lihat / Sembunyikan
                        <?php if (! empty($pengajuan)) : ?>
                        <span class="badge"><?= count($pengajuan) ?></span>
                        <?php endif; ?>
                    </button>
                </div>
            </div>

            <?php if (! empty($pengajuan) && $jumlah_butuh_perbaikan > 0) : ?>
            <div class="alert alert-warning" style="margin-top: 12px; margin-bottom: 0;">
                Ada <strong><?= (int) $jumlah_butuh_perbaikan ?></strong> pengajuan yang membutuhkan perbaikan.
                Klik tombol <strong>Lihat / Sembunyikan</strong> untuk melihat detail dan tombol revisi.
            </div>
            <?php endif; ?>

            <div id="pengajuanSayaCollapse" class="collapse" style="margin-top: 14px;">
                <?php if (empty($pengajuan)) : ?>
                <div class="alert alert-info" style="margin-bottom:0;">
                    Belum ada pengajuan perubahan lapak atau produk.
                </div>
                <?php else : ?>
                <div class="pengajuan-list">
                    <?php foreach ($pengajuan as $row) : ?>
                    <?php
                        $jenis_label = ! empty($row->jenis_label) ? $row->jenis_label : kelola_lapak_jenis_label($row->jenis);
                        $status_label = ! empty($row->status_label) ? $row->status_label : kelola_lapak_status_label($row->status);
                    ?>

                    <div class="pengajuan-item">
                        <div class="pengajuan-head">
                            <div>
                                <div class="pengajuan-title">
                                    <?= html_escape($jenis_label) ?>

                                    <?php if (! empty($row->nama_produk)) : ?>
                                    - <?= html_escape($row->nama_produk) ?>
                                    <?php endif; ?>
                                </div>

                                <div class="pengajuan-meta">
                                    Diajukan pada <?= html_escape($row->created_at ?: '-') ?>
                                </div>
                            </div>

                            <div>
                                <span class="status-badge <?= kelola_lapak_status_class($row->status) ?>">
                                    <?= html_escape($status_label) ?>
                                </span>
                            </div>
                        </div>

                        <?php if ((int) $row->status === 0) : ?>
                        <div class="alert alert-info" style="margin-bottom:0;">
                            Pengajuan Anda sedang menunggu verifikasi admin desa.
                        </div>

                        <?php elseif ((int) $row->status === 3) : ?>
                        <div class="pengajuan-catatan">
                            <strong>Catatan Perbaikan dari Admin</strong>

                            <?php if (! empty($row->catatan_admin)) : ?>
                            <?= nl2br(html_escape($row->catatan_admin)) ?>
                            <?php else : ?>
                            <em>Admin meminta perbaikan, tetapi belum ada catatan detail.</em>
                            <?php endif; ?>

                            <div style="margin-top:8px;">
                                Silakan perbaiki pengajuan sesuai catatan admin.
                            </div>

                            <?php if ($row->jenis === 'produk_ubah' && ! empty($row->id_produk)) : ?>
                            <div style="margin-top:10px;">
                                <a href="<?= site_url($controller . '/produk/ubah/' . $row->id_produk) ?>"
                                    class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil"></i> Perbaiki Produk
                                </a>
                            </div>

                            <?php elseif ($row->jenis === 'profil_ubah') : ?>
                            <div style="margin-top:10px;">
                                <a href="<?= site_url($controller . '/profil') ?>" class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil"></i> Perbaiki Profil Lapak
                                </a>
                            </div>

                            <?php elseif ($row->jenis === 'produk_tambah') : ?>
                            <div style="margin-top:10px;">
                                <a href="<?= site_url($controller . '/produk/tambah') ?>"
                                    class="btn btn-warning btn-xs">
                                    <i class="fa fa-pencil"></i> Perbaiki Produk
                                </a>
                            </div>
                            <?php endif; ?>
                        </div>

                        <?php elseif ((int) $row->status === 2) : ?>
                        <div class="alert alert-danger" style="margin-bottom:0;">
                            Pengajuan ditolak.
                            <?php if (! empty($row->catatan_admin)) : ?>
                            <br><strong>Alasan:</strong> <?= nl2br(html_escape($row->catatan_admin)) ?>
                            <?php endif; ?>
                        </div>

                        <?php elseif ((int) $row->status === 1) : ?>
                        <div class="alert alert-success" style="margin-bottom:0;">
                            Pengajuan sudah disetujui dan diterapkan oleh admin.
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php endif; ?>
    </div>
</div>