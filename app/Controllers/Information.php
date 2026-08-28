<?php

namespace App\Controllers;

use App\Models\PublicInformationModel;
use App\Models\CategoryModel;

class Information extends BaseController
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->where('type', 'public-informations')->findAll();
        
        $defaultCat = !empty($categories) ? $categories[0]['slug'] : 'berkala';
        return redirect()->to('informasi-publik/' . $defaultCat);
    }
    
    public function category($cat = 'berkala')
    {
        $infoModel = new PublicInformationModel();
        $categoryModel = new CategoryModel();
        
        $categories = $categoryModel->where('type', 'public-informations')->findAll();
        
        $validCategories = [];
        foreach ($categories as $c) {
            $validCategories[] = $c['slug'];
        }
        
        $dbCategory = $cat; // slugs shouldn't need dash conversion if they match directly, but fallback just in case
        
        if (!in_array($dbCategory, $validCategories)) {
            $dbCategory = str_replace('-', '_', $cat);
            if (!in_array($dbCategory, $validCategories)) {
                $dbCategory = !empty($categories) ? $categories[0]['slug'] : 'berkala';
                $cat = $dbCategory;
            }
        }
        
        $search = $this->request->getGet('search');
        $subCat = $this->request->getGet('sub_category');
        $yearFilter = $this->request->getGet('year');
        
        // Execute dropdown queries FIRST using fresh builder instances or cloning
        // Get distinct sub_categories for filter dropdown
        $subCategories = $infoModel->select('sub_category')
            ->where('is_active', 1)
            ->where('category', $dbCategory)
            ->where('sub_category !=', null)
            ->where('sub_category !=', '')
            ->groupBy('sub_category')
            ->orderBy('sub_category', 'ASC')
            ->findAll();
            
        // Get distinct years for filter dropdown
        $years = $infoModel->select('year')
            ->where('is_active', 1)
            ->where('category', $dbCategory)
            ->where('year !=', null)
            ->groupBy('year')
            ->orderBy('year', 'DESC')
            ->findAll();
            
        // NOW build the main query
        $infoModel->where('is_active', 1)->where('category', $dbCategory);
        
        if (!empty($search)) {
            $infoModel->like('title', $search);
        }
        if (!empty($subCat)) {
            $infoModel->where('sub_category', $subCat);
        }
        if (!empty($yearFilter)) {
            $infoModel->where('year', $yearFilter);
        }
        
        $data = [
            'title'       => 'Daftar Informasi Publik',
            'information' => $infoModel->orderBy('year', 'DESC')->orderBy('created_at', 'DESC')->paginate(10),
            'pager'       => $infoModel->pager,
            'activeTab'   => $cat,
            'search'      => $search,
            'subCat'      => $subCat,
            'yearFilter'  => $yearFilter,
            'categories'  => $categories,
            'subCategories'=> $subCategories,
            'years'       => $years,
            'breadcrumb'  => [
                ['label' => 'Informasi Publik', 'active' => true]
            ]
        ];
        
        return view('public/information', $data);
    }
}
