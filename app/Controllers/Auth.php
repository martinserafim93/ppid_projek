<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        // If already logged in, redirect based on role
        if (session()->get('logged_in')) {
            return $this->redirectBasedOnRole(session()->get('user_role'));
        }

        if ($this->request->getMethod() === 'POST' || $this->request->getMethod() === 'post') {
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $userModel = new UserModel();
            $user = $userModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password'])) {
                if ($user['role'] !== 'admin' && $user['role'] !== 'pimpinan') {
                    return redirect()->back()->with('error', 'Akses ditolak. Rute ini khusus untuk Admin atau Pimpinan.');
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

                return $this->redirectBasedOnRole($user['role']);
            }

            return redirect()->back()->with('error', 'Email atau Password salah.');
        }

        return view('auth/login');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Anda telah berhasil logout.');
    }

    private function redirectBasedOnRole($role)
    {
        if ($role === 'admin') {
            return redirect()->to('/admin/dashboard');
        } elseif ($role === 'pimpinan') {
            return redirect()->to('/pimpinan/dashboard');
        } else {
            return redirect()->to('/');
        }
    }
}
