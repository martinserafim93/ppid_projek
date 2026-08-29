<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class Category extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index($type)
    {
        $data = [
            'title'      => 'Kelola Kategori ' . ucfirst($type),
            'categories' => $this->categoryModel->where('type', $type)->findAll(),
            'type'       => $type,
        ];

        return view('admin/categories/index', $data);
    }

    public function create($type)
    {
        $data = [
            'title' => 'Tambah Kategori ' . ucfirst($type),
            'type'  => $type,
        ];

        return view('admin/categories/form', $data);
    }

    public function store()
    {
        $type = $this->request->getPost('type');
        $name = $this->request->getPost('name');
        
        $rules = [
            'name' => 'required|min_length[3]|max_length[255]',
            'type' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoryModel->save([
            'name'        => $name,
            'slug'        => url_title($name, '-', true),
            'type'        => $type,
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('admin/categories/' . $type)->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        $data = [
            'title'    => 'Edit Kategori ' . ucfirst($category['type']),
            'type'     => $category['type'],
            'category' => $category,
        ];

        return view('admin/categories/form', $data);
    }

    public function update($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        $type = $category['type'];
        $name = $this->request->getPost('name');

        $rules = [
            'name' => 'required|min_length[3]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoryModel->update($id, [
            'name'        => $name,
            // Slug tidak diupdate saat edit agar relasi dengan data lama tidak terputus
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to('admin/categories/' . $type)->with('success', 'Kategori berhasil diperbarui.');
    }

    public function delete($id)
    {
        $category = $this->categoryModel->find($id);

        if (!$category) {
            return redirect()->back()->with('error', 'Kategori tidak ditemukan.');
        }

        $type = $category['type'];
        $this->categoryModel->delete($id);

        return redirect()->to('admin/categories/' . $type)->with('success', 'Kategori berhasil dihapus.');
    }
}
