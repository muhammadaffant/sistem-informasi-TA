@extends('frontend.main_master')

@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class='active'>History Custom Order</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div>


    <div class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-md-0">
                    <br>
                    {{--  @include('frontend.common.user_sidebar')  --}}
                </div>
                <div class="col-md-12">
                    <a href="{{ route('user.customorder.history') }}" class="btn btn-sm btn-warning">Kembali</a>
                    <br>
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Ongkir</th>
                                    <th>Deskripsi</th>
                                    <th>Size</th>
                                    <th>Status Transaksi</th>
                                    <th>Status Pesanan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customOrders as $item)
                                    <tr>
                                        <td>{{ $item->order_date }}</td>
                                        <td>{{ $item->total_price }}</td>
                                        <td>{{ $item->ongkir }}</td>
                                        <td>{{ $item->design_description }} </td>
                                        <td>
    @php
        // Decode string JSON menjadi array PHP
        $sizeDetails = json_decode($item->size, true);
    @endphp

    {{-- Cek apakah data tersebut valid JSON dan merupakan array --}}
    @if(is_array($sizeDetails) && json_last_error() === JSON_ERROR_NONE)
        <ul style="padding-left: 15px; margin-bottom: 0; font-size: 12px;">
            @foreach($sizeDetails as $detail)
                {{-- Tampilkan setiap ukuran dan kuantitasnya --}}
                <li>{{ $detail['size'] ?? 'N/A' }} ({{ $detail['quantity'] ?? 0 }} pcs)</li>
            @endforeach
        </ul>
    @else
        {{-- Jika bukan JSON (untuk data lama), tampilkan apa adanya --}}
        {{ $item->size }}
    @endif
</td>
                                        <td>
                                            <span class="badge" style="background-color: rgb(65, 66, 65); color: white;">{{ $item->status }}</span>
                                        </td>
                                        <td>
                                            @if (!empty($item->status_pesanan))
                                                <span class="badge" style="background-color: rgb(28, 172, 67); color: white;">{{ $item->status_pesanan }}</span>
                                            @else
                                                <span class="badge" style="background-color: rgb(255, 193, 7); color: black;">Belum Diproses</span>
                                            @endif
                                        </td>
                                        
                                        <td>
                                            @if ($item->total_price == 0)
                                                <p>Menunggu Persetujuan Admin</p>
                                            @else
                                                <a href="{{ route('user.customorder.detail', $item->id) }}"
                                                    class="btn btn-sm btn-info"><i class="fa fa-eye"></i>
                                                    View</a>

                                                <a href="{{ route('user.order.invoice_customorder', $item->id) }}"
                                                    class="btn btn-sm btn-danger" target="_blank"><i
                                                        class="fa fa-download"></i>
                                                    Invoice</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div style="margin-top: 300px">

    </div>
    {{--  @include('frontend.body.brands')  --}}
@endsection
