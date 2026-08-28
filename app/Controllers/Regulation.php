<?php

namespace App\Controllers;

use App\Models\RegulationModel;
use App\Models\CategoryModel;

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
                  ->orLike('number', $search)
                  ->groupEnd();
        }
        
        $categoryModel = new CategoryModel();

        $data = [
            'title'       => 'Regulasi dan Produk Hukum',
            'regulations' => $query->orderBy('year', 'DESC')->paginate(10),
            'pager'       => $regulationModel->pager,
            'type'        => $type,
            'search'      => $search,
            'categories'  => $categoryModel->where('type', 'regulations')->findAll(),
            'breadcrumb'  => [
                ['label' => 'Regulasi', 'active' => true]
            ]
        ];
        
        return view('public/regulation', $data);
    }
}
