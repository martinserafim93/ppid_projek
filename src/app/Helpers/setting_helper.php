<?php

/**
 * Setting Helper
 *
 * Semua settings dimuat SEKALI (1 query) lalu disimpan di memori (static)
 * dan cache lintas-request. Panggilan berikutnya = 0 query DB.
 */

if (!function_exists('loadSettings')) {
    /**
     * Muat seluruh settings (sekali saja per request / dari cache).
     *
     * @return array<string, string> Map key => value
     */
    function loadSettings(): array
    {
        static $settings = null;

        // Sudah dimuat di request ini
        if ($settings !== null) {
            return $settings;
        }

        // Cache lintas-request (default: file handler). TTL 1 jam.
        $cache  = cache();
        $cached = $cache->get('site_settings');
        if (is_array($cached)) {
            return $settings = $cached;
        }

        $settings = [];
        $db = \Config\Database::connect();

        // Guard: jangan error jika tabel belum ada (mis. sebelum migrate)
        if ($db->tableExists('settings')) {
            foreach ($db->table('settings')->get()->getResultArray() as $row) {
                $settings[$row['key']] = $row['value'];
            }
            // Hanya cache jika tabel benar-benar ada
            $cache->save('site_settings', $settings, 3600);
        }

        return $settings;
    }
}

if (!function_exists('getSetting')) {
    /**
     * Ambil nilai pengaturan berdasarkan key.
     *
     * @param string $key     Key pengaturan
     * @param string $default Nilai default jika key tidak ada
     * @return string
     */
    function getSetting(string $key, string $default = ''): string
    {
        $settings = loadSettings();
        // Key ada -> kembalikan value (walau string kosong); tidak ada -> default
        return array_key_exists($key, $settings) ? (string) $settings[$key] : $default;
    }
}
