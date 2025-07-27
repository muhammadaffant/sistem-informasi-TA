<x-modal data-backdrop="static" data-keyboard="false" size="modal-lg">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="province_id">Provinsi</label>
                <select name="province_id" id="province_id" class="form-control select2 province_id"></select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="regency_id">Kab/Kota</label>
                <select name="regency_id" id="regency_id" class="form-control select2 regency_id"></select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="district_id">Kecamatan</label>
                <select name="district_id" id="district_id" class="form-control select2 district_id"></select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="village_id">Desa</label>
                <select name="village_id" id="village_id" class="form-control select2 village_id"></select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="courir">Courir</label>
                <input id="courir" class="form-control" type="text" name="courir">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="ongkir">Ongkir</label>
                <input id="ongkir" class="form-control" type="text" name="ongkir" onkeyup="format_uang(this)">
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
