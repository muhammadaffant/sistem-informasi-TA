<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SubSubCategory\SubSubCategoryService;
use Illuminate\Http\Request;

class AdminSubSubCategoryController extends Controller
{
    private $subSubCategoryService;

    public function __construct(SubSubCategoryService $subSubCategoryService)
    {
        $this->subSubCategoryService = $subSubCategoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.subsubcategory.index',[
            'title' => 'SubSub Category'
        ]);
    }

    public function data()
    {
        $result = $this->subSubCategoryService->getData();

        return datatables($result)
            ->addIndexColumn()
            ->editColumn('aksi', fn($q) => $this->renderActionButtons($q))
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = $this->subSubCategoryService->store($request->all());

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
        $result = $this->subSubCategoryService->show($id);
        return response()->json(['data' => $result]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $result = $this->subSubCategoryService->update($request->all(), $id);

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
        $result = $this->subSubCategoryService->destroy($id);

        return response()->json([
            'message' => $result['message'],
        ]);
    }

    public function subSubCategorySearch($id)
    {
        $result = $this->subSubCategoryService->findById($id);
        
        return response()->json(['data' => $result]);
    }

    /**
     * Render aksi buttons
     */
    protected function renderActionButtons($q)
    {
        return '
                <button onclick="editForm(`' . route('admin.subsubcategory.show', $q->id) . '`)" class="btn btn-xs btn-primary mr-1"><i class="fas fa-pencil-alt"></i></button>
                <button onclick="deleteData(`' . route('admin.subsubcategory.destroy', $q->id) . '`, `' . $q->subsubcategory_name . '`)" class="btn btn-xs btn-danger mr-1"><i class="fas fa-trash-alt"></i></button>
            ';
    }
}
