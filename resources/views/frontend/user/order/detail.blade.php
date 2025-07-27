@extends('frontend.main_master')

@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class="active">Detail</li>
                    <li class='active'>Order</li>
                </ul>
            </div></div></div>
    <div class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <br>
                    @include('frontend.common.user_sidebar')
                </div>
                <div class="col-md-10">
                    <br>
                    {{-- Tabel Informasi Pengiriman --}}
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Alamat</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $order->name }}</td>
                                    <td>{{ $order->phone }}</td>
                                    <td>{{ $order->address }}</td>
                                    <td>{{ $order->notes }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <p>
                        <strong class="text-danger">Catatan : {{ $order->notes }}</strong>
                    </p>

                    {{-- Tabel Item Pesanan --}}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Product Name</th>
                                            <th>Color</th>
                                            <th>Size</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orderItem as $item)
                                            <tr>
                                                <td>
                                                    <img src="{{ Storage::url($item->product->product_thumbnail) }}"
                                                        alt="" style="width: 60px; height:60px">
                                                </td>
                                                <td>{{ $item->product->product_name }}</td>
                                                <td>{{ $item->color }}</td>
                                                <td>{{ $item->size }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>Rp. {{ format_uang($item->price) }}</td>
                                                <td>Rp. {{ format_uang($item->price * $item->qty) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    {{-- =================== BAGIAN BARU UNTUK ONGKIR DAN TOTAL =================== --}}
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            {{-- Kolom ini bisa dibiarkan kosong atau diisi info lain --}}
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Subtotal Produk</th>
                                        {{-- Asumsi: Subtotal adalah Total Bayar dikurangi Ongkir --}}
                                        <td>Rp. {{ format_uang($order->amount - $order->ongkir) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Ongkos Kirim</th>
                                        {{-- Asumsi: field ongkir di database adalah 'ongkir' --}}
                                        <td>Rp. {{ format_uang($order->ongkir) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Total Bayar</th>
                                        {{-- Asumsi: field total bayar di database adalah 'amount' --}}
                                        <td><strong>Rp. {{ format_uang($order->amount) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{-- =================== AKHIR BAGIAN BARU =================== --}}

                </div>
            </div>
        </div>
    </div>

    <div style="margin-top: 50px"></div>
@endsection