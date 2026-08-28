<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Users extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $role = $this->request->getGet('role');
        
        // Exclude pemohon (handled separately usually)
        $query = $this->userModel->whereIn('role', ['admin', 'pimpinan'])->orderBy('created_at', 'DESC');
        
        if (!empty($role) && in_array($role, ['admin', 'pimpinan'])) {
            $query = $query->where('role', $role);
        }

        $data = [
            'title' => 'Manajemen Pengguna (Admin & Pimpinan)',
            'users' => $query->paginate(10),
            'pager' => $this->userModel->pager,
            'role'  => $role
        ];

        return view('admin/users/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pengguna Baru'
        ];

        return view('admin/users/create', $data);
    }

    public function store()
    {
        $rules = [
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'role'     => 'required|in_list[admin,pimpinan]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'      => $this->request->getPost('role'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->userModel->insert($data);

        return redirect()->to('admin/users')->with('message', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (!$user || !in_array($user['role'], ['admin', 'pimpinan'])) {
            return redirect()->to('admin/users')->with('error', 'Pengguna tidak ditemukan atau tidak dapat diedit.');
        }

        $data = [
            'title' => 'Edit Pengguna',
            'user'  => $user
        ];

        return view('admin/users/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);

        if (!$user || !in_array($user['role'], ['admin', 'pimpinan'])) {
            return redirect()->to('admin/users')->with('error', 'Pengguna tidak ditemukan.');
        }

        // Check if email changed to apply is_unique rule
        $emailRule = 'required|valid_email';
        if ($this->request->getPost('email') !== $user['email']) {
            $emailRule .= '|is_unique[users.email]';
        }

        $rules = [
            'name'  => 'required|min_length[3]',
            'email' => $emailRule,
            'role'  => 'required|in_list[admin,pimpinan]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'role'  => $this->request->getPost('role'),
        ];
        
        // Hanya bisa update is_active jika bukan dirinya sendiri
        if (session('user_id') !== $id) {
            $data['is_active'] = $this->request->getPost('is_active') ? 1 : 0;
        }

        $this->userModel->update($id, $data);

        return redirect()->to('admin/users')->with('message', 'Data pengguna berhasil diupdate.');
    }

    public function toggleActive($id)
    {
        // Prevent self-deactivation
        if (session('user_id') == $id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Anda tidak dapat menonaktifkan akun Anda sendiri.'
            ]);
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan.'
            ]);
        }

        $newStatus = $user['is_active'] ? 0 : 1;
        
        $this->userModel->update($id, ['is_active' => $newStatus]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Status pengguna berhasil diubah.',
            'new_status' => $newStatus
        ]);
    }

    public function resetPassword($id)
    {
        // Prevent self-reset
        if (session('user_id') == $id) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Silakan gunakan fitur ubah password profil untuk akun Anda sendiri.'
            ]);
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan.'
            ]);
        }

        // Generate random 8 character alphanumeric password
        $newPassword = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 8);
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        
        $this->userModel->update($id, ['password' => $hashedPassword]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Password berhasil direset.',
            'new_password' => $newPassword
        ]);
    }
}
