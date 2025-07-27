@extends('frontend.main_master')

@section('title', 'My Cart')

@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class='active'>@yield('title')</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    <div class="body-content">
        <div class="container">
            <div class="row">
                <div class="shopping-cart">
                    <div class="shopping-cart-table">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="cart-product-name item">Image</th>
                                        <th class="cart-product-name item">Product Name</th>
                                        <th class="cart-product-name item">Product Code</th>
                                        <th class="cart-product-name item">Product Price</th>
                                        <th class="cart-product-name item">Color</th>
                                        <th class="cart-product-name item">Size</th>
                                        <th class="cart-product-name item">Qty</th>
                                        <th class="cart-product-name item">Subtotal</th>
                                        <th class="cart-product-name item">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="getMyCart">
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="col-md-4 col-sm-12 cart-shopping-total">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>

                                        <div class="cart-grand-total">
                                            Grand Total<span class="inner-left-md" id="grandTotal">0</span>
                                        </div>
                                    </th>
                                </tr>
                            </thead><!-- /thead -->
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="cart-checkout-btn pull-right">
                                            <a href="{{ route('user.checkout') }}"
                                                class="btn btn-primary checkout-btn">PROCCES TO
                                                CHEKOUT</a>
                                        </div>
                                    </td>
                                </tr>
                            </tbody><!-- /tbody -->
                        </table><!-- /table -->
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div style="margin-top: 300px">

    </div>

    {{--  @include('frontend.body.brands')  --}}
@endsection
