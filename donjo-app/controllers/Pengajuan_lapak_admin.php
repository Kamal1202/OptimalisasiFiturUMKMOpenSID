<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Pengajuan_lapak_admin extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('pengajuan_lapak_model');

        $this->controller = 'pengajuan-lapak-admin';
    }

    public function index()
    {
        $status  = trim((string) $this->input->get('status', true));
        $jenis   = trim((string) $this->input->get('jenis', true));
        $keyword = trim((string) $this->input->get('keyword', true));

        $this->db
            ->select('pl.*, p.nama AS nama_penduduk, lp.nama_lapak, pr.nama AS nama_produk')
            ->from('pengajuan_lapak pl')
            ->join('penduduk_hidup p', 'pl.id_pend = p.id', 'LEFT')
            ->join('pelapak lp', 'pl.id_pelapak = lp.id', 'LEFT')
            ->join('produk pr', 'pl.id_produk = pr.id', 'LEFT');

        if ($status !== '') {
            $this->db->where('pl.status', (int) $status);
        }

        if ($jenis !== '') {
            $this->db->where('pl.jenis', $jenis);
        }

        if ($keyword !== '') {
            $this->db->group_start()
                ->like('p.nama', $keyword)
                ->or_like('lp.nama_lapak', $keyword)
                ->or_like('pr.nama', $keyword)
                ->or_like('pl.jenis', $keyword)
                ->group_end();
        }

        $main = $this->db
            ->order_by('pl.id', 'DESC')
            ->get()
            ->result();

        foreach ($main as $row) {
            $row->jenis_label  = $this->pengajuan_lapak_model->jenis_label($row->jenis);
            $row->status_label = $this->pengajuan_lapak_model->status_label($row->status);
        }

        $data = [
            'controller' => $this->controller,
            'main'       => $main,
            'status'     => $status,
            'jenis'      => $jenis,
            'keyword'    => $keyword,
        ];

        $this->render('pengajuan_lapak_admin/index', $data);
    }

    public function detail($id = 0)
    {
        $main = $this->pengajuan_lapak_model->get_detail($id);

        if (empty($main)) {
            show_404();
        }

        $data = [
            'controller' => $this->controller,
            'main'       => $main,
        ];

        $this->render('pengajuan_lapak_admin/detail', $data);
    }

    public function ubah_status($id = 0, $status = 0)
    {
        $status = (int) $status;

        if (! in_array($status, [1, 2, 3], true)) {
            show_404();
        }

        $main = $this->pengajuan_lapak_model->get_detail($id);

        if (empty($main)) {
            show_404();
        }

        if ((int) $main->status === 1 || (int) $main->status === 2) {
            redirect_with('error', 'Pengajuan ini sudah selesai diproses.', "{$this->controller}/detail/{$id}");
        }

        $catatan_admin = trim((string) $this->input->post('catatan_admin', true));
        $admin_id = $this->id_user_admin();

        if ($status === 1) {
            $this->db->trans_begin();

            $hasil = $this->proses_setujui_pengajuan($main);

            if (! $hasil['status']) {
                $this->db->trans_rollback();
                redirect_with('error', $hasil['pesan'], "{$this->controller}/detail/{$id}");
            }

            $this->db
                ->where('id', (int) $main->id)
                ->update('pengajuan_lapak', [
                    'status'        => 1,
                    'catatan_admin' => $catatan_admin,
                    'updated_at'    => date('Y-m-d H:i:s'),
                    'diproses_at'   => date('Y-m-d H:i:s'),
                    'diproses_oleh' => $admin_id,
                ]);

            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                redirect_with('error', 'Pengajuan gagal disetujui karena terjadi kesalahan database.', "{$this->controller}/detail/{$id}");
            }

            $this->db->trans_commit();

            redirect_with('success', 'Pengajuan disetujui dan data lapak/produk berhasil diperbarui.', "{$this->controller}/detail/{$id}");
        }

        $this->db
            ->where('id', (int) $main->id)
            ->update('pengajuan_lapak', [
                'status'        => $status,
                'catatan_admin' => $catatan_admin,
                'updated_at'    => date('Y-m-d H:i:s'),
                'diproses_at'   => date('Y-m-d H:i:s'),
                'diproses_oleh' => $admin_id,
            ]);

        if ($status === 2) {
            redirect_with('success', 'Pengajuan berhasil ditolak.', "{$this->controller}/detail/{$id}");
        }

        redirect_with('success', 'Pengajuan ditandai butuh perbaikan.', "{$this->controller}/detail/{$id}");
    }

    private function proses_setujui_pengajuan($pengajuan)
    {
        $jenis = (string) $pengajuan->jenis;
        $data_baru = is_array($pengajuan->data_baru_array ?? null) ? $pengajuan->data_baru_array : [];

        if ($jenis === 'profil_ubah') {
            return $this->setujui_profil_ubah($pengajuan, $data_baru);
        }

        if ($jenis === 'produk_tambah') {
            return $this->setujui_produk_tambah($pengajuan, $data_baru);
        }

        if ($jenis === 'produk_ubah') {
            return $this->setujui_produk_ubah($pengajuan, $data_baru);
        }

        if ($jenis === 'produk_hapus') {
            return $this->setujui_produk_hapus($pengajuan);
        }

        return [
            'status' => false,
            'pesan'  => 'Jenis pengajuan tidak dikenal: ' . $jenis,
        ];
    }

    private function setujui_profil_ubah($pengajuan, array $data_baru)
    {
        if (empty($pengajuan->id_pelapak)) {
            return [
                'status' => false,
                'pesan'  => 'ID pelapak tidak ditemukan pada pengajuan.',
            ];
        }

        $update = $this->filter_data_tabel('pelapak', $data_baru, [
            'id',
            'id_pend',
            'created_at',
            'updated_at',
        ]);

        if (empty($update)) {
            return [
                'status' => false,
                'pesan'  => 'Tidak ada data profil lapak yang bisa diterapkan.',
            ];
        }

        if ($this->db->field_exists('updated_at', 'pelapak')) {
            $update['updated_at'] = date('Y-m-d H:i:s');
        }

        $this->db
            ->where('id', (int) $pengajuan->id_pelapak)
            ->update('pelapak', $update);

        return [
            'status' => true,
            'pesan'  => 'Profil lapak berhasil diperbarui.',
        ];
    }

    private function setujui_produk_tambah($pengajuan, array $data_baru)
    {
        if (empty($pengajuan->id_pelapak)) {
            return [
                'status' => false,
                'pesan'  => 'ID pelapak tidak ditemukan pada pengajuan.',
            ];
        }

        $foto = $this->susun_foto_dari_rencana($data_baru['foto_rencana'] ?? []);

        if (! $foto['status']) {
            return $foto;
        }

        unset($data_baru['foto_rencana']);

        $insert = $this->filter_data_tabel('produk', $data_baru, [
            'id',
            'created_at',
            'updated_at',
        ]);

        $insert['id_pelapak'] = (int) $pengajuan->id_pelapak;
        $insert['foto'] = json_encode($foto['files']);
        $insert['created_at'] = date('Y-m-d H:i:s');
        $insert['updated_at'] = date('Y-m-d H:i:s');

        $this->db->insert('produk', $insert);

        return [
            'status' => true,
            'pesan'  => 'Produk baru berhasil dibuat.',
        ];
    }

    private function setujui_produk_ubah($pengajuan, array $data_baru)
    {
        if (empty($pengajuan->id_produk)) {
            return [
                'status' => false,
                'pesan'  => 'ID produk tidak ditemukan pada pengajuan.',
            ];
        }

        $produk = $this->db
            ->where('id', (int) $pengajuan->id_produk)
            ->get('produk')
            ->row();

        if (empty($produk)) {
            return [
                'status' => false,
                'pesan'  => 'Produk yang diajukan tidak ditemukan.',
            ];
        }

        $update = $this->filter_data_tabel('produk', $data_baru, [
            'id',
            'id_pelapak',
            'created_at',
            'updated_at',
            'foto_rencana',
        ]);

        if (array_key_exists('foto_rencana', $data_baru)) {
            $foto = $this->susun_foto_dari_rencana($data_baru['foto_rencana']);

            if (! $foto['status']) {
                return $foto;
            }

            $update['foto'] = json_encode($foto['files']);
        }

        $update['updated_at'] = date('Y-m-d H:i:s');

        $this->db
            ->where('id', (int) $pengajuan->id_produk)
            ->update('produk', $update);

        return [
            'status' => true,
            'pesan'  => 'Produk berhasil diperbarui.',
        ];
    }

    private function setujui_produk_hapus($pengajuan)
    {
        if (empty($pengajuan->id_produk)) {
            return [
                'status' => false,
                'pesan'  => 'ID produk tidak ditemukan pada pengajuan.',
            ];
        }

        $this->db
            ->where('id', (int) $pengajuan->id_produk)
            ->delete('produk');

        return [
            'status' => true,
            'pesan'  => 'Produk berhasil dihapus.',
        ];
    }

    private function susun_foto_dari_rencana($foto_rencana)
    {
        $hasil = [];

        if (is_string($foto_rencana)) {
            $decoded = json_decode($foto_rencana, true);
            $foto_rencana = is_array($decoded) ? $decoded : [];
        }

        if (! is_array($foto_rencana)) {
            $foto_rencana = [];
        }

        foreach ($foto_rencana as $item) {
            if (! is_array($item)) {
                continue;
            }

            $tipe = $item['tipe'] ?? '';
            $file = trim((string) ($item['file'] ?? ''));

            if ($tipe === 'hapus') {
                continue;
            }

            if ($file === '') {
                continue;
            }

            if ($tipe === 'baru') {
                $copy = $this->salin_foto_pengajuan_ke_produk($file);

                if (! $copy['status']) {
                    return $copy;
                }
            }

            $hasil[] = $file;
        }

        return [
            'status' => true,
            'files'  => array_values(array_unique(array_filter($hasil))),
            'pesan'  => 'Foto berhasil disusun.',
        ];
    }

    private function salin_foto_pengajuan_ke_produk($file)
    {
        $file = trim((string) $file);

        if ($file === '') {
            return [
                'status' => false,
                'pesan'  => 'Nama file foto kosong.',
            ];
        }

        $source = FCPATH . 'desa/upload/lapak/pengajuan/' . $file;
        $target_dir = FCPATH . 'desa/upload/produk/';
        $target = $target_dir . $file;

        if (! is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        if (file_exists($target)) {
            return [
                'status' => true,
                'pesan'  => 'File foto sudah ada di folder produk.',
            ];
        }

        if (! file_exists($source)) {
            return [
                'status' => false,
                'pesan'  => 'File foto pengajuan tidak ditemukan: ' . $file,
            ];
        }

        if (! copy($source, $target)) {
            return [
                'status' => false,
                'pesan'  => 'Gagal menyalin foto pengajuan ke folder produk: ' . $file,
            ];
        }

        return [
            'status' => true,
            'pesan'  => 'File foto berhasil disalin.',
        ];
    }

    private function filter_data_tabel($table, array $data, array $abaikan = [])
    {
        if (! $this->db->table_exists($table)) {
            return [];
        }

        $fields = $this->db->list_fields($table);
        $fields = is_array($fields) ? $fields : [];

        $hasil = [];

        foreach ($data as $key => $value) {
            if (in_array($key, $abaikan, true)) {
                continue;
            }

            if (! in_array($key, $fields, true)) {
                continue;
            }

            $hasil[$key] = $value;
        }

        return $hasil;
    }

    private function id_user_admin()
    {
        $user = $this->session->user ?? $this->session->userdata('user');

        if (is_array($user)) {
            return $user['id'] ?? null;
        }

        if (is_object($user)) {
            return $user->id ?? null;
        }

        return null;
    }
}