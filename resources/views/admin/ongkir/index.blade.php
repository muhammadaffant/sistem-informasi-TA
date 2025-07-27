@extends('layouts.stisla')

@section('title', 'List Ongkir')

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm(`{{ route('admin.ongkir.store') }}`)" class="btn btn-sm btn-primary"><i
                            class="fas fa-plus-circle"></i> Tambah
                        Data</button>
                </x-slot>
                <x-table>
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Provinsi</th>
                        <th>Kab/Kota</th>
                        <th>Kecamatan</th>
                        <th>Desa</th>
                        <th>Kurir</th>
                        <th>Ongkir</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>
    @include('admin.ongkir.form')
@endsection

@include('includes.datatables')
@include('includes.select2')

@push('scripts')
    <script>
        $(function() {
            // Initialize Select2 for provinces
            $('.province_id').select2({
                thema: 'bootstrap-4', // Corrected 'thema' to 'theme'
                placeholder: '-- Pilih Provinsi --',
                closeOnSelect: true,
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.ongkir.provinceSearch') }}',
                    dataType: 'json',
                    processResults: function(response) {
                        // Log the full response to check its structure
                        console.log(response);

                        // Access the data array and map it to the expected format
                        return {
                            results: response.data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            })
                        };
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching data:', error); // Log errors if AJAX fails
                    }
                }
            });

            // Disable subsequent dropdowns initially
            $('.regency_id, .district_id, .village_id').prop('disabled', true);

            // Initialize Select2 for regencies
            $('.regency_id').select2({
                thema: 'bootstrap-4',
                placeholder: '-- Pilih Kabupaten/Kota --',
                closeOnSelect: true,
                allowClear: true,
                ajax: {
                    url: function() {
                        let provinceId = $('.province_id').val();
                        return provinceId ?
                            `{{ route('user.checkout.searchRegence', ':provinceId') }}`.replace(
                                ':provinceId', provinceId) :
                            '';
                    },
                    dataType: 'json',
                    delay: 300,
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            })
                        };
                    }
                }
            });

            // Initialize Select2 for districts
            $('.district_id').select2({
                thema: 'bootstrap-4',
                placeholder: '-- Pilih Kecamatan --',
                closeOnSelect: true,
                allowClear: true,
                ajax: {
                    url: function() {
                        let regencyId = $('.regency_id').val();
                        return regencyId ?
                            `{{ route('user.checkout.searchDistrict', ':regencyId') }}`.replace(
                                ':regencyId', regencyId) :
                            '';
                    },
                    dataType: 'json',
                    delay: 300,
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            })
                        };
                    }
                }
            });

            // Initialize Select2 for villages
            $('.village_id').select2({
                thema: 'bootstrap-4',
                placeholder: '-- Pilih Desa/Kelurahan --',
                closeOnSelect: true,
                allowClear: true,
                ajax: {
                    url: function() {
                        let districtId = $('.district_id').val();
                        return districtId ?
                            `{{ route('user.checkout.searchVillage', ':districtId') }}`.replace(
                                ':districtId', districtId) :
                            '';
                    },
                    dataType: 'json',
                    delay: 300,
                    processResults: function(data) {
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.name
                                };
                            })
                        };
                    }
                }
            });

            // Enable and reset subsequent dropdowns
            $('.province_id').on('change', function() {
                let provinceId = $(this).val();
                if (provinceId) {
                    $('.regency_id').prop('disabled', false).val(null).trigger('change');
                    $('.district_id, .village_id').prop('disabled', true).val(null).trigger('change');
                } else {
                    $('.regency_id, .district_id, .village_id').val(null).trigger('change').prop('disabled',
                        true);
                }
            });

            $('.regency_id').on('change', function() {
                let regencyId = $(this).val();
                if (regencyId) {
                    $('.district_id').prop('disabled', false).val(null).trigger('change');
                    $('.village_id').prop('disabled', true).val(null).trigger('change');
                } else {
                    $('.district_id, .village_id').val(null).trigger('change').prop('disabled', true);
                }
            });

            $('.district_id').on('change', function() {
                let districtId = $(this).val();
                if (districtId) {
                    $('.village_id').prop('disabled', false).val(null).trigger('change');
                } else {
                    $('.village_id').val(null).trigger('change').prop('disabled', true);
                }
            });
        });
    </script>
@endpush


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
                url: '{{ route('admin.ongkir.data') }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'province_id'
                },
                {
                    data: 'regency_id'
                },
                {
                    data: 'district_id'
                },
                {
                    data: 'village_id'
                },
                {
                    data: 'courir'
                },
                {
                    data: 'ongkir'
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
        function addForm(url, title = 'Tambah Data Ongkir') {
            $(modal).modal('show');
            $(`${modal} .modal-title`).text(title);
            $(`${modal} form`).attr('action', url);
            $(`${modal} [name=_method]`).val('post');
            // Hide the filename display
            resetForm(`${modal} form`);
        }

        // fungsi edit data
        function editForm(url, title = 'Edit Data Ongkir') {
            $.get(url) // Perform a GET request to the specified URL
                .done(response => {
                    $(modal).modal('show'); // Show the modal
                    $(`${modal} .modal-title`).text(title); // Set the modal title
                    $(`${modal} form`).attr('action', url); // Set the form action to the URL
                    $(`${modal} [name=_method]`).val('put'); // Set the HTTP method to PUT

                    resetForm(`${modal} form`); // Reset the form field

                    // Set province dropdown
                    let provinceId = response.data.province.id;
                    let provinceName = response.data.province.name; // Get the province name correctly
                    let provinceExists = $('#province_id').find('option[value="' + provinceId + '"]').length;
                    if (!provinceExists) {
                        $('#province_id').append(new Option(provinceName, provinceId));
                    }
                    $('#province_id').val(provinceId).trigger('change');

                    // Set regency dropdown
                    let regencyId = response.data.regency.id; // Access regency id correctly
                    let regencyName = response.data.regency.name; // Get regency name correctly
                    let regencyExists = $('#regency_id').find('option[value="' + regencyId + '"]').length;
                    if (!regencyExists) {
                        $('#regency_id').append(new Option(regencyName, regencyId));
                    }
                    $('#regency_id').val(regencyId).trigger('change');

                    // Set district dropdown
                    let districtId = response.data.district.id; // Assuming district data has id
                    let districtName = response.data.district.name; // Assuming district data has name
                    let districtExists = $('#district_id').find('option[value="' + districtId + '"]').length;
                    if (!districtExists) {
                        $('#district_id').append(new Option(districtName, districtId));
                    }
                    $('#district_id').val(districtId).trigger('change');

                    // Set village dropdown
                    let villageId = response.data.village.id; // Assuming village data has id
                    let villageName = response.data.village.name; // Assuming village data has name
                    let villageExists = $('#village_id').find('option[value="' + villageId + '"]').length;
                    if (!villageExists) {
                        $('#village_id').append(new Option(villageName, villageId));
                    }
                    $('#village_id').val(villageId).trigger('change');

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
