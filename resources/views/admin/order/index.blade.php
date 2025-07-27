@extends('layouts.stisla')

@section('title', 'Data Orders')

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card>
                <x-table>
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Tanggal</th>
                        {{-- <th>Invoice</th> --}}
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Size</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Nomor Hp</th>
                        <th>Alamat</th>
                        <th>Kode Pos</th>
                        <th>Harga</th>
                        <th>Ongkir</th>
                        <th>Kurir</th>
                        <th>Status Transaksi</th>
                        <th>Status Pesanan</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('admin.order.form')
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
                url: '{{ route('admin.orders.data') }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at'
                },
                // {
                //     data: 'invoice_no'
                // },
                {
                    data: 'product_code', // Path untuk mengambil product_name
                },
                {
                    data: 'product_name', // Path untuk mengambil product_name
                },
                {
                    data: 'size', // Path untuk mengambil product_name
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'phone'
                },
                { 
                    data: 'alamat_lengkap'
                },
                {
                    data: 'post_code',
                },

                {
                    data: 'harga', // Path untuk mengambil product_name
                },
                {
                    data: 'ongkir', // Path untuk mengambil product_name
                },
                {
                    data: 'courir', // Path untuk mengambil product_name
                },
                {
                    data: 'status'
                },
                {
                    data: 'status_pesanan',
                    name: 'status_pesanan',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        let selectedProcessing = data == "proses" ? "selected" : "";
                        let selectedShipped = data == "dikirim" ? "selected" : "";
                        let selectedCompleted = data == "selesai" ? "selected" : "";

                        return `
                            <select class="form-control status-pesanan" data-id="${row.id}">
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="proses" ${selectedProcessing}>Proses</option>
                                <option value="dikirim" ${selectedShipped}>Dikirim</option>
                                <option value="selesai" ${selectedCompleted}>Selesai</option>
                            </select>
                        `;
                    }

                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
            ]
        });


            $(document).on('change', '.status-pesanan', function() {
            let orderId = $(this).data('id'); // Ambil ID pesanan
            let statusPesanan = $(this).val(); // Ambil status baru

            $.ajax({
                url: '/admin/orders/update-status', // Route untuk update status
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    id: orderId,
                    status_pesanan: statusPesanan
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    table.ajax.reload(); // Refresh tabel setelah update
                },
                error: function(errors) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true
                    });
                }
            });
        });

        // fungsi edit data
        function editForm(url, title = 'Edit Data Kategori') {
            $.get(url) // Perform a GET request to the specified URL
                .done(response => {
                    $(modal).modal('show'); // Show the modal
                    $(`${modal} .modal-title`).text(title); // Set the modal title
                    $(`${modal} form`).attr('action', url); // Set the form action to the URL
                    $(`${modal} [name=_method]`).val('put'); // Set the HTTP method to PUT

                    resetForm(`${modal} form`); // Reset the form fields
                    loopForm(response.data); // Populate the form fields with the response data
                })
                .fail(errors => { // Handle any errors from the GET request
                    $('#spinner-border').hide(); // Hide the spinner
                    $(button).prop('disabled', false); // Enable the button
                    Swal.fire({ // Show an error message
                        icon: 'error',
                        title: 'Oops! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        $('#spinner-border').hide();
                        $(button).prop('disabled', false);
                        loopErrors(errors.responseJSON.errors); // Handle validation errors
                    }
                });
        }

        // fungsi kirim data inputan
        function submitForm(originalForm) {
            const submitBtn = $('#submitBtn'); // Reference to the button
            $(button).prop('disabled', true);
            $('#spinner-border').show();
            submitBtn.addClass('btn-progress');

            $.post({
                    url: $(originalForm).attr('action'),
                    data: new FormData(originalForm),
                    dataType: 'JSON',
                    contentType: false,
                    cache: false,
                    processData: false
                })
                .done(response => {
                    $(modal).modal('hide');
                    if (response.status = 200) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            showConfirmButton: false,
                            timer: 3000
                        }).then(() => {
                            $(button).prop('disabled', false);
                            $('#spinner-border').hide();
                            submitBtn.removeClass('btn-progress');
                            table.ajax.reload();
                        })
                    }
                })
                .fail(errors => {
                    $('#spinner-border').hide();
                    submitBtn.removeClass('btn-progress');
                    $(button).prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Opps! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        $('#spinner-border').hide()
                        submitBtn.removeClass('btn-progress')
                        $(button).prop('disabled', false);
                        loopErrors(errors.responseJSON.errors);
                        return;
                    }
                });
        }
    </script>
@endpush
