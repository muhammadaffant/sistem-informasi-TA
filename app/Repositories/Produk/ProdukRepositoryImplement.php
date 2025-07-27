<?php

namespace App\Repositories\Produk;

use App\Models\Produk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use LaravelEasyRepository\Implementations\Eloquent;

class ProdukRepositoryImplement extends Eloquent implements ProdukRepository
{
    protected Produk $model;

    public function __construct(Produk $model)
    {
        $this->model = $model;
    }

    public function getData()
    {
        return $this->model->with(['kategori', 'produkDetails'])->get();
    }

    public function store($data)
    {
        DB::beginTransaction();

        try {
            $data['slug'] = Str::slug($data['nama_produk']);
            $data['foto_produk'] = $this->handleUploadedFile($data['foto_produk'] ?? null);

            $produk = $this->model->create($this->mapMainProductData($data));
            $this->handleProductDetails($produk, $data);

            DB::commit();
            return $produk;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function show($id)
    {
        return $this->model->with(['kategori', 'produkDetails'])->findOrFail($id);
    }

    public function update($data, $id)
    {
        DB::beginTransaction();

        try {
            $produk = $this->model->findOrFail($id);

            if (isset($data['foto_produk'])) {
                $this->deleteFileIfExists($produk->foto_produk);
                $data['foto_produk'] = $this->handleUploadedFile($data['foto_produk']);
            }

            $produk->update($this->mapMainProductData($data));
            $this->updateProductDetails($produk, $data);

            DB::commit();
            return $produk;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $produk = $this->model->findOrFail($id);

            $this->deleteFileIfExists($produk->foto_produk);
            $produk->produkDetails()->delete();
            $produk->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Handle file upload and return the file path.
     */
    private function handleUploadedFile($file)
    {
        if ($file instanceof \Illuminate\Http\UploadedFile) {
            return upload('produk', $file, 'produk');
        }
        return null;
    }

    /**
     * Delete a file if it exists.
     */
    private function deleteFileIfExists($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }

    /**
     * Map main product data for creating or updating.
     */
    private function mapMainProductData($data)
    {
        return [
            'nama_produk' => $data['nama_produk'] ?? null,
            'kategori_id' => $data['kategori'] ?? null,
            'keterangan'  => $data['keterangan'] ?? null,
            'foto_produk' => $data['foto_produk'] ?? null,
            'slug'        => $data['slug'] ?? null,
        ];
    }

    /**
     * Handle creation of product details.
     */
    private function handleProductDetails($produk, $data)
    {
        if (!empty($data['size'])) {
            foreach ($data['size'] as $index => $size) {
                $produk->produkDetails()->create($this->mapProductDetailData($data, $index, $size));
            }
        }
    }

    /**
     * Update product details and handle deletion of unused details.
     */
    private function updateProductDetails($produk, $data)
    {
        if (isset($data['size']) && is_array($data['size'])) {
            $existingSizes = [];
            foreach ($data['size'] as $index => $size) {
                $produkDetail = $produk->produkDetails()->where('size', $size)->first();

                if ($produkDetail) {
                    $produkDetail->update($this->mapProductDetailData($data, $index, $size));
                } else {
                    $produk->produkDetails()->create($this->mapProductDetailData($data, $index, $size));
                }
                $existingSizes[] = $size;
            }

            $produk->produkDetails()
                ->whereNotIn('size', $existingSizes)
                ->delete();
        }
    }

    /**
     * Map product detail data for creation or update.
     */
    private function mapProductDetailData($data, $index, $size)
    {
        return [
            'size'         => $size,
            'harga_produk' => isset($data['harga_produk'][$index])
                ? str_replace('.', '', $data['harga_produk'][$index])
                : 0,
            'quantity'     => $data['quantity'][$index] ?? 0,
        ];
    }
}
