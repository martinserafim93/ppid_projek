<?php

namespace App\Controllers;

use App\Models\PageModel;

class Profile extends BaseController
{
    public function show($slug)
    {
        $pageModel = new PageModel();
        
        $page = $pageModel->where('slug', $slug)->where('is_active', 1)->first();
        
        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $data = [
            'title' => $page['title'],
            'page'  => $page,
            'breadcrumb' => [
                ['label' => 'Profil', 'url' => '#'],
                ['label' => $page['title'], 'active' => true]
            ]
        ];
        
        return view('public/profile/show', $data);
    }
}
