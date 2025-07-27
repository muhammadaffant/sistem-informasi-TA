<?php
namespace App\Services\JenisSablon;

use LaravelEasyRepository\ServiceApi;
use Illuminate\Support\Facades\Validator;
use App\Repositories\JenisSablon\JenisSablonRepository;


class JenisSablonServiceImplement extends ServiceApi implements JenisSablonService
{
    protected string $title = "";
    protected JenisSablonRepository $mainRepository;

    public function __construct(JenisSablonRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function getData()
    {
        return $this->mainRepository->getData();
    }

    public function store($data)
    {
        $validator = Validator::make($data, [
            // MODIFIKASI: Tambahkan validasi untuk kategori
            'sablon_category_id' => 'required|exists:sablon_categories,id',
            'nama_sablon' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return ['status' => 'error', 'errors' => $validator->errors(), 'message' => 'Input tidak valid.'];
        }

        $this->mainRepository->store($data);
        return ['status' => 'success', 'message' => 'Data berhasil disimpan.'];
    }

    public function show($id)
    {
        return $this->mainRepository->show($id);
    }

    public function update($data, $id)
    {
        $validator = Validator::make($data, [
            // MODIFIKASI: Tambahkan validasi untuk kategori
            'sablon_category_id' => 'required|exists:sablon_categories,id',
            'nama_sablon' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return ['status' => 'error', 'errors' => $validator->errors(), 'message' => 'Input tidak valid.'];
        }

        $this->mainRepository->update($data, $id);
        return ['status' => 'success', 'message' => 'Data berhasil diperbarui.'];
    }

    public function destroy($id)
    {
        $this->mainRepository->destroy($id);
        return ['status' => 'success', 'message' => 'Data berhasil dihapus.'];
    }
}