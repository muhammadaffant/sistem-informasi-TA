@extends('layouts.stisla')

@section('title', $title)

@section('content')
<div class="section-body">

    <div class="card">
        <div class="card-header">
            <h4>Filter Laporan Custom Order</h4>
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
                <a href="{{ route('admin.laporancustomorder.export') }}" id="exportBtn" class="btn btn-success mb-2 ml-2">
                    Export Excel
                </a>
            </form>
        </div>
    </div>

    <x-card>
        <x-table>
            <x-slot name="thead">
                <th>No</th>
                <th>ID Custom Order</th>
                <th>Nama Pelanggan</th>
                <th>Deskripsi Desain</th>
                <th>Tipe Bahan</th>
                <th>Jumlah Barang</th>
                <th>Total Harga Barang</th>
                <th>Ongkir</th>
                <th>Total + Ongkir</th>
                <th>Status</th>
                <th>Tanggal Order</th>
            </x-slot>
        </x-table>
    </x-card>
</div>
@endsection

@include('includes.datatables')

@push('scripts')
<script>
    function updateExportLink() {
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();
        let baseUrl = '{{ route("admin.laporancustomorder.export") }}';
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
                url: '{{ route('admin.laporancustomorder.data') }}',
                data: function (d) {
                    d.start_date = $('#start_date').val();
                    d.end_date = $('#end_date').val();
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'id', name: 'id' },
                { data: 'user_name', name: 'user.name' },
                // Memastikan 'Deskripsi Desain' menggunakan 'design_description'
                { data: 'design_description', name: 'design_description', orderable: false, searchable: false },
                // BARU: Kolom untuk Tipe Kain
                { data: 'fabric_type', name: 'fabric_type', orderable: false, searchable: false },
                { data: 'quantity_value', name: 'qty', orderable: false, searchable: false },
                { data: 'total_price_formatted', name: 'total_price' },
                { data: 'ongkir_formatted', name: 'ongkir', orderable: false, searchable: false },
                { data: 'total_with_ongkir_formatted', name: 'total_price_plus_ongkir', orderable: false, searchable: false },
                { data: 'status_order', name: 'status' },
                { data: 'order_date_formatted', name: 'order_date' }
            ]
        });

        $('#filter').on('click', function () {
            table.ajax.reload();
            updateExportLink();
        });

 
        updateExportLink();
    });
</script>
@endpush