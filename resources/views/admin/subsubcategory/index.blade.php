@extends('layouts.stisla')

@section('title', 'Sub Sub Kategori')

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm(`{{ route('admin.subsubcategory.store') }}`)" class="btn btn-sm btn-primary"><i
                            class="fas fa-plus-circle"></i> Tambah
                        Data</button>
                </x-slot>
                <x-table>
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Nama Sub Sub Kategori</th>
                        <th>Nama Sub Kategori</th>
                        <th>Nama Kategori</th>
                        <th>slug</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('admin.subsubcategory.form')
@endsection

@include('includes.datatables')
@include('includes.select2')

@push('scripts')
    <script>
        let table;
        let modal = '#modal-form';
        let button = '#submitBtn';

        $(function() {
            // Initialize category_id Select2
            $('.category_id').select2({
                thema: 'bootstrap-4',
                placeholder: '-- Pilih Kategori --',
                closeOnSelect: true,
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.category.categorySearch') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.category_name
                                };
                            })
                        };
                    }
                }
            });

            // Disable subcategory dropdown initially
            $('.subcategory_id').prop('disabled', true);

            // Initialize subcategory_id Select2
            $('.sub_category_id').select2({
                thema: 'bootstrap-4',
                placeholder: '-- Pilih Sub Kategori --',
                closeOnSelect: true,
                allowClear: true,
                ajax: {
                    url: function() {
                        let categoryId = $('.category_id').val(); // Get selected category
                        return categoryId ?
                            `{{ url('admin/subcategory') }}/${categoryId}/search` :
                            ''; // Adjust route as per your application
                    },
                    dataType: 'json',
                    delay: 250,
                    processResults: function(response) {
                        console.log(response);
                        if (!Array.isArray(response.data)) {
                            console.error("Expected an array in response.data but got:", response);
                            return {
                                results: []
                            };
                        }
                        return {
                            results: response.data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.subcategory_name
                                };
                            })
                        };
                    }
                }
            });

            // Enable subcategory dropdown when category is selected
            $('.category_id').on('change', function() {
                let categoryId = $(this).val();

                if (categoryId) {
                    // Enable subcategory dropdown
                    $('.sub_category_id').prop('disabled', false).val(null).trigger('change');
                } else {
                    // Disable and reset subcategory dropdown
                    $('.sub_category_id').val(null).trigger('change').prop('disabled', true);
                }
            });
        });

        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('admin.subsubcategory.data') }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'subsubcategory_name'
                },
                {
                    data: 'sub_category.subcategory_name'
                },
                {
                    data: 'category.category_name'
                },
                {
                    data: 'subsubcategory_slug'
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
        function addForm(url, title = 'Tambah Data SubSubKategori') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('post');
            // Hide the filename display
            resetForm(`${modal} form`);
        }

        // fungsi edit data
        function editForm(url, title = 'Edit Data SubSubKategori') {
            $.get(url)
                .done(response => {
                    $(modal).modal('show');
                    $(`${modal} .modal-title`).text(title);
                    $(`${modal} form`).attr('action', url);
                    $(`${modal} [name=_method]`).val('put');

                    let categoryId = response.data.category.id;
                    let subCategoryId = response.data.sub_category.id;

                    // Set category dropdown
                    let categoryExists = $('#category_id').find('option[value="' + categoryId + '"]').length;
                    if (!categoryExists) {
                        $('#category_id').append(new Option(response.data.category.category_name, categoryId));
                    }
                    $('#category_id').val(categoryId).trigger('change');

                    // Set subcategory dropdown
                    let subCategoryExists = $('#sub_category_id').find('option[value="' + subCategoryId + '"]').length;
                    if (!subCategoryExists) {
                        $('#sub_category_id').append(new Option(response.data.sub_category.subcategory_name,
                            subCategoryId));
                    }
                    $('#sub_category_id').val(subCategoryId).trigger('change');

                    resetForm(`${modal} form`);
                    loopForm(response.data);
                })
                .fail(errors => {
                    $('#spinner-border').hide();
                    $(button).prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops! Gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: true,
                    });
                    if (errors.status == 422) {
                        loopErrors(errors.responseJSON.errors);
                    }
                });
        }

        // fungsi delete data
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
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false,
                            });
                            table.ajax.reload(); // Refresh tabel
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: xhr.responseJSON?.message || 'Terjadi kesalahan.',
                            });
                        }
                    });
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
