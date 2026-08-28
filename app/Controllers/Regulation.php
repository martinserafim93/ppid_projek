<?php

namespace App\Controllers;

use App\Models\RegulationModel;

class Regulation extends BaseController
{
    public function index()
    {
        $regulationModel = new RegulationModel();
        
        $type = $this->request->getGet('type');
        $search = $this->request->getGet('search');
        
        $query = $regulationModel->where('is_active', 1);
        
        if (!empty($type)) {
            $query->where('type', $type);
        }
        
        if (!empty($search)) {
            $query->groupStart()
                  ->like('title', $search)
                  ->orLike('regulation_number', $search)
                  ->groupEnd();
        }
        
        $data = [
            'title'       => 'Regulasi dan Produk Hukum',
            'regulations' => $query->orderBy('year', 'DESC')->paginate(10),
            'pager'       => $regulationModel->pager,
            'type'        => $type,
            'search'      => $search,
            'breadcrumb'  => [
                ['label' => 'Regulasi', 'active' => true]
            ]
        ];
        
        return view('public/regulation', $data);
    }
}
