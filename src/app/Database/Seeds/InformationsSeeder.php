<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class InformationsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'category'      => 'berkala',
                'title'         => 'Profil Pimpinan Kanwil Kemenag Kaltara',
                'description'   => 'Informasi mengenai profil pimpinan yang diperbarui secara berkala.',
                'file_path'     => 'uploads/informations/sample-profil-pimpinan.pdf',
                'sort_order'    => 1,
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'category'      => 'serta_merta',
                'title'         => 'Surat Edaran Bencana Alam',
                'description'   => 'Informasi serta merta mengenai peringatan dini dan penanganan bencana.',
                'file_path'     => 'uploads/informations/sample-se-bencana.pdf',
                'sort_order'    => 2,
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'category'      => 'tersedia',
                'title'         => 'Daftar Aset Barang Milik Negara',
                'description'   => 'Informasi daftar aset BMN Kanwil Kemenag Kaltara.',
                'file_path'     => 'uploads/informations/sample-aset.pdf',
                'sort_order'    => 3,
                'is_active'     => 1,
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]
        ];

        foreach ($data as $row) {
            $exists = $this->db->table('public_informations')
                               ->where('title', $row['title'])
                               ->countAllResults();
            if ($exists == 0) {
                $this->db->table('public_informations')->insert($row);
            }
        }
    }
}
