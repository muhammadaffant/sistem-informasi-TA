<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="">
    <meta name="keywords" content="MediaCenter, Template, eCommerce">
    <meta name="robots" content="all">
    {{-- <title>VIMS | {{ $title ?? '' }}</title> --}}
    <title>VIMS | @yield('title', $title ?? '')</title>


    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{ asset('/frontend') }}/assets/css/bootstrap.min.css">

    <!-- Customizable CSS -->
    <link rel="stylesheet" href="{{ asset('/frontend') }}/assets/css/main.css">
    <link rel="stylesheet" href="{{ asset('/frontend') }}/assets/css/blue.css">
    <link rel="stylesheet" href="{{ asset('/frontend') }}/assets/css/owl.carousel.css">
    <link rel="stylesheet" href="{{ asset('/frontend') }}/assets/css/owl.transitions.css">
    <link rel="stylesheet" href="{{ asset('/frontend') }}/assets/css/animate.min.css">
    <link rel="stylesheet" href="{{ asset('/frontend') }}/assets/css/rateit.css">
    <link rel="stylesheet" href="{{ asset('/frontend') }}/assets/css/bootstrap-select.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="{{ asset('/frontend') }}/assets/css/font-awesome.css">

    <!-- Fonts -->
    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800'
        rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        .top-cart-row .dropdown-cart .dropdown-menu {
            border: 1px solid #e1e1e1;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            border-radius: 0;
            float: right;
            left: auto;
            min-width: 0;
            padding: 24px 22px;
            right: 0;
            width: 270px !important;
            -moz-box-shadow: none;
            -webkit-box-shadow: none;
            box-shadow: none;
        }

        .cart-shopping-total {
            float: right;
            margin-top: 10px;
            /* Opsional untuk memberikan jarak */
        }

        .checkout-box .checkout-steps .checkout-step-01 .already-registered-login button {
            margin-top: 1px !important;
        }

        .search-marquee {
            font-size: 16px;
            color: #b2bc20;
            font-weight: normal;
            padding: 5px;
        }

        #current-time {
            font-weight: bold;
            color: #ffff;
        }

        .checkout-box .checkout-steps .checkout-step-01 .guest-login form .radio input[type="radio"],
        .checkout-box .checkout-steps form .radio-inline input[type="radio"],
        .checkout-box .checkout-steps form .checkbox input[type="checkbox"],
        .checkout-box .checkout-steps form .checkbox-inline input[type="checkbox"] {
            margin-left: -20px !important;
            margin-right: 20px !important;
        }

        .radio input[type=radio],
        .radio-inline input[type=radio],
        .checkbox input[type=checkbox],
        .checkbox-inline input[type=checkbox] {
            position: absolute;
            margin-top: 4px \9;
            margin-left: -20px;
        }

        input[type=radio],
        input[type=checkbox] {
            margin: 4px 0 0;
            margin-top: 1px \9;
            line-height: normal;
        }
    </style>
</head>

<body class="cnt-home">
    <!-- ============================================== HEADER ============================================== -->
    @include('frontend.body.header')
    <!-- ============================================== HEADER : END ============================================== -->
    @yield('content')
    <!-- /#top-banner-and-menu -->
    @include('frontend.body.brands') 
    <!-- ============================================================= FOOTER ============================================================= -->
     @include('frontend.body.footer') 
    <!-- ============================================================= FOOTER : END============================================================= -->

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><strong id="pname"></strong></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card" style="width: 100%;">
                                <img id="pimage" src="..." class="card-img-top" style="width: 100%"
                                    alt="...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item">Product Price: <span id="price"></span>
                                    <del id="oldprice"></del>
                                </li>
                                {{-- <li class="list-group-item">Product Code: <span id="pcode"></span></li> --}}
                                <li class="list-group-item">Category: <span id="pcategory"></span></li>
                                <li class="list-group-item">Brand: <span id="pbrand"></span></li>
                                <li class="list-group-item">Stock: <span id="pstock"></strong></li>
                            </ul>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" id="sizeArea">
                                <label for="size">Size</label>
                                <select name="size" id="size" class="form-control">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="color">Color</label>
                                <select name="color" id="color" class="form-control">
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="qty">Quantity</label>
                                <input type="number" class="form-control" name="qty" id="qty"
                                    value="1" min="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="variant_id" id="variant_id"> 
                    <input type="hidden" name="product_id" id="product_id">
                    <button type="button" class="btn btn-primary" onclick="addToCart()">Add to Cart</button>
                </div>
            </div>
        </div>
    </div>

    <!-- For demo purposes – can be removed on production -->

    <!-- For demo purposes – can be removed on production : End -->

    <!-- JavaScripts placed at the end of the document so the pages load faster -->
    <script src="{{ asset('/frontend') }}/assets/js/jquery-1.11.1.min.js"></script>
    <script src="{{ asset('/frontend') }}/assets/js/bootstrap.min.js"></script>
    <script src="{{ asset('/frontend') }}/assets/js/bootstrap-hover-dropdown.min.js"></script>
    <script src="{{ asset('/frontend') }}/assets/js/owl.carousel.min.js"></script>
    <script src="{{ asset('/frontend') }}/assets/js/echo.min.js"></script>
    <script src="{{ asset('/frontend') }}/assets/js/jquery.easing-1.3.min.js"></script>
    <script src="{{ asset('/frontend') }}/assets/js/bootstrap-slider.min.js"></script>
    <script src="{{ asset('/frontend') }}/assets/js/jquery.rateit.min.js"></script>
    <script type="text/javascript" src="{{ asset('/frontend') }}/assets/js/lightbox.min.js"></script>
    <script src="{{ asset('/frontend') }}/assets/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('/frontend') }}/assets/js/wow.min.js"></script>
    <script src="{{ asset('/frontend') }}/assets/js/scripts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fabric.js/5.3.1/fabric.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        // function get view modal
     let currentVariants = [];

    // FUNGSI BARU: Untuk update UI berdasarkan varian yang dipilih
    function updateVariantDetails(variant) {
        if (!variant) return;

        // Update harga
        if (variant.discount > 0) {
            $('#price').text('Rp. ' + formatRupiah(variant.price_after_discount));
            $('#oldprice').text('Rp. ' + formatRupiah(variant.price)).show();
        } else {
            $('#price').text('Rp. ' + formatRupiah(variant.price));
            $('#oldprice').hide();
        }

        // Update stok
        // Update stok
        if (variant.quantity > 0) {
            // Tampilkan jumlah stok yang sebenarnya
            $('#pstock').html('<strong>' + variant.quantity + '</strong> Tersisa'); 
            $('button[onclick="addToCart()"]').prop('disabled', false);
        } else {
            $('#pstock').html('<span class="badge badge-danger">Habis</span>');
            $('button[onclick="addToCart()"]').prop('disabled', true);
        }

        // Simpan ID varian yang dipilih
        $('#variant_id').val(variant.id);
    }

    // function get view modal (MODIFIKASI)
// function get view modal (MODIFIKASI LENGKAP)
function productView(id) {
    $.ajax({
        type: 'GET',
        url: '{{ url("product/view/modal/") }}/' + id,
        dataType: 'json',
        success: function(data) {
            // Simpan data produk dan varian
            let product = data.product;
            currentVariants = product.variants;

            // Set informasi produk dasar
            $('#pname').text(product.product_name);
            // $('#pcode').text(product.product_code);
            $('#pcategory').text(product.category.category_name);
            $('#pbrand').text(product.brand.brand_name);
            $('#pimage').attr('src', product.product_thumbnail);
            $('#product_id').val(product.id);
            $('#qty').val(1);

            // ================== LOGIKA UNTUK WARNA (TAMBAHAN) ==================
            // Kosongkan dropdown warna terlebih dahulu
            $('select[name="color"]').empty();
            
            // Cek jika data warna ada
            if (product.product_color) {
                // Pisahkan string warna menjadi array
                let colors = product.product_color.split(',');
                // Isi dropdown warna
                $.each(colors, function(key, value) {
                    $('select[name="color"]').append('<option value="' + value.trim() + '">' + value.trim() + '</option>');
                });
            }
            // ================== AKHIR LOGIKA WARNA ==================


            // ================== LOGIKA UNTUK UKURAN (Sudah Benar) ==================
            // Kosongkan dropdown ukuran
            $('select[name="size"]').empty();
            
            if (currentVariants && currentVariants.length > 0) {
                $('#sizeArea').show();
                // Isi dropdown ukuran dengan data dari varian
                $.each(currentVariants, function(key, variant) {
                    $('select[name="size"]').append('<option value="' + variant.id + '">' + variant.size + '</option>');
                });
                // Update UI dengan detail dari varian pertama sebagai default
                updateVariantDetails(currentVariants[0]);
            } else {
                $('#sizeArea').hide();
                $('#pstock').html('<span class="badge badge-danger">Tidak Tersedia</span>');
                $('button[onclick="addToCart()"]').prop('disabled', true);
            }
        }
    })
}

    // Event listener untuk dropdown ukuran
    $(document).on('change', 'select[name="size"]', function() {
        let selectedVariantId = $(this).val();
        // Cari data varian lengkap berdasarkan ID yang dipilih
        let selectedVariant = currentVariants.find(v => v.id == selectedVariantId);
        // Update UI dengan data varian yang baru
        updateVariantDetails(selectedVariant);
    });

    // function add to cart (MODIFIKASI)
 // function add to cart (MODIFIKASI)
function addToCart() {
    let product_id = $('#product_id').val();
    let variant_id = $('#variant_id').val();
    let qty = $('#qty').val();
    let color = $('#color option:selected').text(); // <-- TAMBAHKAN INI

    if (!variant_id) {
        Swal.fire({ title: "Gagal", text: "Silakan pilih ukuran terlebih dahulu.", icon: "error" });
        return;
    }

    $.ajax({
        type: "POST",
        dataType: "json",
        data: {
            variant_id: variant_id,
            qty: qty,
            color: color // <-- TAMBAHKAN INI
        },
        url: "/cart/data/store/" + product_id,
        success: function(data) {
            // ... (sisa kode sukses Anda sudah benar)
            miniCart();
            $('#closeModal').click();
            Swal.fire({
                title: "Berhasil",
                text: data.success,
                showConfirmButton: false,
                timer: 3000,
                icon: "success"
            });
        },
        error: function(xhr) {
            // ... (sisa kode error Anda sudah benar)
        }
    });
}

    // Helper untuk format rupiah (Anda sudah punya, tapi pastikan seperti ini)
    function formatRupiah(angka) {
        if (angka === null || angka === undefined) return '0';
        return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    </script>

    <script>
        function miniCart() {
            $.ajax({
                type: "GET",
                url: '/product/mini/cart',
                dataType: 'json',
                success: function(response) {

                    $('span[id="cartSubTotal"]').text(response.cartTotal)
                    $('#cartQty').text(response.cartQty)

                    let miniCart = ""

                    $.each(response.carts, function(key, value) {
                        miniCart += `<div class="cart-item product-summary">
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <div class="image"> <a href=""><img src="${value.options.image}"
                                                            alt=""></a>
                                                </div>
                                            </div>
                                            <div class="col-xs-7">
                                                <h3 class="name"><a href="#">${value.name}</a>
                                                </h3>
                                                <div class="price">Rp. ${value.price} * ${value.qty}</div>
                                            </div>
                                            <div class="col-xs-1 action"> <button type="submit" onclick="miniCartRemove(this.id)"  id="${value.rowId}" ><i class="fa fa-trash"></i></button> </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    <hr>
                                `
                    });

                    $('#miniCart').html(miniCart)
                }
            })
        }

        miniCart()

        // remove mini cart
        function miniCartRemove(rowId) {
            $.ajax({
                type: 'GET',
                url: "/minicart/product-remove/" + rowId,
                dataType: 'json',
                success: function(data) {
                    Swal.fire({
                        title: "Berhasil",
                        text: data.success,
                        showConfirmButton: false,
                        timer: 3000,
                        icon: "success"
                    }).then(() => {
                        miniCart()
                        cart()
                    });

                }
            })
        }

        // product wislist
        function addToWislist(productId) {
            $.ajax({
                type: "POST",
                url: "/user/add-to-wishlist/" + productId,
                dataType: "json",
                success: function(response) {
                    if ($.isEmptyObject(response.error)) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                            showConfirmButton: false,
                            timer: 3000
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.error,
                            showConfirmButton: false,
                            timer: 3000
                        })
                    }
                }
            })
        }

        // Get data Wishlist
        function getWishlist() {
            $.ajax({
                type: "GET",
                url: '/user/get-wishlist-product',
                dataType: 'json',
                success: function(response) {
                    let row = ""

                    $.each(response, function(key, value) {
                        row += `
                              <tr>
                                        <td class="col-md-2"><img src="/storage/${value.product.product_thumbnail}" alt="imga"></td>
                                        <td class="col-md-7">
                                            <div class="product-name"><a href="/detail/${value.product.id}/${value.product.product_slug}">${value.product.product_name}</a></div>
                                            <div class="price">
                                               ${value.product.discount_price == 0 ?
                                                `${formatRupiah(value.product.selling_price)}` :
                                                 `${formatRupiah(value.product.price_after_discount)} <span class="price-before-discount">${formatRupiah(value.product.selling_price)}</span>`
                                            }
                                            </div>
                                        </td>
                                        <td class="col-md-2">
                                                      <button data-toggle="modal" id="${value.product.id}"
                                                            onclick="productView(this.id)" data-target="#staticBackdrop"
                                                            class="btn btn-primary icon" type="button"
                                                            title="Add Cart"> Add To Cart
                                                        </button>
                                        </td>
                                        <td class="col-md-1 close-btn">
                                            <button type="submit" id="${value.id}" onclick="removeWishlist(this.id)" ><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>

                        `
                    })
                    $('#getWishlist').html(row)
                }
            })
        }

        getWishlist();

        // remove wishlist
        function removeWishlist(id) {
            $.ajax({
                type: 'GET',
                url: "/user/remove-wishlist/" + id,
                dataType: 'json',
                success: function(data) {
                    Swal.fire({
                        title: "Berhasil",
                        text: data.success,
                        showConfirmButton: false,
                        timer: 3000,
                        icon: "success"
                    }).then(() => {
                        getWishlist()
                    });

                }
            })
        }

        // get MyCart
        function cart() {
            $.ajax({
                type: "GET",
                url: '/get-mycart-product',
                dataType: 'json',
                success: function(response) {
                    let row = ""

                    $.each(response.carts, function(key, value) {
                        row += `
                              <tr>
                                        <td class="col-md-2"><img src="${value.options.image}" alt="imga" style="width:60px; height: 60px;"></td>
                                        <td class="col-md-2">
                                            <div class="product-name"><a href="#">${value.name}</a></div>
                                        </td>

                                        <td class="col-md-2">
                                             <strong>
                                              ${formatRupiah(value.price)}
                                            </strong>
                                        </td>

                                        <td class="col-md-1">
                                            ${value.options.color == null ? `<strong>.....</strong>` : `<strong>${value.options.color}</strong>` }
                                        </td>

                                        <td class="col-md-1">
                                            ${value.options.size == 0 ? `<strong>.....</strong>` : `<strong>${value.options.size}</strong>` }
                                        </td>

                                        <td class="col-md-2">
                                             <button class="btn btn-sm btn-success" id="${value.rowId}" onclick="cartIncrement(this.id)" >+</button>
                                            <input type="text" value="${value.qty}" min="1" max="100" disabled style="width:30px; text-align:center">
                                            ${value.qty > 1 ?
                                            ` <button class="btn btn-sm btn-danger" id="${value.rowId}" onclick="cartDecrement(this.id)" >-</button>` :

                                            `<button class="btn btn-sm btn-danger" disabled>-</button>`

                                        }

                                        </td>
                                        <td class="col-md-2">
                                            <strong>${formatRupiah(value.subtotal)}</strong>
                                        </td>

                                        <td class="col-md-2 close-btn">
                                            <button type="submit" id="${value.rowId}" onclick="removeMyCart(this.id)" ><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>

                        `
                    })
                    $('#getMyCart').html(row)
                    $('#grandTotal').text(formatRupiah(response.cartTotal))
                }
            })
        }

        cart()

        function removeMyCart(id) {
            $.ajax({
                type: 'GET',
                url: "/remove-mycart/" + id,
                dataType: 'json',
                success: function(data) {
                    Swal.fire({
                        title: "Berhasil",
                        text: data.success,
                        showConfirmButton: false,
                        timer: 3000,
                        icon: "success"
                    }).then(() => {
                        cart()
                        miniCart()
                    });

                }
            })
        }

        // cart increment
        function cartIncrement(rowId) {
            $.ajax({
                type: "GET",
                url: "/cart-increment/" + rowId,
                dataType: "json",
                success: function(response) {
                    cart()
                    miniCart()
                }
            })
        }

        // cart decrement
        function cartDecrement(rowId) {
            $.ajax({
                type: "GET",
                url: "/cart-decrement/" + rowId,
                dataType: "json",
                success: function(response) {
                    cart()
                    miniCart()
                }
            })
        }

        function formatRupiah(number) {
            return "Rp.  " + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
    </script>

    <script>
        // Function to update the time every second
        // Fungsi untuk memperbarui waktu setiap detik
        function updateTime() {
            const currentTimeElement = document.getElementById("current-time");
            const now = new Date();

            // Daftar nama hari dalam bahasa Indonesia
            const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const day = days[now.getDay()];
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');

            // Format waktu dalam format jam:menit:detik
            const timeString = `${day}, ${hours}:${minutes}:${seconds}`;

            // Menampilkan waktu pada elemen dengan id "current-time"
            currentTimeElement.textContent = timeString;
        }

        // Memperbarui waktu setiap detik
        setInterval(updateTime, 1000);

        // Panggil pertama kali untuk menampilkan waktu secara langsung
        updateTime();
    </script>

    @stack('script')
</body>

</html>
