<?php

namespace App\Repositories\Product;

use App\Models\MultiImg;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\ProductVariant;
use LaravelEasyRepository\Implementations\Eloquent;

class ProductRepositoryImplement extends Eloquent implements ProductRepository
{
    protected Product $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function getData()
    {
        return $this->model->with(['variants','category', 'brand', 'subCategory', 'subSubCategory', 'multiImages'])->latest()->get();
    }

    public function store($data)
    {
    DB::beginTransaction();
    try {
        $data['product_slug'] = Str::slug($data['product_name']);
        $data = $this->handleCheckboxValues($data);

        $product = $this->model->create([
            // Simpan yang relevan ke table `products`
            'brand_id'           => $data['brand_id'],
            'category_id'        => $data['category_id'],
            'subcategory_id'     => $data['subcategory_id'],
            'subsubcategory_id'  => $data['subsubcategory_id'],
            'product_code'       => $data['product_code'],
            'product_name'       => $data['product_name'],
            'product_slug'       => $data['product_slug'],
            'product_color'      => $data['product_color'],
            'short_descp'        => $data['short_descp'],
            'long_descp'         => $data['long_descp'],
            'status'             => $data['status'],
            'special_deals'      => $data['special_deals'] ?? 0,
        ]);

        // Upload thumbnail
        if (!empty($data['product_thumbnail'])) {
            $product->product_thumbnail = $this->uploadFile($data['product_thumbnail'], 'uploads/products/thumbnail');
            $product->save();
        }

        // Upload multi images
        $this->handleMultiImages($product->id, $data['photo_name'] ?? []);

        // Simpan product_variants
        foreach ($data['sizes'] as $i => $size) {
            ProductVariant::create([
                'product_id' => $product->id,
                'size'       => $size,
                'price'      => (int) str_replace('.', '', $data['prices'][$i]),
                'discount'   => isset($data['discounts'][$i]) ? (int) $data['discounts'][$i] : 0,
                'price_after_discount' => isset($data['price_after_discounts'][$i]) ? (int) str_replace('.', '', $data['price_after_discounts'][$i]) : 0,
                'quantity'   => (int) $data['quantities'][$i],
            ]);
        }

        DB::commit();
        return $product;
    } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
    }
}

    public function detail($id)
    {
        $product = $this->model->with(['variants','category', 'brand', 'subCategory', 'subSubCategory', 'multiImages'])->find($id);

        // Generate URL for the main thumbnail
        $product['product_thumbnail'] = Storage::url($product['product_thumbnail']);

        // Generate URL for each multi image
        if ($product->multiImages) {
            foreach ($product->multiImages as $key => $image) {
                $product->multiImages[$key]['photo_name'] = Storage::url($image['photo_name']);
            }
        }

        // Format prices
        $product['selling_price'] = format_uang($product['selling_price']);
        $product['price_after_discount'] = format_uang($product['price_after_discount']);

        return $product;
    }

    public function show($id)
    {
        $product = $this->model->with(['category', 'brand', 'subCategory', 'subSubCategory', 'multiImages'])->find($id);
        $product['selling_price'] = format_uang($product['selling_price']);
        $product['price_after_discount'] = format_uang($product['price_after_discount']);

        return $product;
    }

   public function update($data, $id)
{
    DB::beginTransaction();

    try {
        // 1. Temukan produk yang akan diupdate
        $product = $this->model->findOrFail($id);

        // 2. Siapkan data untuk tabel 'products'
        $productData = [
            'brand_id'          => $data['brand_id'],
            'category_id'       => $data['category_id'],
            'subcategory_id'    => $data['subcategory_id'],
            'subsubcategory_id' => $data['subsubcategory_id'],
            'product_name'      => $data['product_name'],
            'product_slug'      => Str::slug($data['product_name']),
            'product_color'     => $data['product_color'],
            'short_descp'       => $data['short_descp'],
            'long_descp'        => $data['long_descp'],
            'status'            => $data['status'],
            'special_deals'     => isset($data['special_deals']) ? 1 : 0,
        ];
        
        // 3. Handle upload thumbnail jika ada file baru
        if (!empty($data['product_thumbnail'])) {
            $this->deleteFileIfExists($product->product_thumbnail); // Hapus thumbnail lama
            $productData['product_thumbnail'] = $this->uploadFile($data['product_thumbnail'], 'uploads/products/thumbnail');
        }

        // 4. Update data utama di tabel 'products'
        $product->update($productData);

        // 5. Hapus semua varian lama yang terkait dengan produk ini
        $product->variants()->delete();

        // 6. Buat ulang varian berdasarkan data baru dari form
        if (isset($data['sizes']) && is_array($data['sizes'])) {
            foreach ($data['sizes'] as $i => $size) {
                ProductVariant::create([
                    'product_id' => $product->id,
                    'size'       => $size,
                    'price'      => (int) str_replace('.', '', $data['prices'][$i]),
                    'discount'   => $data['discounts'][$i] ?? 0,
                    'price_after_discount' => isset($data['price_after_discounts'][$i]) ? (int) str_replace('.', '', $data['price_after_discounts'][$i]) : 0,
                    'quantity'   => (int) $data['quantities'][$i],
                ]);
            }
        }

        // Handle multi-images (jika ada yang di-upload)
        if (isset($data['photo_name']) && is_array($data['photo_name'])) {
            // Hapus semua gambar lama
            $product->multiImages()->each(function ($image) {
                $this->deleteFileIfExists($image->photo_name);
            });
            $product->multiImages()->delete();

            // Upload gambar baru
            $this->handleMultiImages($product->id, $data['photo_name']);
        }

        DB::commit();
        return $product;

    } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
    }
}

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $product = $this->model->with('multiImages')->findOrFail($id);

            $this->deleteFileIfExists($product->product_thumbnail);

            foreach ($product->multiImages as $image) {
                $this->deleteFileIfExists($image->photo_name);
            }

            $product->multiImages()->delete();
            $product->delete();

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    private function handleCheckboxValues($data): array
    {
        // foreach (['hot_deals', 'featured', 'special_offer', 'special_deals'] as $key) {
        //     $data[$key] = isset($data[$key]) ? 1 : 0;
        // }
        // return $data;
        foreach (['special_deals'] as $key) {
            $data[$key] = isset($data[$key]) ? 1 : 0;
        }
        return $data;
    }

    private function sanitizePrice($price)
    {
        return str_replace('.', '', $price);
    }

    private function handleMultiImages($productId, $images)
    {
        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                DB::table('multi_imgs')->insert([
                    'product_id' => $productId,
                    'photo_name' => $this->uploadFile($image, 'uploads/products/multi'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    private function uploadFile(UploadedFile $file, string $path): string
    {
        $filename = uniqid() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($path, $filename, 'public');
    }

    private function deleteFileIfExists(string $filePath)
    {
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}
