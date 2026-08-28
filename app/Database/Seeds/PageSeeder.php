<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title'     => 'Sejarah Kanwil Kemenag Kaltara',
                'slug'      => 'sejarah-kanwil',
                'content'   => '<p>Ini adalah halaman contoh untuk Sejarah Kanwil Kemenag Kaltara. Silakan ubah konten ini melalui panel admin.</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title'     => 'Profil PPID',
                'slug'      => 'profil-ppid',
                'content'   => '<p>Ini adalah halaman contoh untuk Profil PPID. Silakan ubah konten ini melalui panel admin.</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title'     => 'Struktur Organisasi',
                'slug'      => 'struktur-organisasi',
                'content'   => '<p>Ini adalah halaman contoh untuk Struktur Organisasi PPID. Silakan ubah konten ini melalui panel admin.</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title'     => 'Tugas dan Fungsi PPID',
                'slug'      => 'tugas-dan-fungsi',
                'content'   => '<p>Ini adalah halaman contoh untuk Tugas dan Fungsi PPID. Silakan ubah konten ini melalui panel admin.</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title'     => 'Visi dan Misi',
                'slug'      => 'visi-dan-misi',
                'content'   => '<p>Ini adalah halaman contoh untuk Visi dan Misi. Silakan ubah konten ini melalui panel admin.</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Layanan
            [
                'title'     => 'Maklumat Pelayanan',
                'slug'      => 'maklumat-pelayanan',
                'content'   => '<p>Ini adalah halaman contoh untuk Maklumat Pelayanan. Silakan ubah konten ini melalui panel admin.</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title'     => 'Pedoman Pengelolaan Organisasi',
                'slug'      => 'pedoman-pengelolaan',
                'content'   => '<p>Ini adalah halaman contoh untuk Pedoman Pengelolaan. Silakan ubah konten ini melalui panel admin.</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title'     => 'Jadwal Layanan',
                'slug'      => 'jadwal-layanan',
                'content'   => '<p>Ini adalah halaman contoh untuk Jadwal Layanan. Silakan ubah konten ini melalui panel admin.</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title'     => 'Biaya/Tarif Layanan',
                'slug'      => 'biaya-layanan',
                'content'   => '<p>Ini adalah halaman contoh untuk Biaya Layanan. Silakan ubah konten ini melalui panel admin.</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title'     => 'SOP PPID',
                'slug'      => 'sop-ppid',
                'content'   => '<p>Ini adalah halaman contoh untuk SOP PPID. Silakan ubah konten ini melalui panel admin.</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title'     => 'Standar Operasional (PPEM)',
                'slug'      => 'standar-operasional',
                'content'   => '<p>Ini adalah halaman contoh untuk Standar Operasional. Silakan ubah konten ini melalui panel admin.</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            // Informasi
            [
                'title'     => 'Tata Cara Permohonan Info',
                'slug'      => 'tata-cara-permohonan',
                'content'   => '<p>Ini adalah halaman contoh untuk Tata Cara Permohonan Informasi. Silakan ubah konten ini melalui panel admin.</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title'     => 'Tata Cara Pengajuan Keberatan',
                'slug'      => 'tata-cara-keberatan',
                'content'   => '<p>Ini adalah halaman contoh untuk Tata Cara Keberatan. Silakan ubah konten ini melalui panel admin.</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title'     => 'Tata Cara Sengketa Informasi',
                'slug'      => 'tata-cara-sengketa',
                'content'   => '<p>Ini adalah halaman contoh untuk Tata Cara Sengketa. Silakan ubah konten ini melalui panel admin.</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title'     => 'Hak & Kewajiban Pemohon',
                'slug'      => 'hak-dan-kewajiban',
                'content'   => '<p>Ini adalah halaman contoh untuk Hak & Kewajiban. Silakan ubah konten ini melalui panel admin.</p>',
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Only insert if empty
        if ($this->db->table('pages')->countAllResults() == 0) {
            $this->db->table('pages')->insertBatch($data);
        }
    }
}
