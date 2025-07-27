@extends('layouts.stisla')

@section('title', 'Data Size')

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card>
                <x-slot name="header">
                    <div class="card-header-action">
                        {{-- Tombol "Tambah Data Size (Global)" tetap ada di sini --}}
                        <button onclick="addForm(`{{ route('admin.size.store') }}`)" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus-circle"></i> Tambah Data Size (Global)
                        </button>
                    </div>
                </x-slot>

                <x-table>
                    <x-slot name="thead">
                        <th></th> {{-- Untuk ikon expand/collapse --}}
                        <th>No</th>
                        <th>Nama Bahan</th>
                        {{-- Hapus <th>Aksi</th> di sini karena tombol 'Add Size' per baris sudah dihilangkan --}}
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    {{-- Memanggil file form modal --}}
    @include('admin.size.form')
@endsection

@include('includes.datatables')

@push('scripts')
    <script>
        let table;
        let modal = '#modal-form';
        let button = '#submitBtn';

        $(function () {
            table = $('.table').DataTable({
                processing: true,
                serverSide: true,
                autoWidth: false,
                responsive: true,
                ajax: {
                    url: '{{ route('admin.size.data') }}'
                },
                columns: [
                    {
                        className: 'dt-control', // Kelas untuk kolom kontrol DataTables
                        orderable: false,
                        data: null,
                        defaultContent: ''
                    },
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nama_bahan', name: 'nama_bahan' },
                    // Hapus definisi kolom 'action' di sini
                    // { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            // Add event listener for opening and closing details
            $('.table tbody').on('click', 'td.dt-control', function () {
                var tr = $(this).closest('tr');
                var row = table.row(tr);
                var bahan_id = row.data().id; // Get the bahan_id from the parent row data

                if (row.child.isShown()) {
                    // This row is already open - close it
                    row.child.hide();
                    tr.removeClass('shown');
                } else {
                    // Open this row
                    // Show a loading message while fetching data
                    row.child('Memuat ukuran untuk ' + row.data().nama_bahan + '...').show();
                    tr.addClass('shown');

                    // Fetch the sizes via AJAX
                    $.ajax({
                        url: '{{ url("admin/size/data") }}/' + bahan_id + '/sizes', // Use the new route
                        method: 'GET',
                        success: function(response) {
                            // Format the child row content
                            var childTable = `
                                <table class="table table-bordered table-sm" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Size</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>`;
                            $.each(response.data, function(index, size) {
                                childTable += `
                                    <tr>
                                        <td>${index + 1}</td>
                                        <td>${size.nama_size}</td>
                                        <td>${size.price}</td>
                                        <td>${size.aksi}</td>
                                    </tr>`;
                            });
                            childTable += `</tbody></table>`;
                            row.child(childTable).show();
                        },
                        error: function() {
                            row.child('<div class="alert alert-danger">Gagal memuat ukuran.</div>').show();
                        }
                    });
                }
            });
        });

        // Fungsi untuk form tambah data
        function addForm(url, title = 'Tambah Data Size') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('post');
            resetForm(`${modal} form`);
            // Opsional: Jika Anda ingin pre-select bahan_id di form tambah global, Anda bisa menambahkannya di sini
            // Tapi karena tombolnya global, mungkin tidak ada bahan_id spesifik untuk di-pre-select.
        }

        // Fungsi untuk form edit data (tetap sama)
        function editForm(url, title = 'Edit Data Size') {
            $.get(url)
                .done(response => {
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    let updateUrl = url.replace('/show', '');
                    $(`${modal} form`).attr('action', updateUrl);
                    $(`${modal} [name=_method]`).val('put');

                    resetForm(`${modal} form`);

                    let data = response.data;
                    $(`${modal} [name=bahan_id]`).val(data.bahan_id);
                    $(`${modal} [name=nama_size]`).val(data.nama_size);
                    $(`${modal} [name=price]`).val(data.price);
                })
                .fail(errors => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops! Gagal',
                        text: 'Tidak dapat menampilkan data.',
                    });
                });
        }

        // Fungsi untuk hapus data (tetap sama)
        function deleteData(url, name) {
            Swal.fire({
                title: 'Hapus Data!',
                text: `Apakah Anda yakin ingin menghapus size untuk ${name}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.post(url, {
                            '_token': '{{ csrf_token() }}',
                            '_method': 'delete'
                        })
                        .done(response => {
                            Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 2000, showConfirmButton: false });
                            // Reload tabel utama untuk menyegarkan data setelah hapus
                            table.ajax.reload();
                        })
                        .fail(errors => {
                            Swal.fire({ icon: 'error', title: 'Gagal', text: 'Tidak dapat menghapus data.' });
                        });
                }
            });
        }

        // Fungsi untuk submit form (create/update) (tetap sama)
        function submitForm(originalForm) {
            const submitBtn = $('#submitBtn');
            submitBtn.prop('disabled', true).addClass('btn-progress');

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
                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message, timer: 3000, showConfirmButton: false });
                table.ajax.reload(); // Reload the main table
            })
            .fail(errors => {
                Swal.fire({ icon: 'error', title: 'Opps! Gagal', text: errors.responseJSON.message || 'Terjadi kesalahan' });
                if (errors.status === 422) {
                    loopErrors(errors.responseJSON.errors); // Asumsi `loopErrors` menampilkan error validasi
                }
            })
            .always(() => {
                submitBtn.prop('disabled', false).removeClass('btn-progress');
            });
        }

        // Placeholder for resetForm and loopErrors functions (assuming they exist elsewhere)
        function resetForm(form) {
            $(form)[0].reset();
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
        }

        function loopErrors(errors) {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            for (let item in errors) {
                $(`[name="${item}"]`).addClass('is-invalid');
                if ($(`[name="${item}"]`).is('select')) {
                    $(`[name="${item}"]`).closest('.form-group').append(`<div class="invalid-feedback">${errors[item][0]}</div>`);
                } else {
                    $(`[name="${item}"]`).after(`<div class="invalid-feedback">${errors[item][0]}</div>`);
                }
            }
        }
    </script>
@endpush