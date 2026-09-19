<?php
namespace App\Database\Seeds;
use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'       => 'Admin PPID',
                'email'      => 'admin@ppid-kaltara.go.id',
                'password'   => password_hash('admin123', PASSWORD_BCRYPT),
                'role'       => 'admin',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name'       => 'Pimpinan PPID',
                'email'      => 'pimpinan@ppid-kaltara.go.id',
                'password'   => password_hash('pimpinan123', PASSWORD_BCRYPT),
                'role'       => 'pimpinan',
                'is_active'  => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
