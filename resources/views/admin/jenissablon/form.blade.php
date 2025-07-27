<x-modal data-backdrop="static" data-keyboard="false" size="modal-lg">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')


            <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="sablon_category_id">Kategori Sablon</label>
                    <select name="sablon_category_id" id="sablon_category_id" class="form-control" required>
                        <option value="" disabled selected>Pilih Kategori</option>
                        @if (isset($categories))
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="nama_sablon">Nama Sablon</label>
                <input type="text" class="form-control" name="nama_sablon" id="nama_sablon" autocomplete="off">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="harga">Harga Sablon</label>
                <input type="text" class="form-control" name="harga" id="harga" autocomplete="off">
            </div>
        </div>
    </div>
    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-primary" id="submitBtn">
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>
