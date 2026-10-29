<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Lapak extends Web_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('lapak_model');
    }

    public function index($p = 1)
    {
        if ($this->setting->tampilkan_lapak_web == 0) {
            show_404();
        }

        $data = $this->includes;
        $this->_get_common_data($data);

        // Ambil kata kunci pencarian
        $data['keyword'] = trim((string) $this->input->get('keyword', true));

        // Ambil semua produk aktif sesuai kata kunci
        $data['produk'] = $this->lapak_model
            ->get_produk($data['keyword'], 1)
            ->order_by('pr.id', 'DESC')
            ->get()
            ->result();

        // Ambil kategori untuk filter
        $data['kategori'] = $this->lapak_model
            ->get_kategori('', 1)
            ->get()
            ->result();

        $data['total_produk'] = count($data['produk']);
        $data['halaman_statis'] = 'lapak/index';

        $this->set_template('layouts/halaman_statis_lebar.tpl.php');
        $this->load->view($this->template, $data);
    }

    public function toko($id_pelapak = 0)
    {
        if ($this->setting->tampilkan_lapak_web == 0) {
            show_404();
        }

        $data = $this->includes;
        $this->_get_common_data($data);

        $id_pelapak = (int) $id_pelapak;

        $data['lapak'] = $this->detail_lapak_aktif($id_pelapak);

        if (empty($data['lapak'])) {
            show_404();
        }

        $data['produk'] = $this->lapak_model
            ->get_produk('', 1)
            ->where('pr.id_pelapak', $id_pelapak)
            ->order_by('pr.id', 'DESC')
            ->get()
            ->result();

        $data['kategori']       = $this->lapak_model->get_kategori('', 1)->get()->result();
        $data['halaman_statis'] = 'lapak/toko';

        $this->set_template('layouts/halaman_statis_lebar.tpl.php');
        $this->load->view($this->template, $data);
    }

    public function detail($id = 0)
    {
        if ($this->setting->tampilkan_lapak_web == 0) {
            show_404();
        }

        $data = $this->includes;
        $this->_get_common_data($data);

        $id = (int) $id;

        $data['produk'] = $this->lapak_model
            ->get_produk('', 1)
            ->where('pr.id', $id)
            ->get()
            ->row();

        if (empty($data['produk'])) {
            show_404();
        }

        $data['produk_lain'] = $this->lapak_model
            ->get_produk('', 1)
            ->where('pr.id_pelapak', (int) $data['produk']->id_pelapak)
            ->where('pr.id !=', $id)
            ->limit(4)
            ->get()
            ->result();

        $data['halaman_statis'] = 'lapak/detail';

        $this->set_template('layouts/halaman_statis_lebar.tpl.php');
        $this->load->view($this->template, $data);
    }

    private function daftar_lapak_aktif($keyword = '')
    {
        $keyword = trim((string) $keyword);

        $this->db
            ->select('
                lp.id,
                lp.id_pend,
                lp.nama_lapak,
                lp.deskripsi_lapak,
                lp.logo,
                lp.banner,
                lp.telepon,
                lp.lat,
                lp.lng,
                lp.zoom,
                lp.status,
                p.nama AS nama_pemilik,
                p.nik,
                COUNT(DISTINCT pr.id) AS jumlah_produk
            ')
            ->from('pelapak lp')
            ->join('penduduk_hidup p', 'p.id = lp.id_pend', 'LEFT')
            ->join('produk pr', 'pr.id_pelapak = lp.id AND pr.status = 1', 'LEFT')
            ->where('lp.status', 1);

        if ($keyword !== '') {
            $this->db
                ->group_start()
                ->like('lp.nama_lapak', $keyword)
                ->or_like('p.nama', $keyword)
                ->or_like('lp.telepon', $keyword)
                ->or_like('lp.deskripsi_lapak', $keyword)
                ->group_end();
        }

        return $this->db
            ->group_by('
                lp.id,
                lp.id_pend,
                lp.nama_lapak,
                lp.deskripsi_lapak,
                lp.logo,
                lp.banner,
                lp.telepon,
                lp.lat,
                lp.lng,
                lp.zoom,
                lp.status,
                p.nama,
                p.nik
            ')
            ->order_by('lp.nama_lapak', 'ASC')
            ->get()
            ->result();
    }

    private function detail_lapak_aktif($id_pelapak)
    {
        return $this->db
            ->select('
                lp.*,
                p.nama AS nama_pemilik,
                p.nik,
                COUNT(DISTINCT pr.id) AS jumlah_produk
            ')
            ->from('pelapak lp')
            ->join('penduduk_hidup p', 'p.id = lp.id_pend', 'LEFT')
            ->join('produk pr', 'pr.id_pelapak = lp.id AND pr.status = 1', 'LEFT')
            ->where('lp.id', (int) $id_pelapak)
            ->where('lp.status', 1)
            ->group_by('lp.id')
            ->get()
            ->row();
    }
}