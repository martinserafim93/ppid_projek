<?php

namespace App\Controllers;

use App\Models\PageModel;

class Service extends BaseController
{
    public function show($slug)
    {
        $pageModel = new PageModel();
        
        $page = $pageModel->where('slug', $slug)->where('is_active', 1)->first();
        
        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        // Determine breadcrumb root from uri
        $uri = service('uri');
        $segment1 = $uri->getTotalSegments() >= 1 ? $uri->getSegment(1) : 'layanan';
        $rootLabel = $segment1 === 'informasi' ? 'Layanan Informasi' : 'Standar Layanan';
        
        $data = [
            'title' => $page['title'],
            'page'  => $page,
            'breadcrumb' => [
                ['label' => $rootLabel, 'url' => '#'],
                ['label' => $page['title'], 'active' => true]
            ]
        ];
        
        return view('public/service/show', $data);
    }
}
