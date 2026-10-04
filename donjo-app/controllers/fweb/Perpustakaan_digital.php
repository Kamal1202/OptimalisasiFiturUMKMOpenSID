<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Perpustakaan_digital extends Web_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('perpustakaan_digital_model');
    }

    public function index()
    {
        $data = $this->includes;
        $this->_get_common_data($data);

        $per_page   = 8;
        $page       = (int) $this->input->get('page', true);
        $keyword    = trim((string) $this->input->get('keyword', true));
        $active_tab = trim((string) $this->input->get('tab', true));

        if ($page < 1) {
            $page = 1;
        }

        if (! in_array($active_tab, ['perpus', 'koleksi', 'panduan'], true)) {
            $active_tab = ($keyword !== '' || $page > 1) ? 'koleksi' : 'perpus';
        }

        $total_buku = $this->perpustakaan_digital_model->count_buku($keyword);
        $total_page = (int) ceil($total_buku / $per_page);

        if ($total_page > 0 && $page > $total_page) {
            $page = $total_page;
        }

        $offset = ($page - 1) * $per_page;
        $koleksi_buku = $this->perpustakaan_digital_model->get_buku($per_page, $offset, $keyword);

        foreach ($koleksi_buku as $buku) {
            $buku->cover_url  = $this->perpustakaan_digital_model->cover_url($buku);
            $buku->detail_url = site_url('perpustakaan-digital/buku/' . $buku->id);
            $buku->baca_url   = site_url('perpustakaan-digital/baca/' . $buku->id);
        }

        $data['judul_halaman'] = 'Perpustakaan Digital';
        $data['link_sikancil'] = 'https://play.google.com/store/apps/details?id=com.eperpus.saas.perpuskrw&pcampaignid=web_share';

        $data['koleksi_buku'] = $koleksi_buku;
        $data['keyword']      = $keyword;
        $data['page']         = $page;
        $data['per_page']     = $per_page;
        $data['total_buku']   = $total_buku;
        $data['total_page']   = $total_page;
        $data['active_tab']   = $active_tab;

        $data['halaman_statis'] = 'perpustakaan_digital/index';

        $this->set_template('layouts/halaman_statis_lebar.tpl.php');
        $this->load->view($this->template, $data);
    }

    public function detail($id = 0)
    {
        $data = $this->includes;
        $this->_get_common_data($data);

        $buku = $this->perpustakaan_digital_model->get_detail($id);

        if (empty($buku)) {
            show_404();
        }

        $buku->cover_url = $this->perpustakaan_digital_model->cover_url($buku);
        $buku->baca_url  = site_url('perpustakaan-digital/baca/' . $buku->id);

        $buku_terkait = $this->perpustakaan_digital_model->get_buku_terkait($buku->id, $buku->kategori, 4);

        foreach ($buku_terkait as $item) {
            $item->cover_url  = $this->perpustakaan_digital_model->cover_url($item);
            $item->detail_url = site_url('perpustakaan-digital/buku/' . $item->id);
            $item->baca_url   = site_url('perpustakaan-digital/baca/' . $item->id);
        }

        $data['buku']          = $buku;
        $data['buku_terkait']  = $buku_terkait;
        $data['halaman_statis'] = 'perpustakaan_digital/detail';

        $this->set_template('layouts/halaman_statis_lebar.tpl.php');
        $this->load->view($this->template, $data);
    }

    public function baca($id = 0)
    {
        $data = $this->includes;
        $this->_get_common_data($data);

        $buku = $this->perpustakaan_digital_model->get_detail($id);

        if (empty($buku)) {
            show_404();
        }

        $this->perpustakaan_digital_model->increment_dilihat($buku->id);

        $buku->cover_url  = $this->perpustakaan_digital_model->cover_url($buku);
        $buku->reader_url = $this->perpustakaan_digital_model->reader_url($buku);
        $buku->detail_url = site_url('perpustakaan-digital/buku/' . $buku->id);

        $data['buku']           = $buku;
        $data['halaman_statis'] = 'perpustakaan_digital/baca';

        $this->set_template('layouts/halaman_statis_lebar.tpl.php');
        $this->load->view($this->template, $data);
    }
}