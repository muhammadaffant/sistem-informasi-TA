<?php

namespace App\Repositories\Layanan;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Layanan;
use Illuminate\Support\Facades\Storage;

class LayananRepositoryImplement extends Eloquent implements LayananRepository
{
    protected Layanan $model;

    public function __construct(Layanan $model)
    {
        $this->model = $model;
    }

    /**
     * Get all Layanan data.
     */
    public function getData()
    {
        return $this->model->all();
    }

    /**
     * Store a new Layanan record.
     */
    public function store($data)
    {
        // $data['foto_layanan'] = $this->handleUploadedFile($data['foto_layanan'] ?? null);

        return $this->model->create($data);
    }

    /**
     * Show a specific Layanan record by ID.
     */
    public function show($id)
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Update an existing Layanan record by ID.
     */
    public function update($data, $id)
    {
        $layanan = $this->model->findOrFail($id);

        // if (isset($data['foto_layanan'])) {
        //     $this->deleteFileIfExists($layanan->foto_layanan);
        //     $data['foto_layanan'] = $this->handleUploadedFile($data['foto_layanan']);
        // }

        $layanan->update($data);

        return $layanan;
    }

    /**
     * Delete a Layanan record by ID.
     */
    public function destroy($id)
    {
        $layanan = $this->model->findOrFail($id);

        // $this->deleteFileIfExists($layanan->foto_layanan);

        return $layanan->delete();
    }

    /**
     * Handle the uploaded file and return the storage path.
     */
    private function handleUploadedFile($file)
    {
        // if ($file instanceof \Illuminate\Http\UploadedFile) {
        //     return upload('layanan', $file, 'layanan');
        // }
        return null;
    }

    /**
     * Delete a file from storage if it exists.
     */
    private function deleteFileIfExists($filePath)
    {
        // if ($filePath && Storage::disk('public')->exists($filePath)) {
        //     Storage::disk('public')->delete($filePath);
        // }
    }
}
