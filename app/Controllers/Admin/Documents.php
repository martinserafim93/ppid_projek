<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DocumentModel;

class Documents extends BaseController
{
    protected $documentModel;

    public function __construct()
    {
        $this->documentModel = new DocumentModel();
        helper(['form', 'url', 'upload', 'admin']);
    }

    public function index()
    {
        $keyword = $this->request->getGet('q');
        
        $query = $this->documentModel->orderBy('created_at', 'DESC');
        
        if (!empty($keyword)) {
            $query = $query->groupStart()
                           ->like('title', $keyword)
                           ->orLike('description', $keyword)
                           ->groupEnd();
        }

        $data = [
            'title' => 'Kelola Dokumen Publik',
            'documents' => $query->paginate(10),
            'pager' => $this->documentModel->pager,
            'keyword' => $keyword
        ];

        return view('admin/documents/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Upload Dokumen Baru'
        ];

        return view('admin/documents/create', $data);
    }

    public function store()
    {
        $rules = [
            'title'       => 'required|min_length[3]',
            'description' => 'permit_empty',
            'file'        => 'uploaded[file]|max_size[file,15360]|ext_in[file,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar]',
            'is_active'   => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $fileObj = $this->request->getFile('file');
        if (!$fileObj->isValid() || $fileObj->hasMoved()) {
            return redirect()->back()->withInput()->with('error', 'File tidak valid atau sudah dipindahkan.');
        }

        // Auto-detect file info
        $fileSize = $fileObj->getSize(); // in bytes
        $fileType = $fileObj->getMimeType();
        
        $fileName = uploadFile($fileObj, 'documents');
        if (!$fileName) {
            return redirect()->back()->withInput()->with('error', 'Gagal mengupload dokumen.');
        }

        $data = [
            'title'          => $this->request->getPost('title'),
            'description'    => $this->request->getPost('description'),
            'file_path'      => 'uploads/documents/' . $fileName,
            'file_size'      => $fileSize,
            'file_type'      => $fileType,
            'download_count' => 0,
            'uploaded_by'    => session()->get('user_id') ?: 1, // Fallback ke 1 jika session tak ada
            'is_active'      => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->documentModel->insert($data);

        return redirect()->to('admin/documents')->with('message', 'Dokumen berhasil diupload.');
    }

    public function edit($id)
    {
        $document = $this->documentModel->find($id);

        if (!$document) {
            return redirect()->to('admin/documents')->with('error', 'Dokumen tidak ditemukan.');
        }

        $data = [
            'title'    => 'Edit Dokumen',
            'document' => $document
        ];

        return view('admin/documents/edit', $data);
    }

    public function update($id)
    {
        $document = $this->documentModel->find($id);

        if (!$document) {
            return redirect()->to('admin/documents')->with('error', 'Dokumen tidak ditemukan.');
        }

        $rules = [
            'title'       => 'required|min_length[3]',
            'description' => 'permit_empty',
            'file'        => 'permit_empty|uploaded[file]|max_size[file,15360]|ext_in[file,pdf,doc,docx,xls,xlsx,ppt,pptx,zip,rar]',
            'is_active'   => 'permit_empty'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ];

        // Handle file upload if new file is provided
        $fileObj = $this->request->getFile('file');
        if ($fileObj && $fileObj->isValid() && !$fileObj->hasMoved()) {
            
            // Delete old file
            if (!empty($document['file_path'])) {
                deleteFile($document['file_path']);
            }
            
            // Auto-detect new file info
            $fileSize = $fileObj->getSize();
            $fileType = $fileObj->getMimeType();
            
            $fileName = uploadFile($fileObj, 'documents');
            if ($fileName) {
                $data['file_path'] = 'uploads/documents/' . $fileName;
                $data['file_size'] = $fileSize;
                $data['file_type'] = $fileType;
            } else {
                return redirect()->back()->withInput()->with('error', 'Gagal mengupload file baru.');
            }
        }

        $this->documentModel->update($id, $data);

        return redirect()->to('admin/documents')->with('message', 'Info dokumen berhasil diupdate.');
    }

    public function delete($id)
    {
        $document = $this->documentModel->find($id);

        if (!$document) {
            return redirect()->to('admin/documents')->with('error', 'Dokumen tidak ditemukan.');
        }

        // Delete file
        if (!empty($document['file_path'])) {
            deleteFile($document['file_path']);
        }

        $this->documentModel->delete($id);

        return redirect()->to('admin/documents')->with('message', 'Dokumen berhasil dihapus.');
    }

    public function download($id)
    {
        $document = $this->documentModel->find($id);

        if (!$document) {
            return redirect()->back()->with('error', 'Dokumen tidak ditemukan.');
        }

        // Increment download count
        $this->documentModel->update($id, ['download_count' => $document['download_count'] + 1]);

        // Trigger download
        return $this->response->download(FCPATH . $document['file_path'], null);
    }
}
