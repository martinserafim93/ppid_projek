<?php

namespace App\Controllers;

use App\Models\InfographicModel;
use App\Models\PublicInformationModel;
use App\Models\DocumentModel;
use App\Models\PageModel;
use App\Models\RequestModel;

class Home extends BaseController
{
    public function index(): string
    {
        $infographicModel = new InfographicModel();
        $infoModel = new PublicInformationModel();
        $documentModel = new DocumentModel();

        // Calculate some statistics
        $requestModel = new RequestModel();
        $totalRequests = $requestModel->countAllResults();
        $totalDocs = $documentModel->where('is_active', 1)->countAllResults();
        $totalInfo = $infoModel->where('is_active', 1)->countAllResults();

        $data = [
            'title' => 'Beranda',
            'infographics' => $infographicModel->orderBy('sort_order', 'ASC')->orderBy('created_at', 'DESC')->findAll(6),
            'latestInfo'   => $infoModel->where('is_active', 1)->orderBy('created_at', 'DESC')->findAll(4),
            'totalRequests'=> $totalRequests,
            'totalDocs'    => $totalDocs,
            'totalInfo'    => $totalInfo,
        ];

        return view('public/home', $data);
    }
}
