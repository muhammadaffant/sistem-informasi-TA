@extends('layouts.stisla')

@section('title', 'Custom Order')

@push('styles')
<style>
    .design-wrapper {
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .design-wrapper:hover {
        box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        transform: translateY(-2px);
    }
    
    .design-image-container {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .design-image-container:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 15px rgba(78, 115, 223, 0.3);
    }
    
    .design-info {
        padding: 15px;
        background: linear-gradient(135deg, #f8f9fc 0%, #e9ecef 100%);
        border-radius: 8px;
        border-left: 4px solid #4e73df;
    }
    
    #imageModal .modal-body img {
        transition: all 0.3s ease;
        max-height: 80vh;
        object-fit: contain;
    }
    
    #imageModal .modal-body img:hover {
        transform: scale(1.02);
    }
    
    .design-type-badge {
        position: absolute;
        top: 5px;
        right: 5px;
        z-index: 10;
    }
    
    .btn-design-action {
        transition: all 0.3s ease;
    }
    
    .btn-design-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
</style>
@endpush

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
                        <th>Tanggal & Waktu Pesan</th>
                        <th>Nama Lengkap</th>
                        <th>Nomor Hp</th>
                        <th>Bahan Kain</th>
                        <th>Jenis Sablon</th>
                        <th>Harga Sablon</th>
                        <th>Detail Ukuran</th>
                        <th>Total Qty</th>
                        <th>Total Berat</th>
                        <th>Estimasi (Hari)</th>
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
                { data: 'total_weight', name: 'total_weight', render: function(data, type, row) {
                    if (data) {
                        let formattedWeight = data >= 1000 ? 
                            (data / 1000).toFixed(1) + ' kg' : 
                            data + ' gram';
                        return `<span class="badge badge-secondary">${formattedWeight}</span>`;
                    }
                    return '<span class="text-muted">-</span>';
                }},
                { data: 'estimated_days', name: 'estimated_days', render: function(data, type, row) {
                    if (data) {
                        return `<span class="badge badge-info">${data} hari</span>`;
                    }
                    return '<span class="text-muted">-</span>';
                }},
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

            // Menampilkan gambar desain dengan tampilan yang lebih baik
            const designContainer = $('#design_container');
            
            // Cek apakah ada file desain
            const hasFrontDesign = data.file_design_front && data.file_design_front !== 'design.jpg';
            const hasBackDesign = data.file_design_back && data.file_design_back !== 'design.jpg';
            const hasMainDesign = data.file_design && data.file_design !== 'design.jpg';
            
            if (hasFrontDesign || hasBackDesign || hasMainDesign) {
                let designHtml = `
                    <div class="design-wrapper" style="border: 1px solid #ddd; border-radius: 8px; padding: 15px; background-color: #f8f9fa;">
                        <div class="row">
                            <div class="col-md-12">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-palette mr-2"></i>Preview Desain Kaos
                                </h6>
                            </div>
                        </div>
                        <div class="row">
                `;
                
                // Desain Depan
                if (hasFrontDesign) {
                    const frontPath = `/storage/${data.file_design_front}`;
                    designHtml += `
                        <div class="col-md-6 mb-3">
                            <div class="text-center">
                                <p class="font-weight-bold text-primary mb-2">
                                    <i class="fas fa-tshirt mr-2"></i>Desain Depan
                                </p>
                                <div class="design-image-container" style="border: 2px solid #28a745; border-radius: 8px; padding: 8px; background: white; display: inline-block;">
                                    <img src="${frontPath}" 
                                         class="img-fluid" 
                                         alt="Desain Depan" 
                                         style="max-width: 150px; max-height: 120px; object-fit: contain; border-radius: 4px;"
                                         onclick="showImageModal('${frontPath}', 'Desain Depan')">
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <strong>Posisi:</strong> ${data.front_position || 'Tidak ditentukan'}
                                    </small>
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                // Desain Belakang
                if (hasBackDesign) {
                    const backPath = `/storage/${data.file_design_back}`;
                    designHtml += `
                        <div class="col-md-6 mb-3">
                            <div class="text-center">
                                <p class="font-weight-bold text-secondary mb-2">
                                    <i class="fas fa-layer-group mr-2"></i>Desain Belakang
                                </p>
                                <div class="design-image-container" style="border: 2px solid #6c757d; border-radius: 8px; padding: 8px; background: white; display: inline-block;">
                                    <img src="${backPath}" 
                                         class="img-fluid" 
                                         alt="Desain Belakang" 
                                         style="max-width: 150px; max-height: 120px; object-fit: contain; border-radius: 4px;"
                                         onclick="showImageModal('${backPath}', 'Desain Belakang')">
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <strong>Posisi:</strong> ${data.back_position || 'Tidak ditentukan'}
                                    </small>
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                // Fallback untuk desain lama (jika tidak ada front/back design)
                if (!hasFrontDesign && !hasBackDesign && hasMainDesign) {
                    const mainPath = `/storage/${data.file_design}`;
                    designHtml += `
                        <div class="col-md-6 mb-3">
                            <div class="text-center">
                                <p class="font-weight-bold text-primary mb-2">
                                    <i class="fas fa-image mr-2"></i>Desain Utama
                                </p>
                                <div class="design-image-container" style="border: 2px solid #4e73df; border-radius: 8px; padding: 8px; background: white; display: inline-block;">
                                    <img src="${mainPath}" 
                                         class="img-fluid" 
                                         alt="Desain Kaos" 
                                         style="max-width: 150px; max-height: 120px; object-fit: contain; border-radius: 4px;"
                                         onclick="showImageModal('${mainPath}', 'Desain Kaos')">
                                </div>
                                <div class="mt-2">
                                    <small class="text-muted">
                                        <strong>Posisi:</strong> ${data.position || 'Tidak ditentukan'}
                                    </small>
                                </div>
                            </div>
                        </div>
                    `;
                }
                
                // Info tambahan
                designHtml += `
                            <div class="col-md-${(hasFrontDesign && hasBackDesign) ? '12' : '6'}">
                                <div class="design-info">
                                    <p class="mb-1"><strong><i class="fas fa-palette mr-2"></i>Warna Kaos:</strong></p>
                                    <p class="text-muted">${data.design_description || 'Tidak ada catatan khusus'}</p>
                                    <div class="mt-3">
                `;
                
                if (hasFrontDesign) {
                    designHtml += `
                        <button type="button" class="btn btn-sm btn-success mr-2 btn-design-action" onclick="showImageModal('/storage/${data.file_design_front}', 'Desain Depan')">
                            <i class="fas fa-expand-arrows-alt mr-1"></i>Lihat Depan
                        </button>
                    `;
                }
                
                if (hasBackDesign) {
                    designHtml += `
                        <button type="button" class="btn btn-sm btn-secondary mr-2 btn-design-action" onclick="showImageModal('/storage/${data.file_design_back}', 'Desain Belakang')">
                            <i class="fas fa-expand-arrows-alt mr-1"></i>Lihat Belakang
                        </button>
                    `;
                }
                
                if (!hasFrontDesign && !hasBackDesign && hasMainDesign) {
                    designHtml += `
                        <button type="button" class="btn btn-sm btn-primary btn-design-action" onclick="showImageModal('/storage/${data.file_design}', 'Desain Kaos')">
                            <i class="fas fa-expand-arrows-alt mr-1"></i>Lihat Ukuran Penuh
                        </button>
                    `;
                }
                
                designHtml += `
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                
                designContainer.html(designHtml);
            } else {
                designContainer.html(`
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle mr-2"></i>
                        Tidak ada file desain yang diunggah untuk pesanan ini.
                    </div>
                `);
            }

            // =======================================================
            // TAMPILKAN DETAIL VARIASI (NEW SYSTEM)
            // =======================================================
            const variationsContainer = $('#variations-detail-container');
            const legacyContainer = $('#legacy-size-container');
            
            // Cek apakah ada data custom_order_items (sistem baru)
            if (data.custom_order_items && data.custom_order_items.length > 0) {
                variationsContainer.show();
                legacyContainer.hide();
                
                let tableHtml = `
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>No</th>
                                    <th>Bahan</th>
                                    <th>Ukuran</th>
                                    <th>Jenis Sablon</th>
                                    <th>Qty</th>
                                    <th>Harga Bahan</th>
                                    <th>Harga Sablon</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                `;
                
                data.custom_order_items.forEach((item, index) => {
                    tableHtml += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${item.bahan ? item.bahan.nama_bahan : 'N/A'}</td>
                            <td>${item.size ? item.size.nama_size : 'N/A'}</td>
                            <td>${item.jenis_sablon ? (item.jenis_sablon.sablon_category ? item.jenis_sablon.sablon_category.name + ' - ' : '') + item.jenis_sablon.nama_sablon : 'N/A'}</td>
                            <td>${item.quantity} pcs</td>
                            <td>Rp ${parseInt(item.bahan_price || 0).toLocaleString('id-ID')}</td>
                            <td>Rp ${parseInt(item.sablon_price || 0).toLocaleString('id-ID')}</td>
                            <td><strong>Rp ${parseInt(item.subtotal || 0).toLocaleString('id-ID')}</strong></td>
                        </tr>
                    `;
                });
                
                // Total row
                tableHtml += `
                        <tr class="bg-light">
                            <td colspan="4" class="text-right"><strong>TOTAL</strong></td>
                            <td><strong>${data.qty} pcs</strong></td>
                            <td colspan="2"></td>
                            <td><strong>Rp ${parseInt(data.total_price).toLocaleString('id-ID')}</strong></td>
                        </tr>
                    </tbody>
                </table>
                </div>
                `;
                
                variationsContainer.html(tableHtml);
            } else {
                // =======================================================
                // FALLBACK KE SISTEM LAMA (LEGACY SUPPORT)
                // =======================================================
                variationsContainer.hide();
                legacyContainer.show();
                
                const sizeContainer = $('#size-detail-container');
                sizeContainer.empty();

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

    // Fungsi untuk menampilkan gambar dalam modal
    function showImageModal(imageSrc, title) {
        const modalHtml = `
            <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="imageModalLabel">
                                <i class="fas fa-image mr-2"></i>${title}
                            </h5>
                            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center" style="background: #f8f9fa;">
                            <div id="imageLoader" class="text-center py-4">
                                <i class="fas fa-spinner fa-spin fa-2x text-primary mb-2"></i>
                                <p class="text-muted">Memuat gambar...</p>
                            </div>
                            <img id="modalImage" 
                                 src="${imageSrc}" 
                                 class="img-fluid d-none" 
                                 alt="${title}" 
                                 style="max-width: 100%; height: auto; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);"
                                 onload="imageLoaded()" 
                                 onerror="imageError()">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fas fa-times mr-1"></i>Tutup
                            </button>
                            <a href="${imageSrc}" download class="btn btn-primary" target="_blank">
                                <i class="fas fa-download mr-1"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Hapus modal lama jika ada
        $('#imageModal').remove();
        
        // Tambahkan modal baru ke body
        $('body').append(modalHtml);
        
        // Tampilkan modal
        $('#imageModal').modal('show');
    }
    
    // Fungsi ketika gambar berhasil dimuat
    function imageLoaded() {
        $('#imageLoader').addClass('d-none');
        $('#modalImage').removeClass('d-none');
    }
    
    // Fungsi ketika gambar gagal dimuat
    function imageError() {
        $('#imageLoader').html(`
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                Gagal memuat gambar. File mungkin tidak ditemukan atau rusak.
            </div>
        `);
    }
    </script>  --}}
@endpush
