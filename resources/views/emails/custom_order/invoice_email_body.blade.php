<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pesanan Custom</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            -webkit-font-smoothing: antialiased;
            font-size: 16px;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f6f6f6;
        }
    </style>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased; font-size: 16px; line-height: 1.6; margin: 0; padding: 0; background-color: #f6f6f6;">
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background-color: #f6f6f6;">
        <tr>
            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; display: block; margin: 0 auto; max-width: 580px; padding: 10px; width: 580px;">
                <div style="box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px;">
                    <div style="text-align: center; padding: 20px 0;">
                        <h2 style="color: #0056b3; font-size: 26px; font-weight: bold; margin: 0;">Viary Store</h2>
                    </div>
                    <table role="presentation" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; background: #ffffff; border-radius: 5px; border: 1px solid #e9e9e9;">
                        <tr>
                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; box-sizing: border-box; padding: 30px;">
                                <h1 style="font-size: 24px; font-weight: 600; color: #333333; margin: 0 0 20px 0;">Pembayaran Berhasil! ✅</h1>
                                {{-- Gunakan nama dari relasi user --}}
                                <p style="margin: 0 0 15px 0;">Halo <strong>{{ $order->user->name }}</strong>,</p>
                                <p style="margin: 0 0 15px 0;">Terima kasih telah melakukan pemesanan custom di Viary Store. Kami telah menerima pembayaran Anda</p>
                                
                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; margin-top: 30px; border-top: 1px solid #eeeeee;">
                                    <tr><td style="padding-top: 20px;"></td></tr>
                                    <tr>
                                        <td colspan="2" style="padding-bottom: 15px;">
                                            <h3 style="margin: 0; font-size: 18px; font-weight: 600;">Ringkasan Pesanan Custom</h3>
                                        </td>
                                    </tr>
                                    {{-- <tr>
                                        Custom Order menggunakan 'id' sebagai nomor referensi
                                        <td style="width: 150px; padding: 8px 0; color: #555;">Nomor Pesanan</td>
                                        <td style="padding: 8px 0;">: <strong>#{{ $order->id }}</strong></td>
                                    </tr> --}}
                                    <tr>
                                        {{-- Custom Order menggunakan 'order_date' --}}
                                        <td style="width: 150px; padding: 8px 0; color: #555;">Tanggal Pesanan</td>
                                        <td style="padding: 8px 0;">: {{ \Carbon\Carbon::parse($order->order_date)->format('d F Y') }}</td>
                                    </tr>
                                     <tr>
                                        <td style="width: 150px; padding: 8px 0; color: #555;">Metode Pembayaran</td>
                                        <td style="padding: 8px 0;">: {{ ucwords(str_replace('_', ' ', $order->payment_type)) }}</td>
                                    </tr>
                                    <tr>
                                        {{-- INI BAGIAN PENTING: Gunakan 'remaining_payment' --}}
                                        <td style="width: 150px; padding: 8px 0; font-weight: bold; color: #333;">Total Pembayaran</td>
                                        <td style="padding: 8px 0; font-weight: bold; color: #0056b3;">: Rp {{ number_format($order->remaining_payment, 0, ',', '.') }}</td>
                                    </tr>
                                </table>

                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; box-sizing: border-box; margin-top: 30px;">
                                    <tbody>
                                        <tr>
                                            <td align="center" style="font-family: sans-serif; font-size: 14px; vertical-align: top; padding-bottom: 15px;">
                                                <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: auto;">
                                                    <tbody>
                                                        <tr>
                                                            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top; background-color: #0056b3; border-radius: 5px; text-align: center;">
                                                                {{-- Arahkan ke history custom order --}}
                                                                <a href="{{ route('user.customorder.history') }}" target="_blank" style="display: inline-block; color: #ffffff; background-color: #0056b3; border: solid 1px #0056b3; border-radius: 5px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #0056b3;">Lihat Riwayat Pesanan</a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <p style="margin: 30px 0 15px 0;">Pesanan Anda akan segera kami proses dan kirim ke alamat yang tertera. Terima kasih sekali lagi!</p>
                                <p style="margin: 0;">Salam hangat,<br>Tim Viary Store</p>
                            </td>
                        </tr>
                        </table>
                    <div style="clear: both; margin-top: 10px; text-align: center; width: 100%;">
                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;">
                            <tr>
                                <td style="font-family: sans-serif; vertical-align: top; padding: 20px; font-size: 12px; color: #999999; text-align: center;">
                                    <span style="color: #999999; font-size: 12px; text-align: center;">Viary Store | Tegal,Jawa Tengah, Kecamatan adiwerna, Kabupaten Tegal, 52194</span><br>
                                    <span style="color: #999999; font-size: 12px; text-align: center;">Email ini dikirim secara otomatis. Mohon tidak membalas email ini.</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    </div>
            </td>
            <td style="font-family: sans-serif; font-size: 14px; vertical-align: top;">&nbsp;</td>
        </tr>
    </table>
</body>
</html>