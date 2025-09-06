@extends('frontend.main_master')

@section('title', 'Custom Order')

{{-- Menambahkan Font Awesome untuk ikon --}}
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Fallback untuk Font Awesome -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
<style>
    /* Style tambahan untuk membuat tampilan lebih bersih */
    .card-header .fas {
        margin-right: 10px;
    }
    
    /* Icon spacing improvements */
    .fas.mr-2 {
        margin-right: 0.5rem !important;
    }
    
    .nav-link .fas {
        margin-right: 8px;
    }
    
    /* Ensure Font Awesome loads properly */
    i.fas {
        font-family: "Font Awesome 5 Free" !important;
        font-weight: 900 !important;
        display: inline-block;
        font-style: normal;
        font-variant: normal;
        text-rendering: auto;
        line-height: 1;
    }
    .price-summary-card {
        position: sticky;
        top: 20px; /* Membuat panel ringkasan "mengikuti" saat scroll */
    }
    .grand-total-row td {
        font-size: 1.3em;
        font-weight: bold;
        border-top: 2px solid #dee2e6;
        padding-top: 10px !important;
    }
    
    /* Style untuk multi-variasi */
    .variation-item {
        transition: all 0.3s ease;
        border: 1px solid #e3e6f0;
    }
    
    .variation-item:hover {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    
    .variation-item .card-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-bottom: none;
    }
    
    .variation-item .card-header h6 {
        margin: 0;
        font-weight: 600;
    }
    
    .remove-variation {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
        border-radius: 0.2rem;
    }
    
    .remove-variation:hover {
        background-color: #dc3545;
        border-color: #dc3545;
        transform: scale(1.05);
    }
    
    .variation-item .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .variation-item .form-group label {
        font-weight: 600;
        color: #5a5c69;
        margin-bottom: 0.5rem;
    }
    
    #addVariationBtn {
        background: linear-gradient(135deg, #1cc88a 0%, #36b3a0 100%);
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.35rem;
        transition: all 0.3s ease;
    }
    
    #addVariationBtn:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(28, 200, 138, 0.3);
    }
    
    .subtotal-display, 
    .bahan-price-display, 
    .sablon-price-display {
        background-color: #f8f9fc;
        font-weight: 600;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .form-control {
        border-radius: 0.35rem;
        border: 1px solid #d1d3e2;
    }
    
    .form-control:focus {
        border-color: #bac8f3;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
    }
    
    /* Estimation container styling */
    #estimation-container {
        border-left: 4px solid #007bff;
    }
    
    .estimation-info table td {
        padding: 0.25rem 0.5rem;
        vertical-align: middle;
        border: none;
    }
    
    .estimation-info table td:first-child {
        padding-left: 0;
        white-space: nowrap;
    }
    
    .estimation-info table td:last-child {
        padding-right: 0;
    }
    
    /* Animation untuk menambah variasi */
    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .variation-item {
        animation: slideInUp 0.5s ease-out;
    }
    
    /* Responsive improvements */
    @media (max-width: 768px) {
        .variation-item .card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
        
        .remove-variation {
            align-self: flex-end;
        }
    }
    
    /* Design Preview Styles */
    .nav-tabs .nav-link {
        border-radius: 0.35rem 0.35rem 0 0;
        font-weight: 600;
        color: #5a5c69;
        border: 1px solid #d1d3e2;
        background-color: #f8f9fc;
    }
    
    .nav-tabs .nav-link.active {
        background-color: #4e73df;
        border-color: #4e73df;
        color: white;
    }
    
    .nav-tabs .nav-link:hover {
        background-color: #224abe;
        color: white;
        border-color: #224abe;
    }
    
    .tab-content {
        border-radius: 0 0 0.35rem 0.35rem;
        min-height: 200px;
    }
    
    .tab-pane {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    .tab-pane.active {
        padding: 1.5rem !important;
    }
    
    #front_design_preview_container,
    #back_design_preview_container {
        transition: all 0.3s ease;
        border: 2px dashed #d1d3e2 !important;
    }
    
    #front_design_preview_container:hover,
    #back_design_preview_container:hover {
        border-color: #4e73df !important;
        background-color: #f1f5f9 !important;
    }
    
    #front_design_preview_container.has-image,
    #back_design_preview_container.has-image {
        border: 2px solid #1cc88a !important;
        background-color: #f8fff8 !important;
    }
    
    .form-check-input:checked {
        background-color: #4e73df;
        border-color: #4e73df;
    }
    
    .design-preview-img {
        border-radius: 0.25rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
    }
    
    .file-input-wrapper {
        position: relative;
    }
    
    .file-input-wrapper input[type="file"] {
        padding: 0.5rem;
        border: 2px dashed #d1d3e2;
        background-color: #f8f9fc;
        border-radius: 0.35rem;
        transition: all 0.3s ease;
    }
    
    .file-input-wrapper input[type="file"]:hover {
        border-color: #4e73df;
        background-color: #f1f5f9;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endpush


@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class='active'>@yield('title')</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="body-content">
        <div class="container">
            <div class="checkout-box">
                <form id="customOrderForm" role="form" enctype="multipart/form-data">
                    @csrf
                    {{-- Hidden fields dipindahkan ke sini agar tetap di dalam form --}}
                    <input type="hidden" name="province_id" id="province_id">
                    <input type="hidden" name="city_id" id="city_id">
                    <input type="hidden" name="district_id" id="district_id">
                    <input type="hidden" name="courier" id="courier_hidden">
                    <input type="hidden" name="courier_service" id="courier_service_hidden">
                    <input type="hidden" name="ongkir" id="ongkir_hidden">
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                    
                    {{-- Hidden fields untuk kompatibilitas dengan backend yang lama --}}
                    <input type="hidden" name="file_design" id="file_design_legacy">
                    <input type="hidden" name="position" id="position_legacy">

                    <div class="row">
                        {{-- KOLOM KIRI: FORM INPUT --}}
                        <div class="col-lg-8">
                            {{-- KARTU 1: INFORMASI PEMESAN & DESAIN --}}
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5><i class="fas fa-user-edit mr-2"></i>Informasi Pemesan & Desain</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name" class="info-title">Nama Lengkap</label>
                                        <input id="name" class="form-control" type="text" name="name" value="{{ Auth::user()->name }}" required>
                                    </div>
                                    
                                    {{-- DESAIN SECTION --}}
                                    <div class="form-group">
                                        <label class="info-title">Upload Desain/Logo</label>
                                        
                                        {{-- DESAIN DEPAN (WAJIB) --}}
                                        <div class="card border-primary mb-3">
                                            <div class="card-header bg-primary text-white py-2">
                                                <h6 class="mb-0"><i class="fas fa-tshirt mr-2"></i>Desain Depan (Wajib)</h6>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group mb-2">
                                                            <label for="front_design_file" class="form-label">Upload File Desain Depan *</label>
                                                            <input id="front_design_file" class="form-control" type="file" name="front_design_file" accept="image/*" required>
                                                            <small class="text-muted">Format: JPG, PNG, JPEG (Max: 2MB)</small>
                                                        </div>
                                                        <div class="form-group mb-0">
                                                            <label for="front_position" class="form-label">Posisi Desain Depan *</label>
                                                            <select name="front_position" id="front_position" class="form-control" required>
                                                                <option value="" disabled selected>Pilih Posisi</option>
                                                                <option value="Depan Tengah">Depan Tengah</option>
                                                                <option value="Depan Samping Kiri">Depan Samping Kiri</option>
                                                                <option value="Depan Samping Kanan">Depan Samping Kanan</option>
                                                                <option value="Depan Atas Kiri">Depan Atas Kiri</option>
                                                                <option value="Depan Atas Kanan">Depan Atas Kanan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Preview Desain Depan</label>
                                                        <div id="front_design_preview_container" class="border rounded p-2 text-center" style="min-height: 100px; background: #f8f9fa;">
                                                            <img id="front_design_preview" src="" alt="Preview akan muncul di sini" style="max-width: 100%; max-height: 80px; display: none;">
                                                            <div id="front_preview_placeholder" class="text-muted">
                                                                <i class="fas fa-image fa-lg mb-1"></i>
                                                                <br><small>Preview Depan</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        {{-- DESAIN BELAKANG (OPSIONAL) --}}
                                        <div class="card border-secondary">
                                            <div class="card-header bg-secondary text-white py-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h6 class="mb-0"><i class="fas fa-layer-group mr-2"></i>Desain Belakang (Opsional)</h6>
                                                    <div class="form-check form-check-inline mb-0">
                                                        <input class="form-check-input" type="checkbox" id="has_back_design" name="has_back_design" value="1">
                                                        <label class="form-check-label text-white" for="has_back_design">
                                                            <small>Tambahkan</small>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body" id="back_design_fields" style="display: none;">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group mb-2">
                                                            <label for="back_design_file" class="form-label">Upload File Desain Belakang</label>
                                                            <input id="back_design_file" class="form-control" type="file" name="back_design_file" accept="image/*">
                                                            <small class="text-muted">Format: JPG, PNG, JPEG (Max: 2MB)</small>
                                                        </div>
                                                        <div class="form-group mb-0">
                                                            <label for="back_position" class="form-label">Posisi Desain Belakang</label>
                                                            <select name="back_position" id="back_position" class="form-control">
                                                                <option value="" disabled selected>Pilih Posisi</option>
                                                                <option value="Belakang Tengah">Belakang Tengah</option>
                                                                <option value="Belakang Atas">Belakang Atas</option>
                                                                <option value="Belakang Bawah">Belakang Bawah</option>
                                                                <option value="Belakang Samping Kiri">Belakang Samping Kiri</option>
                                                                <option value="Belakang Samping Kanan">Belakang Samping Kanan</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label class="form-label">Preview Desain Belakang</label>
                                                        <div id="back_design_preview_container" class="border rounded p-2 text-center" style="min-height: 100px; background: #f8f9fa;">
                                                            <img id="back_design_preview" src="" alt="Preview akan muncul di sini" style="max-width: 100%; max-height: 80px; display: none;">
                                                            <div id="back_preview_placeholder" class="text-muted">
                                                                <i class="fas fa-image fa-lg mb-1"></i>
                                                                <br><small>Preview Belakang</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="design_description" class="info-title">Warna Kaos & Catatan Tambahan</label>
                                        <textarea id="design_description" name="design_description" class="form-control" rows="2" placeholder="Contoh: Hitam, Putih, Merah Maroon. Tambahkan catatan khusus jika ada."></textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- KARTU 2: SPESIFIKASI PRODUK --}}
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5><i class="fas fa-tshirt mr-2"></i>Spesifikasi & Kuantitas Produk</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h6 class="mb-0">Item Pesanan:</h6>
                                        <button type="button" id="addVariationBtn" class="btn btn-sm btn-success">
                                            <i class="fas fa-plus mr-2"></i>Tambah Variasi
                                        </button>
                                    </div>
                                    
                                    <div id="variations-container">
                                        <!-- Item variasi akan ditambahkan di sini secara dinamis -->
                                    </div>
                                    
                                    <div class="mt-3 text-muted">
                                        <small>
                                            <i class="fas fa-info-circle"></i> 
                                            Anda dapat menambahkan berbagai kombinasi bahan dan sablon dalam satu pesanan. 
                                            Minimal total kuantitas adalah 12 pcs.
                                        </small>
                                        <div class="mt-2">
                                            <small class="text-success">
                                                <i class="fas fa-check-circle"></i> 
                                                Desain depan wajib diisi. Desain belakang opsional namun dapat menambah nilai profesional produk Anda.
                                            </small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- KARTU 3: INFORMASI PENGIRIMAN --}}
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5><i class="fas fa-shipping-fast mr-2"></i>Informasi Pengiriman</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="address" class="info-title">Alamat Lengkap</label>
                                        <textarea name="address" id="address" class="form-control" rows="3" required placeholder="Contoh: Jl. Pahlawan No. 123, RT 01 RW 02, Kel. Mugassari"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"><div class="form-group"><label>Provinsi</label><select id="province_select" class="form-control select2" required></select></div></div>
                                        <div class="col-md-6"><div class="form-group"><label>Kabupaten/Kota</label><select id="city_select" class="form-control select2" disabled required></select></div></div>
                                        <div class="col-md-6"><div class="form-group"><label>Kecamatan</label><select id="district_select" class="form-control select2" disabled required></select></div></div>
                                        <div class="col-md-6"><div class="form-group"><label>Jasa Pengiriman</label><select id="courier_service" class="form-control" required><option value="">-- Pilih --</option><option value="jne">JNE</option><option value="pos">POS Indonesia</option><option value="tiki">TIKI</option></select></div></div>
                                        <div class="col-md-12"><div class="form-group"><label>Paket</label><select id="courier_select" class="form-control" required disabled><option>-- Pilih Alamat & Jasa Pengiriman --</option></select></div></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: RINGKASAN HARGA & SUBMIT --}}
                        <div class="col-lg-4">
                            <div class="card shadow-sm price-summary-card">
                                <div class="card-header bg-primary text-white">
                                    <h5><i class="fas fa-calculator mr-2"></i>Ringkasan Pesanan</h5>
                                </div>
                                <div class="card-body">
                                    {{-- CONTAINER UNTUK RINGKASAN HARGA REAL-TIME --}}
                                    <div id="price-summary-container">
                                        <p class="text-muted text-center" style="padding: 50px 0;">Ringkasan akan muncul di sini setelah Anda mengisi kuantitas.</p>
                                    </div>
                                    
                                    {{-- CONTAINER UNTUK ESTIMASI PENGERJAAN --}}
                                    <div id="estimation-container" style="display: none;" class="mt-3 p-3 bg-light rounded">
                                        <h6 class="text-primary mb-3"><i class="fas fa-clock mr-2"></i>Estimasi Pengerjaan</h6>
                                        <div id="estimation-content">
                                            <!-- Konten estimasi akan ditampilkan di sini -->
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <button type="button" id="reviewOrderButton" class="btn btn-primary btn-lg btn-block">Lanjutkan ke Review Pesanan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

{{-- Letakkan kode ini di dalam file custom_order.blade.php, bisa di bawah <form> atau sebelum @endsection --}}

<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Konfirmasi Pesanan Anda</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Harap periksa kembali detail pesanan Anda sebelum melanjutkan. Pastikan semua data sudah benar.</p>
                
                {{-- Area untuk menampilkan ringkasan --}}
                <div class="row">
                    {{-- Kolom Kiri: Detail Pesanan & Pengiriman --}}
                    <div class="col-md-6">
                        <h6><strong><i class="fas fa-user-edit mr-2"></i>Detail Pemesan & Desain</strong></h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="120px">Nama</td>
                                <td>: <strong id="review_name"></strong></td>
                            </tr>
                            <tr>
                                <td>Warna Kaos</td>
                                <td>: <strong id="review_colors"></strong></td>
                            </tr>
                        </table>

                        <div class="row">
                            {{-- Preview Desain Depan --}}
                            <div class="col-md-6">
                                <h6 class="text-primary"><i class="fas fa-tshirt mr-2"></i>Desain Depan</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="60px">Posisi</td>
                                        <td>: <strong id="review_front_position"></strong></td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Preview</td>
                                        <td valign="top">: 
                                            <img id="review_front_design_preview" src="" alt="Preview Desain Depan" 
                                                 style="max-width: 120px; border: 1px solid #ddd; padding: 3px; border-radius: 0.25rem;">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            
                            {{-- Preview Desain Belakang --}}
                            <div class="col-md-6" id="review_back_design_section" style="display: none;">
                                <h6 class="text-secondary"><i class="fas fa-layer-group mr-2"></i>Desain Belakang</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td width="60px">Posisi</td>
                                        <td>: <strong id="review_back_position"></strong></td>
                                    </tr>
                                    <tr>
                                        <td valign="top">Preview</td>
                                        <td valign="top">: 
                                            <img id="review_back_design_preview" src="" alt="Preview Desain Belakang" 
                                                 style="max-width: 120px; border: 1px solid #ddd; padding: 3px; border-radius: 0.25rem;">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <h6 class="mt-4"><strong><i class="fas fa-shipping-fast mr-2"></i>Alamat Pengiriman</strong></h6>
                        <p id="review_address" style="white-space: pre-wrap;"></p>
                        
                        {{-- Estimasi Pengerjaan di Modal --}}
                        <div id="review_estimation" class="mt-3"></div>
                    </div>

                    {{-- Kolom Kanan: Ringkasan Belanja --}}
                    <div class="col-md-6">
                         <h6><strong><i class="fas fa-tshirt mr-2"></i>Rincian Produk</strong></h6>
                         <div id="review_items_summary" class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                            {{-- Rincian item akan dimasukkan di sini oleh JavaScript --}}
                         </div>
                         
                         <h6 class="mt-4"><strong><i class="fas fa-calculator mr-2"></i>Ringkasan Biaya</strong></h6>
                         <div id="review_price_summary">
                            {{-- Ringkasan harga dari kolom kanan akan disalin ke sini --}}
                         </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal & Kembali Edit</button>
                <button type="button" id="confirmAndSubmitOrder" class="btn btn-primary"><i class="fas fa-check"></i> Ya, Konfirmasi & Proses Pesanan</button>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
$(function() {
    let variationCounter = 0;
    
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
    }

    // Template untuk variasi baru
    function getVariationTemplate(counter) {
        return `
        <div class="variation-item card border-light mb-3" data-variation="${counter}">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Variasi #${counter + 1}</h6>
                <button type="button" class="btn btn-sm btn-danger remove-variation" data-variation="${counter}">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Pilih Bahan</label>
                            <select name="variations[${counter}][bahan_id]" class="form-control bahan-select" data-variation="${counter}" required>
                                <option value="" disabled selected>Pilih Bahan</option>
                                @php
                                    $bahans = \App\Models\Bahan::has('sizes')->get();
                                @endphp
                                @foreach ($bahans as $bahan)
                                    <option value="{{ $bahan->id }}">{{ $bahan->nama_bahan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Kategori Sablon</label>
                            <select class="form-control sablon-category-select" data-variation="${counter}" required>
                                <option value="" disabled selected>Pilih Kategori Sablon</option>
                                @php
                                    $sablon_categories = \App\Models\SablonCategory::has('jenisSablons')->get();
                                @endphp
                                @foreach ($sablon_categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Ukuran</label>
                            <select name="variations[${counter}][size_id]" class="form-control size-select" data-variation="${counter}" disabled required>
                                <option value="">Pilih bahan terlebih dahulu</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jenis Sablon</label>
                            <select name="variations[${counter}][jenis_sablon_id]" class="form-control jenis-sablon-select" data-variation="${counter}" disabled required>
                                <option value="">Pilih kategori sablon terlebih dahulu</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Jumlah (pcs)</label>
                            <input type="number" name="variations[${counter}][quantity]" class="form-control quantity-input" data-variation="${counter}" min="1" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Harga Bahan</label>
                            <input type="text" class="form-control bahan-price-display" data-variation="${counter}" readonly>
                            <input type="hidden" name="variations[${counter}][bahan_price]" class="bahan-price-value" data-variation="${counter}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Harga Sablon</label>
                            <input type="text" class="form-control sablon-price-display" data-variation="${counter}" readonly>
                            <input type="hidden" name="variations[${counter}][sablon_price]" class="sablon-price-value" data-variation="${counter}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Subtotal Variasi</label>
                            <input type="text" class="form-control subtotal-display" data-variation="${counter}" readonly>
                            <input type="hidden" name="variations[${counter}][subtotal]" class="subtotal-value" data-variation="${counter}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        `;
    }

    // Tambah variasi baru
    function addVariation() {
        const template = getVariationTemplate(variationCounter);
        $('#variations-container').append(template);
        variationCounter++;
        updatePriceSummary();
    }

    // Hapus variasi
    function removeVariation(counter) {
        $(`.variation-item[data-variation="${counter}"]`).remove();
        updatePriceSummary();
        updateVariationNumbers();
    }

    // Update nomor variasi setelah ada yang dihapus
    function updateVariationNumbers() {
        $('.variation-item').each(function(index) {
            $(this).find('.card-header h6').text(`Variasi #${index + 1}`);
        });
    }

    // Load sizes berdasarkan bahan
    function loadSizes(bahanId, variation) {
        const sizeSelect = $(`.size-select[data-variation="${variation}"]`);
        
        if (!bahanId) {
            sizeSelect.html('<option value="">Pilih bahan terlebih dahulu</option>').prop('disabled', true);
            return;
        }

        sizeSelect.html('<option value="">Memuat...</option>').prop('disabled', true);

        $.ajax({
            url: `/api/get-sizes/${bahanId}`,
            type: 'GET',
            dataType: 'json',
            success: function(sizes) {
                sizeSelect.empty().prop('disabled', false);
                if (sizes.length > 0) {
                    sizeSelect.append('<option value="" disabled selected>Pilih Ukuran</option>');
                    $.each(sizes, function(index, size) {
                        sizeSelect.append(`<option value="${size.id}" data-price="${size.price}">${size.nama_size} - ${formatRupiah(size.price)}</option>`);
                    });
                } else {
                    sizeSelect.html('<option value="">Ukuran tidak tersedia</option>').prop('disabled', true);
                }
            },
            error: function() {
                sizeSelect.html('<option value="">Gagal memuat ukuran</option>').prop('disabled', true);
            }
        });
    }

    // Load jenis sablon berdasarkan kategori
    function loadJenisSablon(categoryId, variation) {
        const jenisSablonSelect = $(`.jenis-sablon-select[data-variation="${variation}"]`);
        
        if (!categoryId) {
            jenisSablonSelect.html('<option value="">Pilih kategori sablon terlebih dahulu</option>').prop('disabled', true);
            return;
        }

        jenisSablonSelect.html('<option value="">Memuat...</option>').prop('disabled', true);

        $.ajax({
            url: `/api/get-sablon-details/${categoryId}`,
            type: 'GET',
            dataType: 'json',
            success: function(details) {
                jenisSablonSelect.empty().prop('disabled', false);
                if (details.length > 0) {
                    jenisSablonSelect.append('<option value="" disabled selected>Pilih Jenis Sablon</option>');
                    $.each(details, function(index, detail) {
                        jenisSablonSelect.append(`<option value="${detail.id}" data-price="${detail.harga}">${detail.nama_sablon} - ${formatRupiah(detail.harga)}</option>`);
                    });
                } else {
                    jenisSablonSelect.html('<option value="">Jenis sablon tidak tersedia</option>').prop('disabled', true);
                }
            },
            error: function() {
                jenisSablonSelect.html('<option value="">Gagal memuat jenis sablon</option>').prop('disabled', true);
            }
        });
    }

    // Update harga dan subtotal untuk variasi
    function updateVariationPrice(variation) {
        const sizeSelect = $(`.size-select[data-variation="${variation}"]`);
        const jenisSablonSelect = $(`.jenis-sablon-select[data-variation="${variation}"]`);
        const quantityInput = $(`.quantity-input[data-variation="${variation}"]`);
        
        const bahanPrice = parseFloat(sizeSelect.find('option:selected').data('price')) || 0;
        const sablonPrice = parseFloat(jenisSablonSelect.find('option:selected').data('price')) || 0;
        const quantity = parseInt(quantityInput.val()) || 0;
        
        // Update display harga
        $(`.bahan-price-display[data-variation="${variation}"]`).val(formatRupiah(bahanPrice));
        $(`.bahan-price-value[data-variation="${variation}"]`).val(bahanPrice);
        $(`.sablon-price-display[data-variation="${variation}"]`).val(formatRupiah(sablonPrice));
        $(`.sablon-price-value[data-variation="${variation}"]`).val(sablonPrice);
        
        // Hitung subtotal
        const subtotal = (bahanPrice + sablonPrice) * quantity;
        $(`.subtotal-display[data-variation="${variation}"]`).val(formatRupiah(subtotal));
        $(`.subtotal-value[data-variation="${variation}"]`).val(subtotal);
        
        updatePriceSummary();
    }

    // Update ringkasan harga total
    function updatePriceSummary() {
        let totalQty = 0;
        let totalPrice = 0;
        const ongkir = parseFloat($('#ongkir_hidden').val()) || 0;

        $('.variation-item').each(function() {
            const variation = $(this).data('variation');
            const qty = parseInt($(`.quantity-input[data-variation="${variation}"]`).val()) || 0;
            const subtotal = parseFloat($(`.subtotal-value[data-variation="${variation}"]`).val()) || 0;
            
            totalQty += qty;
            totalPrice += subtotal;
        });

        const grandTotal = totalPrice + ongkir;
        const container = $('#price-summary-container');

        if (totalQty === 0) {
            container.html('<p class="text-muted text-center" style="padding: 50px 0;">Ringkasan akan muncul di sini setelah Anda menambah variasi.</p>');
            $('#estimation-container').hide(); // Sembunyikan estimasi jika tidak ada item
            return;
        }

        // Hitung total berat secara real-time
        calculateTotalWeight().then(totalWeight => {
            let formattedWeight = totalWeight >= 1000 ? 
                (totalWeight / 1000).toFixed(1) + ' kg' : 
                totalWeight + ' gram';

            let summaryHtml = `
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px;">
                    <table class="table table-sm" style="margin-bottom: 0;">
                        <tbody>
                            <tr><td>Total Kuantitas</td><td class="text-right"><b>${totalQty} pcs</b></td></tr>
                            <tr><td>Total Berat</td><td class="text-right"><b>${formattedWeight}</b></td></tr>
                            <tr><td>Subtotal Produk</td><td class="text-right font-weight-bold">${formatRupiah(totalPrice)}</td></tr>
                            <tr><td>Biaya Pengiriman</td><td class="text-right">${formatRupiah(ongkir)}</td></tr>
                        </tbody>
                        <tfoot>
                            <tr class="grand-total-row bg-light"><td class="text-primary">Grand Total</td><td class="text-right text-primary">${formatRupiah(grandTotal)}</td></tr>
                        </tfoot>
                    </table>`;
            
            if (totalQty > 0 && totalQty < 12) {
                summaryHtml += `<div class="alert alert-warning text-center mt-3 p-2"><b>Peringatan:</b> Min. pemesanan adalah 12 pcs.</div>`;
            }

            summaryHtml += `</div>`;
            container.html(summaryHtml);
            
            // Update estimasi pengerjaan
            if (totalQty >= 12) {
                updateEstimation(totalQty);
            } else {
                $('#estimation-container').hide();
            }
        }).catch(error => {
            // Fallback jika gagal menghitung berat
            let summaryHtml = `
                <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px;">
                    <table class="table table-sm" style="margin-bottom: 0;">
                        <tbody>
                            <tr><td>Total Kuantitas</td><td class="text-right"><b>${totalQty} pcs</b></td></tr>
                            <tr><td>Total Berat</td><td class="text-right"><b>-</b></td></tr>
                            <tr><td>Subtotal Produk</td><td class="text-right font-weight-bold">${formatRupiah(totalPrice)}</td></tr>
                            <tr><td>Biaya Pengiriman</td><td class="text-right">${formatRupiah(ongkir)}</td></tr>
                        </tbody>
                        <tfoot>
                            <tr class="grand-total-row bg-light"><td class="text-primary">Grand Total</td><td class="text-right text-primary">${formatRupiah(grandTotal)}</td></tr>
                        </tfoot>
                    </table>`;
            
            if (totalQty > 0 && totalQty < 12) {
                summaryHtml += `<div class="alert alert-warning text-center mt-3 p-2"><b>Peringatan:</b> Min. pemesanan adalah 12 pcs.</div>`;
            }

            summaryHtml += `</div>`;
            container.html(summaryHtml);
            
            // Update estimasi pengerjaan
            if (totalQty >= 12) {
                updateEstimation(totalQty);
            } else {
                $('#estimation-container').hide();
            }
        });
    }

    // Update estimasi pengerjaan
    function updateEstimation(totalQuantity) {
        $.ajax({
            url: '{{ route("api.calculate.estimation") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                total_quantity: totalQuantity
            },
            success: function(response) {
                if (response.success) {
                    const estimationHtml = `
                        <div class="estimation-info">
                            <table class="table table-sm table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <td width="120px" class="text-muted small">Estimasi Selesai:</td>
                                        <td><strong class="text-success">${response.estimated_days} hari kerja</strong></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted small">Tanggal Pemesanan:</td>
                                        <td>${response.order_date}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted small">Perkiraan Selesai:</td>
                                        <td><strong class="text-primary">${response.completion_date}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-center mt-2">
                                <small class="text-info font-italic">${response.working_days_info}</small>
                            </div>
                        </div>
                    `;
                    $('#estimation-content').html(estimationHtml);
                    $('#estimation-container').show();
                } else {
                    $('#estimation-container').hide();
                }
            },
            error: function() {
                $('#estimation-container').hide();
            }
        });
    }

    // Event Listeners
    
    // Tambah variasi pertama saat halaman dimuat
    addVariation();

    // Tombol tambah variasi
    $('#addVariationBtn').on('click', function() {
        addVariation();
    });

    // Event delegation untuk element yang ditambah dinamis
    $(document).on('click', '.remove-variation', function() {
        if ($('.variation-item').length > 1) {
            const variation = $(this).data('variation');
            removeVariation(variation);
        } else {
            Swal.fire({
                icon: 'warning',
                title: 'Peringatan',
                text: 'Minimal harus ada satu variasi produk.'
            });
        }
    });

    $(document).on('change', '.bahan-select', function() {
        const variation = $(this).data('variation');
        const bahanId = $(this).val();
        loadSizes(bahanId, variation);
    });

    $(document).on('change', '.sablon-category-select', function() {
        const variation = $(this).data('variation');
        const categoryId = $(this).val();
        loadJenisSablon(categoryId, variation);
    });

    $(document).on('change', '.size-select, .jenis-sablon-select, .quantity-input', function() {
        const variation = $(this).data('variation');
        updateVariationPrice(variation);
        
        // Recalculate shipping cost when variations change
        setTimeout(() => {
            let destination = $('#district_select').val();
            let courier = $('#courier_service').val();
            if (destination && courier) {
                checkOngkir();
            }
        }, 500); // Small delay to ensure price calculation is done first
    });

    // Handle design preview for front design
    $('#front_design_file').on('change', function() {
        const file = this.files[0];
        if (file) {
            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: 'Ukuran file maksimal 2MB. Silakan pilih file yang lebih kecil.'
                });
                $(this).val('');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#front_design_preview').attr('src', e.target.result).show().addClass('design-preview-img');
                $('#front_preview_placeholder').hide();
                $('#front_design_preview_container').addClass('has-image');
            };
            reader.readAsDataURL(file);
        } else {
            $('#front_design_preview').hide().removeClass('design-preview-img');
            $('#front_preview_placeholder').show();
            $('#front_design_preview_container').removeClass('has-image');
        }
    });

    // Handle design preview for back design
    $('#back_design_file').on('change', function() {
        const file = this.files[0];
        if (file) {
            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: 'Ukuran file maksimal 2MB. Silakan pilih file yang lebih kecil.'
                });
                $(this).val('');
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#back_design_preview').attr('src', e.target.result).show().addClass('design-preview-img');
                $('#back_preview_placeholder').hide();
                $('#back_design_preview_container').addClass('has-image');
            };
            reader.readAsDataURL(file);
        } else {
            $('#back_design_preview').hide().removeClass('design-preview-img');
            $('#back_preview_placeholder').show();
            $('#back_design_preview_container').removeClass('has-image');
        }
    });

    // Handle back design checkbox
    $('#has_back_design').on('change', function() {
        if (this.checked) {
            $('#back_design_fields').slideDown(300);
            $('#back_design_file').attr('required', true);
            $('#back_position').attr('required', true);
        } else {
            $('#back_design_fields').slideUp(300);
            $('#back_design_file').attr('required', false).val('');
            $('#back_position').attr('required', false).val('');
            // Reset preview
            $('#back_design_preview').hide().removeClass('design-preview-img');
            $('#back_preview_placeholder').show();
            $('#back_design_preview_container').removeClass('has-image');
        }
    });

    // Also update ongkir when bahan changes
    $(document).on('change', '.bahan-select', function() {
        setTimeout(() => {
            let destination = $('#district_select').val();
            let courier = $('#courier_service').val();
            if (destination && courier) {
                checkOngkir();
            }
        }, 500);
    });

    // =================================================================
    // FUNGSI UNTUK ALAMAT & ONGKIR
    // =================================================================
    $('.select2').select2();
    $('#province_select').select2({ placeholder: '-- Pilih Provinsi --', ajax: { url: '{{ route("api.get.provinces") }}', dataType: 'json', delay: 250, data: p => ({ q: p.term }), processResults: r => ({ results: $.map(r, i => ({ text: i.name, id: i.id })) }) } });
    $('#city_select').select2({ placeholder: '-- Pilih Kabupaten/Kota --', ajax: { url: function() { var provinceId = $('#province_select').val(); return provinceId ? `{{ url("api/get-cities") }}/${provinceId}` : null; }, dataType: 'json', delay: 250, data: p => ({ q: p.term }), processResults: r => ({ results: $.map(r, i => ({ text: i.name, id: i.id })) }) } });
    $('#district_select').select2({ placeholder: '-- Pilih Kecamatan --', ajax: { url: function() { var cityId = $('#city_select').val(); return cityId ? `{{ url("api/get-districts") }}/${cityId}` : null; }, dataType: 'json', delay: 250, data: p => ({ q: p.term }), processResults: r => ({ results: $.map(r, i => ({ text: i.name, id: i.id })) }) } });

    $('#province_select').on('change', function() {
        $('#province_id').val($(this).val());
        $('#city_select').val(null).trigger('change').prop('disabled', false);
        $('#district_select').val(null).trigger('change').prop('disabled', true);
        resetOngkirUI();
    });

    $('#city_select').on('change', function() {
        $('#city_id').val($(this).val());
        $('#district_select').val(null).trigger('change').prop('disabled', false);
        resetOngkirUI();
    });

    $('#district_select, #courier_service').on('change', function() {
        $('#district_id').val($('#district_select').val());
        checkOngkir();
    });

    $('#courier_select').on('change', function() {
        let cost = parseInt($(this).val() || 0);
        if (!cost && $(this).val() === "") { resetOngkirUI(); return; }
        let selected = $(this).find('option:selected');
        $('#ongkir_hidden').val(cost);
        $('#courier_hidden').val($('#courier_service').val());
        $('#courier_service_hidden').val(selected.data('service'));
        updatePriceSummary(); // Update total saat ongkir dipilih
    });
    
    function checkOngkir() {
        let destination = $('#district_select').val();
        let courier = $('#courier_service').val();
        if (!destination || !courier) { resetOngkirUI(); return; }

        // Calculate dynamic weight based on variations
        calculateTotalWeight().then(weight => {
            $.ajax({
                url: '{{ route("api.get.ongkir") }}', type: 'POST',
                data: { _token: '{{ csrf_token() }}', origin_id: 115, destination_id: destination, weight: weight, courier: courier },
                beforeSend: () => $('#courier_select').html('<option>Memuat...</option>').prop('disabled', true),
                success: function(response) {
                    if (response.status === 'success' && response.data.length > 0) {
                        let html = '<option value="">-- Pilih Paket --</option>';
                        response.data.forEach(item => {
                            let cost = item.cost;
                            let formattedCost = formatRupiah(cost);
                            html += `<option value="${cost}" data-service="${item.service}">${item.code.toUpperCase()} - ${item.description} (${item.etd} hari) - ${formattedCost}</option>`;
                        });
                        $('#courier_select').html(html).prop('disabled', false);
                    } else {
                        let msg = response.message || 'Layanan tidak tersedia';
                        $('#courier_select').html(`<option value="">${msg}</option>`).prop('disabled', true);
                    }
                },
                error: () => $('#courier_select').html('<option>Gagal memuat</option>').prop('disabled', true)
            });
        }).catch(error => {
            console.error('Error calculating weight:', error);
            // Fallback to default weight if calculation fails
            $.ajax({
                url: '{{ route("api.get.ongkir") }}', type: 'POST',
                data: { _token: '{{ csrf_token() }}', origin_id: 115, destination_id: destination, weight: 1000, courier: courier },
                beforeSend: () => $('#courier_select').html('<option>Memuat...</option>').prop('disabled', true),
                success: function(response) {
                    if (response.status === 'success' && response.data.length > 0) {
                        let html = '<option value="">-- Pilih Paket --</option>';
                        response.data.forEach(item => {
                            let cost = item.cost;
                            let formattedCost = formatRupiah(cost);
                            html += `<option value="${cost}" data-service="${item.service}">${item.code.toUpperCase()} - ${item.description} (${item.etd} hari) - ${formattedCost}</option>`;
                        });
                        $('#courier_select').html(html).prop('disabled', false);
                    } else {
                        let msg = response.message || 'Layanan tidak tersedia';
                        $('#courier_select').html(`<option value="">${msg}</option>`).prop('disabled', true);
                    }
                },
                error: () => $('#courier_select').html('<option>Gagal memuat</option>').prop('disabled', true)
            });
        });
    }

    // Function to calculate total weight dynamically
    function calculateTotalWeight() {
        return new Promise((resolve, reject) => {
            let variations = [];
            
            // Collect all variations data
            $('#variations-container .variation-item').each(function() {
                let variation = $(this);
                let bahanId = variation.find('.bahan-select').val();
                let quantity = parseInt(variation.find('.quantity-input').val()) || 0;
                
                if (bahanId && quantity > 0) {
                    variations.push({
                        bahan_id: bahanId,
                        quantity: quantity
                    });
                }
            });

            if (variations.length === 0) {
                resolve(1000); // Default weight if no variations
                return;
            }

            // Send AJAX request to calculate weight
            $.ajax({
                url: '{{ route("user.customorder.calculate.weight") }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    variations: variations
                },
                success: function(response) {
                    if (response.success) {
                        resolve(response.total_weight);
                    } else {
                        reject('Failed to calculate weight');
                    }
                },
                error: function() {
                    reject('Error calculating weight');
                }
            });
        });
    }

    function resetOngkirUI() {
        $('#courier_select').html('<option>-- Pilih Alamat & Jasa Pengiriman --</option>').prop('disabled', true);
        $('#ongkir_hidden').val('');
        updatePriceSummary(); // Update total saat ongkir direset
    }

    // FUNGSI SUBMIT FORM
    $('#reviewOrderButton').on('click', function(e) {
        e.preventDefault();

        // Validasi
        let totalQty = 0;
        let hasValidVariation = false;
        
        $('.variation-item').each(function() {
            const variation = $(this).data('variation');
            const qty = parseInt($(`.quantity-input[data-variation="${variation}"]`).val()) || 0;
            const bahanId = $(`.bahan-select[data-variation="${variation}"]`).val();
            const sizeId = $(`.size-select[data-variation="${variation}"]`).val();
            const sablonId = $(`.jenis-sablon-select[data-variation="${variation}"]`).val();
            
            if (bahanId && sizeId && sablonId && qty > 0) {
                hasValidVariation = true;
                totalQty += qty;
            }
        });

        if (!hasValidVariation) {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Silakan lengkapi minimal satu variasi produk.' });
            return;
        }
        
        if (totalQty < 12) {
            Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Minimum total kuantitas pemesanan adalah 12 pcs.' });
            return;
        }

        if (!$('#front_design_file').val()) {
            Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Harap upload file desain depan.' });
            return;
        }

        // Validasi desain belakang jika dicentang
        if ($('#has_back_design').is(':checked') && !$('#back_design_file').val()) {
            Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Harap upload file desain belakang atau hapus centang pada opsi desain belakang.' });
            return;
        }

        if (!$('#address').val().trim()) {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Silakan isi alamat pengiriman.' });
            return;
        }

        if (!$('#ongkir_hidden').val()) {
            Swal.fire({ icon: 'error', title: 'Oops...', text: 'Silakan pilih paket pengiriman.' });
            return;
        }

        // Populate review modal
        $('#review_name').text($('#name').val());
        $('#review_front_position').text($('#front_position option:selected').text());
        $('#review_colors').text($('#design_description').val() || '-');
        
        // Show front design preview
        const frontFileInput = $('#front_design_file')[0];
        if (frontFileInput.files && frontFileInput.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#review_front_design_preview').attr('src', e.target.result);
            };
            reader.readAsDataURL(frontFileInput.files[0]);
        }

        // Show back design if exists
        if ($('#has_back_design').is(':checked') && $('#back_design_file').val()) {
            $('#review_back_design_section').show();
            $('#review_back_position').text($('#back_position option:selected').text());
            
            const backFileInput = $('#back_design_file')[0];
            if (backFileInput.files && backFileInput.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#review_back_design_preview').attr('src', e.target.result);
                };
                reader.readAsDataURL(backFileInput.files[0]);
            }
        } else {
            $('#review_back_design_section').hide();
        }
        
        // Show variations in review
        let reviewItemsHtml = '<div class="table-responsive"><table class="table table-sm table-bordered"><thead><tr><th>Bahan</th><th>Ukuran</th><th>Sablon</th><th>Qty</th><th>Subtotal</th></tr></thead><tbody>';
        
        $('.variation-item').each(function() {
            const variation = $(this).data('variation');
            const bahanText = $(`.bahan-select[data-variation="${variation}"] option:selected`).text();
            const sizeText = $(`.size-select[data-variation="${variation}"] option:selected`).text();
            const sablonText = $(`.jenis-sablon-select[data-variation="${variation}"] option:selected`).text();
            const qty = $(`.quantity-input[data-variation="${variation}"]`).val();
            const subtotalText = $(`.subtotal-display[data-variation="${variation}"]`).val();
            
            if (bahanText && sizeText && sablonText && qty) {
                reviewItemsHtml += `<tr><td>${bahanText}</td><td>${sizeText.split(' - ')[0]}</td><td>${sablonText.split(' - ')[0]}</td><td>${qty} pcs</td><td>${subtotalText}</td></tr>`;
            }
        });
        
        reviewItemsHtml += '</tbody></table></div>';
        $('#review_items_summary').html(reviewItemsHtml);

        // Alamat
        let province = $('#province_select').select2('data')[0]?.text || '';
        let city = $('#city_select').select2('data')[0]?.text || '';
        let district = $('#district_select').select2('data')[0]?.text || '';
        let address = $('#address').val();
        let fullAddress = `${address}\n${district}, ${city}, ${province}`;
        $('#review_address').text(fullAddress);

        // Copy price summary
        $('#review_price_summary').html($('#price-summary-container').html());
        $('#review_price_summary .alert').remove();

        // Copy estimation summary
        if ($('#estimation-container').is(':visible')) {
            $('#review_estimation').html(`
                <h6><strong><i class="fas fa-clock mr-2"></i>Estimasi Pengerjaan</strong></h6>
                ${$('#estimation-content').html()}
            `).addClass('alert alert-info');
        } else {
            $('#review_estimation').empty().removeClass('alert alert-info');
        }

        // Show modal
        $('#confirmationModal').modal('show');
    });

    // Submit form final
    $('#confirmAndSubmitOrder').on('click', function() {
        const submitButton = $(this);
        submitButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Memproses...');

        // Set legacy fields untuk kompatibilitas backend
        $('#position_legacy').val($('#front_position').val());

        const formData = new FormData($('#customOrderForm')[0]);

        $.ajax({
            url: '{{ route("user.customorder.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#confirmationModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: response.success || 'Pesanan custom Anda berhasil disubmit.',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    window.location.href = '{{ route("user.customorder.history") }}';
                });
            },
            error: function(xhr) {
                $('#confirmationModal').modal('hide');
                let errorMsg = 'Terjadi kesalahan. Pastikan semua field telah terisi dengan benar.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMsg = Object.values(xhr.responseJSON.errors).map(e => `<li>${e.join(', ')}</li>`).join('');
                    errorMsg = `<ul class="text-left" style="padding-left: 20px;">${errorMsg}</ul>`;
                } else if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }
                Swal.fire({ icon: 'error', title: 'Gagal!', html: errorMsg });
            },
            complete: function() {
                submitButton.prop('disabled', false).html('<i class="fas fa-check"></i> Ya, Konfirmasi & Proses Pesanan');
                $('#reviewOrderButton').prop('disabled', false);
            }
        });
    });
});
</script>
@endpush