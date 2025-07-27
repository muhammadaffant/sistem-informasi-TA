<x-modal data-backdrop="static" data-keyboard="false" size="modal-lg">
    <x-slot name="title">
        Tambah Kategori Sablon
    </x-slot>

    {{-- Method akan diubah secara dinamis oleh JS untuk edit --}}
    @method('POST')

    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="name">Nama Kategori</label>
                <input type="text" class="form-control" name="name" id="name" autocomplete="off" required>
                 {{-- div untuk menampilkan error validasi --}}
                <div class="invalid-feedback"></div>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-primary" id="submitBtn">
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-danger">
            <i class="fas fa-times"></i>
            Batal
        </button>
    </x-slot>
</x-modal>
