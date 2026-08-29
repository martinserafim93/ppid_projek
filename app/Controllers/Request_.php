<?php

namespace App\Controllers;

use App\Models\RequestModel;
use App\Models\RequestFileModel;

class Request_ extends BaseController
{
    public function create()
    {
        // Hanya untuk user yang sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/user/login')->with('error', 'Silakan login terlebih dahulu untuk mengajukan permohonan.');
        }

        $data = [
            'title' => 'Formulir Permohonan Informasi Publik'
        ];
        return view('public/request/create', $data);
    }

    public function store()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/user/login');
        }

        $rules = [
            'subject'     => 'required|min_length[5]',
            'description' => 'required|min_length[10]',
            'purpose'     => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $ticketNumber = $this->generateTicketNumber();

        $requestModel = new RequestModel();
        $requestId = $requestModel->insert([
            'ticket_number' => $ticketNumber,
            'user_id'       => session()->get('user_id'),
            'subject'       => $this->request->getPost('subject'),
            'description'   => $this->request->getPost('description'),
            'purpose'       => $this->request->getPost('purpose'),
            'status'        => 'pending',
        ]);

        // Handle file upload (lampiran opsional)
        $files = $this->request->getFileMultiple('attachments');
        if ($files) {
            $fileModel = new RequestFileModel();
            foreach ($files as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move('uploads/requests', $newName);
                    $fileModel->insert([
                        'request_id'  => $requestId,
                        'file_path'   => 'uploads/requests/' . $newName,
                        'file_name'   => $file->getClientName(),
                        'file_type'   => $file->getClientMimeType(),
                        'uploaded_by' => session()->get('user_id'),
                    ]);
                }
            }
        }

        return redirect()->to('/permohonan/sukses/' . $ticketNumber);
    }

    private function generateTicketNumber(): string
    {
        $year = date('Y');
        $requestModel = new RequestModel();
        
        // Disable soft deletes temporarily if using it, just in case
        $lastRequest = $requestModel->like('ticket_number', "PPID-KALTARA-{$year}-", 'after')
                                    ->orderBy('id', 'DESC')
                                    ->first();

        if ($lastRequest) {
            $lastNumber = intval(substr($lastRequest['ticket_number'], -5));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return "PPID-KALTARA-{$year}-" . str_pad($newNumber, 5, '0', STR_PAD_LEFT);
    }

    public function success($ticketNumber)
    {
        // Pastikan tiket ada
        $requestModel = new RequestModel();
        $requestData = $requestModel->where('ticket_number', $ticketNumber)->first();
        
        if (!$requestData) {
            return redirect()->to('/')->with('error', 'Tiket tidak ditemukan.');
        }
        
        $data = [
            'title' => 'Permohonan Berhasil',
            'ticketNumber' => $ticketNumber
        ];
        
        return view('public/request/success', $data);
    }

    public function track()
    {
        $data = [
            'title' => 'Lacak Status Permohonan',
            'ticketData' => session()->getFlashdata('ticketData') ?? null,
        ];
        return view('public/request/track', $data);
    }

    public function search()
    {
        $ticketNumber = $this->request->getPost('ticket_number');

        if (empty($ticketNumber)) {
            return redirect()->back()->with('error', 'Silakan masukkan nomor tiket.');
        }

        $requestModel = new RequestModel();
        
        // Coba cari tiket
        $ticketData = $requestModel->select('requests.*, users.name as user_name')
                                   ->join('users', 'users.id = requests.user_id')
                                   ->where('ticket_number', $ticketNumber)
                                   ->first();

        if (!$ticketData) {
            return redirect()->back()->with('error', 'Tiket tidak ditemukan. Pastikan penulisan nomor tiket sudah benar.');
        }

        return redirect()->back()->with('ticketData', $ticketData);
    }

    public function history()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/user/login');
        }

        $requestModel = new RequestModel();
        $userId = session()->get('user_id');

        $data = [
            'title'    => 'Riwayat Permohonan',
            'requests' => $requestModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll(),
        ];

        return view('public/request/history', $data);
    }

    public function detail($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/user/login');
        }

        $requestModel = new RequestModel();
        $requestData = $requestModel->where('id', $id)->where('user_id', session()->get('user_id'))->first();

        if (!$requestData) {
            return redirect()->to('/permohonan/riwayat')->with('error', 'Data tidak ditemukan atau Anda tidak memiliki akses.');
        }

        $fileModel = new RequestFileModel();
        $files = $fileModel->where('request_id', $id)->findAll();

        $data = [
            'title'   => 'Detail Permohonan',
            'request' => $requestData,
            'files'   => $files
        ];

        return view('public/request/detail', $data);
    }

    public function objection($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/user/login');
        }

        $requestModel = new RequestModel();
        $requestData = $requestModel->where('id', $id)->where('user_id', session()->get('user_id'))->first();

        if (!$requestData || $requestData['status'] !== 'rejected') {
            return redirect()->back()->with('error', 'Pengajuan keberatan hanya berlaku untuk tiket yang ditolak.');
        }

        $objectionReason = $this->request->getPost('objection_reason');
        if (empty($objectionReason)) {
            return redirect()->back()->with('error', 'Alasan keberatan wajib diisi.');
        }

        $requestModel->update($id, [
            'status' => 'objection',
            'response' => $requestData['response'] . "\n\n[KEBERATAN PEMOHON]: " . $objectionReason
        ]);

        return redirect()->back()->with('success', 'Pengajuan keberatan berhasil dikirim dan akan ditinjau kembali oleh tim PPID.');
    }
}
