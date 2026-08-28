<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RegulationModel;
use App\Models\CategoryModel;

class Regulations extends BaseController
{
    protected $regulationModel;

    public function __construct()
    {
        $this->regulationModel = new RegulationModel();
        helper(['form', 'url', 'upload', 'admin']);
    }

    public function index()
    {
        $type = $this->request->getGet('type');
        
        $query = $this->regulationModel->orderBy('year', 'DESC')->orderBy('sort_order', 'ASC');
        
        if (!empty($type)) {
            $query = $query->where('type', $type);
        }

        $categoryModel = new CategoryModel();

        $data = [
            'title'       => 'Kelola Regulasi',
            'regulations' => $query->paginate(10),
            'pager'       => $this->regulationModel->pager,
            'type'        => $type,
            'categories'  => $categoryModel->where('type', 'regulations')->findAll(),
        ];

        return view('admin/regulations/index', $data);
    }

    public function create()
    {
        $categoryModel = new CategoryModel();

        $data = [
            'title'      => 'Tambah Regulasi Baru',
            'categories' => $categoryModel->where('type', 'regulations')->findAll(),
        ];

        return view('admin/regulations/create', $data);
    }

    public function store()
    {
        $rules = [
            'title'       => 'required|min_length[3]',
            'type'        => 'required',
            'number'      => 'permit_empty',
            'year'        => 'permit_empty|numeric|exact_length[4]',
            'description' => 'permit_empty',
            'file'        => 'permit_empty|uploaded[file]|max_size[file,10240]|ext_in[file,pdf]',
            'sort_order'  => 'permit_empty|is_natural',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileName = null;
        $fileObj = $this->request->getFile('file');
        if ($fileObj && $fileObj->isValid() && !$fileObj->hasMoved()) {
            // override allowed types for our helper function just in case
            $options = ['allowedTypes' => ['application/pdf']];
            $fileName = uploadFile($fileObj, 'regulations', $options);
            if (!$fileName) {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload file PDF.');
            }
        }

        $data = [
            'title'       => $this->request->getPost('title'),
            'type'        => $this->request->getPost('type'),
            'number'      => $this->request->getPost('number'),
            'year'        => $this->request->getPost('year') ?: null,
            'description' => $this->request->getPost('description'),
            'sort_order'  => $this->request->getPost('sort_order') ?: 0,
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ];

        if ($fileName) {
            $data['file_path'] = 'uploads/regulations/' . $fileName;
        }

        $this->regulationModel->insert($data);

        return redirect()->to('admin/regulations')->with('message', 'Regulasi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $regulation = $this->regulationModel->find($id);

        if (!$regulation) {
            return redirect()->to('admin/regulations')->with('error', 'Regulasi tidak ditemukan.');
        }

        $categoryModel = new CategoryModel();

        $data = [
            'title'      => 'Edit Regulasi',
            'regulation' => $regulation,
            'categories' => $categoryModel->where('type', 'regulations')->findAll(),
        ];

        return view('admin/regulations/edit', $data);
    }

    public function update($id)
    {
        $regulation = $this->regulationModel->find($id);

        if (!$regulation) {
            return redirect()->to('admin/regulations')->with('error', 'Regulasi tidak ditemukan.');
        }

        $rules = [
            'title'       => 'required|min_length[3]',
            'type'        => 'required',
            'number'      => 'permit_empty',
            'year'        => 'permit_empty|numeric|exact_length[4]',
            'description' => 'permit_empty',
            'file'        => 'permit_empty|uploaded[file]|max_size[file,10240]|ext_in[file,pdf]',
            'sort_order'  => 'permit_empty|is_natural',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'       => $this->request->getPost('title'),
            'type'        => $this->request->getPost('type'),
            'number'      => $this->request->getPost('number'),
            'year'        => $this->request->getPost('year') ?: null,
            'description' => $this->request->getPost('description'),
            'sort_order'  => $this->request->getPost('sort_order') ?: 0,
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ];

        // Handle file upload
        $fileObj = $this->request->getFile('file');
        if ($fileObj && $fileObj->isValid() && !$fileObj->hasMoved()) {
            $options = ['allowedTypes' => ['application/pdf']];
            $fileName = uploadFile($fileObj, 'regulations', $options);
            if ($fileName) {
                // Delete old file
                if (!empty($regulation['file_path'])) {
                    deleteFile($regulation['file_path']);
                }
                $data['file_path'] = 'uploads/regulations/' . $fileName;
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload file PDF baru.');
            }
        } elseif ($this->request->getPost('remove_file') == '1') {
            if (!empty($regulation['file_path'])) {
                deleteFile($regulation['file_path']);
            }
            $data['file_path'] = null;
        }

        $this->regulationModel->update($id, $data);

        return redirect()->to('admin/regulations')->with('message', 'Regulasi berhasil diupdate.');
    }

    public function delete($id)
    {
        $regulation = $this->regulationModel->find($id);

        if (!$regulation) {
            return redirect()->to('admin/regulations')->with('error', 'Regulasi tidak ditemukan.');
        }

        // Delete file if exist
        if (!empty($regulation['file_path'])) {
            deleteFile($regulation['file_path']);
        }

        $this->regulationModel->delete($id);

        return redirect()->to('admin/regulations')->with('message', 'Regulasi berhasil dihapus.');
    }
}
