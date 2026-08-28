<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\InfographicModel;

class Infographics extends BaseController
{
    protected $infographicModel;

    public function __construct()
    {
        $this->infographicModel = new InfographicModel();
        helper(['form', 'url', 'upload', 'admin']);
    }

    public function index()
    {
        $data = [
            'title' => 'Kelola Infografis',
            'infographics' => $this->infographicModel->orderBy('sort_order', 'ASC')->orderBy('created_at', 'DESC')->paginate(12),
            'pager' => $this->infographicModel->pager,
        ];

        return view('admin/infographics/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Infografis Baru'
        ];

        return view('admin/infographics/create', $data);
    }

    public function store()
    {
        $rules = [
            'title'       => 'required|min_length[3]',
            'image'       => 'uploaded[image]|max_size[image,5120]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
            'description' => 'permit_empty',
            'sort_order'  => 'permit_empty|is_natural',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageName = null;
        $imageFile = $this->request->getFile('image');
        
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $imageName = uploadFile($imageFile, 'infographics');
            if (!$imageName) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload gambar.');
            }
        }

        $data = [
            'title'       => $this->request->getPost('title'),
            'image'       => 'uploads/infographics/' . $imageName,
            'description' => $this->request->getPost('description'),
            'sort_order'  => $this->request->getPost('sort_order') ?: 0,
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->infographicModel->insert($data);

        return redirect()->to('admin/infographics')->with('message', 'Infografis berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $infographic = $this->infographicModel->find($id);

        if (!$infographic) {
            return redirect()->to('admin/infographics')->with('error', 'Infografis tidak ditemukan.');
        }

        $data = [
            'title'       => 'Edit Infografis',
            'infographic' => $infographic
        ];

        return view('admin/infographics/edit', $data);
    }

    public function update($id)
    {
        $infographic = $this->infographicModel->find($id);

        if (!$infographic) {
            return redirect()->to('admin/infographics')->with('error', 'Infografis tidak ditemukan.');
        }

        $rules = [
            'title'       => 'required|min_length[3]',
            'image'       => 'permit_empty|uploaded[image]|max_size[image,5120]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
            'description' => 'permit_empty',
            'sort_order'  => 'permit_empty|is_natural',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'sort_order'  => $this->request->getPost('sort_order') ?: 0,
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ];

        // Handle image upload
        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $imageName = uploadFile($imageFile, 'infographics');
            if ($imageName) {
                // Delete old image
                if (!empty($infographic['image'])) {
                    deleteFile($infographic['image']);
                }
                $data['image'] = 'uploads/infographics/' . $imageName;
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload gambar baru.');
            }
        }

        $this->infographicModel->update($id, $data);

        return redirect()->to('admin/infographics')->with('message', 'Infografis berhasil diupdate.');
    }

    public function delete($id)
    {
        $infographic = $this->infographicModel->find($id);

        if (!$infographic) {
            return redirect()->to('admin/infographics')->with('error', 'Infografis tidak ditemukan.');
        }

        // Delete file if exist
        if (!empty($infographic['image'])) {
            deleteFile($infographic['image']);
        }

        $this->infographicModel->delete($id);

        return redirect()->to('admin/infographics')->with('message', 'Infografis berhasil dihapus.');
    }
}
