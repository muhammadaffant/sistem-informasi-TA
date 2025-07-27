<?php

namespace App\Services\Layanan;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Layanan\LayananRepository;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class LayananServiceImplement extends ServiceApi implements LayananService
{

    /**
     * set title message api for CRUD
     * @param string $title
     */
    protected string $title = "";
    /**
     * uncomment this to override the default message
     * protected string $create_message = "";
     * protected string $update_message = "";
     * protected string $delete_message = "";
     */

    /**
     * don't change $this->mainRepository variable name
     * because used in extends service class
     */
    protected LayananRepository $mainRepository;

    public function __construct(LayananRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    /**
     * getData
     *
     * @return void
     */
    public function getData()
    {
        try {
            return $this->mainRepository->getData();
        } catch (\Exception $e) {

            Log::debug($e->getMessage());
            return [];
        }
    }

    /**
     * store
     *
     * @param  mixed $data
     * @return void
     */
    public function store($data)
    {
        // Validasi data
        $validator = Validator::make($data, [
            'nama_layanan' => 'required',
            'deskripsi'    => 'nullable',
            // 'foto_layanan' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return [
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ];
        }

        // Simpan data ke repository
        $this->mainRepository->store($data);

        // Hasil sukses
        return [
            'status'  => 'success',
            'message' => 'Data berhasil disimpan.',
        ];
    }

    public function show($id)
    {
        return $this->mainRepository->show($id);
    }

    /**
     * update
     *
     * @param  mixed $layanan
     * @param  mixed $data
     * @return void
     */
    public function update($data, $id)
    {
        // Validate data
        $validator = Validator::make($data, [
            'nama_layanan' => 'required',
            'deskripsi'    => 'nullable',
            // 'foto_layanan' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($validator->fails()) {
            return [
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ];
        }

        // Update the existing record
        $this->mainRepository->update($data, $id);

        return [
            'status'  => 'success',
            'message' => 'Data berhasil diperbarui.',
        ];
    }

    /**
     * delete
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $this->mainRepository->destroy($id);

        return [
            'status'  => 'success',
            'message' => 'Data berhasil diperbarui.',
        ];
    }
}
