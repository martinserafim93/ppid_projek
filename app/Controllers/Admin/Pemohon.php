<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Pemohon extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $query = $this->userModel->where('role', 'pemohon')->orderBy('created_at', 'DESC');

        $data = [
            'title' => 'Manajemen Pemohon',
            'users' => $query->paginate(10),
            'pager' => $this->userModel->pager,
        ];

        return view('admin/pemohon/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Pemohon Baru'
        ];

        return view('admin/pemohon/create', $data);
    }

    public function store()
    {
        $rules = [
            'name'     => 'required|min_length[3]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'nik'      => 'required|exact_length[16]|numeric',
            'phone'    => 'required|min_length[10]|max_length[15]|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'nik'       => $this->request->getPost('nik'),
            'phone'     => $this->request->getPost('phone'),
            'role'      => 'pemohon',
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->userModel->insert($data);

        return redirect()->to('admin/pemohon')->with('message', 'Pemohon berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);

        if (!$user || $user['role'] !== 'pemohon') {
            return redirect()->to('admin/pemohon')->with('error', 'Pemohon tidak ditemukan atau tidak dapat diedit.');
        }

        $data = [
            'title' => 'Edit Data Pemohon',
            'user'  => $user
        ];

        return view('admin/pemohon/edit', $data);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);

        if (!$user || $user['role'] !== 'pemohon') {
            return redirect()->to('admin/pemohon')->with('error', 'Pemohon tidak ditemukan.');
        }

        // Check if email changed to apply is_unique rule
        $emailRule = 'required|valid_email';
        if ($this->request->getPost('email') !== $user['email']) {
            $emailRule .= '|is_unique[users.email]';
        }

        $rules = [
            'name'  => 'required|min_length[3]',
            'email' => $emailRule,
            'nik'   => 'required|exact_length[16]|numeric',
            'phone' => 'required|min_length[10]|max_length[15]|numeric',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'      => $this->request->getPost('name'),
            'email'     => $this->request->getPost('email'),
            'nik'       => $this->request->getPost('nik'),
            'phone'     => $this->request->getPost('phone'),
            'is_active' => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->userModel->update($id, $data);

        return redirect()->to('admin/pemohon')->with('message', 'Data pemohon berhasil diupdate.');
    }

    public function toggleActive($id)
    {
        $user = $this->userModel->find($id);

        if (!$user || $user['role'] !== 'pemohon') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Pemohon tidak ditemukan.'
            ]);
        }

        $newStatus = $user['is_active'] ? 0 : 1;
        
        $this->userModel->update($id, ['is_active' => $newStatus]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Status pemohon berhasil diubah.',
            'new_status' => $newStatus
        ]);
    }

    public function resetPassword($id)
    {
        $user = $this->userModel->find($id);

        if (!$user || $user['role'] !== 'pemohon') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Pemohon tidak ditemukan.'
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
