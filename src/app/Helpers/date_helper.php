<?php

/**
 * date_helper.php
 *
 * Helper untuk format tanggal & waktu sesuai zona WITA (Asia/Makassar).
 */

if (!function_exists('formatWita')) {
    /**
     * Format datetime (dalam UTC) menjadi zona WITA.
     *
     * @param string|null $datetime Nilai datetime dari database (UTC)
     * @param string $format Format output (default: 'd M Y H:i')
     * @return string Tanggal berzona WITA, atau '-' jika kosong/null
     */
    function formatWita(?string $datetime, string $format = 'd M Y H:i'): string
    {
        if (empty($datetime)) {
            return '-';
        }

        try {
            $time = \CodeIgniter\I18n\Time::parse($datetime, 'UTC');
            return $time->setTimezone('Asia/Makassar')->format($format);
        } catch (\Exception $e) {
            return '-';
        }
    }
}
