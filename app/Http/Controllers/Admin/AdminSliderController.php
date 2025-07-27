<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Slider\SliderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSliderController extends Controller
{
    private $sliderService;

    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.slider.index',[
            'title' => 'Slider'
        ]);
    }

    public function data()
    {
        $result = $this->sliderService->getData();

        return datatables($result)
            ->addIndexColumn()
            ->editColumn('slider_img', fn($q) => $this->renderImageColumn($q))
            ->editColumn('aksi', fn($q) => $this->renderActionButtons($q))
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $result = $this->sliderService->store($request->all());

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
        $result = $this->sliderService->show($id);
        return response()->json(['data' => $result]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $result = $this->sliderService->update($request->all(), $id);

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
        $result = $this->sliderService->destroy($id);

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
                <button onclick="editForm(`' . route('admin.slider.show', $q->id) . '`)" class="btn btn-xs btn-primary mr-1"><i class="fas fa-pencil-alt"></i></button>
                <button onclick="deleteData(`' . route('admin.slider.destroy', $q->id) . '`, `' . $q->title . '`)" class="btn btn-xs btn-danger mr-1"><i class="fas fa-trash-alt"></i></button>
        ';
    }

    /**
     * Render image column for DataTables.
     */
    protected function renderImageColumn($q)
    {
        if ($q->slider_img) {
            $imageUrl = Storage::url($q->slider_img);
            return '<img src="' . $imageUrl . '" class="img-thumbnail" style="max-width: 100px;">';
        }

        return '<span class="text-muted">Tidak ada gambar</span>';
    }
}
