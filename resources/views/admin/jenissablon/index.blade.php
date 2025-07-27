@extends('layouts.stisla')

@section('title', 'Daftar Jenis Sablon')

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm(`{{ route('admin.jenissablon.store') }}`)" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah Data
                    </button>
                </x-slot>
                <x-table>
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Nama Sablon</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('admin.jenissablon.form')
@endsection

@include('includes.datatables')

@push('scripts')
    <script>
        let table;
        let modal = '#modal-form';
        let form = '#modalForm'; // Selector untuk form baru kita
        let button = '#submitBtn';

        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('admin.jenissablon.data') }}'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'kategori', name: 'sablonCategory.name' },
                { data: 'nama_sablon' },
                {
                    data: 'harga',
                    render: function(data, type, row) {
                        return new Intl.NumberFormat('id-ID', {
                            style: 'currency', currency: 'IDR', minimumFractionDigits: 0
                        }).format(data);
                    }
                },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
            ]
        });

        function addForm(url, title = 'Tambah Jenis Sablon') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${form}`).attr('action', url);
            $(`${form} [name=_method]`).val('POST');
            resetForm(`${modal} form`);
        }

        function editForm(url, title = 'Edit Jenis Sablon') {
            $.get(url)
                .done(response => {
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${form}`).attr('action', url);
                    $(`${form} [name=_method]`).val('PUT');
                    // resetForm(form);
                    resetForm(`${modal} form`); // Reset the form fields
                    loopForm(response.data);
                    if(response.data) {
                        $(`${form} [name=sablon_category_id]`).val(response.data.sablon_category_id);
                        loopForm(response.data);
                    }
                })
                .fail(errors => {
                    Swal.fire({ icon: 'error', title: 'Oops! Gagal', text: 'Tidak dapat mengambil data.' });
                });
        }

        function deleteData(url, name) {
            Swal.fire({
                title: 'Hapus Data!',
                text: 'Apakah Anda yakin ingin menghapus ' + name + '?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batalkan',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        data: { _token: '{{ csrf_token() }}' },
                        success: function(response) {
                            Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                            table.ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: xhr.responseJSON?.message || 'Terjadi kesalahan.' });
                        }
                    });
                }
            });
        }

        // Fungsi submitForm sekarang menerima elemen form sebagai argumen
        function submitForm(originalForm) {
            const submitBtn = $(button);
            submitBtn.prop('disabled', true).addClass('btn-progress');

            $.ajax({
                url: $(originalForm).attr('action'),
                type: 'POST',
                data: new FormData(originalForm),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    $(modal).modal('hide');
                    Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, showConfirmButton: false, timer: 3000 });
                    table.ajax.reload();
                },
                error: function(errors) {
                    Swal.fire({ icon: 'error', title: 'Opps! Gagal', text: errors.responseJSON?.message || 'Terjadi kesalahan server.' });
                    if (errors.status == 422) {
                        loopErrors(errors.responseJSON.errors);
                    }
                },
                complete: function() {
                    submitBtn.prop('disabled', false).removeClass('btn-progress');
                }
            });
        }
    </script>
@endpush
