<?php

namespace App\Services\Product;

use LaravelEasyRepository\ServiceApi;
use App\Repositories\Product\ProductRepository;
use Illuminate\Support\Facades\Validator;

class ProductServiceImplement extends ServiceApi implements ProductService
{
    protected string $title = "";
    protected ProductRepository $mainRepository;

    public function __construct(ProductRepository $mainRepository)
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
    'brand_id'           => 'required',
    'category_id'        => 'required',
    'subcategory_id'     => 'required',
    'subsubcategory_id'  => 'required',
    'product_code'       => 'required',
    'product_name'       => 'required|string',
    'product_color'      => 'required|string',
    'short_descp'        => 'required|string',
    'long_descp'         => 'required|string',
    'product_thumbnail'  => 'required|mimes:png,jpg,jpeg|max:2048',
    'photo_name'         => 'required|array',
    'photo_name.*'       => 'mimes:png,jpg,jpeg|max:10000',
    'sizes'              => 'required|array',
    'prices'             => 'required|array',
    'quantities'         => 'required|array',
    'discounts'          => 'array',
    'price_after_discounts' => 'array',
    'special_deals'      => 'nullable',
    'status'             => 'required|in:0,1',
]);



        if ($validator->fails()) {
            return [
                'status'  => 'error',
                'errors'  => $validator->errors(),
                'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
            ];
        }

        // Save to the database
        $this->mainRepository->store($data);

        return [
            'status'  => 'success',
            'message' => 'Data berhasil disimpan.',
        ];
    }

    public function show($id)
    {
        return $this->mainRepository->show($id);
    }

    public function detail($id)
    {
        return $this->mainRepository->detail($id);
    }

public function update($data, $id)
{
    // Aturan validasi yang baru untuk data produk dan variannya (array)
    $validator = Validator::make($data, [
        'brand_id'          => 'required',
        'category_id'       => 'required',
        'subcategory_id'    => 'required',
        'subsubcategory_id' => 'required',
        'product_name'      => 'required|string|max:255',
        'product_color'     => 'required|string',
        'short_descp'       => 'required|string',
        'long_descp'        => 'required|string',
        'product_thumbnail' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        'status'            => 'required|in:0,1',
        'special_deals'     => 'nullable',
        
        // Aturan validasi untuk varian (array)
        'sizes'             => 'required|array',
        'sizes.*'           => 'required|string', // Validasi setiap elemen di dalam array 'sizes'
        'prices'            => 'required|array',
        'prices.*'          => 'required|string', // Validasi setiap elemen di dalam array 'prices'
        'quantities'        => 'required|array',
        'quantities.*'      => 'required|integer|min:0', // Validasi setiap elemen di dalam array 'quantities'
        'discounts'         => 'nullable|array',
        'discounts.*'       => 'nullable|integer|min:0|max:100', // Validasi setiap elemen di dalam array 'discounts'
    ]);

    if ($validator->fails()) {
        return [
            'status'  => 'error',
            'errors'  => $validator->errors(),
            'message' => 'Maaf, inputan yang Anda masukkan salah. Silakan periksa kembali dan coba lagi.',
        ];
    }

    // Panggil repository untuk menjalankan logika update ke database
    $this->mainRepository->update($data, $id);

    return [
        'status'  => 'success',
        'message' => 'Data berhasil diperbarui.',
    ];
}

    public function destroy($id)
    {
        $this->mainRepository->destroy($id);

        return [
            'status'  => 'success',
            'message' => 'Data berhasil dihapus.',
        ];
    }
}
