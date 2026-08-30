<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $seeders = [
            'AdminSeeder',
            'SettingsSeeder',
            file_exists(APPPATH . 'Database/Seeds/PageSeeder.php') ? 'PageSeeder' : 'PagesSeeder',
            file_exists(APPPATH . 'Database/Seeds/CategorySeeder.php') ? 'CategorySeeder' : null,
            file_exists(APPPATH . 'Database/Seeds/DocumentCategorySeeder.php') ? 'DocumentCategorySeeder' : null,
            'RegulationsSeeder',
            'InformationsSeeder',
        ];

        foreach ($seeders as $seeder) {
            if ($seeder) {
                try {
                    $this->call($seeder);
                    echo "Seeder {$seeder} ran successfully.\n";
                } catch (\Exception $e) {
                    echo "Seeder {$seeder} skipped/failed: " . $e->getMessage() . "\n";
                }
            }
        }
        
        echo "Master DatabaseSeeder has finished!\n";
    }
}
