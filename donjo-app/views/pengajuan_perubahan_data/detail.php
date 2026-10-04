<div class="content-wrapper">
    <section class="content-header">
        <h1>Detail Pengajuan Perubahan Data</h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('main') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li><a href="<?= site_url($controller) ?>">Pengajuan Perubahan Data</a></li>
            <li class="active">Detail</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Informasi Pengajuan</h3>

                <div class="box-tools pull-right">
                    <a href="<?= site_url($controller) ?>" class="btn btn-default btn-sm">
                        <i class="fa fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>

            <div class="box-body">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th width="220">NIK</th>
                        <td><?= html_escape($main->nik ?: $main->nik_penduduk) ?></td>
                    </tr>
                    <tr>
                        <th>Nama Penduduk</th>
                        <td><?= html_escape($main->nama) ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="label label-<?= $badge_status ?>">
                                <?= html_escape($label_status) ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Pengajuan</th>
                        <td><?= html_escape($main->created_at) ?></td>
                    </tr>
                    <tr>
                        <th>Catatan Warga</th>
                        <td><?= nl2br(html_escape($main->catatan_warga ?: $main->catatan)) ?></td>
                    </tr>
                    <tr>
                        <th>Catatan Admin</th>
                        <td><?= nl2br(html_escape($main->catatan_admin)) ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Perbandingan Data</h3>
            </div>

            <div class="box-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="220">Field</th>
                                <th>Data Lama</th>
                                <th>Data Baru</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($baris_perubahan)) : ?>
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada perubahan field. Periksa catatan warga.
                                </td>
                            </tr>
                            <?php else : ?>
                            <?php foreach ($baris_perubahan as $row) : ?>
                            <tr>
                                <td>
                                    <strong><?= html_escape($row['label']) ?></strong>
                                    <br>
                                    <small class="text-muted"><?= html_escape($row['field']) ?></small>
                                </td>
                                <td><?= html_escape($row['lama_tampil']) ?></td>
                                <td><?= html_escape($row['baru_tampil']) ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <?php if ((int) $main->status === 0) : ?>
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">Verifikasi Pengajuan</h3>
            </div>

            <div class="box-body">
                <div class="alert alert-warning">
                    Tombol <strong>Setujui</strong> akan menerapkan data baru ke data penduduk resmi.
                    Periksa perbandingan data dengan teliti sebelum menyetujui.
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <form action="<?= site_url("{$controller}/ubah-status/{$main->id}/1") ?>" method="post">
                            <div class="form-group">
                                <label>Catatan Admin</label>
                                <textarea name="catatan_admin" class="form-control input-sm" rows="3"
                                    placeholder="Catatan persetujuan"></textarea>
                            </div>

                            <button type="submit" class="btn btn-success btn-sm">
                                <i class="fa fa-check"></i> Setujui
                            </button>
                        </form>
                    </div>

                    <div class="col-md-4">
                        <form action="<?= site_url("{$controller}/ubah-status/{$main->id}/2") ?>" method="post">
                            <div class="form-group">
                                <label>Catatan Admin</label>
                                <textarea name="catatan_admin" class="form-control input-sm" rows="3"
                                    placeholder="Alasan penolakan"></textarea>
                            </div>

                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa fa-times"></i> Tolak
                            </button>
                        </form>
                    </div>

                    <div class="col-md-4">
                        <form action="<?= site_url("{$controller}/ubah-status/{$main->id}/3") ?>" method="post">
                            <div class="form-group">
                                <label>Catatan Admin</label>
                                <textarea name="catatan_admin" class="form-control input-sm" rows="3"
                                    placeholder="Data yang perlu diperbaiki"></textarea>
                            </div>

                            <button type="submit" class="btn btn-warning btn-sm">
                                <i class="fa fa-refresh"></i> Butuh Perbaikan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php elseif ((int) $main->status === 3) : ?>
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="fa fa-refresh"></i> Menunggu Perbaikan
                </h3>
            </div>

            <div class="box-body">
                <div class="alert alert-warning">
                    <strong>Pengajuan ini membutuhkan perbaikan.</strong><br>
                    Warga diminta memperbaiki data sesuai catatan admin.
                </div>

                <?php if (! empty($main->catatan_admin)) : ?>
                <div class="alert alert-info">
                    <strong>Catatan Admin:</strong><br>
                    <?= nl2br(html_escape($main->catatan_admin)) ?>
                </div>
                <?php endif; ?>

                <p class="text-muted" style="margin-bottom:0;">
                    Tombol verifikasi disembunyikan sementara sampai warga mengirim ulang perbaikan.
                </p>
            </div>
        </div>
        <?php endif; ?>
    </section>
</div>