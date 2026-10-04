<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Pengajuan_lapak_model extends CI_Model
{
    private $table = 'pengajuan_lapak';
    private $table_file = 'pengajuan_lapak_file';

    public function get_all($status = null)
    {
        $this->db
            ->select('pl.*, p.nama AS nama_penduduk, lp.nama_lapak, pr.nama AS nama_produk')
            ->from($this->table . ' pl')
            ->join('penduduk_hidup p', 'pl.id_pend = p.id', 'LEFT')
            ->join('pelapak lp', 'pl.id_pelapak = lp.id', 'LEFT')
            ->join('produk pr', 'pl.id_produk = pr.id', 'LEFT');

        if ($status !== null && $status !== '') {
            $this->db->where('pl.status', (int) $status);
        }

        return $this->db
            ->order_by('pl.id', 'DESC')
            ->get()
            ->result();
    }

    public function get_detail($id)
    {
        $pengajuan = $this->db
            ->select('
                pl.*,
                p.nama AS nama_penduduk,
                lp.nama_lapak,
                pr.nama AS nama_produk,
                pr.foto AS foto_produk_lama
            ')
            ->from($this->table . ' pl')
            ->join('penduduk_hidup p', 'pl.id_pend = p.id', 'LEFT')
            ->join('pelapak lp', 'pl.id_pelapak = lp.id', 'LEFT')
            ->join('produk pr', 'pl.id_produk = pr.id', 'LEFT')
            ->where('pl.id', (int) $id)
            ->get()
            ->row();

        if (empty($pengajuan)) {
            return null;
        }

        $pengajuan->data_lama_array = $this->decode_json($pengajuan->data_lama);
        $pengajuan->data_baru_array = $this->decode_json($pengajuan->data_baru);
        $pengajuan->files = $this->get_files($pengajuan->id);

        return $pengajuan;
    }

    public function get_files($id_pengajuan)
    {
        return $this->db
            ->where('id_pengajuan', (int) $id_pengajuan)
            ->order_by('id', 'ASC')
            ->get($this->table_file)
            ->result();
    }

    public function buat_pengajuan($data)
    {
        $insert = [
            'id_pend'       => $data['id_pend'] ?? null,
            'id_pelapak'    => $data['id_pelapak'] ?? null,
            'id_produk'     => $data['id_produk'] ?? null,
            'jenis'         => $data['jenis'],
            'data_lama'     => ! empty($data['data_lama']) ? json_encode($data['data_lama']) : null,
            'data_baru'     => ! empty($data['data_baru']) ? json_encode($data['data_baru']) : null,
            'status'        => 0,
            'catatan_admin' => null,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'diproses_at'   => null,
            'diproses_oleh' => null,
        ];

        $this->db->insert($this->table, $insert);

        return (int) $this->db->insert_id();
    }

    public function tambah_file($id_pengajuan, $file, $tipe = 'foto_produk')
    {
        if (empty($id_pengajuan) || empty($file)) {
            return false;
        }

        return $this->db->insert($this->table_file, [
            'id_pengajuan' => (int) $id_pengajuan,
            'tipe'         => $tipe,
            'file'         => $file,
            'created_at'   => date('Y-m-d H:i:s'),
        ]);
    }

    public function hitung_menunggu()
    {
        return (int) $this->db
            ->where('status', 0)
            ->count_all_results($this->table);
    }

    public function ada_pengajuan_menunggu($jenis, $id_pelapak = null, $id_produk = null)
    {
        $this->db
            ->from($this->table)
            ->where('jenis', $jenis)
            ->where('status', 0);

        if (! empty($id_pelapak)) {
            $this->db->where('id_pelapak', (int) $id_pelapak);
        }

        if (! empty($id_produk)) {
            $this->db->where('id_produk', (int) $id_produk);
        }

        return $this->db->count_all_results() > 0;
    }

    public function status_label($status)
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

    public function jenis_label($jenis)
    {
        $labels = [
            'profil_ubah'   => 'Perubahan Profil Lapak',
            'produk_tambah' => 'Tambah Produk/Menu',
            'produk_ubah'   => 'Perubahan Produk/Menu',
            'produk_hapus'  => 'Penghapusan Produk/Menu',
        ];

        return $labels[$jenis] ?? $jenis;
    }

    private function decode_json($json)
    {
        if (empty($json)) {
            return [];
        }

        $data = json_decode($json, true);

        return is_array($data) ? $data : [];
    }
}