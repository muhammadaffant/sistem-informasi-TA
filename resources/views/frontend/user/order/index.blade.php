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
                                    <th>Invoce</th>
                                    <th>Transaksi Order</th>
                                    <th>Status Order</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $item)
                                    <tr>
                                        <td>{{ $item->created_at->format('d F Y') }}</td>
                                        <td>{{ $item->amount }}</td>
                                        <td>{{ $item->payment_type }} </td>
                                        <td>{{ $item->invoice_no }} </td>
                                        <td>
                                            @if ($item->status == 'Pending')
                                                <span class="badge" style="background-color: orange; color: black;">{{ $item->status }}</span>
                                            @else
                                                <span class="badge" style="background-color: green; color: white;">{{ $item->status }}</span>
                                            @endif
                                        </td>

                                        <td>
                                            @if ($item->status_pesanan == 'dikirim')
                                                <span class="badge" style="background-color: blue; color: white;">dikirim</span>
                                            @elseif ($item->status_pesanan == 'proses')
                                                <span class="badge" style="background-color: orange; color: black;">diproses</span>
                                            @elseif ($item->status_pesanan == 'selesai')
                                                <span class="badge" style="background-color: green; color: white;">selesai</span>
                                            @else
                                                <span class="badge" style="background-color: gray; color: white;">Belum Diproses</span>
                                            @endif
                                        </td>
                                        
                                        <td>
                                            <a href="{{ route('user.order.detail', $item->id) }}"
                                                class="btn btn-sm btn-info"><i class="fa fa-eye"></i>
                                                </a>

                                            <a href="{{ route('user.order.invoice', $item->id) }}"
                                                class="btn btn-sm btn-danger" target="_blank"><i class="fa fa-download"></i>
                                                </a>

                                                @if ($item->status == 'Pending')
                                                <form action="{{ route('user.order.delete', $item->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Are you sure you want to delete this order?')">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
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

    <div style="margin-top: 190px">

    </div>
@endsection
