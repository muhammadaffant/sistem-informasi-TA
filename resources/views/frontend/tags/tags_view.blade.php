@extends('frontend.main_master')

@section('content')
    <div class="body-content outer-top-xs">

        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <!-- ================================== TOP NAVIGATION ================================== -->
                    @include('frontend.common.vertical_menu')
                    <!-- ================================== TOP NAVIGATION : END ================================== -->
                    <div class="sidebar-module-container">
                        <div class="sidebar-filter">
                            <!-- ============================================== SIDEBAR CATEGORY ============================================== -->
                            <div class="sidebar-widget wow fadeInUp animated"
                                style="visibility: visible; animation-name: fadeInUp;">
                                <h3 class="section-title">shop by</h3>
                                <div class="widget-header">
                                    <h4 class="widget-title">Category</h4>
                                </div>
                                <div class="sidebar-widget-body">
                                    <div class="accordion">

                                        @foreach ($categories as $category)
                                            <div class="accordion-group">
                                                <div class="accordion-heading">
                                                    <a href="#collapse{{ $category->id }}" data-toggle="collapse"
                                                        class="accordion-toggle collapsed">
                                                        {{ $category->category_name }}
                                                    </a>
                                                </div>
                                                <!-- /.accordion-heading -->
                                                <div class="accordion-body collapse" id="collapse{{ $category->id }}"
                                                    style="height: 0px;">
                                                    <div class="accordion-inner">
                                                        <ul>

                                                            @php
                                                                $subcategories = App\Models\SubCategory::where(
                                                                    'category_id',
                                                                    $category->id,
                                                                )
                                                                    ->orderBy('subcategory_name', 'ASC')
                                                                    ->get();
                                                            @endphp

                                                            @if ($subcategories->isNotEmpty())
                                                                @foreach ($subcategories as $subcategory)
                                                                    <li><a
                                                                            href="{{ url('/category/product/' . $subcategory->id . '/' . $subcategory->subcategory_slug) }}">{{ $subcategory->subcategory_name }}</a>
                                                                    </li>
                                                                @endforeach
                                                            @endif


                                                        </ul>
                                                    </div>
                                                    <!-- /.accordion-inner -->
                                                </div>
                                                <!-- /.accordion-body -->
                                            </div>
                                            <!-- /.accordion-group -->
                                        @endforeach


                                    </div>
                                    <!-- /.accordion -->
                                </div>
                                <!-- /.sidebar-widget-body -->
                            </div>
                            <!-- /.sidebar-widget -->
                            <!-- ============================================== SIDEBAR CATEGORY : END ============================================== -->



                            <!-- ============================================== PRICE SILDER============================================== -->
                            <!-- /.sidebar-widget-body -->
                        </div>
                        <!-- /.sidebar-widget -->
                        <!-- ============================================== PRICE SILDER : END ============================================== -->

                        <!-- ============================================== MANUFACTURES============================================== -->

                        <!-- ============================================== MANUFACTURES: END ============================================== -->


                        <!-- ============================================== COMPARE============================================== -->

                        <!-- ============================================== COMPARE: END ============================================== -->

                        <!-- ============================================== PRODUCT TAGS ============================================== -->
                        @include('frontend.common.product_tags')
                        <!-- ============================================== PRODUCT TAGS : END ============================================== -->

                        <!-- ============================================== Testimonials ============================================== -->

                        <!-- ============================================== Testimonials: END ============================================== -->

                    </div>
                    <!-- /.sidebar-filter -->
                </div>
                <!-- /.sidebar-module-container -->

                <div class="col-md-9">
                    <!-- ========================================== SECTION – HERO ========================================= -->

                    {{--  <div id="category" class="category-carousel hidden-xs">
                        <div class="item">
                            <div class="image">
                                <img src="{{ asset('frontend/assets/images/banners/cat-banner-1.jpg') }}" alt=""
                                    class="img-responsive">
                            </div>
                            <div class="container-fluid">
                                <div class="caption vertical-top text-left">
                                    <div class="big-text"> Big Sale </div>
                                    <div class="excerpt hidden-sm hidden-md"> Save up to 49% off </div>
                                    <div class="excerpt-normal hidden-sm hidden-md"> Lorem ipsum dolor sit amet,
                                        consectetur adipiscing elit </div>
                                </div>
                            </div>
                        </div>
                    </div>  --}}


                    <div class="clearfix filters-container m-t-10">
                        <div class="row">
                            <div class="col col-sm-6 col-md-2">
                                <div class="filter-tabs">
                                    <ul id="filter-tabs" class="nav nav-tabs nav-tab-box nav-tab-fa-icon">
                                        <li class="active"> <a data-toggle="tab" href="#grid-container"><i
                                                    class="icon fa fa-th-large"></i>Grid</a> </li>
                                        <li class=""><a data-toggle="tab" href="#list-container"><i
                                                    class="icon fa fa-th-list"></i>List</a></li>
                                    </ul>
                                </div>
                                <!-- /.filter-tabs -->
                            </div>
                            <!-- /.col -->
                            <div class="col col-sm-12 col-md-6">
                                <div class="col col-sm-3 col-md-6 no-padding">
                                    <div class="lbl-cnt"> <span class="lbl">Sort by</span>
                                        <div class="fld inline">
                                            <div class="dropdown dropdown-small dropdown-med dropdown-white inline">
                                                <button data-toggle="dropdown" type="button" class="btn dropdown-toggle">
                                                    Position <span class="caret"></span>
                                                </button>
                                                <ul role="menu" class="dropdown-menu">
                                                    <li role="presentation"><a href="#">position</a></li>
                                                    <li role="presentation"><a href="#">Price:Lowest first</a></li>
                                                    <li role="presentation"><a href="#">Price:HIghest first</a></li>
                                                    <li role="presentation"><a href="#">Product Name:A to Z</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- /.fld -->
                                    </div>
                                    <!-- /.lbl-cnt -->
                                </div>
                                <!-- /.col -->
                                <div class="col col-sm-3 col-md-6 no-padding">
                                    <div class="lbl-cnt"> <span class="lbl">Show</span>
                                        <div class="fld inline">
                                            <div class="dropdown dropdown-small dropdown-med dropdown-white inline">
                                                <button data-toggle="dropdown" type="button" class="btn dropdown-toggle"> 1
                                                    <span class="caret"></span> </button>
                                                <ul role="menu" class="dropdown-menu">
                                                    <li role="presentation"><a href="#">1</a></li>
                                                    <li role="presentation"><a href="#">2</a></li>
                                                    <li role="presentation"><a href="#">3</a></li>
                                                    <li role="presentation"><a href="#">4</a></li>
                                                    <li role="presentation"><a href="#">5</a></li>
                                                    <li role="presentation"><a href="#">6</a></li>
                                                    <li role="presentation"><a href="#">7</a></li>
                                                    <li role="presentation"><a href="#">8</a></li>
                                                    <li role="presentation"><a href="#">9</a></li>
                                                    <li role="presentation"><a href="#">10</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- /.fld -->
                                    </div>
                                    <!-- /.lbl-cnt -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.col -->
                            <div class="col col-sm-6 col-md-4 text-right">
                                <div class="pagination-container">
                                    <ul class="list-inline list-unstyled">
                                        <li class="prev"><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                        <li><a href="#">1</a></li>
                                        <li class="active"><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li class="next"><a href="#"><i class="fa fa-angle-right"></i></a></li>
                                    </ul>
                                    <!-- /.list-inline -->
                                </div>
                                <!-- /.pagination-container -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>


                    <div class="search-result-container ">


                        <div id="myTabContent" class="tab-content category-list">
                            <div class="tab-pane active" id="grid-container">
                                <div class="category-product">
                                    <div class="row">

                                        @foreach ($products as $product)
                                            <div class="col-sm-6 col-md-4 wow fadeInUp animated"
                                                style="visibility: visible; animation-name: fadeInUp;">
                                                <div class="products">
                                                    <div class="product">
                                                        <div class="product-image">
                                                            <div class="image"> <a
                                                                    href="{{ url('/detail/' . $product->id . '/' . $product->product_slug) }}"><img
                                                                        src="{{ Storage::url($product->product_thumbnail) }}"
                                                                        alt=""></a>
                                                            </div>
                                                            <!-- /.image -->

                                                            @if ($product->discount_price != 0)
                                                                <div class="tag new">
                                                                    <span
                                                                        class="text-white text-bold">{{ $product->discount_price }}%</span>
                                                                </div>
                                                            @else
                                                                <div class="tag new"><span>New</span></div>
                                                            @endif
                                                        </div>
                                                        <!-- /.product-image -->

                                                        <div class="product-info text-left">
                                                            <h3 class="name"><a
                                                                    href="{{ url('/detail/' . $product->id . '/' . $product->product_slug) }}">
                                                                    {{ $product->product_name }}
                                                                </a>
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


                                                        </div>
                                                        <!-- /.product-info -->
                                                        <div class="cart clearfix animate-effect">
                                                            <div class="action">
                                                                <ul class="list-unstyled">
                                                                    <li class="add-cart-button btn-group">
                                                                        <button data-toggle="modal"
                                                                            id="{{ $product->id }}"
                                                                            onclick="productView(this.id)"
                                                                            data-target="#staticBackdrop"
                                                                            class="btn btn-primary icon" type="button"
                                                                            title="Add Cart"> <i
                                                                                class="fa fa-shopping-cart"></i>
                                                                        </button>

                                                                        <button class="btn btn-primary cart-btn"
                                                                            type="button">Add to
                                                                            cart</button>
                                                                    </li>

                                                                    <li class="add-cart-button btn-group"> <button
                                                                            type="submit" onclick="addToWislist(this.id)"
                                                                            id="{{ $product->id }}"
                                                                            data-toggle="tooltip"
                                                                            class="btn btn-primary icon" title="Wishlist">
                                                                            <i class="icon fa fa-heart"></i>
                                                                        </button>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <!-- /.action -->
                                                        </div>
                                                        <!-- /.cart -->
                                                    </div>
                                                    <!-- /.product -->

                                                </div>
                                                <!-- /.products -->
                                            </div>
                                            <!-- /.item -->
                                        @endforeach

                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.category-product -->

                            </div>
                            <!-- /.tab-pane -->


                            {{--  LIST PRODUCT  --}}

                            <div class="tab-pane" id="list-container">
                                @foreach ($products as $product)
                                    <div class="category-product">
                                        <div class="category-product-inner wow fadeInUp animated"
                                            style="visibility: visible; animation-name: fadeInUp;">
                                            <div class="products">
                                                <div class="product-list product">

                                                    <div class="row product-list-row">
                                                        <div class="col col-sm-4 col-lg-4">
                                                            <div class="product-image">
                                                                <div class="image"> <img
                                                                        src="{{ Storage::url($product->product_thumbnail) }}"
                                                                        alt="">
                                                                </div>
                                                            </div>
                                                            <!-- /.product-image -->
                                                        </div>
                                                        <!-- /.col -->

                                                        <div class="col col-sm-8 col-lg-8">
                                                            <div class="product-info">
                                                                <h3 class="name"><a
                                                                        href="{{ url('/detail/' . $product->id . '/' . $product->product_slug) }}">{{ $product->product_name }}</a>
                                                                </h3>
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


                                                                <!-- /.product-price -->
                                                                <div class="description m-t-10">
                                                                    {{ $product->short_descp }}
                                                                </div>
                                                                <div class="cart clearfix animate-effect">
                                                                    <div class="action">
                                                                        <ul class="list-unstyled">
                                                                            <li class="add-cart-button btn-group">
                                                                                <button data-toggle="modal"
                                                                                    id="{{ $product->id }}"
                                                                                    onclick="productView(this.id)"
                                                                                    data-target="#staticBackdrop"
                                                                                    class="btn btn-primary icon"
                                                                                    type="button" title="Add Cart"> <i
                                                                                        class="fa fa-shopping-cart"></i>
                                                                                </button>

                                                                                <button class="btn btn-primary cart-btn"
                                                                                    type="button">Add to
                                                                                    cart</button>
                                                                            </li>

                                                                            <li class="add-cart-button btn-group"> <button
                                                                                    type="submit"
                                                                                    onclick="addToWislist(this.id)"
                                                                                    id="{{ $product->id }}"
                                                                                    data-toggle="tooltip"
                                                                                    class="btn btn-primary icon"
                                                                                    title="Wishlist">
                                                                                    <i class="icon fa fa-heart"></i>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <!-- /.action -->
                                                                </div>
                                                                <!-- /.cart -->

                                                            </div>
                                                            <!-- /.product-info -->
                                                        </div>
                                                        <!-- /.col -->
                                                    </div>
                                                    <!-- /.product-list-row -->
                                                    <div class="tag new"><span>new</span></div>
                                                </div>
                                                <!-- /.product-list -->
                                            </div>
                                            <!-- /.products -->
                                        </div>
                                        <!-- /.category-product-inner -->
                                    </div>
                                @endforeach
                                <!-- /.category-product -->
                            </div>
                            <!-- /.tab-pane #list-container -->

                            {{--  LIST PRODUCT : END  --}}
                        </div>


                        <!-- /.tab-content -->
                        <div class="clearfix filters-container">
                            <div class="text-right">
                                <div class="pagination-container">
                                    <ul class="list-inline list-unstyled">
                                        <li class="prev"><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                        <li><a href="#">1</a></li>
                                        <li class="active"><a href="#">2</a></li>
                                        <li><a href="#">3</a></li>
                                        <li><a href="#">4</a></li>
                                        <li class="next"><a href="#"><i class="fa fa-angle-right"></i></a>
                                        </li>
                                    </ul>
                                    <!-- /.list-inline -->
                                </div>
                                <!-- /.pagination-container -->
                            </div>
                            <!-- /.text-right -->

                        </div>
                        <!-- /.filters-container -->

                    </div>
                    <!-- /.search-result-container -->

                </div>

            </div>
            <!-- ============================================== BRANDS CAROUSEL ============================================== -->
            @include('frontend.body.brands')
            <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
        </div>
    @endsection
