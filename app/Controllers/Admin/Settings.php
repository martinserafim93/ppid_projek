<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Settings extends BaseController
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        helper(['form', 'url', 'upload', 'admin']);
    }

    public function index()
    {
        // Fetch all settings grouped by 'group'
        $allSettings = $this->db->table('settings')
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        // Group settings by group field
        $grouped = [];
        foreach ($allSettings as $setting) {
            $group = $setting['group'] ?? 'general';
            $grouped[$group][] = $setting;
        }

        // Human-readable group labels
        $groupLabels = [
            'general' => 'Pengaturan Umum',
            'contact' => 'Kontak & Media Sosial',
        ];

        // Human-readable group icons
        $groupIcons = [
            'general' => 'bi-gear',
            'contact' => 'bi-telephone',
        ];

        $data = [
            'title'       => 'Pengaturan Website',
            'grouped'     => $grouped,
            'groupLabels' => $groupLabels,
            'groupIcons'  => $groupIcons,
        ];

        return view('admin/settings/index', $data);
    }

    public function update()
    {
        $allSettings = $this->db->table('settings')
            ->get()
            ->getResultArray();

        foreach ($allSettings as $setting) {
            $key  = $setting['key'];
            $type = $setting['type'];

            if ($type === 'image') {
                // Handle image upload
                $file = $this->request->getFile($key);
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    // Validate image
                    $maxSize = ($key === 'site_favicon') ? 512 : 2048; // KB
                    $fileSizeKB = $file->getSize() / 1024;

                    if ($fileSizeKB > $maxSize) {
                        return redirect()->back()->with('error', "File {$setting['description']} terlalu besar. Maksimal " . ($maxSize >= 1024 ? ($maxSize/1024) . ' MB' : $maxSize . ' KB') . '.');
                    }

                    $mimeType = $file->getMimeType();
                    $allowedMimes = ['image/png', 'image/jpeg', 'image/jpg', 'image/webp', 'image/x-icon'];
                    if (!in_array($mimeType, $allowedMimes)) {
                        return redirect()->back()->with('error', "Tipe file {$setting['description']} tidak diizinkan.");
                    }

                    $newName = uploadFile($file, 'settings');
                    if ($newName) {
                        // Delete old file
                        if (!empty($setting['value'])) {
                            deleteFile($setting['value']);
                        }

                        $newValue = 'uploads/settings/' . $newName;
                        $this->db->table('settings')
                            ->where('key', $key)
                            ->update([
                                'value'      => $newValue,
                                'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                    }
                }
                // If no file uploaded, keep old value (do nothing)
            } else {
                // Text, textarea: update from POST
                $newValue = $this->request->getPost($key);

                if ($newValue !== null) {
                    // Basic validation for required fields
                    if ($key === 'site_name' && empty(trim($newValue))) {
                        return redirect()->back()->withInput()->with('error', 'Nama instansi wajib diisi.');
                    }
                    if ($key === 'site_email' && !empty(trim($newValue)) && !filter_var($newValue, FILTER_VALIDATE_EMAIL)) {
                        return redirect()->back()->withInput()->with('error', 'Format email tidak valid.');
                    }

                    $this->db->table('settings')
                        ->where('key', $key)
                        ->update([
                            'value'      => $newValue,
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                }
            }
        }
        // Bersihkan cache settings agar perubahan langsung tampil di situs publik
        cache()->delete('site_settings');

        return redirect()->to('admin/settings')->with('message', 'Pengaturan website berhasil diperbarui.');
    }
}
