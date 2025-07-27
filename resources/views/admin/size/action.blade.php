<div class="btn-group">
    <button onclick="editForm(`{{ route('admin.size.show', $model->id) }}`)" class="btn btn-xs btn-info">
        <i class="fas fa-edit"></i>
    </button>
    <button onclick="deleteData(`{{ route('admin.size.destroy', $model->id) }}`, '{{ $model->bahan->nama_bahan }} - Size {{ $model->nama_size }}')" class="btn btn-xs btn-danger">
        <i class="fas fa-trash"></i>
    </button>
</div>