<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Perpustakaan_digital_model extends CI_Model
{
    private $table = 'perpustakaan_digital_buku';

    public function count_buku($keyword = '')
    {
        $this->db->from($this->table);
        $this->db->where('aktif', 1);

        if ($keyword !== '') {
            $this->apply_keyword($keyword);
        }

        return $this->db->count_all_results();
    }

    public function get_buku($limit = 8, $offset = 0, $keyword = '')
    {
        $this->db
            ->from($this->table)
            ->where('aktif', 1);

        if ($keyword !== '') {
            $this->apply_keyword($keyword);
        }

        return $this->db
            ->order_by('id', 'ASC')
            ->limit((int) $limit, (int) $offset)
            ->get()
            ->result();
    }

    public function get_detail($id, $aktif = true)
    {
        $this->db
            ->from($this->table)
            ->where('id', (int) $id);

        if ($aktif) {
            $this->db->where('aktif', 1);
        }

        return $this->db->get()->row();
    }

    public function get_buku_terkait($id, $kategori = '', $limit = 4)
    {
        $this->db
            ->from($this->table)
            ->where('aktif', 1)
            ->where('id !=', (int) $id);

        if ($kategori !== '') {
            $kategori_utama = trim(explode(',', $kategori)[0]);

            if ($kategori_utama !== '') {
                $this->db->like('kategori', $kategori_utama);
            }
        }

        return $this->db
            ->order_by('id', 'ASC')
            ->limit((int) $limit)
            ->get()
            ->result();
    }

    public function increment_dilihat($id)
    {
        $this->db
            ->set('dilihat', 'dilihat + 1', false)
            ->set('terakhir_dibaca', date('Y-m-d H:i:s'))
            ->where('id', (int) $id)
            ->update($this->table);
    }

    public function cover_url($buku)
    {
        if (! empty($buku->sampul)) {
            $lokasi_sampul = 'desa/upload/perpustakaan/sampul/' . $buku->sampul;

            if (is_file(FCPATH . $lokasi_sampul)) {
                return base_url($lokasi_sampul);
            }
        }

        return '';
    }

    public function reader_url($buku)
    {
        if (! empty($buku->file_pdf)) {
            $lokasi_pdf = 'desa/upload/perpustakaan/pdf/' . $buku->file_pdf;

            if (is_file(FCPATH . $lokasi_pdf)) {
                return base_url($lokasi_pdf);
            }
        }

        return '';
    }

    private function apply_keyword($keyword)
    {
        $keyword = trim((string) $keyword);

        $this->db->group_start()
            ->like('judul', $keyword)
            ->or_like('deskripsi', $keyword)
            ->or_like('kategori', $keyword)
            ->or_like('penerbit', $keyword)
            ->or_like('kontributor', $keyword)
            ->or_like('penulis', $keyword)
            ->or_like('sumber', $keyword)
            ->group_end();
    }
}