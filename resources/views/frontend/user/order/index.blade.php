@extends('frontend.main_master')

@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class='active'>History Order</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div>


    <div class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <br>
                    @include('frontend.common.user_sidebar')
                </div>
                <div class="col-md-2">

                </div>
                <div class="col-md-10">
                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Total</th>
                                    <th>Payment</th>
                                    <th>Invoice</th>
                                    <th>Transaksi Order</th>
                                    <th>Status Order</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $item)
                                    <tr>
                                        <td>{{ $item->created_at->format('d F Y') }}</td>
                                        <td>Rp. {{ number_format($item->amount, 0, ',', '.') }}</td>
                                        <td>{{ $item->payment_type ?? 'N/A' }}</td>
                                        <td>{{ $item->invoice_no }}</td>
                                        <td>
                                            @if ($item->status == 'Pending')
                                                <span class="badge" style="background-color: orange; color: black;">{{ $item->status }}</span>
                                            @elseif ($item->status == 'Success')
                                                <span class="badge" style="background-color: green; color: white;">{{ $item->status }}</span>
                                            @elseif ($item->status == 'Refunded')
                                                <span class="badge" style="background-color: #DC143C; color: white;">{{ $item->status }}</span>
                                            @else
                                                 <span class="badge" style="background-color: red; color: white;">{{ $item->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{-- Tampilkan Status Pesanan Utama Terlebih Dahulu --}}
                                            @if ($item->refund_status == 'requested')
                                                <span class="badge" style="background-color: #E9967A; color: white;">Permintaan Refund</span>
                                            @elseif ($item->refund_status == 'refunded')
                                                <span class="badge" style="background-color: #DC143C; color: white;">Dana Dikembalikan</span>
                                            @elseif ($item->status_pesanan == 'dikirim')
                                                <span class="badge" style="background-color: blue; color: white;">Dikirim</span>
                                            @elseif ($item->status_pesanan == 'proses')
                                                <span class="badge" style="background-color: orange; color: black;">Diproses</span>
                                            @elseif ($item->status_pesanan == 'selesai')
                                                <span class="badge" style="background-color: green; color: white;">Selesai</span>
                                            @else
                                                <span class="badge" style="background-color: gray; color: white;">Belum Diproses</span>
                                            @endif

                                            {{-- JIKA refund pernah ditolak, tambahkan badge informasi --}}
                                            @if ($item->refund_status == 'rejected')
                                                <br>
                                                <span class="badge" style="background-color: #808080; color: white; margin-top: 5px;">Refund Ditolak</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('user.order.detail', $item->id) }}" class="btn btn-sm btn-info" title="View Detail"><i class="fa fa-eye"></i></a>
                                            <a href="{{ route('user.order.invoice', $item->id) }}" class="btn btn-sm btn-danger" target="_blank" title="Download Invoice"><i class="fa fa-download"></i></a>

                                            @if ($item->status == 'Pending')
                                                <a href="{{ route('user.checkout.payment', ['order' => $item->id]) }}" class="btn btn-sm btn-success" title="Pay Now"><i class="fa fa-credit-card"></i> Pay</a>
                                                
                                                <form action="{{ route('user.order.delete', $item->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this pending order?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete Order">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- =================== LOGIKA BARU UNTUK TOMBOL REFUND =================== --}}
                                            @if ($item->status == 'Success' && $item->status_pesanan != 'dikirim' && is_null($item->refund_status))
                                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#refundModal{{ $item->id }}" title="Ajukan Refund">
                                                    <i class="fa fa-undo"></i> Refund
                                                </button>
                                            @endif
                                            {{-- ======================================================================= --}}
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

    {{-- MODAL UNTUK REFUND MANUAL (DENGAN INFO REKENING) --}}
    @foreach ($orders as $item)
    <div class="modal fade" id="refundModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="refundModalLabel{{ $item->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="refundModalLabel{{ $item->id }}">Ajukan Refund untuk Invoice: {{ $item->invoice_no }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('user.order.refund_request', $item->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="refund_reason">Alasan Refund <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="refund_reason" rows="3" required placeholder="Jelaskan alasan Anda..."></textarea>
                        </div>
                        <hr>
                        <h5>Informasi Rekening Bank untuk Pengembalian Dana</h5>
                        <p><small>Pastikan data rekening benar untuk mempercepat proses refund.</small></p>
                        <div class="form-group">
                            <label for="refund_bank_name">Nama Bank <span class="text-danger">*</span></label>
                            <select name="refund_bank_name" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Bank --</option>
                                <option value="BCA">BCA</option>
                                <option value="Mandiri">Mandiri</option>
                                <option value="BNI">BNI</option>
                                <option value="BRI">BRI</option>
                                <option value="CIMB Niaga">CIMB Niaga</option>
                                <option value="BSI">BSI</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="refund_account_name">Nama Pemilik Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="refund_account_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="refund_account_number">Nomor Rekening <span class="text-danger">*</span></label>
                            <input type="text" name="refund_account_number" class="form-control" required placeholder="Contoh: 1234567890">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Kirim Permintaan Refund</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
    {{-- ======================================================================================= --}}


    <div style="margin-top: 190px">

    </div>
@endsection
