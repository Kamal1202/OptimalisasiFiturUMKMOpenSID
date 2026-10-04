<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Kelola_lapak extends Mandiri_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('lapak_model');
        $this->load->model('pengajuan_lapak_model');
        $this->load->library('upload');

        $this->controller = 'layanan-mandiri/kelola-lapak';
    }

    public function index($p = 1)
    {
        $id_pend = (int) $this->is_login->id_pend;

        $data = [
            'controller' => $this->controller,
            'pelapak'    => $this->pelapak_warga($id_pend),
            'produk'     => [],
            'pengajuan'  => [],
        ];

        if (! empty($data['pelapak'])) {
            $data['pengajuan'] = $this->db
                ->select('pl.*, pr.nama AS nama_produk')
                ->from('pengajuan_lapak pl')
                ->join('produk pr', 'pl.id_produk = pr.id', 'LEFT')
                ->where('pl.id_pelapak', (int) $data['pelapak']->id)
                ->order_by('pl.id', 'DESC')
                ->limit(10)
                ->get()
                ->result();

            foreach ($data['pengajuan'] as $row) {
                $row->jenis_label = $this->pengajuan_lapak_model->jenis_label($row->jenis);
                $row->status_label = $this->pengajuan_lapak_model->status_label($row->status);
            }
        }

        if (! empty($data['pelapak']) && (int) $data['pelapak']->status === 1) {
            $data['produk'] = $this->lapak_model
                ->get_produk('', null, $id_pend)
                ->order_by('pr.id', 'DESC')
                ->get()
                ->result();
        }

        $data['jumlah_produk'] = count($data['produk']);
        $data['jumlah_pengajuan_aktif'] = 0;

        foreach ($data['pengajuan'] as $row) {
            if (in_array((int) $row->status, [0, 3], true)) {
                $data['jumlah_pengajuan_aktif']++;
            }
        }

        $this->render('kelola_lapak', $data);
    }

    public function produk_tambah()
    {
        $id_pend = (int) $this->is_login->id_pend;
        $pelapak = $this->pelapak_warga($id_pend);

        if (empty($pelapak)) {
            redirect_with('error', 'Anda belum terdaftar sebagai pelapak.', $this->controller);
        }

        if ((int) $pelapak->status !== 1) {
            redirect_with('error', 'Lapak Anda belum aktif. Silakan hubungi admin desa.', $this->controller);
        }

        $data = [
            'controller'  => $this->controller,
            'aksi'        => 'Tambah',
            'pelapak'     => $pelapak,
            'kategori'    => $this->lapak_model->get_kategori('', 1)->get()->result(),
            'satuan'      => $this->lapak_model->get_satuan(),
            'form_action' => site_url($this->controller . '/produk/simpan'),
            'main'        => null,
        ];

        $this->render('kelola_lapak_form', $data);
    }

    public function produk_simpan()
    {
        $id_pend = (int) $this->is_login->id_pend;
        $pelapak = $this->pelapak_warga($id_pend);

        if (empty($pelapak)) {
            redirect_with('error', 'Anda belum terdaftar sebagai pelapak.', $this->controller);
        }

        $data_baru = $this->data_produk_pengajuan($pelapak);

        $foto_rencana = [];
        $foto_upload = [];

        for ($i = 1; $i <= (int) $this->setting->banyak_foto_tiap_produk; $i++) {
            $file_baru = $this->upload_foto_pengajuan('foto_' . $i);

            if (! empty($file_baru)) {
                $foto_rencana[] = [
                    'posisi' => $i,
                    'tipe'   => 'baru',
                    'file'   => $file_baru,
                ];

                $foto_upload[] = $file_baru;
            }
        }

        $data_baru['foto_rencana'] = $foto_rencana;

        $pengajuan_perbaikan = $this->pengajuan_perbaikan(
            'produk_tambah',
            $pelapak->id,
            null
        );

        if (! empty($pengajuan_perbaikan)) {
            $this->update_pengajuan_perbaikan(
                $pengajuan_perbaikan->id,
                $id_pend,
                $pelapak->id,
                null,
                'produk_tambah',
                [],
                $data_baru,
                $foto_upload
            );

            redirect_with(
                'success',
                'Perbaikan pengajuan tambah produk/menu berhasil dikirim ulang. Pengajuan akan diverifikasi kembali oleh admin desa.',
                $this->controller
            );
        }

        $id_pengajuan = $this->pengajuan_lapak_model->buat_pengajuan([
            'id_pend'    => $id_pend,
            'id_pelapak' => $pelapak->id,
            'id_produk'  => null,
            'jenis'      => 'produk_tambah',
            'data_lama'  => null,
            'data_baru'  => $data_baru,
        ]);

        foreach ($foto_upload as $file) {
            $this->pengajuan_lapak_model->tambah_file($id_pengajuan, $file, 'foto_produk');
        }

        redirect_with(
            'success',
            'Pengajuan tambah produk/menu berhasil dikirim. Produk akan tampil setelah disetujui admin desa.',
            $this->controller
        );
    }

    public function produk_ubah($id = 0)
    {
        $id_pend = (int) $this->is_login->id_pend;
        $pelapak = $this->pelapak_warga($id_pend);

        if (empty($pelapak)) {
            redirect_with('error', 'Anda belum terdaftar sebagai pelapak.', $this->controller);
        }

        if ((int) $pelapak->status !== 1) {
            redirect_with('error', 'Lapak Anda belum aktif. Silakan hubungi admin desa.', $this->controller);
        }

        $produk = $this->produk_milik_pelapak($id, $pelapak->id);

        if (empty($produk)) {
            redirect_with('error', 'Produk tidak ditemukan atau bukan milik lapak Anda.', $this->controller);
        }

        $data = [
            'controller'  => $this->controller,
            'aksi'        => 'Ubah',
            'pelapak'     => $pelapak,
            'kategori'    => $this->lapak_model->get_kategori('', 1)->get()->result(),
            'satuan'      => $this->lapak_model->get_satuan(),
            'form_action' => site_url($this->controller . '/produk/update/' . (int) $id),
            'main'        => $produk,
        ];

        $this->render('kelola_lapak_form', $data);
    }

    public function produk_update($id = 0)
    {
        $id_pend = (int) $this->is_login->id_pend;
        $pelapak = $this->pelapak_warga($id_pend);

        if (empty($pelapak)) {
            redirect_with('error', 'Anda belum terdaftar sebagai pelapak.', $this->controller);
        }

        $produk = $this->produk_milik_pelapak($id, $pelapak->id);

        if (empty($produk)) {
            redirect_with('error', 'Produk tidak ditemukan atau bukan milik lapak Anda.', $this->controller);
        }

        if ($this->pengajuan_lapak_model->ada_pengajuan_menunggu('produk_ubah', $pelapak->id, $produk->id)) {
            redirect_with(
                'error',
                'Produk ini masih memiliki pengajuan perubahan yang menunggu persetujuan admin.',
                $this->controller
            );
        }

        if ($this->pengajuan_lapak_model->ada_pengajuan_menunggu('produk_hapus', $pelapak->id, $produk->id)) {
            redirect_with(
                'error',
                'Produk ini sedang diajukan untuk dihapus dan menunggu persetujuan admin.',
                $this->controller
            );
        }

        $data_lama = (array) $produk;
        $data_baru = $this->data_produk_pengajuan($pelapak, $produk);

        $foto_lama = [];

        if (! empty($produk->foto)) {
            $decoded = json_decode((string) $produk->foto, true);
            $foto_lama = is_array($decoded) ? array_values($decoded) : [];
        }

        $foto_rencana = [];
        $foto_upload = [];

        for ($i = 1; $i <= (int) $this->setting->banyak_foto_tiap_produk; $i++) {
            $index = $i - 1;
            $old_foto = $foto_lama[$index] ?? '';

            if ((int) $this->input->post('hapus_foto_' . $i, true) === 1) {
                $foto_rencana[] = [
                    'posisi' => $i,
                    'tipe'   => 'hapus',
                    'file'   => '',
                ];

                continue;
            }

            $file_baru = $this->upload_foto_pengajuan('foto_' . $i);

            if (! empty($file_baru)) {
                $foto_rencana[] = [
                    'posisi' => $i,
                    'tipe'   => 'baru',
                    'file'   => $file_baru,
                ];

                $foto_upload[] = $file_baru;
                continue;
            }

            if (! empty($old_foto)) {
                $foto_rencana[] = [
                    'posisi' => $i,
                    'tipe'   => 'lama',
                    'file'   => $old_foto,
                ];
            }
        }

        $data_baru['foto_rencana'] = $foto_rencana;

        $pengajuan_perbaikan = $this->pengajuan_perbaikan('produk_ubah', $pelapak->id, $produk->id);

        if (! empty($pengajuan_perbaikan)) {
            $this->update_pengajuan_perbaikan(
                $pengajuan_perbaikan->id,
                $id_pend,
                $pelapak->id,
                $produk->id,
                'produk_ubah',
                $data_lama,
                $data_baru,
                $foto_upload
            );

            redirect_with(
                'success',
                'Perbaikan pengajuan perubahan produk/menu berhasil dikirim ulang. Pengajuan akan diverifikasi kembali oleh admin desa.',
                $this->controller
            );
        }

        $id_pengajuan = $this->pengajuan_lapak_model->buat_pengajuan([
            'id_pend'    => $id_pend,
            'id_pelapak' => $pelapak->id,
            'id_produk'  => $produk->id,
            'jenis'      => 'produk_ubah',
            'data_lama'  => $data_lama,
            'data_baru'  => $data_baru,
        ]);

        foreach ($foto_upload as $file) {
            $this->pengajuan_lapak_model->tambah_file($id_pengajuan, $file, 'foto_produk');
        }

        redirect_with(
            'success',
            'Pengajuan perubahan produk/menu berhasil dikirim. Perubahan akan tampil setelah disetujui admin desa.',
            $this->controller
        );
    }

    public function produk_status($id = 0, $status = 0)
    {
        $status = (int) $status;

        if (! in_array($status, [0, 1], true)) {
            redirect_with('error', 'Status produk tidak valid.', $this->controller);
        }

        $id_pend = (int) $this->is_login->id_pend;
        $pelapak = $this->pelapak_warga($id_pend);

        if (empty($pelapak)) {
            redirect_with('error', 'Anda belum terdaftar sebagai pelapak.', $this->controller);
        }

        $produk = $this->produk_milik_pelapak($id, $pelapak->id);

        if (empty($produk)) {
            redirect_with('error', 'Produk tidak ditemukan atau bukan milik lapak Anda.', $this->controller);
        }

        if ($this->pengajuan_lapak_model->ada_pengajuan_menunggu('produk_ubah', $pelapak->id, $produk->id)) {
            redirect_with(
                'error',
                'Produk ini masih memiliki pengajuan perubahan yang menunggu persetujuan admin.',
                $this->controller
            );
        }

        if ($this->pengajuan_lapak_model->ada_pengajuan_menunggu('produk_hapus', $pelapak->id, $produk->id)) {
            redirect_with(
                'error',
                'Produk ini sedang diajukan untuk dihapus dan menunggu persetujuan admin.',
                $this->controller
            );
        }

        $data_lama = (array) $produk;
        $data_baru = (array) $produk;
        $data_baru['status'] = $status;

        $this->pengajuan_lapak_model->buat_pengajuan([
            'id_pend'    => $id_pend,
            'id_pelapak' => $pelapak->id,
            'id_produk'  => $produk->id,
            'jenis'      => 'produk_ubah',
            'data_lama'  => $data_lama,
            'data_baru'  => $data_baru,
        ]);

        if ($status === 1) {
            redirect_with(
                'success',
                'Pengajuan pengaktifan produk berhasil dikirim. Produk akan aktif setelah disetujui admin desa.',
                $this->controller
            );
        }

        redirect_with(
            'success',
            'Pengajuan penonaktifan produk berhasil dikirim. Produk akan nonaktif setelah disetujui admin desa.',
            $this->controller
        );
    }

    public function produk_hapus($id = 0)
    {
        $id_pend = (int) $this->is_login->id_pend;
        $pelapak = $this->pelapak_warga($id_pend);

        if (empty($pelapak)) {
            redirect_with('error', 'Anda belum terdaftar sebagai pelapak.', $this->controller);
        }

        $produk = $this->produk_milik_pelapak($id, $pelapak->id);

        if (empty($produk)) {
            redirect_with('error', 'Produk tidak ditemukan atau bukan milik lapak Anda.', $this->controller);
        }

        if ($this->pengajuan_lapak_model->ada_pengajuan_menunggu('produk_hapus', $pelapak->id, $produk->id)) {
            redirect_with(
                'error',
                'Produk ini sudah memiliki pengajuan penghapusan yang menunggu persetujuan admin.',
                $this->controller
            );
        }

        $data_lama = (array) $produk;

        $this->pengajuan_lapak_model->buat_pengajuan([
            'id_pend'    => $id_pend,
            'id_pelapak' => $pelapak->id,
            'id_produk'  => $produk->id,
            'jenis'      => 'produk_hapus',
            'data_lama'  => $data_lama,
            'data_baru'  => [
                'aksi' => 'hapus_produk',
            ],
        ]);

        redirect_with(
            'success',
            'Pengajuan penghapusan produk berhasil dikirim. Produk akan dihapus setelah disetujui admin desa.',
            $this->controller
        );
    }

    public function profil()
    {
        $id_pend = (int) $this->is_login->id_pend;
        $pelapak = $this->pelapak_warga($id_pend);

        if (empty($pelapak)) {
            redirect_with('error', 'Anda belum terdaftar sebagai pelapak.', $this->controller);
        }

        $desa = $this->db
            ->select('lat, lng, zoom')
            ->from('config')
            ->get()
            ->row();

        $data = [
            'controller' => $this->controller,
            'pelapak'    => $pelapak,
            'lokasi'     => [
                'lat'  => $pelapak->lat ?: ($desa->lat ?? '-6.200000'),
                'lng'  => $pelapak->lng ?: ($desa->lng ?? '106.816666'),
                'zoom' => $pelapak->zoom ?: ($desa->zoom ?? 10),
            ],
            'form_action' => site_url($this->controller . '/profil/update'),
        ];

        $this->render('kelola_lapak_profil', $data);
    }

    public function profil_update()
    {
        $id_pend = (int) $this->is_login->id_pend;
        $pelapak = $this->pelapak_warga($id_pend);

        if (empty($pelapak)) {
            redirect_with('error', 'Anda belum terdaftar sebagai pelapak.', $this->controller);
        }

        $nama_lapak = trim((string) $this->input->post('nama_lapak', true));
        $telepon    = preg_replace('/[^0-9]/', '', (string) $this->input->post('telepon', true));
        $deskripsi  = trim((string) $this->input->post('deskripsi_lapak', true));
        $lat        = trim((string) $this->input->post('lat', true));
        $lng        = trim((string) $this->input->post('lng', true));
        $zoom       = (int) $this->input->post('zoom', true);

        if ($nama_lapak === '') {
            redirect_with('error', 'Nama lapak wajib diisi.', $this->controller . '/profil');
        }

        if ($telepon === '') {
            redirect_with('error', 'Nomor WhatsApp wajib diisi.', $this->controller . '/profil');
        }

        if ($zoom < 1 || $zoom > 20) {
            $zoom = 10;
        }

        $update = [
            'nama_lapak'      => $nama_lapak,
            'deskripsi_lapak' => $this->security->xss_clean($deskripsi),
            'telepon'         => $telepon,
            'lat'             => $lat,
            'lng'             => $lng,
            'zoom'            => $zoom,
        ];

        $logo_baru = $this->upload_media_lapak('logo', 'logo', 5120);

        if (! empty($logo_baru)) {
            $update['logo'] = $logo_baru;
        } elseif ((int) $this->input->post('hapus_logo', true) === 1) {
            $update['logo'] = null;
        }

        $banner_baru = $this->upload_media_lapak('banner', 'banner', 8192);

        if (! empty($banner_baru)) {
            $update['banner'] = $banner_baru;
        } elseif ((int) $this->input->post('hapus_banner', true) === 1) {
            $update['banner'] = null;
        }

        if ($this->pengajuan_lapak_model->ada_pengajuan_menunggu('profil_ubah', $pelapak->id)) {
            redirect_with(
                'error',
                'Masih ada pengajuan perubahan profil lapak yang menunggu persetujuan admin.',
                $this->controller
            );
        }

        $data_lama = [
            'nama_lapak'      => $pelapak->nama_lapak,
            'deskripsi_lapak' => $pelapak->deskripsi_lapak,
            'logo'            => $pelapak->logo ?? null,
            'banner'          => $pelapak->banner ?? null,
            'telepon'         => $pelapak->telepon,
            'lat'             => $pelapak->lat,
            'lng'             => $pelapak->lng,
            'zoom'            => $pelapak->zoom,
        ];

        $pengajuan_perbaikan = $this->pengajuan_perbaikan('profil_ubah', $pelapak->id, null);

        if (! empty($pengajuan_perbaikan)) {
            $this->update_pengajuan_perbaikan(
                $pengajuan_perbaikan->id,
                $id_pend,
                $pelapak->id,
                null,
                'profil_ubah',
                $data_lama,
                $update,
                []
            );

            redirect_with(
                'success',
                'Perbaikan pengajuan profil lapak berhasil dikirim ulang. Pengajuan akan diverifikasi kembali oleh admin desa.',
                $this->controller
            );
        }

        $this->pengajuan_lapak_model->buat_pengajuan([
            'id_pend'    => $id_pend,
            'id_pelapak' => $pelapak->id,
            'id_produk'  => null,
            'jenis'      => 'profil_ubah',
            'data_lama'  => $data_lama,
            'data_baru'  => $update,
        ]);

        redirect_with(
            'success',
            'Pengajuan perubahan profil lapak berhasil dikirim. Perubahan akan tampil setelah disetujui admin desa.',
            $this->controller
        );
    }

    private function pelapak_warga($id_pend)
    {
        return $this->db
            ->select('lp.*, p.nama, p.nik')
            ->from('pelapak lp')
            ->join('penduduk_hidup p', 'p.id = lp.id_pend', 'left')
            ->where('lp.id_pend', (int) $id_pend)
            ->get()
            ->row();
    }

    private function produk_milik_pelapak($id_produk, $id_pelapak)
    {
        return $this->db
            ->where('id', (int) $id_produk)
            ->where('id_pelapak', (int) $id_pelapak)
            ->get('produk')
            ->row();
    }

    private function data_produk_pengajuan($pelapak, $produk = null)
    {
        $nama = trim((string) $this->input->post('nama', true));
        $id_produk_kategori = (int) $this->input->post('id_produk_kategori', true);
        $harga = preg_replace('/[^0-9]/', '', (string) $this->input->post('harga', true));
        $satuan = trim((string) $this->input->post('satuan', true));
        $tipe_potongan = (int) $this->input->post('tipe_potongan', true);

        if ($nama === '') {
            redirect_with('error', 'Nama produk/menu wajib diisi.', $this->controller);
        }

        if ($id_produk_kategori <= 0) {
            redirect_with('error', 'Kategori produk/menu wajib dipilih.', $this->controller);
        }

        if ($harga === '') {
            redirect_with('error', 'Harga produk/menu wajib diisi.', $this->controller);
        }

        if ($satuan === '') {
            redirect_with('error', 'Satuan produk/menu wajib dipilih.', $this->controller);
        }

        if (! in_array($tipe_potongan, [1, 2], true)) {
            $tipe_potongan = 1;
        }

        $potongan_input = $tipe_potongan === 2
            ? $this->input->post('nominal', true)
            : $this->input->post('persen', true);

        $potongan = preg_replace('/[^0-9]/', '', (string) $potongan_input);

        return [
            'id_pelapak'          => (int) $pelapak->id,
            'id_produk_kategori'  => $id_produk_kategori,
            'nama'                => $nama,
            'harga'               => (int) $harga,
            'satuan'              => $satuan,
            'tipe_potongan'       => $tipe_potongan,
            'potongan'            => (int) ($potongan ?: 0),
            'deskripsi'           => $this->security->xss_clean((string) $this->input->post('deskripsi', true)),
            'status'              => ! empty($produk) ? (int) $produk->status : 1,
        ];
    }

    private function pengajuan_perbaikan($jenis, $id_pelapak, $id_produk = null)
    {
        $this->db
            ->from('pengajuan_lapak')
            ->where('jenis', $jenis)
            ->where('id_pelapak', (int) $id_pelapak)
            ->where('status', 3);

        if ($id_produk === null) {
            $this->db->where('id_produk IS NULL', null, false);
        } else {
            $this->db->where('id_produk', (int) $id_produk);
        }

        return $this->db
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get()
            ->row();
    }

    private function update_pengajuan_perbaikan($id_pengajuan, $id_pend, $id_pelapak, $id_produk, $jenis, array $data_lama, array $data_baru, array $foto_upload = [])
    {
        $this->db
            ->where('id', (int) $id_pengajuan)
            ->update('pengajuan_lapak', [
                'id_pend'       => (int) $id_pend,
                'id_pelapak'    => (int) $id_pelapak,
                'id_produk'     => ! empty($id_produk) ? (int) $id_produk : null,
                'jenis'         => $jenis,
                'data_lama'     => ! empty($data_lama) ? json_encode($data_lama) : null,
                'data_baru'     => ! empty($data_baru) ? json_encode($data_baru) : null,
                'status'        => 0,
                'catatan_admin' => null,
                'updated_at'    => date('Y-m-d H:i:s'),
                'diproses_at'   => null,
                'diproses_oleh' => null,
            ]);

        $this->db
            ->where('id_pengajuan', (int) $id_pengajuan)
            ->delete('pengajuan_lapak_file');

        foreach ($foto_upload as $file) {
            $this->pengajuan_lapak_model->tambah_file($id_pengajuan, $file, 'foto_produk');
        }
    }

    private function upload_media_lapak($field, $folder_name, $max_size = 5120)
    {
        if (empty($_FILES[$field]['name'])) {
            return null;
        }

        $folder_name = trim((string) $folder_name);

        if (! in_array($folder_name, ['logo', 'banner'], true)) {
            return null;
        }

        $folder = FCPATH . 'desa/upload/lapak/' . $folder_name . '/';

        if (! is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $config = [
            'upload_path'   => $folder,
            'allowed_types' => 'jpg|jpeg|png|webp',
            'encrypt_name'  => true,
            'max_size'      => (int) $max_size,
        ];

        $this->upload->initialize($config);

        if (! $this->upload->do_upload($field)) {
            redirect_with(
                'error',
                strip_tags($this->upload->display_errors()),
                $this->controller . '/profil'
            );

            return null;
        }

        $uploaded = $this->upload->data();

        return $uploaded['file_name'] ?? null;
    }

    private function upload_foto_pengajuan($field)
    {
        if (empty($_FILES[$field]['name'])) {
            return null;
        }

        $folder = FCPATH . 'desa/upload/lapak/pengajuan/';

        if (! is_dir($folder)) {
            mkdir($folder, 0755, true);
        }

        $config = [
            'upload_path'   => $folder,
            'allowed_types' => 'jpg|jpeg|png|webp',
            'encrypt_name'  => true,
            'max_size'      => 20480,
        ];

        $this->upload->initialize($config);

        if (! $this->upload->do_upload($field)) {
            redirect_with(
                'error',
                strip_tags($this->upload->display_errors()),
                $this->controller
            );

            return null;
        }

        $uploaded = $this->upload->data();

        return $uploaded['file_name'] ?? null;
    }
}