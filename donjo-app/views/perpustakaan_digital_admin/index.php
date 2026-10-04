<style>
.perpus-admin .box-title {
    font-weight: 700;
}

.perpus-admin .box-body {
    padding: 12px;
}

.perpus-admin .filter-box {
    margin-bottom: 12px;
    padding: 10px;
    background: #f9f9f9;
    border: 1px solid #eee;
    border-radius: 4px;
}

.perpus-admin .filter-box label {
    font-size: 12px;
    margin-bottom: 4px;
}

.perpus-admin .filter-box .form-group {
    margin-bottom: 8px;
}

.perpus-admin-table {
    table-layout: fixed;
    width: 100%;
    font-size: 12px;
}

.perpus-admin-table thead th {
    text-align: center;
    vertical-align: middle !important;
}

.perpus-admin-table td.text-center {
    text-align: center;
    vertical-align: middle !important;
}

.perpus-admin .cover-admin {
    width: 52px;
    height: 70px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: #eef6f8;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    margin: auto;
}

.perpus-admin .cover-admin img {
    width: 100%;
    height: 100%;
    object-fit: contain;
    background: #f5fcfd;
}

.perpus-admin .cover-admin i {
    font-size: 24px;
    color: #3c8dbc;
}

.perpus-admin .judul-buku {
    font-weight: 700;
    line-height: 1.35;
    color: #222;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.perpus-admin .meta-buku {
    font-size: 11px;
    color: #777;
    margin-top: 4px;
    line-height: 1.45;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.perpus-admin .badge-tipe {
    display: inline-block;
    padding: 4px 7px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 700;
    color: #fff;
    white-space: nowrap;
}

.perpus-admin .badge-aktif {
    background: #00a65a;
}

.perpus-admin .badge-nonaktif {
    background: #dd4b39;
}

.perpus-admin .aksi {
    white-space: normal;
}

.perpus-admin .aksi-wrap {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 4px;
    min-width: 150px;
}

.perpus-admin .aksi-wrap .btn {
    width: 100%;
    padding: 4px 5px;
    font-size: 11px;
    line-height: 1.2;
}

.perpus-admin .small-muted {
    font-size: 11px;
    color: #777;
}

.perpus-admin .table-responsive {
    border: 0;
}

@media (max-width: 991px) {
    .perpus-admin-table {
        table-layout: auto;
        min-width: 980px;
    }
}
</style>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Perpustakaan Digital
            <small>Kelola koleksi buku digital</small>
        </h1>

        <ol class="breadcrumb">
            <li>
                <a href="<?= site_url('hom_sid') ?>">
                    <i class="fa fa-home"></i> Home
                </a>
            </li>
            <li class="active">Perpustakaan Digital</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box box-primary perpus-admin">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-book"></i> Perpustakaan Digital
                        </h3>

                        <div class="box-tools pull-right">
                            <a href="<?= site_url($controller . '/tambah') ?>" class="btn btn-primary btn-sm">
                                <i class="fa fa-plus"></i> Tambah Buku
                            </a>
                        </div>
                    </div>

                    <div class="box-body">
                        <div class="filter-box">
                            <form method="get" action="<?= site_url($controller) ?>">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label>Cari Buku</label>
                                            <input type="text" name="keyword" class="form-control input-sm"
                                                value="<?= html_escape($keyword ?? '') ?>"
                                                placeholder="Judul, kategori, penulis, penerbit, sumber...">
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="status" class="form-control input-sm">
                                                <option value="">Semua</option>
                                                <option value="1"
                                                    <?= (string) ($status ?? '') === '1' ? 'selected' : '' ?>>Aktif
                                                </option>
                                                <option value="0"
                                                    <?= (string) ($status ?? '') === '0' ? 'selected' : '' ?>>Nonaktif
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
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
                            <table class="table table-bordered table-striped table-hover perpus-admin-table">
                                <thead>
                                    <tr>
                                        <th style="width: 38px;">No</th>
                                        <th style="width: 72px;">Cover</th>
                                        <th>Judul Buku</th>
                                        <th style="width: 75px;">Status</th>
                                        <th style="width: 65px;">Dibaca</th>
                                        <th style="width: 185px;">Aksi</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php if (empty($main)) : ?>
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada data buku.</td>
                                    </tr>
                                    <?php else : ?>
                                    <?php foreach ($main as $index => $row) : ?>
                                    <tr>
                                        <td class="text-center"><?= $index + 1 ?></td>

                                        <td>
                                            <div class="cover-admin">
                                                <?php if (! empty($row->cover_url)) : ?>
                                                <img src="<?= html_escape($row->cover_url) ?>"
                                                    alt="<?= html_escape($row->judul) ?>"
                                                    onerror="this.style.display='none'; this.parentNode.querySelector('.cover-fallback').style.display='flex';">

                                                <div class="cover-fallback"
                                                    style="display:none; width:100%; height:100%; align-items:center; justify-content:center;">
                                                    <i class="fa fa-book"></i>
                                                </div>
                                                <?php else : ?>
                                                <i class="fa fa-book"></i>
                                                <?php endif; ?>
                                            </div>
                                        </td>

                                        <td>
                                            <div class="judul-buku">
                                                <?= html_escape($row->judul) ?>
                                            </div>

                                            <div class="meta-buku">
                                                <?php if (! empty($row->kategori)) : ?>
                                                <strong>Kategori:</strong> <?= html_escape($row->kategori) ?><br>
                                                <?php endif; ?>

                                                <?php if (! empty($row->penulis)) : ?>
                                                <strong>Penulis:</strong> <?= html_escape($row->penulis) ?><br>
                                                <?php endif; ?>

                                                <?php if (! empty($row->penerbit)) : ?>
                                                <strong>Penerbit:</strong> <?= html_escape($row->penerbit) ?><br>
                                                <?php endif; ?>

                                                <?php if (! empty($row->sumber)) : ?>
                                                <strong>Sumber:</strong> <?= html_escape($row->sumber) ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>

                                        <td class="text-center">
                                            <?php if ((int) $row->aktif === 1) : ?>
                                            <span class="badge-tipe badge-aktif">Aktif</span>
                                            <?php else : ?>
                                            <span class="badge-tipe badge-nonaktif">Nonaktif</span>
                                            <?php endif; ?>
                                        </td>

                                        <td class="text-center">
                                            <?= (int) $row->dilihat ?>
                                        </td>

                                        <td class="aksi">
                                            <div class="aksi-wrap">
                                                <a href="<?= html_escape($row->detail_url) ?>" target="_blank"
                                                    class="btn btn-info btn-xs">
                                                    <i class="fa fa-eye"></i> Preview
                                                </a>

                                                <a href="<?= html_escape($row->baca_url) ?>" target="_blank"
                                                    class="btn btn-success btn-xs">
                                                    <i class="fa fa-book"></i> Baca
                                                </a>

                                                <a href="<?= site_url($controller . '/ubah/' . $row->id) ?>"
                                                    class="btn btn-warning btn-xs">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>

                                                <?php if ((int) $row->aktif === 1) : ?>
                                                <a href="<?= site_url($controller . '/status/' . $row->id . '/0') ?>"
                                                    class="btn btn-danger btn-xs"
                                                    onclick="return confirm('Nonaktifkan buku ini dari halaman publik?')">
                                                    <i class="fa fa-eye-slash"></i> Nonaktif
                                                </a>
                                                <?php else : ?>
                                                <a href="<?= site_url($controller . '/status/' . $row->id . '/1') ?>"
                                                    class="btn btn-primary btn-xs"
                                                    onclick="return confirm('Aktifkan buku ini agar tampil di halaman publik?')">
                                                    <i class="fa fa-eye"></i> Aktifkan
                                                </a>
                                                <?php endif; ?>

                                                <a href="<?= site_url($controller . '/hapus/' . $row->id) ?>"
                                                    class="btn btn-danger btn-xs"
                                                    onclick="return confirm('Hapus buku ini secara permanen? File PDF dan cover lokal juga akan ikut dihapus.')">
                                                    <i class="fa fa-trash"></i> Hapus
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="alert alert-info" style="margin-top: 12px; margin-bottom: 0;">
                            Tahap awal ini baru menampilkan daftar buku. Fitur tambah, edit, upload PDF, upload cover,
                            ambil cover
                            otomatis, aktif/nonaktif, dan hapus akan ditambahkan bertahap.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>