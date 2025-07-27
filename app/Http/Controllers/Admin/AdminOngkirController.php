<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Ongkir\OngkirService;
use Illuminate\Http\Request;

class AdminOngkirController extends Controller
{
    private $ongkirService;

    public function __construct(OngkirService $ongkirService)
    {
        $this->ongkirService = $ongkirService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.ongkir.index');
    }

    public function data()
    {
        $result = $this->ongkirService->getData();

        return datatables($result)
            ->addIndexColumn()
            ->editColumn('province_id', fn($q) => $this->renderProvinceColumn($q))
            ->editColumn('regency_id', fn($q) => $this->renderRegencyColumn($q))
            ->editColumn('district_id', fn($q) => $this->renderDistrictColumn($q))
            ->editColumn('village_id', fn($q) => $this->renderVillageColumn($q))
            ->editColumn('aksi', fn($q) => $this->renderActionButtons($q))
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = $this->ongkirService->store($request->all());

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
        $result = $this->ongkirService->show($id);
        return response()->json(['data' => $result]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $result = $this->ongkirService->update($request->all(), $id);

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
        $result = $this->ongkirService->destroy($id);

        return response()->json([
            'message' => $result['message'],
        ]);
    }

    public function provinceSearch()
    {
        $result = $this->ongkirService->getProvince();
        return response()->json(['data' => $result]);
    }

    /**
     * Render aksi buttons
     */
    protected function renderActionButtons($q)
    {
        return '
                <button onclick="editForm(`' . route('admin.ongkir.show', $q->id) . '`)" class="btn btn-xs btn-primary mr-1"><i class="fas fa-pencil-alt"></i></button>
                <button onclick="deleteData(`' . route('admin.ongkir.destroy', $q->id) . '`, `' . $q->ongkir_name . '`)" class="btn btn-xs btn-danger mr-1"><i class="fas fa-trash-alt"></i></button>
            ';
    }

    public function renderProvinceColumn($q)
    {
        return $q->province->name;
    }

    public function renderRegencyColumn($q)
    {
        return $q->regency->name;
    }

    public function renderDistrictColumn($q)
    {
        return $q->district->name;
    }

    public function renderVillageColumn($q)
    {
        return $q->village->name;
    }
}
