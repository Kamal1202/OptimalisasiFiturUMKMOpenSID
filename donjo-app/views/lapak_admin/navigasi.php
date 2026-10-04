<?php

defined('BASEPATH') || exit('No direct script access allowed');

/*
 * File ini:
 *
 * View navigasi untuk Modul Lapak Admin
 *
 *
 * donjo-app/views/lapak_admin/navigasi.php
 *
 */

if (! function_exists('lapak_admin_persen')) {
        function lapak_admin_persen($aktif, $total)
        {
                $aktif = (int) $aktif;
                $total = (int) $total;

                if ($total <= 0) {
                        return 0;
                }

                return min(100, max(0, ($aktif / $total) * 100));
        }
}

$jml_pengajuan_lapak = [
        'aktif' => 0,
        'total' => 0,
];

if (isset($this->db) && $this->db->table_exists('pengajuan_lapak')) {
        $jml_pengajuan_lapak['aktif'] = (int) $this->db
                ->where_in('status', [0, 3])
                ->count_all_results('pengajuan_lapak');

        $jml_pengajuan_lapak['total'] = (int) $this->db
                ->count_all_results('pengajuan_lapak');
}
?>

<div class="row" style="margin-bottom: 10px;">
    <div class="col-xs-12">
        <div class="pull-right">
            <a href="<?= site_url('lapak_admin/pengaturan'); ?>" title="Pengaturan Modul" class="btn btn-default btn-sm"
                data-remote="false" data-toggle="modal" data-target="#modalBox" data-title="Pengaturan Modul"
                data-backdrop="false" data-keyboard="false">
                <i class="fa fa-gear"></i> Pengaturan
            </a>
        </div>
    </div>
</div>

<div class="row">
    <a href="<?= site_url('lapak_admin/produk'); ?>">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="fa fa-cubes fa-nav"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">PRODUK</span>
                    <span class="info-box-number"><?= $jml_produk['aktif']; ?></span>

                    <div class="progress">
                        <div class="progress-bar"
                            style="width: <?= lapak_admin_persen($jml_produk['aktif'], $jml_produk['total']); ?>%">
                        </div>
                    </div>
                    <span class="progress-description">Total : <b><?= $jml_produk['total']; ?></b></span>
                </div>
            </div>
        </div>
    </a>

    <a href="<?= site_url('lapak_admin/pelapak'); ?>">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="fa fa-users fa-nav"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">PELAPAK</span>
                    <span class="info-box-number"><?= $jml_pelapak['aktif']; ?></span>

                    <div class="progress">
                        <div class="progress-bar"
                            style="width: <?= lapak_admin_persen($jml_pelapak['aktif'], $jml_pelapak['total']); ?>%">
                        </div>
                    </div>
                    <span class="progress-description">Total : <b><?= $jml_pelapak['total']; ?></b></span>
                </div>
            </div>
        </div>
    </a>

    <a href="<?= site_url('lapak_admin/kategori'); ?>">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-yellow">
                <span class="info-box-icon"><i class="fa fa-tags fa-nav"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">KATEGORI</span>
                    <span class="info-box-number"><?= $jml_kategori['aktif']; ?></span>

                    <div class="progress">
                        <div class="progress-bar"
                            style="width: <?= lapak_admin_persen($jml_kategori['aktif'], $jml_kategori['total']); ?>%">
                        </div>
                    </div>
                    <span class="progress-description">Total : <b><?= $jml_kategori['total']; ?></b></span>
                </div>
            </div>
        </div>
    </a>

    <a href="<?= site_url('pengajuan-lapak-admin'); ?>">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box bg-red">
                <span class="info-box-icon"><i class="fa fa-list fa-nav"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">PENGAJUAN LAPAK</span>
                    <span class="info-box-number"><?= $jml_pengajuan_lapak['aktif']; ?></span>

                    <div class="progress">
                        <div class="progress-bar"
                            style="width: <?= lapak_admin_persen($jml_pengajuan_lapak['aktif'], $jml_pengajuan_lapak['total']); ?>%">
                        </div>
                    </div>
                    <span class="progress-description">Total : <b><?= $jml_pengajuan_lapak['total']; ?></b></span>
                </div>
            </div>
        </div>
    </a>
</div>