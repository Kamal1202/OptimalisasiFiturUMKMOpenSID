<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Lengkapi_data_model extends CI_Model
{
    private $table = 'pengajuan_perubahan_data_penduduk';

    public $error_msg = '';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('penduduk_model');
    }

    public function field_wajib()
    {
        return [
            'nik'                    => 'NIK',
            'nama'                   => 'Nama Lengkap',
            'no_kk'                  => 'Nomor KK',
            'hubungan'               => 'Hubungan Dalam Keluarga',
            'sex'                    => 'Jenis Kelamin',
            'agama'                  => 'Agama',
            'status'                 => 'Status Penduduk',
            'wajib_ktp'              => 'Wajib KTP',
            'ktp_el'                 => 'KTP-EL',
            'status_rekam'           => 'Status Rekam',
            'tag_id_card'            => 'Tag ID Card',
            'akta_lahir'             => 'Nomor Akta Lahir',
            'tempatlahir'            => 'Tempat Lahir',
            'tanggallahir'           => 'Tanggal Lahir',
            'tempat_dilahirkan_nama' => 'Tempat Dilahirkan',
            'jenis_kelahiran_nama'   => 'Jenis Kelahiran',
            'kelahiran_anak_ke'      => 'Kelahiran Anak Ke',
            'penolong_kelahiran_nama'=> 'Penolong Kelahiran',
            'berat_lahir'            => 'Berat Lahir',
            'panjang_lahir'          => 'Panjang Lahir',
            'pendidikan_kk'          => 'Pendidikan Dalam KK',
            'pendidikan_sedang'      => 'Pendidikan Sedang Ditempuh',
            'pekerjaan'              => 'Pekerjaan',
            'warganegara'            => 'Warga Negara',
            'dokumen_pasport'        => 'Nomor Paspor',
            'tanggal_akhir_paspor'   => 'Tanggal Akhir Paspor',
            'dokumen_kitas'          => 'Nomor KITAS',
            'ayah_nik'               => 'NIK Ayah',
            'nama_ayah'              => 'Nama Ayah',
            'ibu_nik'                => 'NIK Ibu',
            'nama_ibu'               => 'Nama Ibu',
            'telepon'                => 'Nomor HP',
            'email'                  => 'Email',
            'telegram'               => 'Telegram',
            'alamat'                 => 'Alamat',
            'dusun'                  => 'Dusun',
            'rt'                     => 'RT',
            'rw'                     => 'RW',
            'alamat_sebelumnya'      => 'Alamat Sebelumnya',
            'kawin'                  => 'Status Perkawinan',
            'akta_perkawinan'        => 'Nomor Akta Perkawinan',
            'tanggalperkawinan'      => 'Tanggal Perkawinan',
            'akta_perceraian'        => 'Nomor Akta Perceraian',
            'tanggalperceraian'      => 'Tanggal Perceraian',
            'golongan_darah'         => 'Golongan Darah',
            'cacat'                  => 'Disabilitas',
            'sakit_menahun'          => 'Sakit Menahun',
            'cara_kb'                => 'Cara KB',
            'hamil'                  => 'Status Kehamilan',
            'asuransi'               => 'Asuransi',
            'no_asuransi'            => 'Nomor Asuransi',
        ];
    }

    public function cek_kelengkapan($id_pend)
    {
        $penduduk = $this->penduduk_model->get_penduduk($id_pend);

        $field_wajib = $this->field_wajib();
        $data_kosong = [];

        foreach ($field_wajib as $field => $label) {
            $nilai = trim((string) ($penduduk[$field] ?? ''));

            if (
                $nilai === '' ||
                $nilai === '-' ||
                strtoupper($nilai) === 'BELUM MENGISI' ||
                strtoupper($nilai) === 'TIDAK DIKETAHUI' ||
                strtoupper($nilai) === 'NULL'
            ) {
                $data_kosong[$field] = $label;
            }
        }

        $total_field  = count($field_wajib);
        $total_kosong = count($data_kosong);
        $total_isi    = $total_field - $total_kosong;
        $persen       = $total_field > 0 ? round(($total_isi / $total_field) * 100) : 0;

        return [
            'lengkap'      => $total_kosong === 0,
            'persen'       => $persen,
            'total_field'  => $total_field,
            'total_isi'    => $total_isi,
            'total_kosong' => $total_kosong,
            'data_kosong'  => $data_kosong,
        ];
    }

    public function pengajuan_aktif($id_pend)
    {
        return $this->db
            ->where('id_pend', $id_pend)
            ->where('status', 0)
            ->order_by('id', 'DESC')
            ->get($this->table)
            ->row();
    }

    public function pengajuan_terakhir($id_pend)
    {
        return $this->db
            ->where('id_pend', $id_pend)
            ->order_by('id', 'DESC')
            ->get($this->table)
            ->row();
    }

    public function pengajuan_perbaikan($id_pend)
    {
        return $this->db
            ->where('id_pend', (int) $id_pend)
            ->where('status', 3)
            ->order_by('id', 'DESC')
            ->get($this->table)
            ->row();
    }

    public function label_status($status)
    {
        $status = (int) $status;

        $label = [
            0 => 'Menunggu Verifikasi Admin',
            1 => 'Disetujui',
            2 => 'Ditolak',
            3 => 'Butuh Perbaikan',
        ];

        return $label[$status] ?? 'Tidak Diketahui';
    }

    public function simpan($id_pend, array $data_baru, $catatan = '')
    {
        $penduduk_raw = $this->db
            ->get_where('tweb_penduduk', ['id' => $id_pend])
            ->row_array();

        if (! $penduduk_raw) {
            $this->error_msg = 'Data penduduk tidak ditemukan.';
            return false;
        }

        if ($this->pengajuan_aktif($id_pend)) {
            $this->error_msg = 'Masih ada pengajuan yang sedang menunggu verifikasi.';
            return false;
        }

        $penduduk_tampil = $this->penduduk_model->get_penduduk($id_pend);

        $data_lama = [];
        $perubahan = [];

        foreach ($data_baru as $field => $nilai_baru) {
            $field_lama = $this->field_lama($field);

            if ($field === 'no_kk') {
                $nilai_lama = $penduduk_tampil['no_kk'] ?? '';
            } elseif (array_key_exists($field_lama, $penduduk_raw)) {
                $nilai_lama = $penduduk_raw[$field_lama];
            } elseif (array_key_exists($field, $penduduk_tampil)) {
                $nilai_lama = $penduduk_tampil[$field];
            } else {
                $nilai_lama = '';
            }

            $nilai_lama = trim((string) $nilai_lama);
            $nilai_baru = trim((string) $nilai_baru);

            if ($nilai_lama !== $nilai_baru) {
                $data_lama[$field] = $nilai_lama;
                $perubahan[$field] = $nilai_baru;
            }
        }

        if (empty($perubahan) && trim($catatan) === '') {
            $this->error_msg = 'Tidak ada perubahan data yang diajukan.';
            return false;
        }

        $pengajuan_perbaikan = $this->pengajuan_perbaikan($id_pend);

        if ($pengajuan_perbaikan) {

            $update = [
                'data_lama'    => json_encode($data_lama, JSON_UNESCAPED_UNICODE),
                'data_baru'    => json_encode($perubahan, JSON_UNESCAPED_UNICODE),
                'status'       => 0,
                'catatan_admin'=> null,
                'updated_at'   => date('Y-m-d H:i:s'),
                'verified_at'  => null,
            ];

            if ($this->db->field_exists('verified_by', $this->table)) {
                $update['verified_by'] = null;
            }

            return $this->db
                ->where('id', (int) $pengajuan_perbaikan->id)
                ->update($this->table, $update);
        }

        $waktu = date('Y-m-d H:i:s');

        $insert = [
            'id_pend'    => $id_pend,
            'data_lama'  => json_encode($data_lama, JSON_UNESCAPED_UNICODE),
            'data_baru'  => json_encode($perubahan, JSON_UNESCAPED_UNICODE),
            'status'     => 0,
            'created_at' => $waktu,
            'updated_at' => $waktu,
        ];

        if ($this->db->field_exists('nik', $this->table)) {
            $insert['nik'] = $penduduk_raw['nik'] ?? null;
        }

        if ($this->db->field_exists('catatan', $this->table)) {
            $insert['catatan'] = trim($catatan);
        }

        if ($this->db->field_exists('catatan_warga', $this->table)) {
            $insert['catatan_warga'] = trim($catatan);
        }

        return $this->db->insert($this->table, $insert);
    }

    public function setujui_dan_terapkan($id, $catatan_admin = '', $verified_by = null)
    {
        $pengajuan = $this->db
            ->where('id', (int) $id)
            ->get($this->table)
            ->row();

        if (! $pengajuan) {
            $this->error_msg = 'Pengajuan tidak ditemukan.';
            return false;
        }

        if (! in_array((int) $pengajuan->status, [0, 3], true)) {
            $this->error_msg = 'Pengajuan ini sudah diproses.';
            return false;
        }

        $data_baru = json_decode((string) $pengajuan->data_baru, true);

        if (! is_array($data_baru) || empty($data_baru)) {
            $this->error_msg = 'Tidak ada data perubahan yang bisa diterapkan.';
            return false;
        }

        $update_penduduk = [];
        $dilewati        = [];

        foreach ($data_baru as $field => $nilai) {
            $target = $this->target_update_field($field);

            if (! $target) {
                $dilewati[] = $field;
                continue;
            }

            if (! $this->db->field_exists($target, 'tweb_penduduk')) {
                $dilewati[] = $field;
                continue;
            }

            $nilai_normal = $this->normalisasi_nilai_update($target, $nilai);

            if ($nilai_normal === '__SKIP__') {
                $dilewati[] = $field;
                continue;
            }

            $update_penduduk[$target] = $nilai_normal;
        }

        if (empty($update_penduduk)) {
            $this->error_msg = 'Tidak ada field yang dapat diterapkan otomatis ke data penduduk.';
            return false;
        }

        $waktu = date('Y-m-d H:i:s');

        $this->db->trans_begin();

        $this->db
            ->where('id', (int) $pengajuan->id_pend)
            ->update('tweb_penduduk', $update_penduduk);

        $update_pengajuan = [
            'status'        => 1,
            'catatan_admin' => trim($catatan_admin),
            'updated_at'    => $waktu,
            'verified_at'   => $waktu,
        ];

        if ($this->db->field_exists('verified_by', $this->table)) {
            $update_pengajuan['verified_by'] = $verified_by;
        }

        $this->db
            ->where('id', (int) $id)
            ->update($this->table, $update_pengajuan);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            $this->error_msg = 'Gagal menerapkan pengajuan ke data penduduk.';
            return false;
        }

        $this->db->trans_commit();

        return [
            'diterapkan' => array_keys($update_penduduk),
            'dilewati'   => $dilewati,
        ];
    }

    public function ubah_status_pengajuan($id, $status, $catatan_admin = '', $verified_by = null)
    {
        $pengajuan = $this->db
            ->where('id', (int) $id)
            ->get($this->table)
            ->row();

        if (! $pengajuan) {
            $this->error_msg = 'Pengajuan tidak ditemukan.';
            return false;
        }

        $waktu = date('Y-m-d H:i:s');

        $update = [
            'status'        => (int) $status,
            'catatan_admin' => trim($catatan_admin),
            'updated_at'    => $waktu,
            'verified_at'   => $waktu,
        ];

        if ($this->db->field_exists('verified_by', $this->table)) {
            $update['verified_by'] = $verified_by;
        }

        return $this->db
            ->where('id', (int) $id)
            ->update($this->table, $update);
    }

    private function target_update_field($field)
    {
        $map = [
            'alamat'    => 'alamat_sekarang',
            'no_kk'     => null,
            'wajib_ktp' => null,
        ];

        return array_key_exists($field, $map) ? $map[$field] : $field;
    }

    private function normalisasi_nilai_update($field, $nilai)
    {
        $nilai = trim((string) $nilai);

        $field_angka = [
            'kk_level',
            'sex',
            'agama_id',
            'status',
            'ktp_el',
            'status_rekam',
            'tempat_dilahirkan_id',
            'jenis_kelahiran_id',
            'kelahiran_anak_ke',
            'penolong_kelahiran_id',
            'berat_lahir',
            'panjang_lahir',
            'pendidikan_kk_id',
            'pendidikan_sedang_id',
            'pekerjaan_id',
            'warganegara_id',
            'id_cluster',
            'status_kawin',
            'golongan_darah_id',
            'cacat_id',
            'sakit_menahun_id',
            'cara_kb_id',
            'hamil',
            'id_asuransi',
        ];

        $field_tanggal = [
            'tanggallahir',
            'tanggal_akhir_paspor',
            'tanggalperkawinan',
            'tanggalperceraian',
        ];

        if (in_array($field, $field_angka, true)) {
            $angka = preg_replace('/[^0-9]/', '', $nilai);

            return $angka === '' ? '__SKIP__' : $angka;
        }

        if (in_array($field, $field_tanggal, true)) {
            if ($nilai === '') {
                return '__SKIP__';
            }

            return preg_match('/^\d{4}-\d{2}-\d{2}$/', $nilai) ? $nilai : '__SKIP__';
        }

        return $nilai;
    }

    private function field_lama($field)
    {
        $map = [
            'alamat' => 'alamat_sekarang',
        ];

        return $map[$field] ?? $field;
    }
}