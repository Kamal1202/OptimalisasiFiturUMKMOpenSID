<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Lengkapi_data extends Mandiri_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model(['penduduk_model', 'lengkapi_data_model']);
        $this->controller = 'layanan-mandiri/lengkapi-data';
    }

    public function index()
    {
        $penduduk     = $this->penduduk_model->get_penduduk($this->is_login->id_pend);
        $penduduk_raw = $this->db->get_where('tweb_penduduk', ['id' => $this->is_login->id_pend])->row_array();

        foreach ([
            'tanggallahir',
            'tanggal_akhir_paspor',
            'tanggalperkawinan',
            'tanggalperceraian',
        ] as $field_tanggal) {
            if (($penduduk_raw[$field_tanggal] ?? '') === '0000-00-00') {
                $penduduk_raw[$field_tanggal] = '';
            }
        }

        $kelengkapan = $this->lengkapi_data_model->cek_kelengkapan($this->is_login->id_pend);

        $data = [
            'penduduk'            => $penduduk,
            'penduduk_raw'        => $penduduk_raw,
            'field_wajib'         => $this->lengkapi_data_model->field_wajib(),
            'data_kosong'         => $kelengkapan['data_kosong'],
            'form_action'         => site_url('layanan-mandiri/lengkapi-data/simpan'),

            'pengajuan_aktif'     => $this->lengkapi_data_model->pengajuan_aktif($this->is_login->id_pend),
            'pengajuan_terakhir'  => $this->lengkapi_data_model->pengajuan_terakhir($this->is_login->id_pend),

            'list_agama'          => $this->list_ref('tweb_penduduk_agama'),
            'list_pendidikan_kk'  => $this->list_ref('tweb_penduduk_pendidikan_kk'),
            'list_pendidikan'     => $this->list_ref('tweb_penduduk_pendidikan'),
            'list_pekerjaan'      => $this->list_ref('tweb_penduduk_pekerjaan'),
            'list_kawin'          => $this->list_ref('tweb_penduduk_kawin'),
            'list_golongan_darah' => $this->list_ref('tweb_golongan_darah'),
            'list_asuransi'       => $this->list_ref('tweb_penduduk_asuransi'),
            'list_sex'            => $this->list_ref('tweb_penduduk_sex'),
            'list_warganegara'    => $this->list_ref('tweb_penduduk_warganegara'),
            'list_hubungan'       => $this->list_ref('tweb_penduduk_hubungan'),
            'list_status'         => $this->list_ref('tweb_penduduk_status'),

            'list_tempat_lahir'   => $this->list_ref('tweb_penduduk_tempat_dilahirkan'),
            'list_jenis_lahir'    => $this->list_ref('tweb_penduduk_jenis_kelahiran'),
            'list_penolong_lahir' => $this->list_ref('tweb_penduduk_penolong_kelahiran'),
            'list_cacat'          => $this->list_ref('tweb_penduduk_cacat'),
            'list_sakit_menahun'  => $this->list_ref('tweb_penduduk_sakit_menahun'),
            'list_cara_kb'        => $this->list_ref('tweb_penduduk_cara_kb'),
            'list_hamil'          => $this->list_ref('ref_penduduk_hamil'),

            'list_wilayah'        => $this->db
                ->select('id, dusun, rw, rt')
                ->where_not_in('rt', ['0', '-'])
                ->order_by('dusun')
                ->order_by('rw')
                ->order_by('rt')
                ->get('tweb_wil_clusterdesa')
                ->result(),
        ];

        $this->render('lengkapi_data', $data);
    }

    public function simpan()
    {
        $post = $this->input->post(null, true);

        $data_baru = [
            // Identitas penduduk
            'nik'                       => $this->angka($post['nik'] ?? '', 16),
            'no_kk'                     => $this->angka($post['no_kk'] ?? '', 16),
            'nama'                      => $this->teks_besar($post['nama'] ?? ''),
            'kk_level'                  => $this->teks_besar($post['kk_level'] ?? ''),
            'sex'                       => $this->teks_besar($post['sex'] ?? ''),
            'agama_id'                  => $this->teks_besar($post['agama_id'] ?? ''),
            'status'                    => $this->teks_besar($post['status'] ?? ''),

            // Data KTP
            'wajib_ktp'                 => $this->teks_besar($post['wajib_ktp'] ?? ''),
            'ktp_el'                    => $this->teks_besar($post['ktp_el'] ?? ''),
            'status_rekam'              => $this->teks_besar($post['status_rekam'] ?? ''),
            'tag_id_card'               => $this->teks_besar($post['tag_id_card'] ?? ''),

            // Data kelahiran
            'akta_lahir'                => $this->teks_besar($post['akta_lahir'] ?? ''),
            'tempatlahir'               => $this->teks_besar($post['tempatlahir'] ?? ''),
            'tanggallahir'              => $this->tanggal($post['tanggallahir'] ?? ''),
            'tempat_dilahirkan_id'      => $this->teks_besar($post['tempat_dilahirkan_id'] ?? ''),
            'jenis_kelahiran_id'        => $this->teks_besar($post['jenis_kelahiran_id'] ?? ''),
            'kelahiran_anak_ke'         => $this->angka($post['kelahiran_anak_ke'] ?? '', 2),
            'penolong_kelahiran_id'     => $this->teks_besar($post['penolong_kelahiran_id'] ?? ''),
            'berat_lahir'               => $this->angka($post['berat_lahir'] ?? '', 5),
            'panjang_lahir'             => $this->angka($post['panjang_lahir'] ?? '', 3),

            // Pendidikan dan pekerjaan
            'pendidikan_kk_id'          => $this->teks_besar($post['pendidikan_kk_id'] ?? ''),
            'pendidikan_sedang_id'      => $this->teks_besar($post['pendidikan_sedang_id'] ?? ''),
            'pekerjaan_id'              => $this->teks_besar($post['pekerjaan_id'] ?? ''),

            // Kewarganegaraan
            'warganegara_id'            => $this->teks_besar($post['warganegara_id'] ?? ''),
            'dokumen_pasport'           => $this->teks_besar($post['dokumen_pasport'] ?? ''),
            'tanggal_akhir_paspor'      => $this->tanggal($post['tanggal_akhir_paspor'] ?? ''),
            'dokumen_kitas'             => $this->teks_besar($post['dokumen_kitas'] ?? ''),

            // Orang tua
            'ayah_nik'                  => $this->angka($post['ayah_nik'] ?? '', 16),
            'nama_ayah'                 => $this->teks_besar($post['nama_ayah'] ?? ''),
            'ibu_nik'                   => $this->angka($post['ibu_nik'] ?? '', 16),
            'nama_ibu'                  => $this->teks_besar($post['nama_ibu'] ?? ''),

            // Kontak
            'telepon'                   => $this->angka($post['telepon'] ?? '', 15),
            'email'                     => $this->email($post['email'] ?? ''),
            'telegram'                  => $this->teks_besar($post['telegram'] ?? ''),

            // Alamat
            'alamat'                    => $this->teks_besar($post['alamat'] ?? ''),
            'id_cluster'                => $this->teks_besar($post['id_cluster'] ?? ''),
            'alamat_sebelumnya'         => $this->teks_besar($post['alamat_sebelumnya'] ?? ''),

            // Perkawinan
            'status_kawin'              => $this->teks_besar($post['status_kawin'] ?? ''),
            'akta_perkawinan'           => $this->teks_besar($post['akta_perkawinan'] ?? ''),
            'tanggalperkawinan'         => $this->tanggal($post['tanggalperkawinan'] ?? ''),
            'akta_perceraian'           => $this->teks_besar($post['akta_perceraian'] ?? ''),
            'tanggalperceraian'         => $this->tanggal($post['tanggalperceraian'] ?? ''),

            // Kesehatan dan asuransi
            'golongan_darah_id'         => $this->teks_besar($post['golongan_darah_id'] ?? ''),
            'cacat_id'                  => $this->teks_besar($post['cacat_id'] ?? ''),
            'sakit_menahun_id'          => $this->teks_besar($post['sakit_menahun_id'] ?? ''),
            'cara_kb_id'                => $this->teks_besar($post['cara_kb_id'] ?? ''),
            'hamil'                     => $this->teks_besar($post['hamil'] ?? ''),
            'id_asuransi'               => $this->teks_besar($post['id_asuransi'] ?? ''),
            'no_asuransi'               => $this->teks_besar($post['no_asuransi'] ?? ''),
        ];

        $catatan = trim((string) ($post['catatan'] ?? ''));

        if ($this->lengkapi_data_model->simpan($this->is_login->id_pend, $data_baru, $catatan)) {
            redirect_with('success', 'Pengajuan pelengkapan data berhasil dikirim. Menunggu verifikasi admin.', $this->controller);
        }

        $pesan = $this->lengkapi_data_model->error_msg ?: 'Pengajuan pelengkapan data gagal dikirim.';
        redirect_with('error', $pesan, $this->controller);
    }

    private function list_ref($table)
    {
        if (! $this->db->table_exists($table)) {
            return [];
        }

        return $this->db->order_by('id')->get($table)->result();
    }

    private function angka($nilai, $maksimal = null)
    {
        $nilai = preg_replace('/[^0-9]/', '', (string) $nilai);

        if ($maksimal) {
            $nilai = substr($nilai, 0, $maksimal);
        }

        return $nilai;
    }

    private function teks_besar($nilai)
    {
        return strtoupper(trim((string) $nilai));
    }

    private function email($nilai)
    {
        return strtolower(trim((string) $nilai));
    }

    private function tanggal($nilai)
    {
        $nilai = trim((string) $nilai);

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $nilai)) {
            return $nilai;
        }

        return '';
    }
}