<?php

namespace App\Controllers;

use App\Models\PublicInformationModel;

class Information extends BaseController
{
    public function index()
    {
        return redirect()->to('informasi-publik/berkala');
    }
    
    public function category($cat = 'berkala')
    {
        $infoModel = new PublicInformationModel();
        
        // Valid categories
        $validCategories = ['berkala', 'serta_merta', 'tersedia', 'dikecualikan'];
        
        // Handle variations (e.g. serta-merta from URL)
        $dbCategory = str_replace('-', '_', $cat);
        
        if (!in_array($dbCategory, $validCategories)) {
            $dbCategory = 'berkala';
            $cat = 'berkala';
        }
        
        $search = $this->request->getGet('search');
        $query = $infoModel->where('is_active', 1)->where('category', $dbCategory);
        
        if (!empty($search)) {
            $query->like('title', $search);
        }
        
        $data = [
            'title'       => 'Daftar Informasi Publik',
            'information' => $query->orderBy('year', 'DESC')->orderBy('created_at', 'DESC')->paginate(10),
            'pager'       => $infoModel->pager,
            'activeTab'   => $cat,
            'search'      => $search,
            'breadcrumb'  => [
                ['label' => 'Informasi Publik', 'active' => true]
            ]
        ];
        
        return view('public/information', $data);
    }
}
