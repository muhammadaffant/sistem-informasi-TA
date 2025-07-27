<?php

namespace App\Services\Pesanan;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Pesanan\PesananRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PesananServiceImplement extends ServiceApi implements PesananService
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
    protected PesananRepository $mainRepository;

    public function __construct(PesananRepository $mainRepository)
    {
        $this->mainRepository = $mainRepository;
    }

    public function getData()
    {
        return $this->mainRepository->getData();
    }

    public function store($data)
    {
        // Validasi input
        $validator = Validator::make($data, [
            'kode_pesanan'        => 'required|string|max:255|unique:pesanans,kode_pesanan',
            'user_id'             => 'required|exists:users,id',
            'kategori_id'         => 'required|exists:kategoris,id',
            'nama_lengkap'        => 'required|string|max:255',
            'telepon'             => 'required|string|max:15',
            'keperluan'           => 'required|string|max:255',
            'alamat'              => 'nullable|string',
            'total_item'          => 'required|integer|min:0',
            'total_harga'         => 'required|integer|min:0',
            'status'              => 'required|in:pending,in_progress,completed,canceled',
            'foto_desain'         => 'required|mimes:jpeg,png,jpg,doc,pdf,docx|max:2048',
            'keterangan'          => 'nullable|string',
            'details'             => 'required|array',
            'details.*.size'      => 'required|string|max:255',
            'details.*.quantity'  => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return [
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ];
        }

        DB::beginTransaction();

        try {
            // Pisahkan file dari data
            $file = $data['foto_desain'];
            unset($data['foto_desain']);

            // Simpan data ke database
            $pesanan = $this->mainRepository->store($data);

            // Jika transaksi berhasil, unggah file
            $uploadPath = upload('upload', $file, 'pesanan');
            $pesanan->update(['foto_desain' => $uploadPath]);

            // Commit transaksi
            DB::commit();

            return [
                'status'  => 'success',
                'message' => 'Data berhasil disimpan.',
            ];
        } catch (\Throwable $th) {
            // Rollback jika terjadi kesalahan
            DB::rollBack();

            return [
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $th->getMessage(),
            ];
        }
    }

    public function detail($id)
    {
        return $this->mainRepository->detail($id);
    }

    public function show($id)
    {
        return $this->mainRepository->show($id);
    }

    public function update($data, $id)
    {
        // Validasi input
        $validator = Validator::make($data, [
            'kode_pesanan'        => 'required|string|max:255|unique:pesanans,kode_pesanan,' . $id,
            'user_id'             => 'required|exists:users,id',
            'kategori_id'         => 'required|exists:kategoris,id',
            'nama_lengkap'        => 'required|string|max:255',
            'telepon'             => 'required|string|max:15',
            'keperluan'           => 'required|string|max:255',
            'alamat'              => 'nullable|string',
            'total_item'          => 'required|integer|min:0',
            'total_harga'         => 'required|integer|min:0',
            'status'              => 'required|in:pending,in_progress,completed,canceled',
            'foto_desain'         => 'nullable|mimes:jpeg,png,jpg,doc,pdf,docx|max:2048', // file bisa null
            'keterangan'          => 'nullable|string',
            'details'             => 'required|array',
            'details.*.size'      => 'required|string|max:255',
            'details.*.quantity'  => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return [
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ];
        }

        DB::beginTransaction();

        try {
            // Ambil data pesanan yang akan diupdate
            $pesanan = $this->mainRepository->find($id);

            // Pisahkan file dari data jika ada
            $file = isset($data['foto_desain']) ? $data['foto_desain'] : null;
            unset($data['foto_desain']);

            // Update data pesanan
            $pesanan->update($data);

            // Jika ada file baru, unggah dan update jalur file
            if ($file) {
                // Hapus file lama jika ada
                if ($pesanan->foto_desain && file_exists(public_path($pesanan->foto_desain))) {
                    unlink(public_path($pesanan->foto_desain));
                }

                // Upload file baru
                $uploadPath = upload('upload', $file, 'pesanan');
                $pesanan->update(['foto_desain' => $uploadPath]);
            }

            // Commit transaksi
            DB::commit();

            return [
                'status'  => 'success',
                'message' => 'Data berhasil diperbarui.',
            ];
        } catch (\Throwable $th) {
            // Rollback jika terjadi kesalahan
            DB::rollBack();

            return [
                'status'  => 'error',
                'message' => 'Terjadi kesalahan saat memperbarui data: ' . $th->getMessage(),
            ];
        }
    }

    public function destroy($id)
    {
        $this->mainRepository->destroy($id);

        return [
            'status'  => 'success',
            'message' => 'Data berhasil diperbarui.',
        ];
    }

    public function updateStatus($data)
    {
        $this->mainRepository->updateStatus($data);
        return [
            'status'  => 'success',
            'message' => 'Data berhasil diperbarui.',
        ];
    }
}
