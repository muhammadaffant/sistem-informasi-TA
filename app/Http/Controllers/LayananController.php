<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Services\Layanan\LayananService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LayananController extends Controller
{
    private $layananService;

    public function __construct(LayananService $layananService)
    {
        $this->layananService = $layananService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.layanan.index', [
            'title' => 'Layanan'
        ]);
    }

    public function data()
    {
        $result = $this->layananService->getData();

        return datatables($result)
            ->addIndexColumn()
            ->editColumn('foto_layanan', fn($q) => $this->renderImageColumn($q))
            ->editColumn('aksi', fn($q) => $this->renderActionButtons($q))
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = $this->layananService->store($request->all());

        if ($result['status'] === 'success') {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
            ], 200);
        }

        return response()->json([
            'success' => false,
            'errors'  => $result['errors'],
            'message' => $result['message'],
        ], 422);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $result = $this->layananService->show($id);
        return response()->json(['data' => $result]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $result = $this->layananService->update($request->all(), $id);

        if ($result['status'] === 'success') {
            return response()->json([
                'success' => true,
                'message' => $result['message'],
            ], 200);
        }

        return response()->json([
            'success' => false,
            'errors'  => $result['errors'],
            'message' => $result['message'],
        ], 422);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $result = $this->layananService->destroy($id);

        return response()->json([
            'message' => $result['message'],
        ]);
    }

    /**
     * Render action buttons for DataTables.
     */
    protected function renderActionButtons($q)
    {
        return '
                <button onclick="editForm(`' . route('layanan.show', $q->id) . '`)" class="btn btn-xs btn-primary mr-1"><i class="fas fa-pencil-alt"></i></button>
                <button onclick="deleteData(`' . route('layanan.destroy', $q->id) . '`, `' . $q->nama_layanan . '`)" class="btn btn-xs btn-danger mr-1"><i class="fas fa-trash-alt"></i></button>
        ';
    }

    /**
     * Render image column for DataTables.
     */
    protected function renderImageColumn($q)
    {
        if ($q->foto_layanan) {
            $imageUrl = Storage::url($q->foto_layanan);
            return '<img src="' . $imageUrl . '" class="img-thumbnail" style="max-width: 100px;">';
        }

        return '<span class="text-muted">Tidak ada gambar</span>';
    }
}
