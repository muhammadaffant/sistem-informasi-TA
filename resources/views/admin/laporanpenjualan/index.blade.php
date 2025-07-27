@extends('layouts.stisla')

@section('title', $title)

@section('content')
<div class="section-body">

    <div class="card">
        {{-- Card Filter tidak berubah --}}
        <div class="card-header">
            <h4>Filter Laporan</h4>
        </div>
        <div class="card-body">
            <form class="form-inline">
                <div class="form-group mb-2">
                    <label for="start_date" class="mr-2">Dari Tanggal:</label>
                    <input type="date" class="form-control" id="start_date" name="start_date">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <label for="end_date" class="mr-2">Sampai Tanggal:</label>
                    <input type="date" class="form-control" id="end_date" name="end_date">
                </div>
                <button type="button" id="filter" class="btn btn-primary mb-2">Filter</button>
                <a href="{{ route('admin.laporanpenjualan.export') }}" id="exportBtn" class="btn btn-success mb-2 ml-2">
                    Export Excel
                </a>
            </form>
        </div>
    </div>


    <x-card>
        <x-table>
            <x-slot name="thead">
                <th>No</th>
                <th>Produk</th>
                <th>Warna</th>
                <th>Ukuran</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
                <th>Ongkir</th> {{-- <-- KOLOM BARU --}}
                <th>Total + Ongkir</th> {{-- <-- KOLOM BARU --}}
                <th>Tanggal</th>
            </x-slot>
        </x-table>
    </x-card>
</div>
@endsection

@include('includes.datatables')

@push('scripts')
<script>
    // Script updateExportLink() tidak berubah
    function updateExportLink() {
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();
        let baseUrl = '{{ route("admin.laporanpenjualan.export") }}';
        let exportUrl = new URL(baseUrl);

        if (startDate) {
            exportUrl.searchParams.append('start_date', startDate);
        }
        if (endDate) {
            exportUrl.searchParams.append('end_date', endDate);
        }

        $('#exportBtn').attr('href', exportUrl.href);
    }

    $(document).ready(function() {
        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            autoWidth: false,
            ajax: {
                url: '{{ route('admin.laporanpenjualan.data') }}',
                data: function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'product_name', name: 'product.product_name' },
                { data: 'color', name: 'color' },
                { data: 'size', name: 'size' },
                { data: 'qty', name: 'qty' },
                { data: 'price', name: 'price' },
                { data: 'total', name: 'total', orderable: false, searchable: false },
                { data: 'ongkir', name: 'order.ongkir', orderable: false, searchable: false }, // <-- KOLOM BARU
                { data: 'total_after_shipping', name: 'order.amount', orderable: false, searchable: false }, // <-- KOLOM BARU
                { data: 'order_date', name: 'order.created_at' }
            ]
        });

        // Event listener tidak berubah
        $('#filter').on('click', function () {
            table.ajax.reload();
            updateExportLink();
        });
        updateExportLink();
    });
</script>
@endpush