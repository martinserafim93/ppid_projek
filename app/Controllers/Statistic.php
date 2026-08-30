<?php

namespace App\Controllers;

use App\Models\RequestModel;
use App\Models\DocumentModel;

class Statistic extends BaseController
{
    public function index()
    {
        $requestModel = new RequestModel();
        
        $db = \Config\Database::connect();
        // Rekap per tahun
        $yearlyStats = $db->query("
            SELECT YEAR(created_at) as year,
                   COUNT(CASE WHEN status = 'approved' THEN 1 END) as approved,
                   COUNT(CASE WHEN status = 'rejected' THEN 1 END) as rejected,
                   COUNT(CASE WHEN status IN ('pending', 'process') THEN 1 END) as in_process,
                   COUNT(*) as total
            FROM requests
            GROUP BY YEAR(created_at)
            ORDER BY year DESC
        ")->getResultArray();
        
        // Format untuk Chart.js (5 tahun terakhir misal)
        $labels = [];
        $dataTotal = [];
        foreach (array_slice(array_reverse($yearlyStats), -5) as $stat) {
            $labels[] = $stat['year'];
            $dataTotal[] = $stat['total'];
        }

        $documentModel = new DocumentModel();
        $reports = $documentModel->where('category', 'statistik')
                                 ->where('is_active', 1)
                                 ->orderBy('created_at', 'DESC')
                                 ->findAll();

        $data = [
            'title' => 'Statistik Layanan Informasi Publik',
            'yearlyStats' => $yearlyStats,
            'chartLabels' => $labels,
            'chartData'   => $dataTotal,
            'reports'     => $reports
        ];

        return view('public/statistic', $data);
    }
}
