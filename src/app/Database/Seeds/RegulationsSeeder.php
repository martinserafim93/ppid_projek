<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RegulationsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title'       => 'Undang-Undang Nomor 14 Tahun 2008',
                'type'        => 'Undang-Undang',
                'number'      => '14',
                'year'        => '2008',
                'description' => 'Keterbukaan Informasi Publik',
                'file_path'   => 'uploads/regulations/sample-uu14-2008.pdf',
                'sort_order'  => 1,
                'is_active'   => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'title'       => 'Peraturan Pemerintah Nomor 61 Tahun 2010',
                'type'        => 'Peraturan Pemerintah',
                'number'      => '61',
                'year'        => '2010',
                'description' => 'Pelaksanaan Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik',
                'file_path'   => 'uploads/regulations/sample-pp61-2010.pdf',
                'sort_order'  => 2,
                'is_active'   => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ],
            [
                'title'       => 'PMA Nomor 92 Tahun 2020',
                'type'        => 'Peraturan Menteri',
                'number'      => '92',
                'year'        => '2020',
                'description' => 'Pedoman Layanan Informasi Publik pada Kementerian Agama',
                'file_path'   => 'uploads/regulations/sample-pma92-2020.pdf',
                'sort_order'  => 3,
                'is_active'   => 1,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ]
        ];

        foreach ($data as $row) {
            $exists = $this->db->table('regulations')
                               ->where('title', $row['title'])
                               ->countAllResults();
            if ($exists == 0) {
                $this->db->table('regulations')->insert($row);
            }
        }
    }
}
