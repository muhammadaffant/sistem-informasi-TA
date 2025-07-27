<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\SablonCategory\SablonCategoryService; // <-- IMPORT SERVICE

class SablonCategoryController extends Controller
{
    private $sablonCategoryService;

    // INJECT SERVICE MELALUI CONSTRUCTOR
    public function __construct(SablonCategoryService $sablonCategoryService)
    {
        $this->sablonCategoryService = $sablonCategoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Path view Anda adalah 'admin.kategorisablon.index', jadi kita sesuaikan
        return view('admin.kategorisablon.index', [
            'title' => 'Kategori Sablon',
        ]);
    }

    /**
     * Method untuk menyediakan data ke DataTables.
     */
    public function data()
    {
        $result = $this->sablonCategoryService->getAll();

        return datatables($result)
            ->addIndexColumn()
            ->addColumn('aksi', fn($q) => $this->renderActionButtons($q))
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = $this->sablonCategoryService->create($request->all());

        if ($result['status'] === 'success') {
            return response()->json(['success' => true, 'message' => $result['message']], 200);
        }

        return response()->json(['success' => false, 'errors' => $result['errors'], 'message' => 'Input tidak valid.'], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $result = $this->sablonCategoryService->find($id);
        return response()->json(['data' => $result]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $result = $this->sablonCategoryService->update($id, $request->all());

        if ($result['status'] === 'success') {
            return response()->json(['success' => true, 'message' => $result['message']], 200);
        }

        return response()->json(['success' => false, 'errors' => $result['errors'], 'message' => 'Input tidak valid.'], 422);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Panggil service delete Anda
        $result = $this->sablonCategoryService->delete($id);

        // Periksa status yang dikembalikan oleh service
        if ($result['status'] === 'error') {
            // Jika error, kirim respon JSON dengan status HTTP 422
            // Ini akan memicu callback 'error' di AJAX Anda
            return response()->json([
                'message' => $result['message']
            ], 422);
        }

        // Jika berhasil, kirim respon sukses dengan status 200 (default)
        return response()->json([
            'message' => $result['message']
        ]);
    }

    /**
     * Render tombol aksi untuk DataTables.
     */
    protected function renderActionButtons($q)
    {
        // Sesuaikan route name dengan yang ada di file web.php ('admin.kategorisablon.')
        $editUrl = route('admin.kategorisablon.show', $q->id);
        $deleteUrl = route('admin.kategorisablon.destroy', $q->id);

        return '
            <button onclick="editForm(`' . $editUrl . '`)" class="btn btn-xs btn-primary mr-1"><i class="fas fa-pencil-alt"></i></button>
            <button onclick="deleteData(`' . $deleteUrl . '`, `' . $q->name . '`)" class="btn btn-xs btn-danger mr-1"><i class="fas fa-trash-alt"></i></button>
        ';
    }
}
