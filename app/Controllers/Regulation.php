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

    public function show($slug)
    {
        $regulationModel = new RegulationModel();
        $regulation = $regulationModel->where('slug', $slug)->where('is_active', 1)->first();
        if (! $regulation) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $categoryModel = new CategoryModel();
        $category = $categoryModel->where('type', 'regulations')->where('slug', $regulation['type'])->first();

        return view('public/regulation_detail', [
            'title'      => $regulation['title'],
            'regulation' => $regulation,
            'category'   => $category,
            'breadcrumb' => [
                ['label' => 'Regulasi', 'url' => base_url('regulasi')],
                ['label' => $regulation['title'], 'active' => true],
            ],
        ]);
    }
}
