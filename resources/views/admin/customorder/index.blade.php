@extends('layouts.stisla')

@section('title', 'Custom Order')

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card>
                <x-slot name="header">
                    <h4>@yield('title')</h4>
                </x-slot>
                <x-table>
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Lengkap</th>
                        <th>Nomor Hp</th>
                        <th>Bahan Kain</th>
                        <th>Jenis Sablon</th>
                        <th>Harga Sablon</th>
                        <th>Detail Ukuran</th>
                        <th>Total Qty</th>
                        <th>Subtotal Produk</th>
                        <th>Ongkir</th>
                        <th>Grand Total</th>
                        <th>Status Transaksi</th>
                        <th>Status Pesanan</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('admin.customorder.form')
    @include('admin.customorder.detail')
@endsection

@include('includes.datatables')

@push('scripts')
    <script>
        let table;
        let modal = '#modal-form';
        let modalDetail = '#modalDetail'
        let button = '#submitBtn';

        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('admin.customorders.data') }}'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'order_date', name: 'order_date' },
                { data: 'name', name: 'name' },
                { data: 'nomor_hp', name: 'user.numberphone', orderable: false, searchable: false }, // Kolom baru
                { data: 'fabric_type', name: 'fabric_type' },
                { data: 'jenis_sablon', name: 'jenis_sablon' },
                { data: 'sablon_price', name: 'sablon_price' },
                { data: 'size', name: 'size', orderable: false, searchable: false }, // Sekarang berisi HTML
                { data: 'qty', name: 'qty' },
                { data: 'total_price', name: 'total_price' },
                { data: 'ongkir', name: 'ongkir' },
                { data: 'remaining_payment', name: 'remaining_payment' },
                { data: 'status', name: 'status' },
                { data: 'status_pesanan', name: 'status_pesanan', orderable: false, searchable: false,
                    render: function(data, type, row) {
                        return `
                            <select class="form-control status-dropdown" data-id="${row.id}">
                                <option value="" ${data === null ? 'selected' : ''} disabled>Pilih Status</option>
                                <option value="Dalam Pengerjaan" ${data === 'Dalam Pengerjaan' ? 'selected' : ''}>Dalam Pengerjaan</option>
                                <option value="Dikirim" ${data === 'Dikirim' ? 'selected' : ''}>Dikirim</option>
                                <option value="Selesai" ${data === 'Selesai' ? 'selected' : ''}>Selesai</option>
                            </select>
                        `;
                    }
                },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
            ]
        });

        $(document).on('change', '.status-dropdown', function() {
            let orderId = $(this).data('id');
            let newStatus = $(this).val();

            $.ajax({
                url: `/admin/customorders/${orderId}/update-status`,
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    status_pesanan: newStatus
                },
                success: function(response) {
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, showConfirmButton: false, timer: 1500 });
                    table.ajax.reload(null, false);
                },
                error: function(xhr) {
                    Swal.fire({ icon: 'error', title: 'Gagal', text: 'Gagal memperbarui status.' });
                }
            });
        });

        // fungsi update Status
        function updateStatus(url, title = 'Update Data') {
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

        // fungsi detail
// GANTI SELURUH FUNGSI detailData DENGAN INI
function detailData(url, title = 'Detail Data') {
    $.get(url)
        .done(response => {
            $(modalDetail).modal('show');
            $(`${modalDetail} .modal-title`).text(title);
            
            // Mengisi data-data lain seperti biasa
            let data = response.data;
            $('#name').val(data.name);
            $('#design_description').val(data.design_description);
            $('#fabric_type').val(data.fabric_type);
            $('#jenis_sablon').val(data.jenis_sablon);
            $('#sablon_price').val('Rp ' + parseInt(data.sablon_price).toLocaleString('id-ID'));
            $('#total_price').val('Rp ' + parseInt(data.total_price).toLocaleString('id-ID'));
            $('#dp_paid').val('Rp ' + parseInt(data.dp_paid).toLocaleString('id-ID'));
            $('#remaining_payment').val('Rp ' + parseInt(data.remaining_payment).toLocaleString('id-ID'));
            $('#order_date').val(data.order_date);
            $('#completion_date').val(data.completion_date);
            $('[name=address]').val(data.address);
            $('[name=status]').val(data.status);
            $('[name=ongkir]').val('Rp ' + parseInt(data.ongkir).toLocaleString('id-ID'));
            $('[name=courir]').val(data.courir);
            $('[name=position]').val(data.position);

            // Menampilkan gambar desain
            const fileDesignPath = `/storage/${data.file_design}`;
            $('#file_design').html(`<img src="${fileDesignPath}" class="img-fluid" alt="Desain">`);

            // =======================================================
            // PERBAIKAN UTAMA: PARSING JSON DAN BUAT TABEL RINCIAN
            // =======================================================
            const sizeContainer = $('#size-detail-container');
            sizeContainer.empty(); // Kosongkan dulu

            try {
                const sizeDetails = JSON.parse(data.size);
                if (Array.isArray(sizeDetails)) {
                    let tableHtml = '<table class="table table-sm table-bordered"><thead><tr><th>Ukuran</th><th>Jumlah</th><th>Subtotal</th></tr></thead><tbody>';
                    sizeDetails.forEach(item => {
                        tableHtml += `
                            <tr>
                                <td>${item.size || 'N/A'}</td>
                                <td>${item.quantity || 0} pcs</td>
                                <td>Rp ${parseInt(item.subtotal || 0).toLocaleString('id-ID')}</td>
                            </tr>
                        `;
                    });
                    tableHtml += '</tbody></table>';
                    sizeContainer.html(tableHtml);
                }
            } catch (e) {
                // Jika data bukan JSON, tampilkan sebagai teks biasa
                sizeContainer.text(data.size);
            }
            // =======================================================
        })
        .fail(errors => {
            Swal.fire({
                icon: 'error',
                title: 'Oops! Gagal',
                text: 'Tidak dapat menampilkan data pesanan.',
            });
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

        $(document).on('change', '.status-dropdown', function() {
        let orderId = $(this).data('id');
        let newStatus = $(this).val();

        $.ajax({
            url: `/admin/customorders/${orderId}/update-status`,
            type: 'PUT',
            data: {
                _token: '{{ csrf_token() }}',
                status_pesanan: newStatus
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });
                table.ajax.reload(); // Reload tabel setelah update
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops! Gagal',
                    text: xhr.responseJSON.message,
                    showConfirmButton: true
                });
            }
        });
    });


        function downlodDesain(url) {
            alert(url)
            window.location.href = url;
        }
    </script>

    {{--  <script>
        function showStatusModal(orderId) {
            // Set order ID ke dalam input hidden
            $('#orderId').val(orderId);

            // Tampilkan modal
            $('#statusModal').modal('show');
        }

        $(document).ready(function() {
            $('#saveStatusButton').on('click', function() {
                let orderId = $('#orderId').val();
                let status = $('#status').val();
                let price = $('#price').val();

                $.ajax({
                    url: `/admin/customorders/${orderId}`, // Pastikan route sesuai
                    type: 'PUT',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        status: status,
                        price: price
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#statusModal').modal('hide');
                        // Reload datatable
                        $('#customOrderTable').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert('Terjadi kesalahan: ' + xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>  --}}
@endpush
