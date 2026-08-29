<?php

namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Document extends BaseController
{
    // Daftar dokumen per kategori: /dokumen/{slug}
    public function category($slug)
    {
        $categoryModel = new CategoryModel();
        $category = $categoryModel->where('type', 'documents')
                                  ->where('slug', $slug)
                                  ->first();

        if (! $category) {
            throw PageNotFoundException::forPageNotFound();
        }

        $documentModel = new DocumentModel();
        $search = $this->request->getGet('search');

        $query = $documentModel->where('is_active', 1)->where('category', $slug);
        if (! empty($search)) {
            $query->like('title', $search);
        }

        $documents = $query->orderBy('created_at', 'DESC')->paginate(10);

        // Pertahankan query pencarian saat pindah halaman
        $documentModel->pager->only(['search']);

        $data = [
            'title'      => $category['name'],
            'category'   => $category,
            'documents'  => $documents,
            'pager'      => $documentModel->pager,
            'search'     => $search,
            'breadcrumb' => [
                ['label' => $category['name'], 'active' => true],
            ],
        ];

        return view('public/documents', $data);
    }

    // Unduh + hitung: /dokumen/download/{id}
    public function download($id)
    {
        $documentModel = new DocumentModel();
        $document = $documentModel->where('is_active', 1)->find($id);

        if (! $document) {
            throw PageNotFoundException::forPageNotFound();
        }

        // Tambah hitungan unduhan
        $documentModel->update($id, ['download_count' => $document['download_count'] + 1]);

        // Arahkan ke file (PDF tampil inline di browser, seperti referensi)
        return redirect()->to(base_url($document['file_path']));
    }
}
