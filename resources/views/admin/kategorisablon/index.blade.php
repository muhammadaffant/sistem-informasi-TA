@extends('layouts.stisla')

@section('title', 'Daftar Kategori Sablon')

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card>
                <x-slot name="header">
                    {{-- Tombol ini akan memanggil fungsi JS untuk membuka modal tambah data --}}
                    <button onclick="addForm(`{{ route('admin.kategorisablon.store') }}`)" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah Kategori
                    </button>
                </x-slot>
                <x-table>
                    <x-slot name="thead">
                        <th style="width: 5%">No</th>
                        <th>Nama Kategori</th>
                        <th style="width: 15%">Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    {{-- Memanggil file modal form --}}
    @include('admin.kategorisablon.form')
@endsection

@include('includes.datatables')

@push('scripts')
    <script>
        let table;
        let modal = '#modal-form';
        let button = '#submitBtn';

        // Inisialisasi DataTable
        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                // Route ini harus Anda buat di controller untuk menyediakan data
                url: '{{ route('admin.kategorisablon.data') }}'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'name' },
                { data: 'aksi', name: 'aksi', orderable: false, searchable: false },
            ]
        });

        // Fungsi untuk membuka modal tambah data
        function addForm(url, title = 'Tambah Kategori Sablon') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('post');
            resetForm(`${modal} form`);
        }

        // Fungsi untuk membuka modal edit dan mengambil data
        function editForm(url, title = 'Edit Kategori Sablon') {
            $.get(url)
                .done(response => {
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('put');
                    resetForm(`${modal} form`);
                    // Mengisi form dengan data yang didapat
                    loopForm(response.data);
                })
                .fail(errors => {
                    Swal.fire({ icon: 'error', title: 'Oops! Gagal', text: 'Tidak dapat mengambil data.' });
                });
        }

        // Fungsi untuk menghapus data
        function deleteData(url, name) {
            Swal.fire({
                title: 'Hapus Data!',
                text: `Apakah Anda yakin ingin menghapus kategori ${name}?`,
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

        // Fungsi untuk submit form (tambah/edit)
        function submitForm(originalForm) {
            $(button).prop('disabled', true).addClass('btn-progress');
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
                    Swal.fire({ icon: 'error', title: 'Opps! Gagal', text: errors.responseJSON?.message || 'Terjadi kesalahan server.', showConfirmButton: true });
                    if (errors.status == 422) {
                        loopErrors(errors.responseJSON.errors);
                    }
                },
                complete: function() {
                    $(button).prop('disabled', false).removeClass('btn-progress');
                }
            });
        }
    </script>
@endpush
