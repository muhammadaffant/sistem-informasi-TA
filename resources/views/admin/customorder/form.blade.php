<x-modal data-backdrop="static" data-keyboard="false" size="modal-lg">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')
    {{--
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="status">Harga</label>
                <input type="text" name="price" id="price" class="form-control" onkeyup="format_uang(this)"
                    disabled>
            </div>
        </div>
    </div>  --}}

    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="status">Status Transaksi</label>
                <select id="status" name="status" class="form-control">
                    <option value="Pending">Pending</option>
                    <option value="Progress">Konfirmasi</option>
                    {{--  <option value="Success">Success</option>  --}}
                    {{--  <option value="Canceled">Canceled</option>  --}}
                </select>
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
