@extends('frontend.main_master')

@section('title', 'Custom Order')

{{-- Menambahkan Font Awesome untuk ikon --}}
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
    /* Style tambahan untuk membuat tampilan lebih bersih */
    .card-header .fas {
        margin-right: 10px;
    }
    .price-summary-card {
        position: sticky;
        top: 20px; /* Membuat panel ringkasan "mengikuti" saat scroll */
    }
    .grand-total-row td {
        font-size: 1.3em;
        font-weight: bold;
        border-top: 2px solid #dee2e6;
        padding-top: 10px !important;
    }
</style>
@endpush


@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class='active'>@yield('title')</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="body-content">
        <div class="container">
            <div class="checkout-box">
                <form id="customOrderForm" role="form" enctype="multipart/form-data">
                    @csrf
                    {{-- Hidden fields dipindahkan ke sini agar tetap di dalam form --}}
                    <input type="hidden" name="province_id" id="province_id">
                    <input type="hidden" name="city_id" id="city_id">
                    <input type="hidden" name="district_id" id="district_id">
                    <input type="hidden" name="courier" id="courier_hidden">
                    <input type="hidden" name="courier_service" id="courier_service_hidden">
                    <input type="hidden" name="ongkir" id="ongkir_hidden">
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}">

                    <div class="row">
                        {{-- KOLOM KIRI: FORM INPUT --}}
                        <div class="col-lg-8">
                            {{-- KARTU 1: INFORMASI PEMESAN & DESAIN --}}
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5><i class="fas fa-user-edit"></i>Informasi Pemesan & Desain</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="name" class="info-title">Nama Lengkap</label>
                                        <input id="name" class="form-control" type="text" name="name" value="{{ Auth::user()->name }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="file_design" class="info-title">Upload Desain (Format: JPG, PNG, JPEG)</label>
                                        <input id="file_design" class="form-control" type="file" name="file_design" accept="image/*" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="position" class="info-title">Letak Logo/Desain</label>
                                        <select name="position" class="form-control" required>
                                            <option value="" disabled selected>Pilih Letak Logo</option>
                                            <option value="Depan Tengah">Depan Tengah</option>
                                            <option value="Depan Samping Kiri">Depan Samping Kiri</option>
                                            <option value="Depan Samping Kanan">Depan Samping Kanan</option>
                                            <option value="Belakang Tengah">Belakang Tengah</option>
                                            <option value="Belakang Atas">Belakang Atas</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="design_description" class="info-title">Warna Kaos</label>
                                        <textarea id="design_description" name="design_description" class="form-control" placeholder="Contoh: Hitam, Putih, Merah Maroon"></textarea>
                                    </div>
                                </div>
                            </div>

                            {{-- KARTU 2: SPESIFIKASI PRODUK --}}
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5><i class="fas fa-tshirt"></i>Spesifikasi & Kuantitas Produk</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="fabric_type" class="info-title">1. Pilih Tipe Bahan</label>
                                        <select id="fabric_type" name="bahan_id" class="form-control" required>
                                            <option value="" disabled selected>Pilih Bahan</option>
                                            @php
                                                $bahans = \App\Models\Bahan::has('sizes')->get();
                                            @endphp
                                            @foreach ($bahans as $bahan)
                                                <option value="{{ $bahan->id }}">{{ $bahan->nama_bahan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="info-title">2. Pilih Ukuran dan Jumlah (Minimal 12 pcs)</label>
                                        <div id="size-list-container" class="mt-2" style="border: 1px solid #e0e0e0; padding: 15px; border-radius: 4px;">
                                            <p class="text-muted text-center">Silakan pilih Tipe Bahan terlebih dahulu.</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="sablon_category" class="info-title">3. Pilih Kategori Sablon</label>
                                        <select id="sablon_category" class="form-control" required>
                                            <option value="" disabled selected>Pilih Kategori Sablon</option>
                                            @php
                                                $sablon_categories = \App\Models\SablonCategory::has('jenisSablons')->get();
                                            @endphp
                                            @foreach ($sablon_categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="jenis_sablon" class="info-title">4. Pilih Tipe & Harga Sablon</label>
                                        <select name="jenis_sablon_id" id="jenis_sablon" class="form-control" required disabled>
                                            <option value="" data-price="0">Pilih Kategori terlebih dahulu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- KARTU 3: INFORMASI PENGIRIMAN --}}
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-primary text-white">
                                    <h5><i class="fas fa-shipping-fast"></i>Informasi Pengiriman</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="address" class="info-title">Alamat Lengkap</label>
                                        <textarea name="address" id="address" class="form-control" rows="3" required placeholder="Contoh: Jl. Pahlawan No. 123, RT 01 RW 02, Kel. Mugassari"></textarea>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6"><div class="form-group"><label>Provinsi</label><select id="province_select" class="form-control select2" required></select></div></div>
                                        <div class="col-md-6"><div class="form-group"><label>Kabupaten/Kota</label><select id="city_select" class="form-control select2" disabled required></select></div></div>
                                        <div class="col-md-6"><div class="form-group"><label>Kecamatan</label><select id="district_select" class="form-control select2" disabled required></select></div></div>
                                        <div class="col-md-6"><div class="form-group"><label>Jasa Pengiriman</label><select id="courier_service" class="form-control" required><option value="">-- Pilih --</option><option value="jne">JNE</option><option value="pos">POS Indonesia</option><option value="tiki">TIKI</option></select></div></div>
                                        <div class="col-md-12"><div class="form-group"><label>Paket</label><select id="courier_select" class="form-control" required disabled><option>-- Pilih Alamat & Jasa Pengiriman --</option></select></div></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- KOLOM KANAN: RINGKASAN HARGA & SUBMIT --}}
                        <div class="col-lg-4">
                            <div class="card shadow-sm price-summary-card">
                                <div class="card-header bg-primary text-white">
                                    <h5><i class="fas fa-calculator"></i>Ringkasan Pesanan</h5>
                                </div>
                                <div class="card-body">
                                    {{-- CONTAINER UNTUK RINGKASAN HARGA REAL-TIME --}}
                                    <div id="price-summary-container">
                                        <p class="text-muted text-center" style="padding: 50px 0;">Ringkasan akan muncul di sini setelah Anda mengisi kuantitas.</p>
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                    <button type="button" id="submitCustomOrder" class="btn btn-primary btn-lg btn-block">Submit Custom Order</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
$(function() {
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
    }

    // FUNGSI UNTUK MENGHITUNG DAN MENAMPILKAN RINGKASAN HARGA SECARA REAL-TIME
    function updatePriceSummary() {
        let totalQty = 0;
        let totalBahanPrice = 0;
        const container = $('#price-summary-container');
        const sablonPrice = parseFloat($('#jenis_sablon').find('option:selected').data('price')) || 0;
        const ongkir = parseFloat($('#ongkir_hidden').val()) || 0; // Ambil ongkir

        $('#size-list-container input[type="number"]').each(function() {
            let qty = parseInt($(this).val()) || 0;
            if (qty > 0) {
                totalQty += qty;
                totalBahanPrice += parseFloat($(this).data('price')) * qty;
            }
        });

        if (totalQty === 0) {
            container.html('<p class="text-muted text-center" style="padding: 50px 0;">Ringkasan akan muncul di sini setelah Anda mengisi kuantitas.</p>');
            return;
        }

        let discountRate = 0;
        let discountText = "Tidak ada diskon";
        if (totalQty >= 100) {
            discountRate = 0.15; discountText = `Diskon ${discountRate * 100}%`;
        } else if (totalQty >= 24) {
            discountRate = 0.10; discountText = `Diskon ${discountRate * 100}%`;
        } else if (totalQty >= 12) {
            discountRate = 0.05; discountText = `Diskon ${discountRate * 100}%`;
        }

        const discountAmount = totalBahanPrice * discountRate;
        const finalBahanPrice = totalBahanPrice - discountAmount;
        const totalSablonPrice = sablonPrice * totalQty;
        const subtotalProduk = finalBahanPrice + totalSablonPrice;
        const grandTotal = subtotalProduk + ongkir; // Kalkulasi Grand Total

        let summaryHtml = `
            <div style="background-color: #f8f9fa; padding: 15px; border-radius: 5px;">
                <table class="table table-sm" style="margin-bottom: 0;">
                    <tbody>
                        <tr><td>Total Kuantitas</td><td class="text-right"><b>${totalQty} pcs</b></td></tr>
                        <tr><td>Harga Bahan</td><td class="text-right">${formatRupiah(totalBahanPrice)}</td></tr>
                        <tr><td>Diskon Bahan (${discountText})</td><td class="text-right text-danger">- ${formatRupiah(discountAmount)}</td></tr>
                        <tr><td>Harga Sablon (${formatRupiah(sablonPrice)}/pcs)</td><td class="text-right">${formatRupiah(totalSablonPrice)}</td></tr>
                        <tr style="border-top: 1px solid #ddd;"><td class="font-weight-bold">Subtotal Produk</td><td class="text-right font-weight-bold">${formatRupiah(subtotalProduk)}</td></tr>
                        <tr><td>Biaya Pengiriman</td><td class="text-right">${formatRupiah(ongkir)}</td></tr>
                    </tbody>
                    <tfoot>
                        <tr class="grand-total-row bg-light"><td class="text-primary">Grand Total</td><td class="text-right text-primary">${formatRupiah(grandTotal)}</td></tr>
                    </tfoot>
                </table>
        `;
        
        if (totalQty > 0 && totalQty < 12) {
            summaryHtml += `<div class="alert alert-warning text-center mt-3 p-2"><b>Peringatan:</b> Min. pemesanan adalah 12 pcs.</div>`;
        }

        summaryHtml += `</div>`;
        container.html(summaryHtml);
    }
    
    // Panggil fungsi update saat kuantitas atau jenis sablon berubah
    $('#size-list-container').on('input', 'input[type="number"]', updatePriceSummary);
    $('#jenis_sablon').on('change', updatePriceSummary);
    // Panggil juga saat ongkir berubah
    $('#courier_select').on('change', updatePriceSummary);


    // =================================================================
    // FUNGSI DINAMIS UNTUK MEMILIH UKURAN BERDASARKAN BAHAN
    // =================================================================
    $('#fabric_type').on('change', function() {
        const bahanId = $(this).val();
        const container = $('#size-list-container');
        
        container.html('<p class="text-center">Memuat ukuran...</p>');
        updatePriceSummary(); // Reset summary saat ganti bahan

        if (!bahanId) {
            container.html('<p class="text-muted text-center">Silakan pilih Tipe Bahan terlebih dahulu.</p>');
            return;
        }

        $.ajax({
            url: `/api/get-sizes/${bahanId}`,
            type: 'GET',
            dataType: 'json',
            success: function(sizes) {
                container.empty();
                if (sizes.length > 0) {
                    let tableHtml = '<div class="table-responsive"><table class="table table-bordered table-striped">';
                    tableHtml += `
                        <thead class="thead-light">
                            <tr>
                                <th>Ukuran</th>
                                <th>Harga Satuan</th>
                                <th style="width: 120px;">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                    `;

                    $.each(sizes, function(index, size) {
                        const formattedPrice = formatRupiah(size.price);
                        tableHtml += `
                            <tr>
                                <td><strong>${size.nama_size}</strong></td>
                                <td>${formattedPrice}</td>
                                <td>
                                    <input type="number" 
                                           name="items[${size.id}][qty]" 
                                           class="form-control form-control-sm" 
                                           placeholder="0" 
                                           min="0"
                                           data-price="${size.price}">
                                </td>
                            </tr>
                        `;
                    });
                    tableHtml += '</tbody></table></div>';
                    container.html(tableHtml);
                } else {
                    container.html('<p class="text-danger text-center">Ukuran untuk bahan ini tidak tersedia.</p>');
                }
            },
            error: function() {
                container.html('<p class="text-danger text-center">Gagal memuat data ukuran.</p>');
            }
        });
    });

    // =================================================================
    // FUNGSI DINAMIS UNTUK MEMILIH JENIS SABLON
    // =================================================================
    $('#sablon_category').on('change', function() {
        const categoryId = $(this).val();
        const detailSelect = $('#jenis_sablon');
        
        detailSelect.html('<option value="">Memuat...</option>').prop('disabled', true);
        updatePriceSummary(); // Reset summary

        if (!categoryId) {
            detailSelect.html('<option value="" data-price="0">Pilih Kategori terlebih dahulu</option>');
            return;
        }

        $.ajax({
            url: `/api/get-sablon-details/${categoryId}`,
            type: 'GET',
            dataType: 'json',
            success: function(details) {
                detailSelect.empty().prop('disabled', false);
                if (details.length > 0) {
                    detailSelect.append('<option value="" data-price="0" disabled selected>Pilih Tipe & Harga</option>');
                    $.each(details, function(index, detail) {
                        const formattedPrice = formatRupiah(detail.harga);
                        detailSelect.append(`<option value="${detail.id}" data-price="${detail.harga}">${detail.nama_sablon} - ${formattedPrice}</option>`);
                    });
                } else {
                    detailSelect.html('<option value="">Tipe tidak tersedia</option>').prop('disabled', true);
                }
            },
            error: function() {
                detailSelect.html('<option value="">Gagal memuat</option>').prop('disabled', true);
            }
        });
    });

    // =================================================================
    // FUNGSI UNTUK ALAMAT & ONGKIR
    // =================================================================
    $('.select2').select2();
    $('#province_select').select2({ placeholder: '-- Pilih Provinsi --', ajax: { url: '{{ route("api.get.provinces") }}', dataType: 'json', delay: 250, data: p => ({ q: p.term }), processResults: r => ({ results: $.map(r, i => ({ text: i.name, id: i.id })) }) } });
    $('#city_select').select2({ placeholder: '-- Pilih Kabupaten/Kota --', ajax: { url: function() { var provinceId = $('#province_select').val(); return provinceId ? `{{ url("api/get-cities") }}/${provinceId}` : null; }, dataType: 'json', delay: 250, data: p => ({ q: p.term }), processResults: r => ({ results: $.map(r, i => ({ text: i.name, id: i.id })) }) } });
    $('#district_select').select2({ placeholder: '-- Pilih Kecamatan --', ajax: { url: function() { var cityId = $('#city_select').val(); return cityId ? `{{ url("api/get-districts") }}/${cityId}` : null; }, dataType: 'json', delay: 250, data: p => ({ q: p.term }), processResults: r => ({ results: $.map(r, i => ({ text: i.name, id: i.id })) }) } });

    $('#province_select').on('change', function() {
        $('#province_id').val($(this).val());
        $('#city_select').val(null).trigger('change').prop('disabled', false);
        $('#district_select').val(null).trigger('change').prop('disabled', true);
        resetOngkirUI();
    });

    $('#city_select').on('change', function() {
        $('#city_id').val($(this).val());
        $('#district_select').val(null).trigger('change').prop('disabled', false);
        resetOngkirUI();
    });

    $('#district_select, #courier_service').on('change', function() {
        $('#district_id').val($('#district_select').val());
        checkOngkir();
    });

    $('#courier_select').on('change', function() {
        let cost = parseInt($(this).val() || 0);
        if (!cost && $(this).val() === "") { resetOngkirUI(); return; }
        let selected = $(this).find('option:selected');
        $('#ongkir_hidden').val(cost);
        $('#courier_hidden').val($('#courier_service').val());
        $('#courier_service_hidden').val(selected.data('service'));
        updatePriceSummary(); // Update total saat ongkir dipilih
    });
    
    function checkOngkir() {
        let destination = $('#district_select').val();
        let courier = $('#courier_service').val();
        if (!destination || !courier) { resetOngkirUI(); return; }

        $.ajax({
            url: '{{ route("api.get.ongkir") }}', type: 'POST',
            data: { _token: '{{ csrf_token() }}', origin_id: 115, destination_id: destination, weight: 1000, courier: courier },
            beforeSend: () => $('#courier_select').html('<option>Memuat...</option>').prop('disabled', true),
            success: function(response) {
                if (response.status === 'success' && response.data.length > 0) {
                    let html = '<option value="">-- Pilih Paket --</option>';
                    response.data.forEach(item => {
                        let cost = item.cost;
                        let formattedCost = formatRupiah(cost);
                        html += `<option value="${cost}" data-service="${item.service}">${item.code.toUpperCase()} - ${item.description} (${item.etd} hari) - ${formattedCost}</option>`;
                    });
                    $('#courier_select').html(html).prop('disabled', false);
                } else {
                    let msg = response.message || 'Layanan tidak tersedia';
                    $('#courier_select').html(`<option value="">${msg}</option>`).prop('disabled', true);
                }
            },
            error: () => $('#courier_select').html('<option>Gagal memuat</option>').prop('disabled', true)
        });
    }

    function resetOngkirUI() {
        $('#courier_select').html('<option>-- Pilih Alamat & Jasa Pengiriman --</option>').prop('disabled', true);
        $('#ongkir_hidden').val('');
        updatePriceSummary(); // Update total saat ongkir direset
    }

    // =================================================================
    // FUNGSI SUBMIT FORM UTAMA
    // =================================================================
    $('#submitCustomOrder').on('click', function(e) {
        e.preventDefault();
        
        let formData = new FormData($('#customOrderForm')[0]);
        // Validasi Manual Sederhana sebelum submit
        let totalQty = 0;
        $('#size-list-container input[type="number"]').each(function() {
            totalQty += parseInt($(this).val()) || 0;
        });

        if (totalQty < 12) {
             Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Minimum total kuantitas pemesanan adalah 12 pcs.' });
             return;
        }
        if (!$('#file_design').val()) {
             Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Harap upload file desain Anda.' });
             return;
        }

        $.ajax({
            url: "{{ route('user.customorder.store') }}",
            type: "POST", 
            data: formData, 
            processData: false, 
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            beforeSend: () => $('#submitCustomOrder').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...'),
            success: function(response) {
                if (response.success) {
                    Swal.fire({ icon: 'success', title: 'Berhasil!', text: response.success, timer: 3000, showConfirmButton: false });
                    setTimeout(() => {
                        window.location.href = "{{ route('user.customorder.history') }}";
                    }, 3000);
                }
            },
            error: function(xhr) {
                let errorMsg = 'Terjadi kesalahan. Pastikan semua field telah terisi dengan benar.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    // Menampilkan error validasi dari Laravel
                     errorMsg = Object.values(xhr.responseJSON.errors).map(e => e.join('\n')).join('\n');
                }
                Swal.fire({ icon: 'error', title: 'Gagal!', html: `<pre>${errorMsg}</pre>` });
            },
            complete: () => $('#submitCustomOrder').prop('disabled', false).text('Submit Custom Order')
        });
    });
});
</script>
@endpush