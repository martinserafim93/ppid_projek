<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class ProfileController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $role = session()->get('user_role');
        
        // Hanya Admin dan Pimpinan yang boleh akses via controller ini
        if ($role !== 'admin' && $role !== 'pimpinan') {
            return redirect()->to('/')->with('error', 'Akses ditolak.');
        }

        $data = [
            'title' => 'Profil Saya',
            'user'  => $this->userModel->find($userId),
            // Layout ditentukan dinamis berdasarkan role yang sedang login
            'layout' => $role === 'admin' ? 'layouts/admin' : 'layouts/pimpinan'
        ];

        return view('shared/profile', $data);
    }

    public function update()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->back()->with('error', 'Pengguna tidak ditemukan.');
        }

        $rules = [
            'name' => [
                'rules' => 'required|min_length[3]',
                'errors' => [
                    'required' => 'Nama lengkap wajib diisi.',
                    'min_length' => 'Nama lengkap minimal 3 karakter.'
                ]
            ],
            'avatar' => [
                'rules' => 'max_size[avatar,2048]|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran foto maksimal 2MB.',
                    'is_image' => 'File yang diupload bukan gambar valid.',
                    'mime_in'  => 'Format gambar harus JPG, JPEG, atau PNG.'
                ]
            ]
        ];

        // Validasi password jika diisi
        if ($this->request->getPost('password')) {
            $rules['password'] = [
                'rules' => 'min_length[8]',
                'errors' => [
                    'min_length' => 'Password baru minimal 8 karakter.'
                ]
            ];
            $rules['password_confirm'] = [
                'rules' => 'matches[password]',
                'errors' => [
                    'matches' => 'Konfirmasi password tidak cocok dengan password baru.'
                ]
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'name' => $this->request->getPost('name'),
        ];

        if ($this->request->getPost('password')) {
            $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Handle Avatar Upload
        $avatarFile = $this->request->getFile('avatar');
        if ($avatarFile && $avatarFile->isValid() && !$avatarFile->hasMoved()) {
            $newName = $avatarFile->getRandomName();
            
            // Pindahkan file ke direktori public/uploads/avatars
            $uploadPath = FCPATH . 'uploads/avatars';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $avatarFile->move($uploadPath, $newName);
            
            // Hapus avatar lama jika ada
            if (!empty($user['avatar']) && file_exists($uploadPath . '/' . $user['avatar'])) {
                unlink($uploadPath . '/' . $user['avatar']);
            }
            
            $updateData['avatar'] = $newName;
        }

        $this->userModel->update($userId, $updateData);

        // Update session
        session()->set('user_name', $updateData['name']);
        if (isset($updateData['avatar'])) {
            session()->set('user_avatar', $updateData['avatar']);
        }

        return redirect()->back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}
