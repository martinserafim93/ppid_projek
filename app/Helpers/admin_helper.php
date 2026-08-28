<?php

/**
 * Admin Helper
 * 
 * Helper functions untuk admin dashboard
 */

if (!function_exists('isActiveMenu')) {
    /**
     * Cek apakah menu sedang aktif berdasarkan segment URL
     * 
     * @param string $segment Segment URL yang dicek
     * @return string Return 'active' jika match, empty string jika tidak
     */
    function isActiveMenu(string $segment): string
    {
        $currentUrl = current_url();
        return (strpos($currentUrl, $segment) !== false) ? 'active' : '';
    }
}

if (!function_exists('getUserInitial')) {
    /**
     * Ambil initial dari nama user (maksimal 2 huruf)
     * 
     * @param string|null $name Nama lengkap user
     * @return string Initial 2 huruf uppercase
     */
    function getUserInitial(?string $name): string
    {
        if (empty($name)) {
            return 'AD';
        }

        $words = explode(' ', trim($name));
        
        if (count($words) >= 2) {
            // Ambil huruf pertama dari 2 kata pertama
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        } else {
            // Ambil 2 huruf pertama dari nama
            return strtoupper(substr($name, 0, 2));
        }
    }
}

if (!function_exists('formatNumber')) {
    /**
     * Format angka dengan separator titik
     * 
     * @param int $number Angka yang akan diformat
     * @return string Angka terformat (contoh: 1.000)
     */
    function formatNumber(int $number): string
    {
        return number_format($number, 0, ',', '.');
    }
}

if (!function_exists('getGreeting')) {
    /**
     * Get greeting berdasarkan waktu saat ini
     * 
     * @return string Greeting message
     */
    function getGreeting(): string
    {
        $hour = (int) date('H');
        
        if ($hour >= 0 && $hour < 11) {
            return 'Selamat Pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            return 'Selamat Siang';
        } elseif ($hour >= 15 && $hour < 19) {
            return 'Selamat Sore';
        } else {
            return 'Selamat Malam';
        }
    }
}

if (!function_exists('getBreadcrumb')) {
    /**
     * Generate breadcrumb berdasarkan URL segments
     * 
     * @return array Array of breadcrumb items
     */
    function getBreadcrumb(): array
    {
        $uri = service('uri');
        $segments = $uri->getSegments();
        
        $breadcrumbs = [];
        $breadcrumbs[] = [
            'title' => 'Dashboard',
            'url' => base_url('admin/dashboard'),
            'active' => count($segments) <= 2
        ];
        
        // Mapping segment ke label yang lebih user-friendly
        $segmentLabels = [
            'pages' => 'Kelola Halaman',
            'regulations' => 'Kelola Regulasi',
            'public-informations' => 'Kelola Informasi Publik',
            'infographics' => 'Kelola Infografis',
            'documents' => 'Kelola Dokumen',
            'users' => 'Manajemen User',
            'settings' => 'Pengaturan Situs',
        ];
        
        if (count($segments) > 2) {
            $segment = $segments[1] ?? '';
            if (isset($segmentLabels[$segment])) {
                $breadcrumbs[] = [
                    'title' => $segmentLabels[$segment],
                    'url' => base_url('admin/' . $segment),
                    'active' => true
                ];
            }
        }
        
        return $breadcrumbs;
    }
}
