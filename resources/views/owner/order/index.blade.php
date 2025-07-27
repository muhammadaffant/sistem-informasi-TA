@extends('layouts.stisla')

@section('title', 'Orders')

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card>
                <!-- Filter Tanggal -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label for="start_date">Tanggal Mulai</label>
                        <input type="date" id="start_date" class="form-control" placeholder="YYYY-MM-DD">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button id="filter" class="btn btn-primary">Filter</button>
                        <button id="reset" class="btn btn-secondary ml-2">Reset</button>
                    </div>
                </div>

                <x-table>
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Invoice</th>
                        <th>Nama Lengkap</th>
                        <th>Nomor Hp</th>
                        <th>Payment Type</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
@endsection

@include('includes.datatables')

@push('scripts')
    <script>
        let table;
        let modal = '#modal-form';
        let button = '#submitBtn';

        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('owner.orders.data') }}',
                data: function(d) {
                    d.start_date = $('#start_date').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'order_date'
                },
                {
                    data: 'invoice_no'
                },
                {
                    data: 'name'
                },
                {
                    data: 'phone'
                },
                {
                    data: 'payment_type'
                },
                {
                    data: 'amount'
                },
                {
                    data: 'status'
                },
            ]
        });

        // Event Filter
        $('#filter').click(function() {
            table.ajax.reload();
        });

        // Event Reset
        $('#reset').click(function() {
            $('#start_date').val('');
            table.ajax.reload();
        });
    </script>
@endpush
