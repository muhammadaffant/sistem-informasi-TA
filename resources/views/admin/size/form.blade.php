<x-modal data-backdrop="static" data-keyboard="false" size="modal-md">
    <x-slot name="title">
        Form Data Size
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="bahan_id">Nama Bahan</label>
                <select name="bahan_id" id="bahan_id" class="form-control" required>
                    <option disabled selected>-- Pilih Bahan --</option>
                    @foreach ($bahans as $bahan)
                        <option value="{{ $bahan->id }}">{{ $bahan->nama_bahan }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="nama_size">Nama Size (Contoh: S-Lengan Pendek)</label>
                <input type="text" class="form-control" name="nama_size" id="nama_size" autocomplete="off" required>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="price">Harga</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Rp</div>
                    </div>
                    <input type="number" class="form-control" name="price" id="price" autocomplete="off" required>
                </div>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">
            <i class="fas fa-times"></i> Batal
        </button>
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-primary" id="submitBtn">
            <i class="fas fa-save"></i> Simpan
        </button>
    </x-slot>
</x-modal>