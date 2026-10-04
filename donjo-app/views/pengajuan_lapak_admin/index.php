<style>
.pengajuan-lapak-admin .box-title {
    font-weight: 700;
}

.pengajuan-lapak-admin .filter-box {
    margin-bottom: 12px;
    padding: 10px;
    background: #f9f9f9;
    border: 1px solid #eee;
    border-radius: 4px;
}

.pengajuan-lapak-admin .label {
    display: inline-block;
    min-width: 118px;
    padding: 5px 8px;
    font-size: 11px;
    line-height: 1.2;
    text-align: center;
    white-space: nowrap;
}

.pengajuan-lapak-admin .table>tbody>tr>td {
    vertical-align: middle;
}

.pengajuan-lapak-admin .small-muted {
    color: #777;
    font-size: 12px;
}
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Pengajuan Lapak
            <small>Persetujuan perubahan data UMKM warga</small>
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="<?= site_url('hom_sid') ?>">
                    <i class="fa fa-home"></i> Home
                </a>
            </li>
            <li class="active">Pengajuan Lapak</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-primary pengajuan-lapak-admin">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-check-square-o"></i> Daftar Pengajuan Lapak
                        </h3>
                    </div>

                    <div class="box-body">
                        <div class="filter-box">
                            <form method="get" action="<?= site_url($controller) ?>">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Cari Nama / Lapak / Produk</label>
                                            <input type="text" name="keyword" class="form-control input-sm"
                                                value="<?= html_escape($keyword ?? '') ?>"
                                                placeholder="Cari nama warga, nama lapak, atau produk...">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Jenis Pengajuan</label>
                                            <select name="jenis" class="form-control input-sm">
                                                <option value="">Semua Jenis</option>
                                                <option value="profil_ubah"
                                                    <?= ($jenis ?? '') === 'profil_ubah' ? 'selected' : '' ?>>Perubahan
                                                    Profil Lapak</option>
                                                <option value="produk_tambah"
                                                    <?= ($jenis ?? '') === 'produk_tambah' ? 'selected' : '' ?>>Tambah
                                                    Produk/Menu</option>
                                                <option value="produk_ubah"
                                                    <?= ($jenis ?? '') === 'produk_ubah' ? 'selected' : '' ?>>Perubahan
                                                    Produk/Menu</option>
                                                <option value="produk_hapus"
                                                    <?= ($jenis ?? '') === 'produk_hapus' ? 'selected' : '' ?>>
                                                    Penghapusan Produk/Menu</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control input-sm">
                                                <option value="">Semua Status</option>
                                                <option value="0"
                                                    <?= (string) ($status ?? '') === '0' ? 'selected' : '' ?>>Menunggu
                                                    Verifikasi</option>
                                                <option value="1"
                                                    <?= (string) ($status ?? '') === '1' ? 'selected' : '' ?>>Disetujui
                                                </option>
                                                <option value="2"
                                                    <?= (string) ($status ?? '') === '2' ? 'selected' : '' ?>>Ditolak
                                                </option>
                                                <option value="3"
                                                    <?= (string) ($status ?? '') === '3' ? 'selected' : '' ?>>Butuh
                                                    Perbaikan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label>&nbsp;</label>
                                        <div>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fa fa-search"></i> Cari
                                            </button>

                                            <a href="<?= site_url($controller) ?>" class="btn btn-default btn-sm">
                                                Reset
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="45" class="text-center">No</th>
                                        <th>Jenis Pengajuan</th>
                                        <th>Warga / Lapak</th>
                                        <th>Produk</th>
                                        <th width="145" class="text-center">Status</th>
                                        <th width="150" class="text-center">Tanggal</th>
                                        <th width="95" class="text-center">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (empty($main)) : ?>
                                    <tr>
                                        <td colspan="7" class="text-center">Belum ada pengajuan lapak.</td>
                                    </tr>
                                    <?php else : ?>
                                    <?php foreach ($main as $index => $row) : ?>
                                    <tr>
                                        <td class="text-center"><?= $index + 1 ?></td>

                                        <td>
                                            <strong><?= html_escape($row->jenis_label) ?></strong>
                                            <div class="small-muted">
                                                Kode: <?= html_escape($row->jenis) ?>
                                            </div>
                                        </td>

                                        <td>
                                            <strong><?= html_escape($row->nama_penduduk ?: '-') ?></strong>
                                            <div class="small-muted">
                                                Lapak: <?= html_escape($row->nama_lapak ?: '-') ?>
                                            </div>
                                        </td>

                                        <td>
                                            <?= html_escape($row->nama_produk ?: '-') ?>
                                        </td>

                                        <td class="text-center">
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
                                            <span class="label label-<?= $badge ?>">
                                                <?= html_escape($label) ?>
                                            </span>
                                        </td>

                                        <td class="text-center">
                                            <?= html_escape($row->created_at ?: '-') ?>
                                        </td>

                                        <td class="text-center">
                                            <a href="<?= site_url($controller . '/detail/' . $row->id) ?>"
                                                class="btn btn-info btn-xs">
                                                <i class="fa fa-eye"></i> Detail
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

            </div>
        </div>
    </section>
</div>