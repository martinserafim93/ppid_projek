<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RequestModel;
use App\Models\RequestFileModel;
use App\Models\UserModel;

class Requests extends BaseController
{
    public function index()
    {
        $requestModel = new RequestModel();
        
        $data = [
            'title'    => 'Kelola Permohonan Informasi',
            'requests' => $requestModel->select('requests.*, users.name as user_name, users.email')
                                       ->join('users', 'users.id = requests.user_id')
                                       ->orderBy('requests.created_at', 'DESC')
                                       ->findAll()
        ];
        
        return view('admin/requests/index', $data);
    }

    public function detail($id)
    {
        $requestModel = new RequestModel();
        
        $requestData = $requestModel->select('requests.*, users.name as user_name, users.email, users.nik, users.phone')
                                   ->join('users', 'users.id = requests.user_id')
                                   ->where('requests.id', $id)
                                   ->first();
                                   
        if (!$requestData) {
            return redirect()->to('/admin/requests')->with('error', 'Data permohonan tidak ditemukan.');
        }

        $fileModel = new RequestFileModel();
        $files = $fileModel->where('request_id', $id)->findAll();

        $data = [
            'title'   => 'Detail Permohonan',
            'request' => $requestData,
            'files'   => $files
        ];

        return view('admin/requests/detail', $data);
    }

    public function update($id)
    {
        $requestModel = new RequestModel();
        $requestData = $requestModel->find($id);

        if (!$requestData) {
            return redirect()->to('/admin/requests')->with('error', 'Data tidak ditemukan.');
        }

        $status = $this->request->getPost('status');
        $responseText = $this->request->getPost('response');
        
        $updateData = [
            'status' => $status,
            'responded_at' => date('Y-m-d H:i:s'),
            'responded_by' => session()->get('user_id')
        ];

        if ($status === 'rejected') {
            if (empty($responseText)) {
                return redirect()->back()->withInput()->with('error', 'Alasan penolakan wajib diisi jika menolak permohonan.');
            }
            $updateData['response'] = $responseText;
        } else {
            $updateData['response'] = $responseText; // Can be empty or filled
        }

        // Handle response file if approved
        if ($status === 'approved') {
            $file = $this->request->getFile('response_file');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move('uploads/responses', $newName);
                
                // Hapus file lama jika ada
                if (!empty($requestData['response_file']) && file_exists(FCPATH . $requestData['response_file'])) {
                    unlink(FCPATH . $requestData['response_file']);
                }
                
                $updateData['response_file'] = 'uploads/responses/' . $newName;
            }
        }

        $requestModel->update($id, $updateData);

        return redirect()->to('/admin/requests/detail/' . $id)->with('success', 'Status permohonan berhasil diperbarui.');
    }

    public function create()
    {
        $userModel = new UserModel();
        // Ambil data user yang perannya pemohon
        $users = $userModel->where('role', 'pemohon')->orderBy('name', 'ASC')->findAll();

        $data = [
            'title' => 'Tambah Permohonan Informasi',
            'users' => $users
        ];

        return view('admin/requests/create', $data);
    }

    public function store()
    {
        $rules = [
            'user_id'     => 'required|numeric',
            'subject'     => 'required|min_length[5]',
            'description' => 'required|min_length[10]',
            'purpose'     => 'required|min_length[10]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $requestModel = new RequestModel();
        $ticketNumber = 'REQ-' . date('YmdHis') . '-' . strtoupper(substr(md5(uniqid()), 0, 4));

        $data = [
            'ticket_number' => $ticketNumber,
            'user_id'       => $this->request->getPost('user_id'),
            'subject'       => $this->request->getPost('subject'),
            'description'   => $this->request->getPost('description'),
            'purpose'       => $this->request->getPost('purpose'),
            'status'        => 'pending'
        ];

        $requestId = $requestModel->insert($data);

        // Upload files jika ada
        $files = $this->request->getFileMultiple('files');
        if ($files) {
            $fileModel = new RequestFileModel();
            foreach ($files as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move('uploads/requests', $newName);
                    
                    $fileModel->insert([
                        'request_id' => $requestId,
                        'file_path'  => 'uploads/requests/' . $newName,
                        'file_name'  => $file->getClientName()
                    ]);
                }
            }
        }

        return redirect()->to('/admin/requests')->with('success', 'Permohonan informasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $requestModel = new RequestModel();
        $requestData = $requestModel->find($id);

        if (!$requestData) {
            return redirect()->to('/admin/requests')->with('error', 'Data tidak ditemukan.');
        }

        $userModel = new UserModel();
        $users = $userModel->where('role', 'pemohon')->orderBy('name', 'ASC')->findAll();

        $data = [
            'title'   => 'Edit Permohonan Informasi',
            'request' => $requestData,
            'users'   => $users
        ];

        return view('admin/requests/edit', $data);
    }

    public function updateData($id)
    {
        $requestModel = new RequestModel();
        $requestData = $requestModel->find($id);

        if (!$requestData) {
            return redirect()->to('/admin/requests')->with('error', 'Data tidak ditemukan.');
        }

        $rules = [
            'user_id'     => 'required|numeric',
            'subject'     => 'required|min_length[5]',
            'description' => 'required|min_length[10]',
            'purpose'     => 'required|min_length[10]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $data = [
            'user_id'     => $this->request->getPost('user_id'),
            'subject'     => $this->request->getPost('subject'),
            'description' => $this->request->getPost('description'),
            'purpose'     => $this->request->getPost('purpose')
        ];

        $requestModel->update($id, $data);

        return redirect()->to('/admin/requests')->with('success', 'Data permohonan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $requestModel = new RequestModel();
        $requestData = $requestModel->find($id);

        if (!$requestData) {
            return redirect()->to('/admin/requests')->with('error', 'Data tidak ditemukan.');
        }

        // Hapus file balasan jika ada
        if (!empty($requestData['response_file']) && file_exists(FCPATH . $requestData['response_file'])) {
            unlink(FCPATH . $requestData['response_file']);
        }

        // Hapus file lampiran (attachments)
        $fileModel = new RequestFileModel();
        $files = $fileModel->where('request_id', $id)->findAll();
        foreach ($files as $f) {
            if (file_exists(FCPATH . $f['file_path'])) {
                unlink(FCPATH . $f['file_path']);
            }
        }
        $fileModel->where('request_id', $id)->delete();

        // Hapus data permohonan utama
        $requestModel->delete($id);

        return redirect()->to('/admin/requests')->with('success', 'Data permohonan beserta lampirannya berhasil dihapus.');
    }
}
