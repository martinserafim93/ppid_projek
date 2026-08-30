<?php

namespace App\Controllers\Pimpinan;

use App\Controllers\BaseController;
use App\Models\RequestModel;
use App\Models\SurveyModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $requestModel = new RequestModel();
        $surveyModel  = new SurveyModel();

        $data = [
            'title'           => 'Dashboard Utama',
            'totalRequests'   => $requestModel->countAllResults(),
            'pendingRequests' => $requestModel->where('status', 'pending')->countAllResults(),
            'approvedRequests'=> $requestModel->where('status', 'approved')->countAllResults(),
            'rejectedRequests'=> $requestModel->where('status', 'rejected')->countAllResults(),
            'avgRating'       => $surveyModel->selectAvg('rating')->first()['rating'] ?? 0,
            'recentRequests'  => $requestModel->select('requests.*, users.name as applicant_name')
                                              ->join('users', 'users.id = requests.user_id', 'left')
                                              ->orderBy('created_at', 'DESC')->findAll(5),

            // Data untuk Chart.js
            'monthlyData'     => $this->getMonthlyData(),
            'statusData'      => $this->getStatusData(),
            'avgResponseTime' => $this->getAvgResponseTime()
        ];

        return view('pimpinan/dashboard', $data);
    }

    public function monitoring()
    {
        $requestModel = new RequestModel();
        
        $search = $this->request->getGet('search');
        $status = $this->request->getGet('status');

        $query = $requestModel->select('requests.*, users.name as applicant_name, users.email as applicant_email')
                              ->join('users', 'users.id = requests.user_id', 'left')
                              ->orderBy('requests.created_at', 'DESC');

        if (!empty($search)) {
            $query->groupStart()
                  ->like('requests.ticket_number', $search)
                  ->orLike('requests.subject', $search)
                  ->orLike('users.name', $search)
                  ->groupEnd();
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        $data = [
            'title'    => 'Monitoring Permohonan',
            'requests' => $query->paginate(15),
            'pager'    => $requestModel->pager,
            'search'   => $search,
            'status'   => $status
        ];

        return view('pimpinan/monitoring', $data);
    }

    public function laporan()
    {
        $requestModel = new \App\Models\RequestModel();
        // Rekap status permohonan
        $statusCounts = $requestModel->select('status, COUNT(id) as total')
                                     ->groupBy('status')
                                     ->findAll();
        
        $data = [
            'title' => 'Laporan Statistik',
            'active' => 'laporan',
            'statusCounts' => $statusCounts
        ];
        return view('pimpinan/laporan', $data);
    }

    public function exportCsv()
    {
        $requestModel = new \App\Models\RequestModel();
        $requests = $requestModel->select('requests.*, users.name as user_name')
                                 ->join('users', 'users.id = requests.user_id', 'left')
                                 ->orderBy('created_at', 'DESC')
                                 ->findAll();

        $filename = "Laporan_Permohonan_Informasi_" . date('Ymd') . ".csv";

        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

        $file = fopen('php://output', 'w');

        $header = array("Nomor Tiket", "Nama Pemohon", "Topik Informasi", "Tujuan Penggunaan", "Status", "Tanggal Pengajuan");
        fputcsv($file, $header);

        foreach ($requests as $row) {
            $data = array(
                $row['ticket_number'],
                $row['user_name'],
                $row['topic'],
                $row['purpose'],
                $row['status'],
                $row['created_at']
            );
            fputcsv($file, $data);
        }
        fclose($file);
        exit;
    }

    public function surveys()
    {
        $surveyModel = new SurveyModel();
        
        $db      = \Config\Database::connect();
        $builder = $db->table('surveys');
        $builder->select('surveys.*, requests.ticket_number, users.name as applicant_name');
        $builder->join('requests', 'requests.id = surveys.request_id', 'left');
        $builder->join('users', 'users.id = requests.user_id', 'left');
        $builder->orderBy('surveys.created_at', 'DESC');
        
        $data = [
            'title'   => 'Hasil Survei Kepuasan',
            'surveys' => $builder->get()->getResultArray()
        ];
        return view('pimpinan/survei', $data);
    }

    private function getMonthlyData(): array
    {
        // Query jumlah permohonan per bulan (12 bulan terakhir)
        $db = \Config\Database::connect();
        $result = $db->query("
            SELECT MONTH(created_at) as month, COUNT(*) as total
            FROM requests
            WHERE YEAR(created_at) = YEAR(CURDATE())
            GROUP BY MONTH(created_at)
            ORDER BY month
        ")->getResultArray();

        // Format untuk Chart.js: labels[] dan data[]
        $labels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $data = array_fill(0, 12, 0);
        foreach ($result as $row) {
            $data[$row['month'] - 1] = (int) $row['total'];
        }

        return ['labels' => $labels, 'data' => $data];
    }

    private function getStatusData(): array
    {
        $requestModel = new RequestModel();
        return [
            'pending'  => $requestModel->where('status', 'pending')->countAllResults(),
            'process'  => $requestModel->where('status', 'process')->countAllResults(),
            'approved' => $requestModel->where('status', 'approved')->countAllResults(),
            'rejected' => $requestModel->where('status', 'rejected')->countAllResults(),
        ];
    }
    
    private function getAvgResponseTime(): string
    {
        $db = \Config\Database::connect();
        $result = $db->query("
            SELECT AVG(TIMESTAMPDIFF(HOUR, created_at, responded_at)) as avg_hours
            FROM requests
            WHERE responded_at IS NOT NULL
        ")->getRow();
        
        $hours = (float)($result->avg_hours ?? 0);
        if ($hours > 24) {
            $days = floor($hours / 24);
            return $days . " Hari";
        }
        return round($hours, 1) . " Jam";
    }
}
