<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Pengajuan_perubahan_data extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('lengkapi_data_model');
        $this->controller = 'pengajuan-perubahan-data';
    }

    public function index()
    {
        $status = $this->input->get('status', true);

        $this->db
            ->select('pp.*, p.nama, p.nik AS nik_penduduk')
            ->from('pengajuan_perubahan_data_penduduk pp')
            ->join('tweb_penduduk p', 'p.id = pp.id_pend', 'left');

        if ($status !== null && $status !== '') {
            $this->db->where('pp.status', (int) $status);
        }

        $data = [
            'controller'      => $this->controller,
            'selected_status' => $status,
            'list_status'     => $this->list_status(),
            'main'            => $this->db
                ->order_by('pp.created_at', 'DESC')
                ->get()
                ->result(),
        ];

        $this->render('pengajuan_perubahan_data/index', $data);
    }

    public function detail($id = 0)
    {
        $pengajuan = $this->get_pengajuan($id);

        if (! $id || ! $pengajuan) {
            show_404();
        }

        $data_lama = $this->decode_json($pengajuan->data_lama);
        $data_baru = $this->decode_json($pengajuan->data_baru);

        $data = [
            'controller'       => $this->controller,
            'main'             => $pengajuan,
            'data_lama'        => $data_lama,
            'data_baru'        => $data_baru,
            'baris_perubahan'  => $this->baris_perubahan($data_lama, $data_baru),
            'label_status'     => $this->label_status($pengajuan->status),
            'badge_status'     => $this->badge_status($pengajuan->status),
        ];

        $this->render('pengajuan_perubahan_data/detail', $data);
    }

    public function ubah_status($id = 0, $status = 0)
    {
        $status = (int) $status;

        if (! in_array($status, [1, 2, 3], true)) {
            show_404();
        }

        $pengajuan = $this->get_pengajuan($id);

        if (! $id || ! $pengajuan) {
            show_404();
        }

        $catatan_admin = trim((string) $this->input->post('catatan_admin', true));
        $verified_by   = $this->id_user_admin();

        if ($status === 1) {
            $hasil = $this->lengkapi_data_model->setujui_dan_terapkan($id, $catatan_admin, $verified_by);

            if ($hasil !== false) {
                $pesan = 'Pengajuan disetujui dan data penduduk berhasil diperbarui.';

                if (! empty($hasil['dilewati'])) {
                    $pesan .= ' Field dilewati otomatis: ' . implode(', ', $hasil['dilewati']) . '.';
                }

                redirect_with('success', $pesan, "{$this->controller}/detail/{$id}");
            }

            $pesan = $this->lengkapi_data_model->error_msg ?: 'Gagal menyetujui dan menerapkan pengajuan.';
            redirect_with('error', $pesan, "{$this->controller}/detail/{$id}");
        }

        if ($this->lengkapi_data_model->ubah_status_pengajuan($id, $status, $catatan_admin, $verified_by)) {
            redirect_with('success', 'Status pengajuan berhasil diperbarui.', "{$this->controller}/detail/{$id}");
        }

        $pesan = $this->lengkapi_data_model->error_msg ?: 'Status pengajuan gagal diperbarui.';
        redirect_with('error', $pesan, "{$this->controller}/detail/{$id}");
    }

    private function get_pengajuan($id)
    {
        return $this->db
            ->select('pp.*, p.nama, p.nik AS nik_penduduk')
            ->from('pengajuan_perubahan_data_penduduk pp')
            ->join('tweb_penduduk p', 'p.id = pp.id_pend', 'left')
            ->where('pp.id', (int) $id)
            ->get()
            ->row();
    }

    private function decode_json($json)
    {
        $data = json_decode((string) $json, true);

        return is_array($data) ? $data : [];
    }

    private function baris_perubahan(array $data_lama, array $data_baru)
    {
        $rows = [];

        foreach ($data_baru as $field => $nilai_baru) {
            $nilai_lama = $data_lama[$field] ?? '';

            $rows[] = [
                'field'       => $field,
                'label'       => $this->label_field($field),
                'lama_raw'    => $nilai_lama,
                'baru_raw'    => $nilai_baru,
                'lama_tampil' => $this->nilai_tampil($field, $nilai_lama),
                'baru_tampil' => $this->nilai_tampil($field, $nilai_baru),
            ];
        }

        return $rows;
    }

    private function label_field($field)
    {
        $labels = [
            'nik'                   => 'NIK',
            'no_kk'                 => 'Nomor KK',
            'nama'                  => 'Nama Lengkap',
            'kk_level'              => 'Hubungan dalam Keluarga',
            'sex'                   => 'Jenis Kelamin',
            'agama_id'              => 'Agama',
            'status'                => 'Status Penduduk',
            'wajib_ktp'             => 'Wajib KTP',
            'ktp_el'                => 'KTP-EL',
            'status_rekam'          => 'Status Rekam',
            'tag_id_card'           => 'Tag ID Card',
            'akta_lahir'            => 'Nomor Akta Lahir',
            'tempatlahir'           => 'Tempat Lahir',
            'tanggallahir'          => 'Tanggal Lahir',
            'tempat_dilahirkan_id'  => 'Tempat Dilahirkan',
            'jenis_kelahiran_id'    => 'Jenis Kelahiran',
            'kelahiran_anak_ke'     => 'Kelahiran Anak Ke',
            'penolong_kelahiran_id' => 'Penolong Kelahiran',
            'berat_lahir'           => 'Berat Lahir',
            'panjang_lahir'         => 'Panjang Lahir',
            'pendidikan_kk_id'      => 'Pendidikan dalam KK',
            'pendidikan_sedang_id'  => 'Pendidikan Sedang Ditempuh',
            'pekerjaan_id'          => 'Pekerjaan',
            'warganegara_id'        => 'Warga Negara',
            'dokumen_pasport'       => 'Nomor Paspor',
            'tanggal_akhir_paspor'  => 'Tanggal Akhir Paspor',
            'dokumen_kitas'         => 'Nomor KITAS',
            'ayah_nik'              => 'NIK Ayah',
            'nama_ayah'             => 'Nama Ayah',
            'ibu_nik'               => 'NIK Ibu',
            'nama_ibu'              => 'Nama Ibu',
            'telepon'               => 'Nomor HP',
            'email'                 => 'Email',
            'telegram'              => 'Telegram',
            'alamat'                => 'Alamat',
            'id_cluster'            => 'Dusun / RW / RT',
            'alamat_sebelumnya'     => 'Alamat Sebelumnya',
            'status_kawin'          => 'Status Perkawinan',
            'akta_perkawinan'       => 'Nomor Akta Perkawinan',
            'tanggalperkawinan'     => 'Tanggal Perkawinan',
            'akta_perceraian'       => 'Nomor Akta Perceraian',
            'tanggalperceraian'     => 'Tanggal Perceraian',
            'golongan_darah_id'     => 'Golongan Darah',
            'cacat_id'              => 'Disabilitas',
            'sakit_menahun_id'      => 'Sakit Menahun',
            'cara_kb_id'            => 'Cara KB',
            'hamil'                 => 'Status Kehamilan',
            'id_asuransi'           => 'Jenis Asuransi',
            'no_asuransi'           => 'Nomor Asuransi',
        ];

        return $labels[$field] ?? $field;
    }

    private function nilai_tampil($field, $nilai)
    {
        $nilai = trim((string) $nilai);

        if ($nilai === '') {
            return '-';
        }

        if ($field === 'id_cluster') {
            return $this->label_wilayah($nilai);
        }

        if ($field === 'hamil') {
            return $this->label_hamil($nilai);
        }

        $ref = $this->referensi_field($field);

        if ($ref) {
            return $this->label_referensi($nilai, $ref['table'], $ref['label']);
        }

        return $nilai;
    }

    private function referensi_field($field)
    {
        $map = [
            'kk_level'              => ['table' => 'tweb_penduduk_hubungan', 'label' => 'nama'],
            'sex'                   => ['table' => 'tweb_penduduk_sex', 'label' => 'nama'],
            'agama_id'              => ['table' => 'tweb_penduduk_agama', 'label' => 'nama'],
            'status'                => ['table' => 'tweb_penduduk_status', 'label' => 'nama'],
            'tempat_dilahirkan_id'  => ['table' => 'tweb_penduduk_tempat_dilahirkan', 'label' => 'nama'],
            'jenis_kelahiran_id'    => ['table' => 'tweb_penduduk_jenis_kelahiran', 'label' => 'nama'],
            'penolong_kelahiran_id' => ['table' => 'tweb_penduduk_penolong_kelahiran', 'label' => 'nama'],
            'pendidikan_kk_id'      => ['table' => 'tweb_penduduk_pendidikan_kk', 'label' => 'nama'],
            'pendidikan_sedang_id'  => ['table' => 'tweb_penduduk_pendidikan', 'label' => 'nama'],
            'pekerjaan_id'          => ['table' => 'tweb_penduduk_pekerjaan', 'label' => 'nama'],
            'warganegara_id'        => ['table' => 'tweb_penduduk_warganegara', 'label' => 'nama'],
            'status_kawin'          => ['table' => 'tweb_penduduk_kawin', 'label' => 'nama'],
            'golongan_darah_id'     => ['table' => 'tweb_golongan_darah', 'label' => 'nama'],
            'cacat_id'              => ['table' => 'tweb_penduduk_cacat', 'label' => 'nama'],
            'sakit_menahun_id'      => ['table' => 'tweb_penduduk_sakit_menahun', 'label' => 'nama'],
            'cara_kb_id'            => ['table' => 'tweb_penduduk_cara_kb', 'label' => 'nama'],
            'id_asuransi'           => ['table' => 'tweb_penduduk_asuransi', 'label' => 'nama'],
        ];

        return $map[$field] ?? null;
    }

    private function label_referensi($id, $table, $label_column = 'nama')
    {
        $id = trim((string) $id);

        if ($id === '') {
            return '-';
        }

        if (! ctype_digit($id)) {
            return $id;
        }

        if (! $this->db->table_exists($table)) {
            return $id;
        }

        if (! $this->db->field_exists($label_column, $table)) {
            return $id;
        }

        $row = $this->db
            ->select("id, {$label_column}")
            ->where('id', (int) $id)
            ->get($table)
            ->row();

        if (! $row) {
            return $id;
        }

        return $id . ' - ' . $row->{$label_column};
    }

    private function label_wilayah($id_cluster)
    {
        $id_cluster = trim((string) $id_cluster);

        if ($id_cluster === '') {
            return '-';
        }

        if (! ctype_digit($id_cluster)) {
            return $id_cluster;
        }

        if (! $this->db->table_exists('tweb_wil_clusterdesa')) {
            return $id_cluster;
        }

        $row = $this->db
            ->select('id, dusun, rw, rt')
            ->where('id', (int) $id_cluster)
            ->get('tweb_wil_clusterdesa')
            ->row();

        if (! $row) {
            return $id_cluster;
        }

        $label = trim((string) $row->dusun);

        if ((string) $row->rw !== '' && (string) $row->rw !== '-') {
            $label .= ' - RW ' . $row->rw;
        }

        if ((string) $row->rt !== '' && (string) $row->rt !== '-') {
            $label .= ' / RT ' . $row->rt;
        }

        return $id_cluster . ' - ' . $label;
    }

    private function label_hamil($nilai)
    {
        $nilai = trim((string) $nilai);

        if ($nilai === '') {
            return '-';
        }

        $label = [
            '1' => 'HAMIL',
            '2' => 'TIDAK HAMIL',
        ];

        return isset($label[$nilai]) ? $nilai . ' - ' . $label[$nilai] : $nilai;
    }

    private function list_status()
    {
        return [
            0 => 'Menunggu Verifikasi',
            1 => 'Disetujui',
            2 => 'Ditolak',
            3 => 'Butuh Perbaikan',
        ];
    }

    private function label_status($status)
    {
        $list = $this->list_status();

        return $list[(int) $status] ?? 'Tidak Diketahui';
    }

    private function badge_status($status)
    {
        $status = (int) $status;

        if ($status === 1) {
            return 'success';
        }

        if ($status === 2) {
            return 'danger';
        }

        if ($status === 3) {
            return 'warning';
        }

        return 'info';
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