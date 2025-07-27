@extends('frontend.main_master')
@section('title', 'Checkout Custom Order')

@section('content')
<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li><a href="{{ route('user.customorder') }}">Custom Studio</a></li>
                <li class='active'>@yield('title')</li>
            </ul>
        </div>
    </div>
</div>

<div class="body-content">
    <div class="container">
        <div class="checkout-box">
            <form id="checkoutForm" role="form">
                @csrf
                {{-- Input tersembunyi untuk data dari studio --}}
                <input type="hidden" name="fabric_type" id="fabric_type">
                <input type="hidden" name="jenis_sablon" id="jenis_sablon">
                <input type="hidden" name="bulk_orders_json" id="bulk_orders_json">
                <input type="hidden" name="total_price" id="total_price">
                <input type="hidden" name="final_design_image" id="final_design_image">
                 {{-- Tambahan untuk alamat --}}
                 <input type="hidden" name="province" id="province_name">
                 <input type="hidden" name="regency" id="regency_name">
                 <input type="hidden" name="district" id="district_name">
                 <input type="hidden" name="village" id="village_name">
                 <input type="hidden" name="courier_service" id="courier_service">


                <div class="row">
                    <div class="col-md-8">
                        <div class="panel-group checkout-steps" id="accordion">
                            <div class="panel panel-default checkout-step-01">
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">
                                        <a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
                                            <span>1</span>Alamat Pengiriman
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="info-title" for="name">Nama Lengkap <span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input" id="name" name="name" value="{{ Auth::user()->name }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="info-title" for="email">Email <span>*</span></label>
                                                    <input type="email" class="form-control unicase-form-control text-input" id="email" name="email" value="{{ Auth::user()->email }}" required>
                                                </div>
                                            </div>
                                             <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="info-title" for="phone">No. Telepon <span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input" id="phone" name="phone" value="{{ Auth::user()->phone }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                 <div class="form-group">
                                                    <label class="info-title" for="address">Alamat Lengkap <span>*</span></label>
                                                    <textarea class="form-control" name="address" id="address" cols="30" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            {{-- Form Alamat & Ongkir bisa ditambahkan di sini --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="checkout-progress-sidebar">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="unicase-checkout-title">Ringkasan Pesanan Custom Anda</h4>
                                    </div>
                                    <div class="panel-body">
                                        <h5>Desain Final:</h5>
                                        <img id="summary_design_image" src="" alt="Final Design" class="img-responsive" style="border: 1px solid #ddd; margin-bottom: 15px;">
                                        
                                        <ul class="list-group">
                                            <li class="list-group-item"><strong>Bahan:</strong> <span id="summary_fabric"></span></li>
                                            <li class="list-group-item"><strong>Sablon:</strong> <span id="summary_sablon"></span></li>
                                            <li class="list-group-item"><strong>Detail Pesanan:</strong>
                                                <table class="table table-condensed" id="summary_bulk_orders">
                                                    </table>
                                            </li>
                                             <li class="list-group-item"><strong>Total Kuantitas:</strong> <span id="summary_total_qty"></span> pcs</li>
                                            <li class="list-group-item"><strong>Subtotal:</strong> <span id="summary_subtotal"></span></li>
                                            {{-- <li class="list-group-item"><strong>Ongkir:</strong> <span id="summary_ongkir"></span></li> --}}
                                            <li class="list-group-item active"><h4><strong>Total:</strong> <span id="summary_total"></span></h4></li>
                                        </ul>
                                        
                                        <hr>
                                        <button type="submit" id="placeOrderBtn" class="btn btn-primary btn-block">Buat Pesanan & Lanjutkan Pembayaran</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
$(document).ready(function() {
    // 1. Ambil data dari sessionStorage
    const customOrderData = JSON.parse(sessionStorage.getItem('customOrderData'));

    // Jika tidak ada data, redirect kembali ke studio
    if (!customOrderData) {
        window.location.href = "{{ route('user.customorder') }}";
        return;
    }

    // 2. Tampilkan data di halaman ringkasan
    $('#summary_design_image').attr('src', customOrderData.finalDesign);
    $('#summary_fabric').text(customOrderData.fabricType);
    $('#summary_sablon').text(customOrderData.sablonType);
    $('#summary_subtotal').text('Rp ' + customOrderData.totalPrice.toLocaleString('id-ID'));
    $('#summary_total').text('Rp ' + customOrderData.totalPrice.toLocaleString('id-ID')); // Sementara total = subtotal
    
    let totalQty = 0;
    let bulkTable = '';
    customOrderData.bulkOrders.forEach(order => {
        totalQty += parseInt(order.quantity);
        bulkTable += `<tr><td>${order.size}</td><td>: ${order.quantity} pcs</td></tr>`;
    });
    $('#summary_bulk_orders').html(bulkTable);
    $('#summary_total_qty').text(totalQty);


    // 3. Isi hidden input fields untuk dikirim ke controller
    $('#fabric_type').val(customOrderData.fabricType);
    $('#jenis_sablon').val(customOrderData.sablonType);
    $('#bulk_orders_json').val(JSON.stringify(customOrderData.bulkOrders));
    $('#total_price').val(customOrderData.totalPrice);
    $('#final_design_image').val(customOrderData.finalDesign);


    // 4. Handle submit form checkout
    $('#checkoutForm').on('submit', function(e){
        e.preventDefault();
        
        const formData = new FormData(this);
        
        $.ajax({
            url: "{{ route('user.customorder.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $('#placeOrderBtn').prop('disabled', true).text('Memproses...');
            },
            success: function(response) {
                if(response.status === 'success'){
                     // Hapus data dari session storage setelah berhasil
                    sessionStorage.removeItem('customOrderData');

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                    }).then(() => {
                        window.location.href = response.redirect_url;
                    });
                }
            },
            error: function(xhr) {
                 Swal.fire('Gagal', 'Terjadi kesalahan. Pastikan semua data terisi.', 'error');
            },
            complete: function() {
                 $('#placeOrderBtn').prop('disabled', false).text('Buat Pesanan & Lanjutkan Pembayaran');
            }
        });
    });
});
</script>
@endpush