<x-modal id="modalDetail" data-backdrop="static" data-keyboard="false" size="modal-lg">
    <x-slot name="title">
        Detail Pesanan
    </x-slot>

    <div class="row">
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="name">Nama Pemesan</label>
                <input type="text" id="name" class="form-control" readonly>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="file_design_label">Desain</label>
                <div id="file_design" class="mt-2" style="max-height: 200px; overflow: auto; border: 1px solid #ddd; padding: 5px;">
                    </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="position">Penempatan Logo</label>
                <input type="text" name="position" id="position" class="form-control" readonly>
            </div>
        </div>
         <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="fabric_type">Jenis Bahan</label>
                <input type="text" id="fabric_type" class="form-control" readonly>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="design_description">Deskripsi Desain</label>
                <textarea id="design_description" class="form-control" rows="3" readonly></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="jenis_sablon">Jenis Sablon</label>
                <input type="text" id="jenis_sablon" class="form-control" readonly>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="sablon_price">Harga Sablon</label>
                <input type="text" id="sablon_price" class="form-control" readonly>
            </div>
        </div>
    </div>

    {{-- Container Baru untuk Rincian Ukuran --}}
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label for="size-detail-container">Rincian Ukuran & Jumlah</label>
                <div id="size-detail-container" class="mt-1" style="border: 1px solid #e0e0e0; padding: 10px; border-radius: 4px; background-color: #f9f9f9;">
                    </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="total_price">Total Harga Produk</label>
                <input type="text" id="total_price" class="form-control" readonly>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="ongkir">Ongkir</label>
                <input type="text" name="ongkir" id="ongkir" class="form-control" readonly>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="dp_paid">DP Dibayar</label>
                <input type="text" id="dp_paid" class="form-control" readonly>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="remaining_payment">Grand Total</label>
                <input type="text" id="remaining_payment" class="form-control" readonly>
            </div>
        </div>
    </div>
    
    {{-- Sisa field lainnya... --}}
    
    <x-slot name="footer">
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>