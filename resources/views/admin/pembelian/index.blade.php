@extends('layouts.app')

@section('title', 'Daftar Pembelian')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">@yield('title')</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <x-card>
                            <x-table class="table_pesanan">
                                <x-slot name="thead">
                                    <th>No</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Total Item</th>
                                    <th>Total Harga</th>
                                    <th>Status Pembayaran</th>
                                    <th>Aksi</th>
                                </x-slot>
                            </x-table>
                        </x-card>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('admin.pembelian.detail')
@endsection

@push('scripts')
    <script>
        $(function() {
            $('body').addClass('sidebar-collapse sidebar-mini');
        });

        let table = $('.table_pesanan').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('pembelian.data') }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'kode_pembelian'
                },
                {
                    data: 'user.name'
                },

                {
                    data: 'total_item'
                },
                {
                    data: 'total_harga'
                },

                {
                    data: 'status'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        // fungsi tambah data baru
        function addForm(url, title = 'Tambah Data Kategori') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('post');
            // Hide the filename display
            resetForm(`${modal} form`);
        }

        function detailForm(url) {
            $.get(url, function(response) {
                const data = response.data;

                $('#nama').val(data.user['name'])
                $('#email').val(data.user['email'])
                // Isi tabel detail produk
                if (data.pembelian_detail && Array.isArray(data.pembelian_detail) && data.pembelian_detail.length >
                    0) {
                    let tableContent = '';
                    data.pembelian_detail.forEach(detail => {
                        tableContent += `
                    <tr>
                        <td>${detail.produk.nama_produk}</td>
                        <td>${formatRupiah(detail.harga)}</td>
                        <td>${detail.quantity}</td>
                        <td>${formatRupiah(detail.subtotal)}</td>
                    </tr>
                `;
                    });
                    $('#detailTable tbody').html(tableContent);
                } else {
                    $('#detailTable tbody').html('<tr><td colspan="4">Tidak ada detail pembelian</td></tr>');
                }

                // Tampilkan status dan total harga
                $('#statusPesanan').text(data.status || 'Tidak diketahui');
                $('#totalHarga').text(formatRupiah(data.total_harga || 0));

                // Tampilkan modal
                $('#modalDetail').modal('show');
            }).fail(function() {
                alert('Gagal mengambil data!');
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
