<?php

namespace App\Controllers;

use App\Models\InfographicModel;
use App\Models\PublicInformationModel;
use App\Models\DocumentModel;
use App\Models\PageModel;
// use App\Models\RequestModel; // If RequestModel exists later, uncomment

class Home extends BaseController
{
    public function index(): string
    {
        $infographicModel = new InfographicModel();
        $infoModel = new PublicInformationModel();
        $documentModel = new DocumentModel();

        // Calculate some statistics
        // For now, totalRequests might be dummy or from another table if available
        $totalRequests = 1250; // Placeholder
        $totalDocs = $documentModel->countAllResults();
        $totalInfo = $infoModel->countAllResults();

        $data = [
            'title' => 'Beranda',
            'infographics' => $infographicModel->orderBy('sort_order', 'ASC')->orderBy('created_at', 'DESC')->findAll(6),
            'latestInfo'   => $infoModel->orderBy('created_at', 'DESC')->findAll(4),
            'totalRequests'=> $totalRequests,
            'totalDocs'    => $totalDocs,
            'totalInfo'    => $totalInfo,
        ];

        return view('public/home', $data);
    }
}
