<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PublicInformationModel;
use App\Models\CategoryModel;

class PublicInformations extends BaseController
{
    protected $infoModel;

    public function __construct()
    {
        $this->infoModel = new PublicInformationModel();
        helper(['form', 'url', 'upload', 'admin']);
    }

    public function index()
    {
        $category = $this->request->getGet('category');
        $categoryModel = new CategoryModel();
        $categories = $categoryModel->where('type', 'public-informations')->findAll();

        if (empty($category) && !empty($categories)) {
            $category = $categories[0]['slug']; // Default tab is the first category
        } elseif (empty($category)) {
            $category = 'berkala'; // Fallback
        }
        
        $query = $this->infoModel->where('category', $category)
                               ->orderBy('year', 'DESC')
                               ->orderBy('sort_order', 'ASC');

        $data = [
            'title'           => 'Kelola Informasi Publik',
            'informations'    => $query->paginate(10),
            'pager'           => $this->infoModel->pager,
            'active_category' => $category,
            'categories'      => $categories
        ];

        return view('admin/public-informations/index', $data);
    }

    public function create()
    {
        $categoryModel = new CategoryModel();

        $data = [
            'title'      => 'Tambah Informasi Publik Baru',
            'categories' => $categoryModel->where('type', 'public-informations')->findAll(),
        ];

        return view('admin/public-informations/create', $data);
    }

    public function store()
    {
        $rules = [
            'title'        => 'required|min_length[3]',
            'category'     => 'required',
            'sub_category' => 'permit_empty',
            'description'  => 'permit_empty',
            'file'         => 'permit_empty|uploaded[file]|max_size[file,10240]',
            'year'         => 'permit_empty|numeric|exact_length[4]',
            'sort_order'   => 'permit_empty|is_natural',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileName = null;
        $fileObj = $this->request->getFile('file');
        if ($fileObj && $fileObj->isValid() && !$fileObj->hasMoved()) {
            $fileName = uploadFile($fileObj, 'informations');
            if (!$fileName) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload file.');
            }
        }

        $data = [
            'title'        => $this->request->getPost('title'),
            'category'     => $this->request->getPost('category'),
            'sub_category' => $this->request->getPost('sub_category'),
            'description'  => $this->request->getPost('description'),
            'year'         => $this->request->getPost('year') ?: null,
            'sort_order'   => $this->request->getPost('sort_order') ?: 0,
            'is_active'    => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if ($fileName) {
            $data['file_path'] = 'uploads/informations/' . $fileName;
        }

        $this->infoModel->insert($data);

        return redirect()->to('admin/public-informations?category=' . $data['category'])->with('message', 'Informasi Publik berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $information = $this->infoModel->find($id);

        if (!$information) {
            return redirect()->to('admin/public-informations')->with('error', 'Informasi tidak ditemukan.');
        }

        $categoryModel = new CategoryModel();

        $data = [
            'title'       => 'Edit Informasi Publik',
            'information' => $information,
            'categories'  => $categoryModel->where('type', 'public-informations')->findAll(),
        ];

        return view('admin/public-informations/edit', $data);
    }

    public function update($id)
    {
        $information = $this->infoModel->find($id);

        if (!$information) {
            return redirect()->to('admin/public-informations')->with('error', 'Informasi tidak ditemukan.');
        }

        $rules = [
            'title'        => 'required|min_length[3]',
            'category'     => 'required',
            'sub_category' => 'permit_empty',
            'description'  => 'permit_empty',
            'file'         => 'permit_empty|uploaded[file]|max_size[file,10240]',
            'year'         => 'permit_empty|numeric|exact_length[4]',
            'sort_order'   => 'permit_empty|is_natural',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'        => $this->request->getPost('title'),
            'category'     => $this->request->getPost('category'),
            'sub_category' => $this->request->getPost('sub_category'),
            'description'  => $this->request->getPost('description'),
            'year'         => $this->request->getPost('year') ?: null,
            'sort_order'   => $this->request->getPost('sort_order') ?: 0,
            'is_active'    => $this->request->getPost('is_active') ? 1 : 0,
        ];

        // Handle file upload
        $fileObj = $this->request->getFile('file');
        if ($fileObj && $fileObj->isValid() && !$fileObj->hasMoved()) {
            $fileName = uploadFile($fileObj, 'informations');
            if ($fileName) {
                // Delete old file
                if (!empty($information['file_path'])) {
                    deleteFile($information['file_path']);
                }
                $data['file_path'] = 'uploads/informations/' . $fileName;
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload file baru.');
            }
        } elseif ($this->request->getPost('remove_file') == '1') {
            if (!empty($information['file_path'])) {
                deleteFile($information['file_path']);
            }
            $data['file_path'] = null;
        }

        $this->infoModel->update($id, $data);

        return redirect()->to('admin/public-informations?category=' . $data['category'])->with('message', 'Informasi Publik berhasil diupdate.');
    }

    public function delete($id)
    {
        $information = $this->infoModel->find($id);

        if (!$information) {
            return redirect()->to('admin/public-informations')->with('error', 'Informasi tidak ditemukan.');
        }

        $category = $information['category'];

        // Delete file if exist
        if (!empty($information['file_path'])) {
            deleteFile($information['file_path']);
        }

        $this->infoModel->delete($id);

        return redirect()->to('admin/public-informations?category=' . $category)->with('message', 'Informasi Publik berhasil dihapus.');
    }
}
