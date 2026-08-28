<?php

namespace App\Controllers;

use App\Models\InfographicModel;

class Infographic extends BaseController
{
    public function index()
    {
        $infographicModel = new InfographicModel();
        
        $data = [
            'title'        => 'Galeri Infografis',
            'infographics' => $infographicModel->where('is_active', 1)
                                               ->orderBy('sort_order', 'ASC')
                                               ->orderBy('created_at', 'DESC')
                                               ->paginate(12),
            'pager'        => $infographicModel->pager,
            'breadcrumb'   => [
                ['label' => 'Data & Infografis', 'url' => '#'],
                ['label' => 'Galeri Infografis', 'active' => true]
            ]
        ];
        
        return view('public/infographic', $data);
    }
}
