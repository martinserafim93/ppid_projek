<?php

/**
 * Upload Helper
 * 
 * Helper functions untuk handle file uploads dengan validation,
 * resize image, dan file management
 */

if (!function_exists('uploadFile')) {
    /**
     * Upload file dengan validation dan processing
     * 
     * @param mixed $file File object dari request
     * @param string $directory Target directory dalam public/uploads/
     * @param array $options Options: resize, maxWidth, quality, allowedTypes, maxSize
     * @return string|false Filename jika berhasil, false jika gagal
     */
    function uploadFile($file, string $directory, array $options = [])
    {
        // Default options
        $defaults = [
            'resize' => false,
            'maxWidth' => 1200,
            'quality' => 85,
            'allowedTypes' => [],
            'maxSize' => 10240, // KB
        ];
        
        $options = array_merge($defaults, $options);
        
        // Validate file
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return false;
        }
        
        // Check file size
        $fileSizeKB = $file->getSize() / 1024;
        if ($fileSizeKB > $options['maxSize']) {
            return false;
        }
        
        // Check allowed types if specified
        if (!empty($options['allowedTypes'])) {
            $mimeType = $file->getMimeType();
            if (!in_array($mimeType, $options['allowedTypes'])) {
                return false;
            }
        }
        
        // Generate unique filename
        $extension = $file->getExtension();
        $newName = uniqid() . '_' . time() . '.' . $extension;
        
        // Create directory if not exists
        $uploadPath = FCPATH . 'uploads/' . $directory;
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }
        
        // Move file
        if (!$file->move($uploadPath, $newName)) {
            return false;
        }
        
        // Resize image if option enabled and file is image
        if ($options['resize'] && isImageFile($uploadPath . '/' . $newName)) {
            resizeImage(
                $uploadPath . '/' . $newName,
                $options['maxWidth'],
                $options['quality']
            );
        }
        
        return $newName;
    }
}

if (!function_exists('deleteFile')) {
    /**
     * Delete file dari filesystem secara aman
     * 
     * @param string $path Full path atau relative path dari FCPATH
     * @return bool True jika berhasil atau file tidak ada, false jika gagal
     */
    function deleteFile(string $path): bool
    {
        // Handle relative path
        if (strpos($path, FCPATH) !== 0) {
            $path = FCPATH . ltrim($path, '/');
        }
        
        // Check if file exists
        if (!file_exists($path)) {
            return true; // Consider success if file doesn't exist
        }
        
        // Check if it's a file (not directory)
        if (!is_file($path)) {
            return false;
        }
        
        // Try to delete
        return @unlink($path);
    }
}

if (!function_exists('getFileInfo')) {
    /**
     * Get informasi file dalam format human-readable
     * 
     * @param string $path Full path atau relative path
     * @return array Array dengan keys: size, type, ext, exists
     */
    function getFileInfo(string $path): array
    {
        // Handle relative path
        if (strpos($path, FCPATH) !== 0) {
            $path = FCPATH . ltrim($path, '/');
        }
        
        $info = [
            'exists' => false,
            'size' => '0 B',
            'size_bytes' => 0,
            'type' => 'unknown',
            'ext' => '',
        ];
        
        if (!file_exists($path)) {
            return $info;
        }
        
        $info['exists'] = true;
        $info['size_bytes'] = filesize($path);
        $info['size'] = formatFileSize($info['size_bytes']);
        $info['ext'] = pathinfo($path, PATHINFO_EXTENSION);
        
        // Get mime type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $info['type'] = finfo_file($finfo, $path);
        finfo_close($finfo);
        
        return $info;
    }
}

if (!function_exists('formatFileSize')) {
    /**
     * Format file size ke human-readable format
     * 
     * @param int $bytes File size dalam bytes
     * @return string Formatted size (e.g., "1.5 MB")
     */
    function formatFileSize(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' B';
        }
    }
}

if (!function_exists('isImageFile')) {
    /**
     * Check apakah file adalah image
     * 
     * @param string $path Path ke file
     * @return bool True jika image, false jika bukan
     */
    function isImageFile(string $path): bool
    {
        if (!file_exists($path)) {
            return false;
        }
        
        $mimeType = mime_content_type($path);
        return strpos($mimeType, 'image/') === 0;
    }
}

if (!function_exists('resizeImage')) {
    /**
     * Resize image dengan maintain aspect ratio
     * 
     * @param string $sourcePath Path ke image source
     * @param int $maxWidth Maximum width (height akan disesuaikan)
     * @param int $quality Quality untuk JPEG (0-100)
     * @return bool True jika berhasil, false jika gagal
     */
    function resizeImage(string $sourcePath, int $maxWidth = 1200, int $quality = 85): bool
    {
        if (!file_exists($sourcePath) || !isImageFile($sourcePath)) {
            return false;
        }
        
        // Get image info
        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            return false;
        }
        
        list($width, $height, $type) = $imageInfo;
        
        // Skip if image width is already smaller than max
        if ($width <= $maxWidth) {
            return true;
        }
        
        // Calculate new dimensions
        $ratio = $height / $width;
        $newWidth = $maxWidth;
        $newHeight = (int)($maxWidth * $ratio);
        
        // Create image resource based on type
        switch ($type) {
            case IMAGETYPE_JPEG:
                $source = imagecreatefromjpeg($sourcePath);
                break;
            case IMAGETYPE_PNG:
                $source = imagecreatefrompng($sourcePath);
                break;
            case IMAGETYPE_GIF:
                $source = imagecreatefromgif($sourcePath);
                break;
            case IMAGETYPE_WEBP:
                $source = imagecreatefromwebp($sourcePath);
                break;
            default:
                return false;
        }
        
        if (!$source) {
            return false;
        }
        
        // Create new image
        $destination = imagecreatetruecolor($newWidth, $newHeight);
        
        // Preserve transparency for PNG and GIF
        if ($type == IMAGETYPE_PNG || $type == IMAGETYPE_GIF) {
            imagealphablending($destination, false);
            imagesavealpha($destination, true);
            $transparent = imagecolorallocatealpha($destination, 255, 255, 255, 127);
            imagefilledrectangle($destination, 0, 0, $newWidth, $newHeight, $transparent);
        }
        
        // Resize
        imagecopyresampled(
            $destination,
            $source,
            0, 0, 0, 0,
            $newWidth,
            $newHeight,
            $width,
            $height
        );
        
        // Save based on type
        $success = false;
        switch ($type) {
            case IMAGETYPE_JPEG:
                $success = imagejpeg($destination, $sourcePath, $quality);
                break;
            case IMAGETYPE_PNG:
                // PNG quality is 0-9 (0 = no compression, 9 = max compression)
                $pngQuality = (int)(9 - ($quality / 100 * 9));
                $success = imagepng($destination, $sourcePath, $pngQuality);
                break;
            case IMAGETYPE_GIF:
                $success = imagegif($destination, $sourcePath);
                break;
            case IMAGETYPE_WEBP:
                $success = imagewebp($destination, $sourcePath, $quality);
                break;
        }
        
        // Free memory
        imagedestroy($source);
        imagedestroy($destination);
        
        return $success;
    }
}

if (!function_exists('validateUploadFile')) {
    /**
     * Validate file upload dengan custom rules
     * 
     * @param mixed $file File object dari request
     * @param array $rules Array of validation rules
     * @return array ['valid' => bool, 'errors' => array]
     */
    function validateUploadFile($file, array $rules = []): array
    {
        $result = [
            'valid' => true,
            'errors' => [],
        ];
        
        // Check if file exists and valid
        if (!$file || !$file->isValid()) {
            $result['valid'] = false;
            $result['errors'][] = 'File tidak valid atau tidak ditemukan';
            return $result;
        }
        
        // Check max size (in KB)
        if (isset($rules['maxSize'])) {
            $fileSizeKB = $file->getSize() / 1024;
            if ($fileSizeKB > $rules['maxSize']) {
                $result['valid'] = false;
                $result['errors'][] = 'Ukuran file maksimal ' . formatFileSize($rules['maxSize'] * 1024);
            }
        }
        
        // Check allowed types
        if (isset($rules['allowedTypes']) && !empty($rules['allowedTypes'])) {
            $mimeType = $file->getMimeType();
            if (!in_array($mimeType, $rules['allowedTypes'])) {
                $result['valid'] = false;
                $result['errors'][] = 'Tipe file tidak diizinkan';
            }
        }
        
        // Check allowed extensions
        if (isset($rules['allowedExts']) && !empty($rules['allowedExts'])) {
            $ext = $file->getExtension();
            if (!in_array(strtolower($ext), array_map('strtolower', $rules['allowedExts']))) {
                $result['valid'] = false;
                $result['errors'][] = 'Ekstensi file harus: ' . implode(', ', $rules['allowedExts']);
            }
        }
        
        // Check if image (if required)
        if (isset($rules['isImage']) && $rules['isImage'] === true) {
            $mimeType = $file->getMimeType();
            if (strpos($mimeType, 'image/') !== 0) {
                $result['valid'] = false;
                $result['errors'][] = 'File harus berupa gambar';
            }
        }
        
        return $result;
    }
}

if (!function_exists('createUploadDirectory')) {
    /**
     * Create upload directory jika belum ada
     * 
     * @param string $directory Directory name dalam uploads/
     * @return bool True jika berhasil atau sudah ada
     */
    function createUploadDirectory(string $directory): bool
    {
        $path = FCPATH . 'uploads/' . $directory;
        
        if (is_dir($path)) {
            return true;
        }
        
        return mkdir($path, 0755, true);
    }
}
