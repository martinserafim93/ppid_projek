<?php

namespace App\Controllers;

use App\Models\DocumentModel;

class Data extends BaseController
{
    public function index()
    {
        $documentModel = new DocumentModel();
        
        $search = $this->request->getGet('search');
        
        // Asumsi data statistik disimpan di tabel documents dengan kategori 'statistik'
        $query = $documentModel->where('is_active', 1)->where('category', 'statistik');
        
        if (!empty($search)) {
            $query->like('title', $search);
        }
        
        $data = [
            'title'      => 'Data & Statistik',
            'documents'  => $query->orderBy('created_at', 'DESC')->paginate(10),
            'pager'      => $documentModel->pager,
            'search'     => $search,
            'breadcrumb' => [
                ['label' => 'Data & Infografis', 'url' => '#'],
                ['label' => 'Data & Statistik', 'active' => true]
            ]
        ];
        
        return view('public/data', $data);
    }
}
