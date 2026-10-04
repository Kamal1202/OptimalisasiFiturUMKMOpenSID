<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Perpustakaan_digital_admin extends Admin_Controller
{
    private $table = 'perpustakaan_digital_buku';
    private $pdf_path = 'desa/upload/perpustakaan/pdf/';
    private $sampul_path = 'desa/upload/perpustakaan/sampul/';

    public function __construct()
    {
        parent::__construct();

        $this->load->model('perpustakaan_digital_model');
        $this->load->library('upload');

        $this->controller = 'perpustakaan-digital-admin';

        $this->pastikan_folder_upload();
    }

    public function index()
    {
        $keyword = trim((string) $this->input->get('keyword', true));
        $status  = trim((string) $this->input->get('status', true));

        $this->db->from($this->table);

        if ($keyword !== '') {
            $this->db->group_start()
                ->like('judul', $keyword)
                ->or_like('deskripsi', $keyword)
                ->or_like('kategori', $keyword)
                ->or_like('penerbit', $keyword)
                ->or_like('penulis', $keyword)
                ->or_like('sumber', $keyword)
                ->group_end();
        }

        if ($status !== '') {
            $this->db->where('aktif', (int) $status);
        }

        $main = $this->db
            ->order_by('id', 'ASC')
            ->get()
            ->result();

        foreach ($main as $row) {
            $row->cover_url  = $this->perpustakaan_digital_model->cover_url($row);
            $row->detail_url = site_url('perpustakaan-digital/buku/' . $row->id);
            $row->baca_url   = site_url('perpustakaan-digital/baca/' . $row->id);
        }

        $data = [
            'controller' => $this->controller,
            'main'       => $main,
            'keyword'    => $keyword,
            'status'     => $status,
        ];

        $this->render('perpustakaan_digital_admin/index', $data);
    }

    public function form($id = 0)
    {
        $main = null;

        if ((int) $id > 0) {
            $main = $this->db
                ->where('id', (int) $id)
                ->get($this->table)
                ->row();

            if (empty($main)) {
                show_404();
            }
        }

        $data = [
            'controller'  => $this->controller,
            'main'        => $main,
            'aksi'        => empty($main) ? 'Tambah' : 'Ubah',
            'form_action' => empty($main)
                ? site_url($this->controller . '/simpan')
                : site_url($this->controller . '/update/' . (int) $main->id),
        ];

        $this->render('perpustakaan_digital_admin/form', $data);
    }

    public function simpan()
    {
        echo '<pre>';
        print_r($_FILES);
        die;

        $data = $this->data_validasi();

        $file_pdf = $this->upload_file('file_pdf_upload', $this->pdf_path, 'pdf');

        if (empty($file_pdf)) {
            redirect_with('error', 'File PDF wajib diupload.', $this->controller . '/tambah');
        }

        $data['file_pdf'] = $file_pdf;

        $sampul_manual = $this->upload_file('sampul_upload', $this->sampul_path, 'image');

        if (! empty($sampul_manual)) {
            $data['sampul'] = $sampul_manual;
        } else {
            $data['sampul'] = $this->simpan_cover_base64($this->input->post('cover_base64', false));
        }

        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->insert($this->table, $data);

        redirect_with('success', 'Buku berhasil ditambahkan.', $this->controller);
    }

    public function update($id = 0)
    {
        $main = $this->db
            ->where('id', (int) $id)
            ->get($this->table)
            ->row();

        if (empty($main)) {
            show_404();
        }

        $data = $this->data_validasi();

        $file_pdf_baru = $this->upload_file('file_pdf_upload', $this->pdf_path, 'pdf');

        if (! empty($file_pdf_baru)) {
            $this->hapus_file_lama($this->pdf_path, $main->file_pdf);
            $data['file_pdf'] = $file_pdf_baru;
        } else {
            $data['file_pdf'] = $main->file_pdf;
        }

        if (empty($data['file_pdf'])) {
            redirect_with('error', 'File PDF wajib tersedia.', $this->controller . '/ubah/' . (int) $id);
        }

        $sampul_manual = $this->upload_file('sampul_upload', $this->sampul_path, 'image');

        if (! empty($sampul_manual)) {
            $this->hapus_file_lama($this->sampul_path, $main->sampul);
            $data['sampul'] = $sampul_manual;
        } else {
            $cover_generate = $this->simpan_cover_base64($this->input->post('cover_base64', false));

            if (! empty($cover_generate)) {
                $this->hapus_file_lama($this->sampul_path, $main->sampul);
                $data['sampul'] = $cover_generate;
            } else {
                $data['sampul'] = $main->sampul;
            }
        }

        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db
            ->where('id', (int) $id)
            ->update($this->table, $data);

        redirect_with('success', 'Buku berhasil diperbarui.', $this->controller);
    }

    public function status($id = 0, $status = 0)
    {
        $status = (int) $status;

        if (! in_array($status, [0, 1], true)) {
            redirect_with('error', 'Status buku tidak valid.', $this->controller);
        }

        $main = $this->db
            ->where('id', (int) $id)
            ->get($this->table)
            ->row();

        if (empty($main)) {
            show_404();
        }

        $this->db
            ->where('id', (int) $id)
            ->update($this->table, [
                'aktif'      => $status,
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

        if ($status === 1) {
            redirect_with('success', 'Buku berhasil diaktifkan.', $this->controller);
        }

        redirect_with('success', 'Buku berhasil dinonaktifkan.', $this->controller);
    }

    public function hapus($id = 0)
    {
        $main = $this->db
            ->where('id', (int) $id)
            ->get($this->table)
            ->row();

        if (empty($main)) {
            show_404();
        }

        if (! empty($main->file_pdf)) {
            $this->hapus_file_lama($this->pdf_path, $main->file_pdf);
        }

        if (! empty($main->sampul)) {
            $this->hapus_file_lama($this->sampul_path, $main->sampul);
        }

        $this->db
            ->where('id', (int) $id)
            ->delete($this->table);

        redirect_with('success', 'Buku berhasil dihapus.', $this->controller);
    }

    private function data_validasi()
    {
        $judul = trim((string) $this->input->post('judul', true));

        if ($judul === '') {
            redirect_with('error', 'Judul buku wajib diisi.', $this->controller);
        }

        return [
            'judul'       => $judul,
            'deskripsi'   => trim((string) $this->input->post('deskripsi', true)),
            'kategori'    => trim((string) $this->input->post('kategori', true)),
            'penerbit'    => trim((string) $this->input->post('penerbit', true)),
            'kontributor' => trim((string) $this->input->post('kontributor', true)),
            'penulis'     => trim((string) $this->input->post('penulis', true)),
            'sumber'      => trim((string) $this->input->post('sumber', true)),
            'aktif'       => (int) $this->input->post('aktif', true),
        ];
    }

    private function upload_file($field, $path, $type)
    {
        if (empty($_FILES[$field]['name'])) {
            return null;
        }

        $config = [
            'upload_path'  => FCPATH . $path,
            'encrypt_name' => true,
            'max_size'     => 51200,
        ];

        if ($type === 'pdf') {
            $config['allowed_types'] = 'pdf';
        } else {
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['max_size']      = 5120;
        }

        $this->upload->initialize($config);

        if (! $this->upload->do_upload($field)) {
            redirect_with('error', strip_tags($this->upload->display_errors()), $this->controller);
            return null;
        }

        $uploaded = $this->upload->data();

        return $uploaded['file_name'] ?? null;
    }

    private function simpan_cover_base64($base64)
    {
        $base64 = trim((string) $base64);

        if ($base64 === '') {
            return null;
        }

        if (! preg_match('/^data:image\/(jpeg|jpg|png|webp);base64,/', $base64, $matches)) {
            return null;
        }

        $extension = strtolower($matches[1]);

        if ($extension === 'jpeg') {
            $extension = 'jpg';
        }

        $image_data = preg_replace('/^data:image\/(jpeg|jpg|png|webp);base64,/', '', $base64);
        $image_data = base64_decode($image_data);

        if ($image_data === false) {
            return null;
        }

        $filename = 'cover-pdf-' . date('YmdHis') . '-' . mt_rand(1000, 9999) . '.' . $extension;
        $filepath = FCPATH . $this->sampul_path . $filename;

        if (file_put_contents($filepath, $image_data) === false) {
            return null;
        }

        return $filename;
    }

    private function hapus_file_lama($path, $filename)
    {
        if (empty($filename)) {
            return;
        }

        $file = FCPATH . $path . $filename;

        if (is_file($file)) {
            @unlink($file);
        }
    }

    private function pastikan_folder_upload()
    {
        $folders = [
            FCPATH . $this->pdf_path,
            FCPATH . $this->sampul_path,
        ];

        foreach ($folders as $folder) {
            if (! is_dir($folder)) {
                mkdir($folder, 0755, true);
            }
        }
    }
}