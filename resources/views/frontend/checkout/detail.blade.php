@extends('frontend.main_master')

@section('title', 'Checkout Payment')

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
            <div class="checkout-box ">
                <div class="row">
                    <div class="col-md-8">
                        <div class="checkout-progress-sidebar ">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="unicase-checkout-title">Detail Order</h4>
                                    </div>

                                    {{-- Menggunakan data dari $orderItems --}}
                                    @foreach ($orderItems as $item)
                                        <div class="row" style="padding: 10px;">
                                            <div class="col-md-4">
                                                {{-- Pastikan relasi 'product' dan field 'product_thambnail' ada --}}
                                                <img src="{{ Storage::url($item->product->product_thumbnail) }}" alt="{{ $item->product->product_name }}" style="width: 100%">
                                            </div>
                                            <div class="col-md-8">
                                                <h4 class="unicase-checkout-title">{{ $item->product->product_name }}</h4>
                                                <hr>
                                                <p class="unicase-checkout-title">Quantity: {{ $item->qty }} | Color:
                                                    {{ $item->color }} | Size: {{ $item->size }}</p>
                                                <hr>
                                                <p class="unicase-checkout-title">Price: Rp. {{ number_format($item->price, 0, ',', '.') }}
                                                </p>
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                        </div>

                    <div class="col-md-4">
                        <div class="checkout-progress-sidebar ">
                            <div class="panel-group">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="unicase-checkout-title">Shipping Address</h4>
                                    </div>
                                    <div class="panel-body">
                                        {{-- Menggunakan data dari object $order --}}
                                        <strong>Name: {{ $order->name }}</strong>
                                        <hr>
                                        <strong>Phone: {{ $order->phone }}</strong>
                                        <hr>
                                        <strong>Address: {{ $order->address }}</strong>
                                        <hr>
                                        <strong>Post Code: {{ $order->post_code }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="checkout-progress-sidebar ">
                            <div class="panel-group">
                                <div class="panel panel-default checkout-step-02">
                                    <div class="panel-heading">
                                        <h4 class="unicase-checkout-title">
                                            <a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapseTwo">
                                                <span></span>Lihat Catatan
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapseTwo" class="panel-collapse collapse">
                                        <div class="panel-body">
                                            {{ $order->notes ?? 'Tidak ada catatan.' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <Strong>Subtotal : Rp. {{ number_format($subtotal, 0, ',', '.') }} </Strong>
                                        <hr>
                                        <Strong>Ongkir : Rp. {{ number_format($order->ongkir, 0, ',', '.') }} </Strong>
                                        <hr>
                                        <Strong>Grand Total : Rp. {{ number_format($order->amount, 0, ',', '.') }} </Strong>
                                        <hr>
                                        <button class="btn btn-primary" id="pay-button">Pay Now</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Form ini hanya untuk mengirim callback dari Midtrans --}}
        <form action="{{ route('checkout.store') }}" method="post" id="submitForm">
            @csrf
            <input type="hidden" name="json" id="js_callback">
            <input type="hidden" name="id_order" value="{{ $order->id }}">
        </form>

        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('midtrans.client_key') }}"></script>

        <script type="text/javascript">
            var payButton = document.getElementById('pay-button');
            payButton.addEventListener('click', function() {
                // Gunakan snap_token dari object $order
                window.snap.pay('{{ $order->snap_token }}', {
                    onSuccess: function(result) {
                        sendResponseToForm(result)
                    },
                    onPending: function(result) {
                        sendResponseToForm(result)
                    },
                    onError: function(result) {
                        sendResponseToForm(result)
                    },
                    onClose: function() {
                        alert('Anda menutup jendela popup tanpa menyelesaikan pembayaran.');
                    }
                });
            });

            function sendResponseToForm(result) {
                document.getElementById('js_callback').value = JSON.stringify(result);
                // Hapus baris yang salah ini: document.getElementById('id_order').value = $(this).val()
                $('#submitForm').submit();
            }
        </script>
@endsection