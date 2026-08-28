<?php

/**
 * Setting Helper
 * 
 * Helper functions untuk akses pengaturan situs dari database
 */

if (!function_exists('getSetting')) {
    /**
     * Ambil nilai pengaturan berdasarkan key
     * 
     * @param string $key Key pengaturan
     * @param string $default Nilai default jika key tidak ditemukan
     * @return string Nilai pengaturan atau default
     */
    function getSetting(string $key, string $default = ''): string
    {
        $db = \Config\Database::connect();
        
        // Pastikan tabel ada
        if (!$db->tableExists('settings')) {
            return $default;
        }

        $row = $db->table('settings')->where('key', $key)->get()->getRowArray();
        
        return $row ? $row['value'] : $default;
    }
}
