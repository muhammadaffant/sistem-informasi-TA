@extends('frontend.main_master')

@section('title', 'Detail Custom Order')

@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li><a href="{{ route('user.customorder.history') }}">History Custom Order</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="body-content">
        <div class="container">
            <a href="{{ route('user.customorder.history') }}" class="btn btn-sm btn-warning mb-3">Kembali</a>
            <div class="row">
                {{-- KOLOM KIRI: DETAIL PESANAN --}}
                <div class="col-md-8">
                    <div class="card" style="border: 1px solid #e0e0e0; padding: 20px;">
                        <h4 class="card-title">Detail Pesanan Custom</h4>
                        <hr>
                        <p><strong>Tanggal Pesan:</strong> {{ \Carbon\Carbon::parse($customOrder->order_date)->format('d M Y, H:i') }}</p>
                        <p><strong>Bahan Kain:</strong> {{ $customOrder->fabric_type }}</p>
                        <p><strong>Jenis Sablon:</strong> {{ $customOrder->jenis_sablon }}</p>
                        <p><strong>Warna:</strong> {{ $customOrder->design_description }}</p>
                        <hr>
                        <h5>Rincian Item:</h5>
                        @php
                            $sizeDetails = json_decode($customOrder->size, true);
                        @endphp

                        @if(is_array($sizeDetails) && json_last_error() === JSON_ERROR_NONE)
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-sm">
                                    <thead>
                                        <tr>
                                            <th>Ukuran</th>
                                            <th>Jumlah</th>
                                            <th>Harga Bahan (Satuan)</th>
                                            <th>Harga Sablon (Satuan)</th>
                                            <th>Subtotal per Item</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sizeDetails as $item)
                                            <tr>
                                                <td>{{ $item['size'] ?? 'N/A' }}</td>
                                                <td>{{ $item['quantity'] ?? 0 }} pcs</td>
                                                {{-- Tampilan harga bahan tanpa info diskon --}}
                                                <td>{{ 'Rp ' . number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
                                                <td>{{ 'Rp ' . number_format($item['sablon_price'] ?? 0, 0, ',', '.') }}</td>
                                                {{-- Subtotal per item yang sudah dihitung sebelumnya --}}
                                                <td>{{ 'Rp ' . number_format($item['subtotal'] ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p><strong>Ukuran:</strong> {{ $customOrder->size }}</p>
                        @endif
                    </div>
                </div>

                {{-- KOLOM KANAN: RINGKASAN BIAYA --}}
                <div class="col-md-4">
                    <div class="card" style="border: 1px solid #e0e0e0; padding: 20px;">
                        <h4 class="card-title">Ringkasan Biaya</h4>
                        <hr>
                        {{-- Tampilan ringkasan biaya disederhanakan --}}
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Subtotal Produk</th>
                                    <td class="text-right">{{ 'Rp ' . number_format($customOrder->total_price, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Ongkir ({{ strtoupper($customOrder->courir) }})</th>
                                    <td class="text-right">{{ 'Rp ' . number_format($customOrder->ongkir, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th><h5 class="font-weight-bold">Grand Total</h5></th>
                                    <td class="text-right"><h5 class="font-weight-bold">{{ 'Rp ' . number_format($customOrder->remaining_payment, 0, ',', '.') }}</h5></td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        
                        @php
                            // Logika untuk warna status badge
                            $status_color = '#6c757d'; // Abu-abu (default)
                            $text_color = 'white';
                            if ($customOrder->status == 'Success') {
                                $status_color = '#28a745'; // Hijau
                            } elseif ($customOrder->status == 'Pending' || $customOrder->status == 'Progress') {
                                $status_color = '#ffc107'; // Kuning
                                $text_color = 'black';
                            }
                        @endphp
                        <p><strong>Status Transaksi:</strong> 
                            <span class="badge badge-pill" style="background-color: {{ $status_color }}; color: {{ $text_color }};">
                                {{ $customOrder->status }}
                            </span>
                        </p>
                        
                        <p><strong>Status Pesanan:</strong> <span class="badge badge-pill badge-primary">{{ $customOrder->status_pesanan ?? 'Belum Diproses' }}</span></p>

                        <div class="mt-4 text-center">
                            @if ($customOrder->status == 'Success')
                                <p class="text-success font-weight-bold">Pembayaran Lunas</p>
                            @elseif ($customOrder->status == 'Progress')
                                <button class="btn btn-primary btn-lg" id="pay-button">Bayar Sekarang</button>
                            @else
                                <p class="text-muted">Menunggu persetujuan dan rincian biaya dari admin.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-top: 50px"></div>

    {{-- Form untuk pembayaran tidak perlu diubah --}}
    <form action="{{ route('user.customorder.payment') }}" method="post" id="submitForm">
        @csrf
        <input type="hidden" name="json" id="js_callback">
        <input type="hidden" name="custom_order_id" id="custom_order_id" value="{{ $customOrder->id }}">
    </form>

    @if ($customOrder->status == 'Progress')
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
                data-client-key="{{ config('midtrans.client_key') }}"></script>

        <script type="text/javascript">
            var payButton = document.getElementById('pay-button');
            payButton.addEventListener('click', function() {
                window.snap.pay('{{ $snapToken }}', {
                    onSuccess: function(result) { sendResponseToForm(result) },
                    onPending: function(result) { sendResponseToForm(result) },
                    onError: function(result) { sendResponseToForm(result) },
                    onClose: function() {
                        alert('Anda menutup pop-up pembayaran sebelum selesai.');
                    }
                });
            });

            function sendResponseToForm(result) {
                document.getElementById('js_callback').value = JSON.stringify(result);
                $('#submitForm').submit();
            }
        </script>
    @endif
@endsection