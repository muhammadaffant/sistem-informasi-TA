@extends('layouts.stisla')

@section('title', 'Daftar Produk')

@section('content')
    <div class="row">
        <div class="col-12">
            <x-card>
                <x-slot name="header">
                    <button onclick="addForm(`{{ route('admin.products.store') }}`)" class="btn btn-sm btn-primary"><i
                            class="fas fa-plus-circle"></i> Tambah
                        Data</button>
                </x-slot>
                <x-table class="table_product">
                    <x-slot name="thead">
                        <th>No</th>
                        <th>Thumbnail Produk</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Ukuran & Stok</th>
                        {{-- <th>Harga</th> --}}
                        {{-- <th>Diskon</th> --}}
                        {{-- <th>Harga Diskon</th> --}}
                        <th>Status</th>
                        <th>Aksi</th>
                    </x-slot>
                </x-table>
            </x-card>
        </div>
    </div>

    @include('admin.product.detail')
    @include('admin.product.form')
@endsection

@include('includes.datatables')
@include('includes.select2')

@push('scripts')
    <script>
        let table;
        let modal = '#modal-form';
        let button = '#submitBtn';

        table = $('.table_product').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('admin.products.data') }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'product_thumbnail'
                },
                {
                    data: 'product_code'
                },
                {
                    data: 'product_name'
                },
{
    data: 'size_stock',
    name: 'size_stock',
    orderable: false,
    searchable: false
},
                // {
                //     data: 'selling_price'
                // },
                // {
                //     data: 'discount_price'
                // },
                // {
                //     data: 'price_after_discount'
                // },
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


        $(function() {
            $('body').addClass('sidebar-collapse sidebar-mini');

            // Initialize brand_id Select2
            $('.brand_id').select2({
                thema: 'bootstrap-4',
                placeholder: '-- Pilih Brand --',
                closeOnSelect: true,
                allowClear: true,
                ajax: {
                    url: '{{ route('admin.brands.brandSearch') }}',
                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        console.log(data)
                        return {
                            results: data.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.brand_name
                                };
                            })
                        };
                    }
                }
            });

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

            // Disable subcategory and subsubcategory dropdowns initially
            $('.subcategory_id').prop('disabled', true);
            $('.subsubcategory_id').prop('disabled', true);

            // Initialize subcategory_id Select2
            $('.subcategory_id').select2({
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
                        console.log("Received response:", response);
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

            // Initialize subsubcategory_id Select2
            $('.subsubcategory_id').select2({
                thema: 'bootstrap-4',
                placeholder: '-- Pilih Sub Sub Kategori --',
                closeOnSelect: true,
                allowClear: true,
                ajax: {
                    url: function() {
                        let subCategoryId = $('.subcategory_id').val(); // Get selected subcategory
                        return subCategoryId ?
                            `{{ url('admin/subsubcategory') }}/${subCategoryId}/search` :
                            ''; // Adjust route as per your application
                    },
                    dataType: 'json',
                    delay: 250,
                    processResults: function(response) {
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
                                    text: item.subsubcategory_name
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
                    $('.subcategory_id').prop('disabled', false).val(null).trigger('change');
                    $('.subsubcategory_id').prop('disabled', true).val(null).trigger(
                        'change'); // Keep subsubcategory disabled
                } else {
                    // Disable and reset subcategory dropdown
                    $('.subcategory_id').val(null).trigger('change').prop('disabled', true);
                    $('.subsubcategory_id').val(null).trigger('change').prop('disabled', true);
                }
            });

            // Enable subsubcategory dropdown when subcategory is selected
            $('.subcategory_id').on('change', function() {
                let subCategoryId = $(this).val();

                if (subCategoryId) {
                    // Enable subsubcategory dropdown
                    $('.subsubcategory_id').prop('disabled', false).val(null).trigger('change');
                } else {
                    // Disable and reset subsubcategory dropdown
                    $('.subsubcategory_id').val(null).trigger('change').prop('disabled', true);
                }
            });
        });

        // fungsi tambah data baru
function addForm(url, title = 'Tambah Data Produk') {
    $(modal).modal('show');
    $(`${modal} .modal-title`).text(title);
    $(`${modal} form`).attr('action', url);
    $(`${modal} [name=_method]`).val('post');
    resetForm(`${modal} form`);

    // Ambil kode otomatis
    $.get(`{{ route('admin.products.generateCode') }}`, function(response) {
        $(`${modal} [name="product_code"]`).val(response.code);
    });

    $('#btn-add-field button').show();
}


        // Fungsi edit data
function editForm(url, title = 'Edit Data Produk') {
    $(modal).modal('show');
    $(`${modal} .modal-title`).text(title);
    $(`${modal} form`).attr('action', url);
    $(`${modal} [name=_method]`).val('put');

    resetForm(`${modal} form`);

    $.get(url)
        .done((response) => {
            console.log('Data untuk Edit:', response.data); // Gunakan ini untuk verifikasi

            // Mengisi data umum produk
            const {
                brand,
                category,
                sub_category,
                sub_sub_category,
                product_code,
                product_name,
                product_slug,
                product_color,
                short_descp,
                long_descp,
                special_deals,
                status,
                variants // Ambil data varian di sini
            } = response.data;

            // Update select options
            updateSelectOption('#brand_id', brand.id, brand.brand_name);
            updateSelectOption('#category_id', category.id, category.category_name);
            updateSelectOption('#subcategory_id', sub_category.id, sub_category.subcategory_name);
            updateSelectOption('#subsubcategory_id', sub_sub_category.id, sub_sub_category.subsubcategory_name);

            // Isi field form umum
            $(`${modal} [name="product_code"]`).val(product_code);
            $(`${modal} [name="product_name"]`).val(product_name);
            $(`${modal} [name="product_slug"]`).val(product_slug);
            $(`${modal} [name="product_color"]`).val(product_color);
            $(`${modal} [name="short_descp"]`).val(short_descp);
            $(`${modal} [name="long_descp"]`).val(long_descp);
            $(`${modal} [name="status"]`).val(status);
            
            // Atur checkbox 'special_deals'
            const isSpecialDeal = special_deals == 1;
            $('#special_deals').prop('checked', isSpecialDeal);
            // Panggil fungsi untuk menampilkan/menyembunyikan kolom diskon
            toggleDiscountFieldsPerSize(isSpecialDeal);


            // === PERBAIKAN UTAMA UNTUK VARIAN PRODUK ===

            const sizePriceContainer = $('#sizePriceContainer');
            sizePriceContainer.empty(); // 1. Kosongkan container dari baris template

            if (variants && variants.length > 0) {
                // 2. Loop melalui setiap varian dan buat baris input
                variants.forEach(variant => {
                    const priceFormatted = new Intl.NumberFormat("id-ID").format(variant.price);
                    const priceAfterDiscountFormatted = new Intl.NumberFormat("id-ID").format(variant.price_after_discount);

                    // 3. Buat HTML untuk satu baris varian
                    const newRow = `
                        <div class="row mb-2 size-price-group">
                            <div class="col-md-3">
                                <input type="text" name="sizes[]" class="form-control" placeholder="Ukuran" required value="${variant.size || ''}">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="prices[]" class="form-control price-input" placeholder="Harga" required onkeyup="formatHarga(this)" value="${priceFormatted || ''}">
                            </div>
                            <div class="col-md-2 discount-wrapper" style="display: ${isSpecialDeal ? 'block' : 'none'};">
                                <input type="number" name="discounts[]" class="form-control" placeholder="Diskon %" oninput="updateDiscountedPrice(this)" value="${variant.discount || 0}">
                            </div>
                            <div class="col-md-3 price-discount-wrapper" style="display: ${isSpecialDeal ? 'block' : 'none'};">
                                <input type="text" name="price_after_discounts[]" class="form-control" placeholder="Harga Setelah Diskon" readonly value="${priceAfterDiscountFormatted || ''}">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="quantities[]" class="form-control" placeholder="Stok" required min="0" value="${variant.quantity || 0}">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeSizePrice(this)">Hapus</button>
                            </div>
                        </div>
                    `;
                    // 4. Tambahkan baris baru ke container
                    sizePriceContainer.append(newRow);
                });
            } else {
                 // Jika tidak ada varian sama sekali, tambahkan satu baris kosong
                 addSizePrice();
            }

        })
        .fail((errors) => {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: 'Gagal mengambil data.',
            });
        });
}

function detailForm(url) {
    $.get(url, function(response) {
        const data = response.data;
        console.log('Cek data dari server:', data); // Penting untuk debugging!

        // Mengisi data produk umum
        $('#product_name').val(data.product_name);
        $('#product_code').val(data.product_code || '');
        $('#short_descp').val(data.short_descp || '');
        $('#long_descp').val(data.long_descp || '');
        $('#category').val(data.category.category_name || 'N/A');
        $('#subcategory').val(data.sub_category.subcategory_name || 'N/A');
        $('#product_color').val(data.product_color || '');
        $('#status').val(data.status == 1 ? 'Active' : 'Inactive');

        const variantTableBody = $('#variant_table_body');
        variantTableBody.empty(); 

        if (data.variants && data.variants.length > 0) {
            data.variants.forEach(variant => {
                const priceFormatted = variant.price ? `Rp ${parseInt(variant.price).toLocaleString('id-ID')}` : 'N/A';
                const discountFormatted = variant.discount ? `${variant.discount}%` : '0%';
                
                // 1. FORMAT HARGA SETELAH DISKON
                const priceAfterDiscountFormatted = variant.price_after_discount 
                    ? `Rp ${parseInt(variant.price_after_discount).toLocaleString('id-ID')}` 
                    : priceFormatted; // Jika tidak ada harga diskon, tampilkan harga normal

                const row = `
                    <tr>
                        <td>${variant.size || 'N/A'}</td>
                        <td>${priceFormatted}</td>
                        <td>${discountFormatted}</td>
                        <td>${priceAfterDiscountFormatted}</td> <td>${variant.quantity || 0}</td>
                    </tr>
                `;
                variantTableBody.append(row);
            });
        } else {
            // 3. UBAH COLSPAN MENJADI 5 KARENA ADA 5 KOLOM
            const noVariantRow = '<tr><td colspan="5">Tidak ada varian untuk produk ini.</td></tr>';
            variantTableBody.append(noVariantRow);
        }

        // Mengisi gambar utama dan gambar tambahan
        $('#multi_images').empty();
        $('#product_thumbnail').empty();

        $('#product_thumbnail').append('<img src="' + data.product_thumbnail +
            '" class="img-fluid rounded" style="max-width: 150px; height: auto; margin: 5px;">'
        );
        if (data.multi_images) {
            data.multi_images.forEach(image => {
                $('#multi_images').append('<img src="' + image.photo_name +
                    '" class="img-fluid rounded" style="max-width: 150px; height: auto; margin: 5px;">'
                );
            });
        }

        $('#modalDetail').modal('show');
    });
}
        // Function to update a select element with options
        function updateSelectOption(selector, value, text) {
            // Check if the option exists
            const optionExists = $(`${selector} option[value="${value}"]`).length > 0;

            if (!optionExists) {
                // If the option doesn't exist, create and append it
                const newOption = new Option(text, value, true, true);
                $(selector).append(newOption).trigger('change');
            } else {
                // If the option exists, update the select's value
                $(selector).val(value).trigger('change');
            }
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

    <script>
        // Function to preview the thumbnail image
        function previewImage(input) {
            const file = input.files[0];
            const reader = new FileReader();
            reader.onload = function(e) {
                const thumbnailPreview = document.getElementById('thumbnailPreview');
                thumbnailPreview.src = e.target.result;
                thumbnailPreview.style.display = 'block'; // Show the image preview
            };
            if (file) {
                reader.readAsDataURL(file);
            }
        }

        // Function to preview multiple product images
        function previewMultipleImages(input) {
            const files = input.files;
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            imagePreviewContainer.innerHTML = ''; // Clear previous previews

            for (let i = 0; i < files.length; i++) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.maxWidth = '100px';
                    img.style.margin = '5px';
                    imagePreviewContainer.appendChild(img);
                };
                if (files[i]) {
                    reader.readAsDataURL(files[i]);
                }
            }
        }

        // Event listener to clear previews when the modal is closed
        $(modal).on('hidden.bs.modal', function() {
            // Clear the image previews when modal is closed
            document.getElementById('thumbnailPreview').style.display = 'none';
            document.getElementById('thumbnailPreview').src = '';
            document.getElementById('imagePreviewContainer').innerHTML = '';
            // Optionally reset the file inputs
            document.getElementById('product_thumbnail').value = '';
            document.getElementById('photo_name').value = '';
        });
    </script>

    {{-- <script>
        function calculateDiscountPrice() {
            const sellingPrice = $('[name="selling_price"]').val().replace(/\./g, '');
            const discountPercentage = $('[name="discount_price"]').val();
            const discountAmount = (sellingPrice * discountPercentage) / 100;

            // Calculate the price after discount
            const priceAfterDiscount = sellingPrice - discountAmount;

            // Format the result and display it
            document.getElementById('price_after_discount').value = formatCurrency(priceAfterDiscount);
        }

        function formatCurrency(value) {
            return value.toLocaleString('id-ID').replace(",", ".");
        }

        // Optional: Call this function if you want to display the price after discount on page load (if selling_price is pre-filled)
        calculateDiscountPrice();
    </script> --}}
@endpush
