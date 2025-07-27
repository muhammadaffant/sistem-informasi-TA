<x-modal data-backdrop="static" data-keyboard="false" size="modal-lg">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="nama_bahan">Nama Bahan</label>
                <input type="text" class="form-control" name="nama_bahan" id="nama_bahan" autocomplete="off">
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="price">Harga Bahan</label>
                <input type="text" class="form-control" name="price" id="price" autocomplete="off">
            </div>
        </div>
    </div> --}}
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
