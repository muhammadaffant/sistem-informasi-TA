@extends('frontend.main_master')

@section('title', 'Detail Produk')

{{-- CSS Tambahan untuk Bintang Rating --}}
@push('styles')
<style>
    /* 1. Jadikan SEMUA bintang berwarna abu-abu dan paksa dengan !important */
    .rating .fa-star {
        color: #ddd !important; /* Warna abu-abu untuk bintang kosong */
    }

    /* 2. HANYA bintang dengan kelas 'rate-star' yang akan berwarna oranye, paksa dengan !important */
    .rating .fa-star.rate-star {
        color: #f89921 !important;
    }
    
    .price-strike {
        text-decoration: line-through;
        color: #aaa;
        font-size: 16px;
        margin-left: 10px;
    }
</style>
@endpush


@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class='active'>{{ $product->product_name }}</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="body-content outer-top-xs">
        <div class='container'>
            <div class='row single-product'>
                <div class='col-md-12 sidebar'>
                    {{-- Sertakan Hot Deals jika ada --}}
                    @include('frontend.common.hotdeals_product')
                </div>

                <div class='col-md-12'>
                    <div class="detail-block">
                        <div class="row wow fadeInUp">
                            {{-- GALERI GAMBAR --}}
                            <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
                                <div class="product-item-holder size-big single-product-gallery small-gallery">
                                    <div id="owl-single-product">
                                        @foreach ($multiImg as $img)
                                            <div class="single-product-gallery-item" id="slide{{ $img->id }}">
                                                <img class="img-responsive" alt="" src="{{ Storage::url($img->photo_name) }}" data-echo="{{ Storage::url($img->photo_name) }}" />
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="single-product-gallery-thumbs gallery-thumbs">
                                        <div id="owl-single-product-thumbnails">
                                            @foreach ($multiImg as $key => $img)
                                                <div class="item">
                                                    <a class="horizontal-thumb {{ $key == 0 ? 'active' : '' }}" data-target="#owl-single-product" data-slide="{{ $key }}" href="#slide{{ $img->id }}">
                                                        <img class="img-responsive" width="85" alt="" src="{{ Storage::url($img->photo_name) }}" data-echo="{{ Storage::url($img->photo_name) }}" />
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- INFO PRODUK --}}
                            <div class='col-sm-6 col-md-7 product-info-block'>
                                <div class="product-info">
                                    <h1 class="name" id="pname">{{ $product->product_name }}</h1>
                                    
                                    {{-- Tampilan Stok --}}
                                    <div class="stock-container info-container m-t-10">
                                        <div class="row">
                                            <div class="col-sm-3"><div class="stock-box"><span class="label">Ketersediaan :</span></div></div>
                                            <div class="col-sm-9"><div class="stock-box"><span id="stock-status" class="value">Pilih ukuran</span></div></div>
                                        </div>
                                    </div>

                                    {{-- Deskripsi Singkat --}}
                                    <div class="description-container m-t-20">
                                        {{ $product->short_descp }}
                                    </div>

                                    {{-- Tampilan Harga --}}
                                    <div class="price-container info-container m-t-20">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="price-box" id="price-container">
                                                    <span class="price">Pilih ukuran untuk melihat harga</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Pilihan Varian --}}
                                    <div class="quantity-container info-container">
                                        <div class="row">
                                            {{-- KOLOM UKURAN --}}
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    @if ($product->variants->isNotEmpty())
                                                        <label class="control-label">Ukuran</label>
                                                        <select name="size" id="size" class="form-control unicase-form-control select-style" required>
                                                            <option value="" selected disabled>Pilih Ukuran</option>
                                                            @foreach ($product->variants->unique('size') as $variant)
                                                                <option value="{{ $variant->size }}"
                                                                    data-variant-id="{{ $variant->id }}"
                                                                    data-price="{{ $variant->price }}"
                                                                    data-price-after-discount="{{ $variant->price_after_discount }}"
                                                                    data-stock="{{ $variant->quantity }}">
                                                                    {{ $variant->size }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- KOLOM WARNA --}}
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    @if ($product->product_color)
                                                        <label class="control-label">Warna</label>
                                                        <select name="color" id="color" class="form-control unicase-form-control select-style" required>
                                                            <option value="" selected disabled>Pilih Warna</option>
                                                            @foreach (explode(',', $product->product_color) as $color)
                                                                <option value="{{ trim($color) }}">{{ trim($color) }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Kuantitas & Tombol Add to Cart --}}
                                    <div class="quantity-container info-container">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <span class="label">Jumlah:</span>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="cart-quantity">
                                                    <div class="quant-input">
                                                        <div class="arrows"><div class="arrow plus gradient"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div><div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div></div>
                                                        <input type="text" value="1" id="qty" min="1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-8">
                                                <input type="hidden" id="product_id" value="{{ $product->id }}">
                                                <input type="hidden" id="variant_id" name="variant_id">
                                                <button type="button" id="addToCartBtn" onclick="addToCart()" class="btn btn-primary" disabled>
                                                    <i class="fa fa-shopping-cart inner-right-vs"></i> ADD TO CART
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TAB DESKRIPSI DAN ULASAN --}}
                    <div class="product-tabs inner-bottom-xs wow fadeInUp">
                        <div class="row">
                            <div class="col-sm-3">
                                <ul id="product-tabs" class="nav nav-tabs nav-tab-cell">
                                    <li class="active"><a data-toggle="tab" href="#description">DESKRIPSI</a></li>
                                    <li><a data-toggle="tab" href="#review">ULASAN ({{ count($reviews) }})</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-9">
                                <div class="tab-content">
                                    <div id="description" class="tab-pane in active">
                                        <div class="product-tab">
                                            <p class="text">{!! nl2br(e($product->long_descp)) !!}</p>
                                        </div>
                                    </div>

                                    <div id="review" class="tab-pane">
                                        <div class="product-tab">
                                            {{-- DAFTAR ULASAN --}}
                                            <div class="product-reviews">
                                                <h4 class="title">Ulasan Pelanggan</h4>
            @forelse($reviews as $review)
                <div class="reviews" style="border-bottom: 1px solid #f0f0f0; margin-bottom: 15px; padding-bottom: 15px;">
                    <div class="review">
                        <div class="review-title">
                            <span class="summary"><b>{{ $review->user->name }}</b></span>
                            <span class="date"><i class="fa fa-calendar"></i><span> {{ $review->created_at->diffForHumans() }}</span></span>
                        </div>
                        <div class="text">"{{ $review->comment }}"</div>
                        <div class="rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star" style="display: inline-block; color: {{ $i <= $review->rating ? '#f89921' : '#ddd' }};"></i>
                            @endfor
                        </div>

                        {{-- ========================================================== --}}
                        {{-- BARU: Blok untuk menampilkan balasan admin                  --}}
                        {{-- ========================================================== --}}
                        @if ($review->admin_reply)
                        <div class="admin-reply" style="background-color: #f5f5f5; border-left: 3px solid #f89921; padding: 10px 15px; margin-top: 15px; border-radius: 4px;">
                            <div class="review-title">
                                <span class="summary"><b>Balasan Admin</b></span>
                                <span class="date"><i class="fa fa-calendar"></i><span> {{ \Carbon\Carbon::parse($review->replied_at)->diffForHumans() }}</span></span>
                            </div>
                            <div class="text" style="font-style: italic;">{{ $review->admin_reply }}</div>
                        </div>
                        @endif
                        {{-- ========================================================== --}}

                    </div>
                </div>
            @empty
                <p>Belum ada ulasan untuk produk ini. Jadilah yang pertama!</p>
            @endforelse

                                            </div>

                                            {{-- FORM TULIS ULASAN --}}
                                            <div class="product-add-review" style="margin-top: 25px;">
                                                <h4 class="title">Tulis Ulasan Anda</h4>
                                                <div class="review-form">
                                                    @auth
                                                        @if($hasPurchased)
                                                            <form role="form" class="cnt-form" id="review-form" method="post">
                                                                @csrf
                                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                                <div class="form-group">
                                                                    <label for="rating">Rating <span class="astk">*</span></label>
                                                                    <select name="rating" class="form-control unicase-form-control" style="width: 200px;" required>
                                                                        <option value="" selected disabled>Pilih Bintang</option>
                                                                        <option value="5">5 Bintang - Sempurna</option>
                                                                        <option value="4">4 Bintang - Baik</option>
                                                                        <option value="3">3 Bintang - Cukup</option>
                                                                        <option value="2">2 Bintang - Kurang</option>
                                                                        <option value="1">1 Bintang - Buruk</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="comment">Ulasan Anda <span class="astk">*</span></label>
                                                                    <textarea class="form-control txt" id="comment" name="comment" rows="6" required placeholder="Bagaimana pendapat Anda tentang produk ini?"></textarea>
                                                                </div>
                                                                <div class="action text-right">
                                                                    <button type="submit" class="btn btn-primary btn-upper">Kirim Ulasan</button>
                                                                </div>
                                                            </form>
                                                        @else
                                                            <p class="text-danger">Anda harus membeli produk ini terlebih dahulu untuk memberikan ulasan.</p>
                                                        @endif
                                                    @else
                                                        <p>Silakan <a href="{{ route('login') }}"><b>login</b></a> untuk menulis ulasan.</p>
                                                    @endguest
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    {{-- PRODUK TERKAIT --}}
                                                           <section class="section featured-product wow fadeInUp">
                        <h3 class="section-title">Related products</h3>
                        <div class="owl-carousel home-owl-carousel upsell-product custom-carousel owl-theme outer-top-xs">

                            @if ($relatedProduct->isNotEmpty())
                                @foreach ($relatedProduct as $product)
                                @endforeach
                                <div class="item item-carousel">
                                    <div class="products">

                                        <div class="product">
                                            <div class="product-image">
                                                <div class="image">
                                                    <a
                                                        href="{{ url('/detail/' . $product->id . '/' . $product->product_slug) }}"><img
                                                            src="{{ Storage::url($product->product_thumbnail) }}"
                                                            alt=""></a>
                                                </div><!-- /.image -->



                                                @if ($product->discount_price != 0)
                                                    <div class="tag sale"><span>{{ $product->discount_price }} %<br>
                                                            off</span></div>
                                                @else
                                                    <div class="tag sale"><span>New</span></div>
                                                @endif
                                            </div><!-- /.product-image -->


                                            <div class="product-info text-left">
                                                <h3 class="name"><a
                                                        href="{{ url('/detail/' . $product->id . '/' . $product->product_slug) }}">{{ $product->product_name }}</a>
                                                </h3>

                                                <div class="description">{{ $product->short_descp }}</div>

                                                @if ($product->discount_price == 0)
                                                    <div class="product-price"> <span class="price">
                                                            Rp. {{ format_uang($product->selling_price) }}
                                                        </span>

                                                    </div>
                                                @else
                                                    <div class="product-price"> <span class="price">
                                                            Rp.
                                                            {{ format_uang($product->price_after_discount) }}
                                                        </span>
                                                        <span class="price-before-discount">Rp.
                                                            {{ format_uang($product->selling_price) }}</span>
                                                    </div>
                                                @endif

                                            </div><!-- /.product-info -->
                                            <div class="cart clearfix animate-effect">
                                                <div class="action">
                                                    <ul class="list-unstyled">
                                                        <li class="add-cart-button btn-group">
                                                            <button data-toggle="modal" id="{{ $product->id }}"
                                                                onclick="productView(this.id)" data-target="#staticBackdrop"
                                                                class="btn btn-primary icon" type="button"
                                                                title="Add Cart"> <i class="fa fa-shopping-cart"></i>
                                                            </button>
                                                            <button class="btn btn-primary cart-btn" type="button">Add to
                                                                cart</button>

                                                        </li>


                                                        <li class="add-cart-button btn-group"> <button type="submit"
                                                            onclick="addToWislist(this.id)" id="{{ $product->id }}"
                                                            data-toggle="tooltip" class="btn btn-primary icon"
                                                            title="Wishlist">
                                                            <i class="icon fa fa-heart"></i>
                                                        </button>
                                                    </li>

                                                        <li class="lnk">
                                                            <a class="add-to-cart" href="detail.html" title="Compare">
                                                                <i class="fa fa-signal"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div><!-- /.action -->
                                            </div><!-- /.cart -->
                                        </div><!-- /.product -->

                                    </div><!-- /.products -->
                                </div><!-- /.item -->
                            @endif

                        </div><!-- /.home-owl-carousel -->
                    </section><!-- /.section -->

                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>

{{-- ========================================== JAVASCRIPT ========================================== --}}
{{-- Letakkan di akhir file, sebelum @endsection --}}

{{-- ========================================== JAVASCRIPT ========================================== --}}
<script type="text/javascript">
    // ... (Fungsi addToCart() dan logika varian lainnya tetap sama persis seperti sebelumnya) ...
    function addToCart() {
        const productId = document.getElementById("product_id").value;
        const variantId = document.getElementById("variant_id").value;
        const quantity = document.getElementById("qty").value;
        const colorSelect = document.getElementById("color");
        const color = colorSelect ? colorSelect.value : null;
        const sizeSelect = document.getElementById("size");
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        if ((sizeSelect && sizeSelect.value === "") || (!variantId && sizeSelect)) {
            Swal.fire({ title: "Gagal", text: "Silakan pilih ukuran terlebih dahulu.", icon: "error" });
            return;
        }
        if (colorSelect && colorSelect.value === "") {
            Swal.fire({ title: "Gagal", text: "Silakan pilih warna terlebih dahulu.", icon: "error" });
            return;
        }

        const formData = new FormData();
        formData.append('variant_id', variantId);
        formData.append('qty', quantity);
        if (color) {
            formData.append('color', color);
        }

        fetch('/cart/data/store/' + productId, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json',
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({ title: "Berhasil!", text: data.success, icon: "success", showConfirmButton: false, timer: 2000 });
                if (typeof miniCart === "function") {
                    miniCart();
                }
            } else {
                Swal.fire({ title: "Gagal", text: data.error || "Terjadi kesalahan.", icon: "error" });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({ title: "Error", text: "Tidak dapat memproses permintaan.", icon: "error" });
        });
    }

    // Fungsi untuk menampilkan review baru secara dinamis

// GANTI FUNGSI INI DI BLOK SCRIPT ANDA

function prependNewReview(review) {
    const noReviewMessage = document.querySelector('.product-reviews p');
    if (noReviewMessage) {
        noReviewMessage.remove();
    }

    const userRating = parseInt(review.rating, 10);
    
    let starsHtml = '';
    for (let i = 1; i <= 5; i++) {
        // PERUBAHAN DI SINI: Menambahkan style langsung ke tag <i>
        const starColor = i <= userRating ? '#f89921' : '#ddd';
        starsHtml += `<i class="fa fa-star" style="display: inline-block; color: ${starColor};"></i>`;
    }

    const newReviewHtml = `
        <div class="reviews" style="border-bottom: 1px solid #f0f0f0; margin-bottom: 15px; padding-bottom: 15px;">
            <div class="review">
                <div class="review-title">
                    <span class="summary"><b>${review.user.name}</b></span>
                    <span class="date"><i class="fa fa-calendar"></i><span> Baru saja</span></span>
                </div>
                <div class="text">"${review.comment}"</div>
                <div class="rating">${starsHtml}</div>
            </div>
        </div>
    `;

    const reviewsContainer = document.querySelector('.product-reviews');
    reviewsContainer.insertAdjacentHTML('beforeend', newReviewHtml);

    const reviewTabCounter = document.querySelector('a[href="#review"]');
    if (reviewTabCounter) {
        let currentCount = parseInt(reviewTabCounter.innerText.match(/\d+/)[0]);
        reviewTabCounter.innerHTML = `ULASAN (${currentCount + 1})`;
    }
}

    document.addEventListener("DOMContentLoaded", function () {
        // ... (Logika untuk varian produk tetap sama seperti sebelumnya) ...
        const sizeSelect = document.getElementById("size");
        const colorSelect = document.getElementById("color");
        const addToCartBtn = document.getElementById("addToCartBtn");
        const priceContainer = document.getElementById("price-container");
        const stockStatus = document.getElementById("stock-status");
        const qtyInput = document.getElementById("qty");
        const variantIdInput = document.getElementById("variant_id");

        function formatCurrency(number) {
            if (isNaN(number)) return "";
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(number);
        }

        function updateVariantDetails() {
            if (!sizeSelect || sizeSelect.value === "") return;
            const selectedOption = sizeSelect.options[sizeSelect.selectedIndex];
            variantIdInput.value = selectedOption.getAttribute('data-variant-id');
            const price = parseFloat(selectedOption.getAttribute('data-price'));
            const priceAfterDiscount = parseFloat(selectedOption.getAttribute('data-price-after-discount'));
            const stock = parseInt(selectedOption.getAttribute('data-stock'));
            priceContainer.innerHTML = (priceAfterDiscount > 0 && priceAfterDiscount < price)
                ? `<span class="price">${formatCurrency(priceAfterDiscount)}</span> <span class="price-strike">${formatCurrency(price)}</span>`
                : `<span class="price">${formatCurrency(price)}</span>`;

            if (stock > 0) {
                stockStatus.innerHTML = `<strong class="text-success">${stock} item tersedia</strong>`;
                qtyInput.max = stock;
            } else {
                stockStatus.innerHTML = `<span class="text-danger">Habis</span>`;
                qtyInput.max = 0;
            }
            if (parseInt(qtyInput.value) > stock) qtyInput.value = 1;
        }

        function checkSelectionAndStock() {
            const sizeSelected = sizeSelect ? sizeSelect.value !== "" : true;
            const colorSelected = colorSelect ? colorSelect.value !== "" : true;
            let stock = 0;
            if (sizeSelect && sizeSelect.value !== "") {
                const selectedOption = sizeSelect.options[sizeSelect.selectedIndex];
                stock = parseInt(selectedOption.getAttribute('data-stock'));
            } else if (!sizeSelect) {
                stock = {{ $product->product_qty ?? 0 > 0 ? 1 : 0 }};
            }
            if (sizeSelected && colorSelected && stock > 0) {
                addToCartBtn.removeAttribute("disabled");
            } else {
                addToCartBtn.setAttribute("disabled", "true");
            }
        }

        if (sizeSelect) {
            sizeSelect.addEventListener("change", () => {
                updateVariantDetails();
                checkSelectionAndStock();
            });
        }
        if (colorSelect) {
            colorSelect.addEventListener("change", checkSelectionAndStock);
        }
        checkSelectionAndStock();

        // Logika untuk form review
        const reviewForm = document.getElementById("review-form");
        if (reviewForm) {
            reviewForm.addEventListener("submit", function (e) {
                e.preventDefault();
                const formData = new FormData(this);
                const submitButton = this.querySelector('button[type="submit"]');
                const originalButtonText = submitButton.innerHTML;
                submitButton.disabled = true;
                submitButton.innerHTML = 'MENGIRIM...';

                fetch('{{ route("review.store") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json',
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.review) { // <-- PERUBAHAN
                        Swal.fire({ title: "Berhasil!", text: data.success, icon: "success" });
                        prependNewReview(data.review); // <-- PANGGIL FUNGSI BARU
                        reviewForm.reset();
                        reviewForm.style.display = 'none';
                    } else {
                        Swal.fire({ title: "Gagal!", text: data.error || "Terjadi kesalahan.", icon: "error" });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({ title: "Error", text: "Tidak dapat memproses permintaan.", icon: "error" });
                })
                .finally(() => {
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalButtonText;
                });
            });
        }
    });
</script>
@endsection
