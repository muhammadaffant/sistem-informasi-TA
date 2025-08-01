<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        .invoice-container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .header h2 {
            color: #007bff;
            margin: 0;
            font-size: 26px;
        }

        .header .contact-info {
            text-align: right;
            font-size: 14px;
            line-height: 1.5;
        }

        .details {
            margin: 20px 0;
            font-size: 15px;
        }

        .details strong {
            color: #007bff;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 14px;
        }

        .table thead {
            background-color: #800000;
            color: #ffffff;
        }

        .table th,
        .table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .summary {
            text-align: right;
            margin-top: 20px;
            font-size: 16px;
            width: 50%;
            margin-left: 50%;
        }

        .summary table {
            width: 100%;
            text-align: right;
        }

        .summary table td {
            padding: 5px;
        }
        
        .summary .subtotal-produk {
            font-weight: bold;
            border-top: 1px solid #ccc;
            padding-top: 8px !important;
            margin-top: 8px;
        }

        .summary .grand-total {
            font-weight: bold;
            font-size: 1.2em;
            border-top: 2px solid #333;
            padding-top: 10px !important;
            margin-top: 10px;
        }

        .thanks {
            margin-top: 30px;
            text-align: center;
            font-size: 16px;
            color: #007bff;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .signature p {
            margin: 0;
        }

        .signature h5 {
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <div class="header">
            <h2>viary store</h2>
            <div class="contact-info">
                <p>Viary Store<br>
                    Email: viastores12@gmail.com<br>
                    Phone: 085701297321</p>
            </div>
        </div>

        <div class="details">
            <p><strong>Nama:</strong> {{ $customOrder->user->name }}<br>
                <strong>Email:</strong> {{ $customOrder->user->email }}<br>
                <strong>Phone:</strong> {{ $customOrder->user->numberphone }}<br>
                <strong>Alamat Lengkap:</strong> {{ $customOrder->address }}<br>
                <strong>Kurir: </strong> {{ $customOrder->courir ?? '-' }}
            </p>
            <p>
                <strong>Order Date:</strong> {{ $customOrder->order_date }}<br>
                <strong>Delivery Date:</strong> {{ $customOrder->completion_date }}<br>
                <strong>Payment Type:</strong> {{ $customOrder->payment_type }}
            </p>
        </div>

        <h3>Products</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Ukuran</th>
                    <th>Bahan</th>
                    <th>Harga Bahan</th>
                    <th>Harga Sablon</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sizeDetails = json_decode($customOrder->size, true);
                @endphp

                @if(is_array($sizeDetails) && json_last_error() === JSON_ERROR_NONE)
                    @foreach($sizeDetails as $item)
                        <tr>
                            <td>{{ $customOrder->name }}</td>
                            <td>{{ $item['size'] ?? 'N/A' }}</td>
                            <td>{{ $customOrder->fabric_type }}</td>
                            <td>Rp. {{ number_format($item['price'] ?? 0) }}</td>
                            <td>Rp. {{ number_format($item['sablon_price'] ?? 0) }}</td>
                            <td>{{ $item['quantity'] ?? 0 }}</td>
                            <td>Rp. {{ number_format($item['subtotal'] ?? 0) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="7">Detail produk tidak tersedia.</td>
                    </tr>
                @endif
            </tbody>
        </table>

        @php
            // Lakukan kalkulasi total bahan dan sablon di sini
            $totalHargaBahan = 0;
            if (is_array($sizeDetails)) {
                foreach ($sizeDetails as $item) {
                    $totalHargaBahan += ($item['price'] ?? 0) * ($item['quantity'] ?? 0);
                }
            }
            $totalHargaSablon = $customOrder->sablon_price * $customOrder->qty;
        @endphp

        <div class="summary">
            <table>
                <tr>
                    <td>Total Harga Bahan</td>
                    <td>Rp. {{ number_format($totalHargaBahan) }}</td>
                </tr>
                <tr>
                    <td>Total Harga Sablon</td>
                    <td>Rp. {{ number_format($totalHargaSablon) }}</td>
                </tr>
                <tr class="subtotal-produk">
                    <td>Subtotal Produk</td>
                    <td>Rp. {{ number_format($customOrder->total_price) }}</td>
                </tr>
                <tr>
                    <td>Ongkir</td>
                    <td>Rp. {{ number_format($customOrder->ongkir) }}</td>
                </tr>
                <tr class="grand-total">
                    <td>Total Tagihan</td>
                    <td>Rp. {{ number_format($customOrder->remaining_payment) }}</td>
                </tr>
            </table>
            <h3 style="color: green; margin-top: 15px;">Payment Status: {{ $customOrder->status }}</h3>
        </div>

        <div class="thanks">
            <p>Terima kasih telah membeli produk!</p>
        </div>

        <div class="signature">
            <p>-----------------------</p>
            <h5>Viary Store</h5>
        </div>
    </div>
</body>

</html>