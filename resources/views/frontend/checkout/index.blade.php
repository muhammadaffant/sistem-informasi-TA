@extends('frontend.main_master')
@section('title', 'Checkout')
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
            <div class="row">
                <form class="register-form" role="form" method="post" action="{{ route('user.checkout.detail') }}">
                    @csrf
                    {{-- Hidden inputs to store final values --}}
                    <input type="hidden" name="province_id" id="province_id_hidden">
                    <input type="hidden" name="city_id" id="city_id_hidden">
                    <input type="hidden" name="district_id" id="district_id_hidden">
                    <input type="hidden" name="courier_hidden" id="courier_hidden">
                    <input type="hidden" name="courier_service_hidden" id="courier_service_hidden">
                    <input type="hidden" name="shipping_cost" id="shipping_cost_hidden">

                    <div class="col-md-8">
                        <div class="panel-group checkout-steps" id="accordion">
                            <div class="panel panel-default checkout-step-01">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-6 col-sm-6 guest-login">
                                            <h4 class="checkout-subtitle"><b>Detail Pengiriman</b></h4>
                                            <div class="form-group"><label>Nama Lengkap</label><input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required></div>
                                            <div class="form-group"><label>Email</label><input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required></div>
                                            <div class="form-group"><label>Telepon</label><input type="text" class="form-control" name="phone" value="{{ Auth::user()->numberphone }}" required></div>
                                            <div class="form-group"><label>Kode Pos</label><input type="text" class="form-control" name="post_code" required></div>
                                        </div>
                                        <div class="col-md-6 col-sm-6 already-registered-login">
                                            <h4 class="checkout-subtitle"><b>Alamat & Kurir</b></h4>
                                            <div class="form-group"><label>Pilih Provinsi</label><select id="province_select" class="form-control select2"></select></div>
                                            <div class="form-group"><label>Pilih Kabupaten/Kota</label><select id="city_select" class="form-control select2" disabled></select></div>
                                            <div class="form-group"><label>Pilih Kecamatan</label><select id="district_select" class="form-control select2" disabled></select></div>
                                            <div class="form-group"><label>Pilih Jasa Pengiriman</label><select id="courier_service" class="form-control" required><option value="">-- Pilih --</option><option value="jne">JNE</option><option value="pos">POS Indonesia</option><option value="tiki">TIKI</option></select></div>
                                            <div class="form-group"><label>Pilih Paket</label><select id="courier_select" class="form-control" required disabled><option>-- Pilih Alamat & Jasa Pengiriman --</option></select></div>
                                            <div class="form-group"><label>Alamat Lengkap</label><textarea class="form-control" name="address" rows="3" required></textarea></div>
                                            <div class="form-group"><label>Catatan (Opsional)</label><textarea class="form-control" name="notes" rows="3"></textarea></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                 <div class="col-md-4">
                        <!-- checkout-progress-sidebar -->
                        <div class="checkout-progress-sidebar ">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="unicase-checkout-title">Your Checkout Progress</h4>
                                    </div>
                                    <div class="">
                                        <ul class="nav nav-checkout-progress list-unstyled">
                                            @foreach ($carts as $item)
                                                <li>
                                                    <strong>Image: </strong>
                                                    <img src="{{ url($item->options->image) }}" alt=""
                                                        width="50px;" height="50px;">
                                                </li>
                                                <li>
                                                    <strong>Qty: </strong>
                                                    ({{ $item->qty }})
                                                    <strong>Color: </strong>
                                                    ({{ $item->options->color }})

                                                    <strong>Size: </strong>
                                                    ({{ $item->options->size }})
                                                </li>
                                                <hr>
                                            @endforeach
                                            <strong>Grand Total:</strong> Rp. {{ $total }}
                                            <hr>

                                            <button type="submit" class="btn btn-primary">Continue to Checkout</button>
                                            </form>
                                            <!-- radio-form  -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
$(function() {
    let subtotal = {{ (int) str_replace(',', '', Cart::total()) }};

    // Initialize Select2
    $('#province_select').select2({ placeholder: '-- Pilih Provinsi --', ajax: { url: '{{ route("api.get.provinces") }}', dataType: 'json', delay: 250, data: p => ({ q: p.term }), processResults: r => ({ results: $.map(r, i => ({ text: i.name, id: i.id })) }) } });
    $('#city_select').select2({ placeholder: '-- Pilih Kabupaten/Kota --', ajax: { url: p => p.term ? null : ('{{ url("api/get-cities") }}/' + $('#province_select').val()), dataType: 'json', delay: 250, data: p => ({ q: p.term }), processResults: r => ({ results: $.map(r, i => ({ text: i.name, id: i.id })) }) } });
    $('#district_select').select2({ placeholder: '-- Pilih Kecamatan --', ajax: { url: p => p.term ? null : ('{{ url("api/get-districts") }}/' + $('#city_select').val()), dataType: 'json', delay: 250, data: p => ({ q: p.term }), processResults: r => ({ results: $.map(r, i => ({ text: i.name, id: i.id })) }) } });

    // Event Handlers
    $('#province_select').on('change', function() {
        $('#province_id_hidden').val($(this).val());
        $('#city_select').val(null).trigger('change').prop('disabled', false);
        $('#district_select').val(null).trigger('change').prop('disabled', true);
        resetOngkirUI();
    });

    $('#city_select').on('change', function() {
        $('#city_id_hidden').val($(this).val());
        $('#district_select').val(null).trigger('change').prop('disabled', false);
        resetOngkirUI();
    });

    $('#district_select, #courier_service').on('change', function() {
        $('#district_id_hidden').val($('#district_select').val());
        checkOngkir();
    });

    $('#courier_select').on('change', function() {
        let cost = parseInt($(this).val() || 0);
        if (!cost) { resetOngkir(); return; }
        let selected = $(this).find('option:selected');
        $('#shipping_cost_hidden').val(cost);
        $('#courier_hidden').val($('#courier_service').val());
        $('#courier_service_hidden').val(selected.data('service'));
        $('#ongkir_text').text('Rp ' + cost.toLocaleString('id-ID'));
        $('#total_bayar_text').text('Rp ' + (subtotal + cost).toLocaleString('id-ID'));
    });

    // Helper Functions
 function checkOngkir() {
    let destination = $('#district_select').val();
    let courier = $('#courier_service').val();
    if (!destination || !courier) { resetOngkirUI(); return; }

    $.ajax({
        url: '{{ route("api.get.ongkir") }}',
        type: 'POST',
        data: { _token: '{{ csrf_token() }}', origin_id: 6097, destination_id: destination, weight: 1000, courier: courier },
        beforeSend: () => $('#courier_select').html('<option>Memuat...</option>').prop('disabled', true),

        // ==========================================================
        success: function(response) {
            if (response.status === 'success' && response.data.length > 0) {
                let html = '<option value="">-- Pilih Paket --</option>';

                // Loop langsung pada response.data karena strukturnya sudah flat
                response.data.forEach(item => {
                    let cost = item.cost;
                    // Pastikan 'service' dan 'description' ada di 'item'
                    html += `<option value="${cost}" data-service="${item.service}">${item.code.toUpperCase()} - ${item.description} (${item.service}) - Rp ${cost.toLocaleString('id-ID')}</option>`;
                });

                $('#courier_select').html(html).prop('disabled', false);
            } else {
                let msg = response.message || 'Layanan tidak tersedia';
                $('#courier_select').html(`<option value="">${msg}</option>`).prop('disabled', true);
            }
        },
        error: () => $('#courier_select').html('<option>Gagal memuat</option>').prop('disabled', true)
    });
}
    function resetOngkirUI() {
        $('#courier_select').html('<option>-- Pilih Alamat & Jasa Pengiriman --</option>').prop('disabled', true);
        $('#ongkir_text').text('Rp 0');
        $('#total_bayar_text').text('Rp ' + subtotal.toLocaleString('id-ID'));
        $('#shipping_cost_hidden').val('');
    }
});
</script>
@endpush