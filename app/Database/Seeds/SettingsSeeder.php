<?php
namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'key'         => 'site_name',
                'value'       => 'PPID Kanwil Kemenag Kalimantan Utara',
                'group'       => 'general',
                'type'        => 'text',
                'description' => 'Nama instansi'
            ],
            [
                'key'         => 'site_address',
                'value'       => 'Jl. Kolonel Soetadji, Tanjung Selor Hilir, Kec. Tj. Selor, Kabupaten Bulungan, Kalimantan Utara 77212',
                'group'       => 'general',
                'type'        => 'textarea',
                'description' => 'Alamat kantor'
            ],
            [
                'key'         => 'site_phone',
                'value'       => '(0552) 2033004',
                'group'       => 'general',
                'type'        => 'text',
                'description' => 'Nomor telepon'
            ],
            [
                'key'         => 'site_email',
                'value'       => 'kaltara@kemenag.go.id',
                'group'       => 'general',
                'type'        => 'text',
                'description' => 'Email resmi'
            ],
            [
                'key'         => 'site_logo',
                'value'       => '',
                'group'       => 'general',
                'type'        => 'image',
                'description' => 'Logo instansi'
            ],
            [
                'key'         => 'site_favicon',
                'value'       => '',
                'group'       => 'general',
                'type'        => 'image',
                'description' => 'Favicon'
            ],
            [
                'key'         => 'operating_hours',
                'value'       => 'Senin-Jumat, 08:00-16:00 WITA',
                'group'       => 'general',
                'type'        => 'text',
                'description' => 'Jam operasional'
            ],
            [
                'key'         => 'whatsapp_link',
                'value'       => 'https://wa.me/6281234567890',
                'group'       => 'contact',
                'type'        => 'text',
                'description' => 'Link WhatsApp'
            ],
            [
                'key'         => 'footer_text',
                'value'       => '© Copyright ' . date('Y') . '. PPID Kanwil Kemenag Kaltara. All right reserved.',
                'group'       => 'general',
                'type'        => 'text',
                'description' => 'Teks footer'
            ],
        ];

        // Check if settings already exist to prevent duplicate insertion
        $db = \Config\Database::connect();
        
        // Disable foreign key checks temporarily if needed, though settings usually doesn't have them
        
        foreach ($data as $setting) {
            $existing = $db->table('settings')->where('key', $setting['key'])->countAllResults();
            if ($existing == 0) {
                // Generate current timestamp for updated_at
                $setting['updated_at'] = date('Y-m-d H:i:s');
                $db->table('settings')->insert($setting);
            }
        }
    }
}
