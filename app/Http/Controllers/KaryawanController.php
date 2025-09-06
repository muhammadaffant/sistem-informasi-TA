<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Data Karyawan';
        $karyawan = Karyawan::latest()->paginate(10);
        return view('karyawan.index', compact('karyawan', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Karyawan';
        return view('karyawan.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string|max:20|unique:karyawan,nip',
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan_kehadiran' => 'nullable|numeric|min:0',
            'uang_lembur' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $karyawan = new Karyawan();
            $karyawan->nip = $request->nip;
            $karyawan->nama = $request->nama;
            $karyawan->alamat = $request->alamat;
            $karyawan->gaji_pokok = $request->gaji_pokok ?? 0;
            $karyawan->tunjangan_kehadiran = $request->tunjangan_kehadiran ?? 0;
            $karyawan->uang_lembur = $request->uang_lembur ?? 0;
            $karyawan->save(); // Gaji bersih akan dihitung otomatis

            return response()->json([
                'success' => true,
                'message' => 'Data karyawan berhasil disimpan',
                'data' => $karyawan,
                'gaji_bersih' => $karyawan->gaji_bersih
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        $title = 'Detail Karyawan';
        return view('karyawan.show', compact('karyawan', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        $title = 'Edit Karyawan';
        return view('karyawan.edit', compact('karyawan', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $validator = Validator::make($request->all(), [
            'nip' => 'required|string|max:20|unique:karyawan,nip,' . $karyawan->id,
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan_kehadiran' => 'nullable|numeric|min:0',
            'uang_lembur' => 'nullable|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $karyawan->nip = $request->nip;
            $karyawan->nama = $request->nama;
            $karyawan->alamat = $request->alamat;
            $karyawan->gaji_pokok = $request->gaji_pokok ?? 0;
            $karyawan->tunjangan_kehadiran = $request->tunjangan_kehadiran ?? 0;
            $karyawan->uang_lembur = $request->uang_lembur ?? 0;
            $karyawan->save(); // Gaji bersih akan dihitung otomatis

            return response()->json([
                'success' => true,
                'message' => 'Data karyawan berhasil diupdate',
                'data' => $karyawan,
                'gaji_bersih' => $karyawan->gaji_bersih
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        try {
            $karyawan->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data karyawan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate gaji bersih via AJAX
     */
    public function calculateGajiBersih(Request $request)
    {
        $gaji_pokok = $request->gaji_pokok ?? 0;
        $tunjangan_kehadiran = $request->tunjangan_kehadiran ?? 0;
        $uang_lembur = $request->uang_lembur ?? 0;

        $gaji_bersih = $gaji_pokok + $tunjangan_kehadiran + $uang_lembur;

        return response()->json([
            'gaji_bersih' => $gaji_bersih,
            'formatted_gaji_bersih' => 'Rp ' . number_format($gaji_bersih, 0, ',', '.')
        ]);
    }
}
