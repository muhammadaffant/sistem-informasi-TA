<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\JenisSablon\JenisSablonService;
use App\Models\SablonCategory; 

class AdminJenisSablonController extends Controller
{
     private $jenissablonService;

    public function __construct(JenisSablonService $jenissablonService)
    {
        $this->jenissablonService = $jenissablonService;
    }

    public function index()
    {
        // MODIFIKASI: Ambil data kategori dan kirim ke view
        $categories = SablonCategory::orderBy('name')->get();

        return view('admin.jenissablon.index',[
            'title' => 'Data Jenis Sablon',
            'categories' => $categories // <-- KIRIM KE VIEW
        ]);
    }

    public function data()
    {
        $result = $this->jenissablonService->getData();

        return datatables($result)
            ->addIndexColumn()
            // MODIFIKASI: Tambahkan kolom untuk menampilkan nama kategori
            ->addColumn('kategori', function($q) {
                // Ambil nama dari relasi 'sablonCategory' yang sudah di-eager load
                return $q->sablonCategory->name ?? 'N/A';
            })
            ->editColumn('aksi', fn($q) => $this->renderActionButtons($q))
            ->escapeColumns([])
            ->make(true);
    }

    // ... method store, show, update, destroy, renderActionButtons tetap sama ...
    public function store(Request $request)
    {
        $result = $this->jenissablonService->store($request->all());
        if ($result['status'] === 'success') {
            return response()->json(['success' => true,'message' => $result['message'],], 200);
        }
        return response()->json(['success' => false, 'errors' => $result['errors'], 'message' => $result['message'],], 422);
    }
    public function show($id)
    {
        $result = $this->jenissablonService->show($id);
        return response()->json(['data' => $result]);
    }
    public function update(Request $request, $id)
    {
        $result = $this->jenissablonService->update($request->all(), $id);
        if ($result['status'] === 'success') {
            return response()->json(['success' => true, 'message' => $result['message'],], 200);
        }
        return response()->json(['success' => false, 'errors' => $result['errors'], 'message' => $result['message'],], 422);
    }
    public function destroy($id)
    {
        $result = $this->jenissablonService->destroy($id);
        return response()->json(['message' => $result['message'],]);
    }
    protected function renderActionButtons($q)
    {
        return '
                <button onclick="editForm(`' . route('admin.jenissablon.show', $q->id) . '`)" class="btn btn-xs btn-primary mr-1"><i class="fas fa-pencil-alt"></i></button>
                <button onclick="deleteData(`' . route('admin.jenissablon.destroy', $q->id) . '`, `' . $q->nama_sablon . '`)" class="btn btn-xs btn-danger mr-1"><i class="fas fa-trash-alt"></i></button>
            ';
    }
}
