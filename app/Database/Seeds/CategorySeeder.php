<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'        => 'Profil Kanwil',
                'slug'        => 'profil_kanwil',
                'type'        => 'pages',
                'description' => 'Halaman terkait Profil Kanwil',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Profil PPID',
                'slug'        => 'profil_ppid',
                'type'        => 'pages',
                'description' => 'Halaman terkait Profil PPID',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Standar Layanan',
                'slug'        => 'standar_layanan',
                'type'        => 'pages',
                'description' => 'Halaman terkait Standar Layanan PPID',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Layanan Informasi',
                'slug'        => 'layanan_informasi',
                'type'        => 'pages',
                'description' => 'Halaman terkait Layanan Informasi',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            // --- Regulasi ---
            [
                'name'        => 'Undang-Undang (UU)',
                'slug'        => 'uu',
                'type'        => 'regulations',
                'description' => 'Kategori Undang-Undang',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Peraturan Pemerintah (PP)',
                'slug'        => 'pp',
                'type'        => 'regulations',
                'description' => 'Kategori Peraturan Pemerintah',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Peraturan KI (Perki)',
                'slug'        => 'perki',
                'type'        => 'regulations',
                'description' => 'Kategori Peraturan Komisi Informasi',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Peraturan Menteri (PMA)',
                'slug'        => 'pma',
                'type'        => 'regulations',
                'description' => 'Kategori Peraturan Menteri',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Surat Keputusan (SK)',
                'slug'        => 'sk',
                'type'        => 'regulations',
                'description' => 'Kategori Surat Keputusan',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],

            // --- Informasi Publik ---
            [
                'name'        => 'Informasi Berkala',
                'slug'        => 'berkala',
                'type'        => 'public-informations',
                'description' => 'Informasi yang wajib disediakan dan diumumkan secara berkala',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Informasi Serta Merta',
                'slug'        => 'serta_merta',
                'type'        => 'public-informations',
                'description' => 'Informasi yang dapat mengancam hajat hidup orang banyak dan ketertiban umum',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Informasi Tersedia Setiap Saat',
                'slug'        => 'tersedia',
                'type'        => 'public-informations',
                'description' => 'Informasi yang harus disediakan oleh Badan Publik dan siap tersedia untuk bisa langsung diberikan kepada Pemohon',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'name'        => 'Informasi Dikecualikan',
                'slug'        => 'dikecualikan',
                'type'        => 'public-informations',
                'description' => 'Informasi Publik yang tidak dapat diakses oleh pemohon',
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
        ];

        // Using Query Builder
        // Hapus data lama agar tidak duplicate saat seeding
        $this->db->table('categories')->truncate();
        $this->db->table('categories')->insertBatch($data);
    }
}
