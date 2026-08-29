<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DocumentCategorySeeder extends Seeder
{
    public function run()
    {
        $now  = date('Y-m-d H:i:s');
        $data = [
            ['name' => 'Dokumen Umum',             'slug' => 'umum',      'type' => 'documents', 'description' => 'Dokumen umum PPID',                  'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Data & Statistik Tahunan', 'slug' => 'statistik', 'type' => 'documents', 'description' => 'Dokumen data & statistik tahunan',  'created_at' => $now, 'updated_at' => $now],
            ['name' => 'SOP Layanan',              'slug' => 'sop',       'type' => 'documents', 'description' => 'Standar Operasional Prosedur (SOP) layanan pada Kantor Wilayah Kementerian Agama Provinsi Kalimantan Utara.', 'created_at' => $now, 'updated_at' => $now],
        ];

        foreach ($data as $row) {
            // Idempotent: hanya insert jika belum ada (aman dijalankan berkali-kali)
            $exists = $this->db->table('categories')
                ->where('slug', $row['slug'])
                ->where('type', 'documents')
                ->countAllResults();

            if (! $exists) {
                $this->db->table('categories')->insert($row);
            }
        }
    }
}
