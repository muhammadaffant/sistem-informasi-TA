<?php

// app/Http/Controllers/Admin/AdminSizeController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bahan;
use App\Models\Size;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdminSizeController extends Controller
{
    public function index()
    {
        // Ambil semua bahan untuk dropdown di form
        $bahans = Bahan::orderBy('nama_bahan', 'asc')->get();
        return view('admin.size.index', [
            'title' => 'Data Size',
            'bahans' => $bahans,
        ]);
    }

    public function data()
    {
        // Fetch unique bahans (materials) for the parent rows
        $bahans = Bahan::select('id', 'nama_bahan')->get();

        return DataTables::of($bahans)
            ->addIndexColumn()
            ->addColumn('detail', function ($bahan) {
                // Kolom ini akan menampung kontrol expand/collapse
                return '<i class="fa fa-plus-circle details-control" data-id="' . $bahan->id . '"></i>';
            })
            // Hapus bagian 'action' di sini
            // ->addColumn('action', function ($bahan) {
            //     return '<button onclick="addForm(\'' . route('admin.size.store') . '?bahan_id=' . $bahan->id . '\')" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Add Size</button>';
            // })
            ->rawColumns(['detail']) // Sesuaikan rawColumns karena 'action' dihapus
            ->toJson();
    }

    // New method to fetch sizes for a specific bahan
    public function getSizesByBahan($bahan_id)
    {
        $sizes = Size::where('bahan_id', $bahan_id)->orderBy('nama_size', 'asc')->get();
        return DataTables::of($sizes)
            ->addIndexColumn()
            ->editColumn('price', fn($size) => 'Rp ' . number_format($size->price, 0, ',', '.'))
            ->addColumn('aksi', function ($size) {
                return view('admin.size.action', ['model' => $size])->render();
            })
            ->rawColumns(['aksi'])
            ->toJson();
    }

    public function store(Request $request)
    {
        $request->validate([
            'bahan_id' => 'required|exists:bahans,id',
            'nama_size' => 'required|string|max:20',
            'price' => 'required|integer|min:0',
        ]);

        Size::create($request->all());

        return response()->json(['success' => 'Data Size berhasil ditambahkan.']);
    }

    public function show($id)
    {
        $size = Size::findOrFail($id);
        return response()->json(['data' => $size]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bahan_id' => 'required|exists:bahans,id',
            'nama_size' => 'required|string|max:20',
            'price' => 'required|integer|min:0',
        ]);

        $size = Size::findOrFail($id);
        $size->update($request->all());

        return response()->json(['success' => 'Data Size berhasil diperbarui.']);
    }

    public function destroy($id)
    {
        Size::destroy($id);
        return response()->json(['success' => 'Data Size berhasil dihapus.']);
    }
}