<?php

namespace App\Controllers\Pimpinan;

use App\Controllers\BaseController;
use App\Models\SurveyModel;
use App\Models\RequestModel;

class SurveiController extends BaseController
{
    protected $surveyModel;
    protected $requestModel;

    public function __construct()
    {
        $this->surveyModel = new SurveyModel();
        $this->requestModel = new RequestModel();
    }

    public function index()
    {
        $db      = \Config\Database::connect();
        
        // Ambil Data Survei
        $builder = $db->table('surveys');
        $builder->select('surveys.*, requests.ticket_number, users.name as applicant_name');
        $builder->join('requests', 'requests.id = surveys.request_id', 'left');
        $builder->join('users', 'users.id = requests.user_id', 'left');
        $builder->orderBy('surveys.created_at', 'DESC');
        
        // Ambil Data Permohonan yang belum ada surveinya (untuk dropdown modal)
        $availableRequests = $db->query("
            SELECT id, ticket_number, subject 
            FROM requests 
            WHERE status IN ('approved', 'rejected') 
            AND id NOT IN (SELECT request_id FROM surveys)
            ORDER BY created_at DESC
        ")->getResultArray();

        $data = [
            'title'   => 'Hasil Survei Kepuasan',
            'surveys' => $builder->get()->getResultArray(),
            'availableRequests' => $availableRequests
        ];
        return view('pimpinan/survei', $data);
    }

    public function store()
    {
        $rules = [
            'request_id' => 'required',
            'rating'     => 'required|in_list[1,2,3,4,5]',
            'feedback'   => 'permit_empty|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $requestId = $this->request->getPost('request_id');
        $requestData = $this->requestModel->find($requestId);

        if (!$requestData) {
            return redirect()->back()->with('error', 'Data Permohonan tidak valid.');
        }

        $data = [
            'request_id' => $requestId,
            'user_id'    => $requestData['user_id'],
            'rating'     => $this->request->getPost('rating'),
            'feedback'   => $this->request->getPost('feedback'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        $this->surveyModel->insert($data);
        return redirect()->to('/pimpinan/survei')->with('success', 'Data survei berhasil ditambahkan.');
    }

    public function update($id)
    {
        $rules = [
            'rating'   => 'required|in_list[1,2,3,4,5]',
            'feedback' => 'permit_empty|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $survey = $this->surveyModel->find($id);
        if (!$survey) {
            return redirect()->back()->with('error', 'Data survei tidak ditemukan.');
        }

        $data = [
            'rating'   => $this->request->getPost('rating'),
            'feedback' => $this->request->getPost('feedback')
        ];

        $this->surveyModel->update($id, $data);
        return redirect()->to('/pimpinan/survei')->with('success', 'Data survei berhasil diperbarui.');
    }

    public function delete($id)
    {
        $survey = $this->surveyModel->find($id);
        if (!$survey) {
            return redirect()->back()->with('error', 'Data survei tidak ditemukan.');
        }

        $this->surveyModel->delete($id);
        return redirect()->to('/pimpinan/survei')->with('success', 'Data survei berhasil dihapus.');
    }
}
