<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PageModel;
use App\Models\RegulationModel;
use App\Models\PublicInformationModel;
use App\Models\InfographicModel;

class Dashboard extends BaseController
{
    protected $pageModel;
    protected $regulationModel;
    protected $informationModel;
    protected $infographicModel;

    public function __construct()
    {
        helper(['admin', 'url']);
        
        $this->pageModel = new PageModel();
        $this->regulationModel = new RegulationModel();
        $this->informationModel = new PublicInformationModel();
        $this->infographicModel = new InfographicModel();
    }

    public function index()
    {
        // Check if user is logged in
        if (!session()->get('logged_in')) {
            return redirect()->to('/auth/login');
        }

        // Get statistics from database
        $data = [
            'title' => 'Dashboard',
            'user_name' => session()->get('user_name') ?? 'Administrator',
            'greeting' => getGreeting(),
            'totalPages' => $this->pageModel->countAllResults(),
            'totalRegulations' => $this->regulationModel->countAllResults(),
            'totalInformations' => $this->informationModel->countAllResults(),
            'totalInfographics' => $this->infographicModel->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }
}
