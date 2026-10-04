<div class="content-wrapper">
    <section class="content-header">
        <h1>Pengajuan Perubahan Data Penduduk</h1>
        <ol class="breadcrumb">
            <li><a href="<?= site_url('main') ?>"><i class="fa fa-dashboard"></i> Beranda</a></li>
            <li class="active">Pengajuan Perubahan Data</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Daftar Pengajuan</h3>
            </div>

            <div class="box-body">
                <form method="get" action="<?= site_url($controller) ?>" class="form-inline"
                    style="margin-bottom: 15px;">
                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control input-sm">
                            <option value="">Semua Status</option>
                            <?php foreach ($list_status as $kode => $label) : ?>
                            <option value="<?= $kode ?>" <?= selected((string) $selected_status, (string) $kode) ?>>
                                <?= html_escape($label) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-filter"></i> Filter
                    </button>

                    <a href="<?= site_url($controller) ?>" class="btn btn-default btn-sm">
                        Reset
                    </a>
                </form>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th width="40">No</th>
                                <th>NIK</th>
                                <th>Nama Penduduk</th>
                                <th>Status</th>
                                <th>Tanggal Pengajuan</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($main)) : ?>
                            <tr>
                                <td colspan="6" class="text-center">Belum ada pengajuan.</td>
                            </tr>
                            <?php else : ?>
                            <?php foreach ($main as $i => $row) : ?>
                            <?php
                                        $status = (int) $row->status;

                                        if ($status === 1) {
                                            $badge = 'success';
                                            $label = 'Disetujui';
                                        } elseif ($status === 2) {
                                            $badge = 'danger';
                                            $label = 'Ditolak';
                                        } elseif ($status === 3) {
                                            $badge = 'warning';
                                            $label = 'Butuh Perbaikan';
                                        } else {
                                            $badge = 'info';
                                            $label = 'Menunggu Verifikasi';
                                        }
                                    ?>
                            <tr>
                                <td><?= $i + 1 ?></td>
                                <td><?= html_escape($row->nik ?: $row->nik_penduduk) ?></td>
                                <td><?= html_escape($row->nama) ?></td>
                                <td>
                                    <span class="label label-<?= $badge ?>">
                                        <?= $label ?>
                                    </span>
                                </td>
                                <td><?= html_escape($row->created_at) ?></td>
                                <td>
                                    <a href="<?= site_url("{$controller}/detail/{$row->id}") ?>"
                                        class="btn btn-info btn-sm">
                                        <i class="fa fa-search"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>