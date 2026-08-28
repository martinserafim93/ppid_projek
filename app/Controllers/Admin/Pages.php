<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PageModel;

class Pages extends BaseController
{
    protected $pageModel;

    public function __construct()
    {
        $this->pageModel = new PageModel();
        helper(['form', 'url', 'slug', 'upload', 'admin']);
    }

    public function index()
    {
        $category = $this->request->getGet('category');
        $search   = $this->request->getGet('search');
        $status   = $this->request->getGet('status');
        
        $query = $this->pageModel->orderBy('sort_order', 'ASC')->orderBy('created_at', 'DESC');
        
        if (!empty($category)) {
            $query = $query->where('category', $category);
        }

        if (!empty($search)) {
            $query = $query->like('title', $search);
        }

        if ($status !== null && $status !== '') {
            $query = $query->where('is_active', (int) $status);
        }

        $data = [
            'title'    => 'Kelola Halaman',
            'pages'    => $query->paginate(10),
            'pager'    => $this->pageModel->pager,
            'category' => $category,
            'search'   => $search,
            'status'   => $status,
        ];

        return view('admin/pages/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Halaman Baru'
        ];

        return view('admin/pages/create', $data);
    }

    public function store()
    {
        $rules = [
            'title'    => 'required|min_length[3]',
            'category' => 'required|in_list[profil_kanwil,profil_ppid,standar_layanan,layanan_informasi]',
            'content'  => 'required',
            'image'    => 'permit_empty|uploaded[image]|max_size[image,2048]|is_image[image]',
            'file'     => 'permit_empty|uploaded[file]|max_size[file,10240]',
            'sort_order' => 'permit_empty|is_natural',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageName = null;
        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $options = ['resize' => true, 'maxWidth' => 1200];
            $imageName = uploadFile($imageFile, 'pages', $options);
            if (!$imageName) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload gambar.');
            }
        }

        $fileName = null;
        $fileObj = $this->request->getFile('file');
        if ($fileObj && $fileObj->isValid() && !$fileObj->hasMoved()) {
            $fileName = uploadFile($fileObj, 'pages/files');
            if (!$fileName) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload dokumen.');
            }
        }

        $title = $this->request->getPost('title');
        
        $data = [
            'title'      => $title,
            'slug'       => createSlugFromTitle($title, PageModel::class),
            'category'   => $this->request->getPost('category'),
            'content'    => $this->request->getPost('content'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if ($imageName) {
            $data['image'] = 'uploads/pages/' . $imageName;
        }

        if ($fileName) {
            $data['file_path'] = 'uploads/pages/files/' . $fileName;
        }

        $this->pageModel->insert($data);

        return redirect()->to('admin/pages')->with('message', 'Halaman berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $page = $this->pageModel->find($id);

        if (!$page) {
            return redirect()->to('admin/pages')->with('error', 'Halaman tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Halaman',
            'page'  => $page
        ];

        return view('admin/pages/edit', $data);
    }

    public function update($id)
    {
        $page = $this->pageModel->find($id);

        if (!$page) {
            return redirect()->to('admin/pages')->with('error', 'Halaman tidak ditemukan.');
        }

        $rules = [
            'title'    => 'required|min_length[3]',
            'category' => 'required|in_list[profil_kanwil,profil_ppid,standar_layanan,layanan_informasi]',
            'content'  => 'required',
            'image'    => 'permit_empty|uploaded[image]|max_size[image,2048]|is_image[image]',
            'file'     => 'permit_empty|uploaded[file]|max_size[file,10240]',
            'sort_order' => 'permit_empty|is_natural',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $title = $this->request->getPost('title');
        
        $data = [
            'title'      => $title,
            'category'   => $this->request->getPost('category'),
            'content'    => $this->request->getPost('content'),
            'sort_order' => $this->request->getPost('sort_order') ?: 0,
            'is_active'  => $this->request->getPost('is_active') ? 1 : 0,
        ];

        // Update slug if title changed
        if ($title !== $page['title']) {
            $data['slug'] = createSlugFromTitle($title, PageModel::class, $id);
        }

        // Handle image upload
        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $options = ['resize' => true, 'maxWidth' => 1200];
            $imageName = uploadFile($imageFile, 'pages', $options);
            if ($imageName) {
                // Delete old image
                if (!empty($page['image'])) {
                    deleteFile($page['image']);
                }
                $data['image'] = 'uploads/pages/' . $imageName;
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload gambar baru.');
            }
        } elseif ($this->request->getPost('remove_image') == '1') {
            if (!empty($page['image'])) {
                deleteFile($page['image']);
            }
            $data['image'] = null;
        }

        // Handle file upload
        $fileObj = $this->request->getFile('file');
        if ($fileObj && $fileObj->isValid() && !$fileObj->hasMoved()) {
            $fileName = uploadFile($fileObj, 'pages/files');
            if ($fileName) {
                // Delete old file
                if (!empty($page['file_path'])) {
                    deleteFile($page['file_path']);
                }
                $data['file_path'] = 'uploads/pages/files/' . $fileName;
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload dokumen baru.');
            }
        } elseif ($this->request->getPost('remove_file') == '1') {
            if (!empty($page['file_path'])) {
                deleteFile($page['file_path']);
            }
            $data['file_path'] = null;
        }

        $this->pageModel->update($id, $data);

        return redirect()->to('admin/pages')->with('message', 'Halaman berhasil diupdate.');
    }

    public function delete($id)
    {
        $page = $this->pageModel->find($id);

        if (!$page) {
            return redirect()->to('admin/pages')->with('error', 'Halaman tidak ditemukan.');
        }

        // Delete files if exist
        if (!empty($page['image'])) {
            deleteFile($page['image']);
        }
        if (!empty($page['file_path'])) {
            deleteFile($page['file_path']);
        }

        $this->pageModel->delete($id);

        return redirect()->to('admin/pages')->with('message', 'Halaman berhasil dihapus.');
    }
}
