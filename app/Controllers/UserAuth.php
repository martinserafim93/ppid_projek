<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class UserAuth extends BaseController
{
    public function login()
    {
        // If already logged in, redirect based on role
        if (session()->get('logged_in')) {
            if (session()->get('user_role') === 'admin') return redirect()->to('/admin/dashboard');
            if (session()->get('user_role') === 'pimpinan') return redirect()->to('/pimpinan/dashboard');
            return redirect()->to('/');
        }

        if ($this->request->getMethod() === 'POST' || $this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password'])) {
                if ($user['role'] === 'admin' || $user['role'] === 'pimpinan') {
                    return redirect()->back()->with('error', 'Akun admin/pimpinan tidak dapat digunakan di sini. Silakan masuk melalui halaman login admin.');
                }
                
                if ($user['is_active'] != 1) {
                    return redirect()->back()->with('error', 'Akun Anda belum aktif atau telah dinonaktifkan.');
                }

                $sessionData = [
                    'user_id'    => $user['id'],
                    'user_name'  => $user['name'],
                    'user_email' => $user['email'],
                    'user_role'  => $user['role'],
                    'logged_in'  => true
                ];
                session()->set($sessionData);

                return redirect()->to('/');
            }

            return redirect()->back()->with('error', 'Email atau Password salah.');
        }

        return view('user_auth/login');
    }

    public function register()
    {
        // If already logged in
        if (session()->get('logged_in')) {
            return redirect()->to('/');
        }

        if ($this->request->getMethod() === 'POST' || $this->request->getMethod() === 'post') {
            $rules = [
                'name'             => 'required|min_length[3]',
                'email'            => 'required|valid_email|is_unique[users.email]',
                'nik'              => 'required|exact_length[16]|numeric',
                'phone'            => 'required|min_length[10]',
                'password'         => 'required|min_length[8]',
                'confirm_password' => 'required|matches[password]'
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
            }

            $userModel = new UserModel();
            
            $data = [
                'name'      => $this->request->getPost('name'),
                'email'     => $this->request->getPost('email'),
                'nik'       => $this->request->getPost('nik'),
                'phone'     => $this->request->getPost('phone'),
                'password'  => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
                'role'      => 'pemohon',
                'is_active' => 1
            ];

            $userModel->insert($data);

            return redirect()->to('/user/login')->with('success', 'Registrasi berhasil. Silakan login.');
        }

        return view('user_auth/register');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/user/login')->with('success', 'Anda telah berhasil logout.');
    }
}
