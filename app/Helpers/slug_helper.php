<?php

/**
 * Slug Helper
 * 
 * Helper functions untuk generate URL-friendly slugs
 */

if (!function_exists('generateSlug')) {
    /**
     * Generate URL-friendly slug dari text
     * 
     * @param string $text Text yang akan di-slugify
     * @param mixed $model Model untuk check uniqueness (opsional)
     * @param string $field Field name untuk check uniqueness (default: 'slug')
     * @param int|null $excludeId ID yang di-exclude saat check uniqueness (untuk update)
     * @return string Generated slug
     */
    function generateSlug(string $text, $model = null, string $field = 'slug', ?int $excludeId = null): string
    {
        // Convert to lowercase
        $slug = strtolower($text);
        
        // Replace spaces and special characters with dash
        $slug = preg_replace('/[^a-z0-9]+/i', '-', $slug);
        
        // Remove multiple dashes
        $slug = preg_replace('/-+/', '-', $slug);
        
        // Trim dashes from start and end
        $slug = trim($slug, '-');
        
        // Fallback: jika slug kosong (judul tidak mengandung huruf/angka Latin)
        if ($slug === '') {
            $slug = 'halaman';
        }
        
        // If no model provided, return slug as is
        if ($model === null) {
            return $slug;
        }
        
        // Check uniqueness and add increment if needed
        $originalSlug = $slug;
        $counter = 1;
        
        while (!isSlugUnique($slug, $model, $field, $excludeId)) {
            $counter++;
            $slug = $originalSlug . '-' . $counter;
        }
        
        return $slug;
    }
}

if (!function_exists('isSlugUnique')) {
    /**
     * Check apakah slug unique di database
     * 
     * @param string $slug Slug yang akan dicek
     * @param mixed $model Model instance atau class name
     * @param string $field Field name untuk check (default: 'slug')
     * @param int|null $excludeId ID yang di-exclude dari check (untuk update)
     * @return bool True jika unique, false jika sudah ada
     */
    function isSlugUnique(string $slug, $model, string $field = 'slug', ?int $excludeId = null): bool
    {
        // Get model instance
        if (is_string($model)) {
            $model = new $model();
        }
        
        // Build query
        $builder = $model->where($field, $slug);
        
        // Exclude current ID if provided (for update operation)
        if ($excludeId !== null) {
            $builder->where('id !=', $excludeId);
        }
        
        // Check if exists
        $result = $builder->first();
        
        return $result === null;
    }
}

if (!function_exists('slugify')) {
    /**
     * Alias untuk generateSlug (simple version without DB check)
     * 
     * @param string $text Text yang akan di-slugify
     * @return string Generated slug
     */
    function slugify(string $text): string
    {
        return generateSlug($text);
    }
}

if (!function_exists('sanitizeSlug')) {
    /**
     * Sanitize slug untuk memastikan format yang valid
     * 
     * @param string $slug Slug yang akan di-sanitize
     * @return string Sanitized slug
     */
    function sanitizeSlug(string $slug): string
    {
        // Convert to lowercase
        $slug = strtolower($slug);
        
        // Replace invalid characters
        $slug = preg_replace('/[^a-z0-9-]/', '', $slug);
        
        // Remove multiple dashes
        $slug = preg_replace('/-+/', '-', $slug);
        
        // Trim dashes
        $slug = trim($slug, '-');
        
        return $slug;
    }
}

if (!function_exists('createSlugFromTitle')) {
    /**
     * Create slug dari title dengan auto-increment jika duplicate
     * Helper function khusus untuk form input
     * 
     * @param string $title Title yang akan dijadikan slug
     * @param string $modelClass Fully qualified model class name
     * @param int|null $currentId Current record ID (untuk update)
     * @return string Generated unique slug
     */
    function createSlugFromTitle(string $title, string $modelClass, ?int $currentId = null): string
    {
        return generateSlug($title, $modelClass, 'slug', $currentId);
    }
}
