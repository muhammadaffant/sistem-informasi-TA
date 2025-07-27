<div id="product-tabs-slider" class="scroll-tabs outer-top-vs wow fadeInUp">
    <div class="more-info-tab clearfix ">
        <h3 class="new-product-title pull-left">Produk</h3>
        <ul class="nav nav-tabs nav-tab-line pull-right" id="new-products-1">
            <li class="active"><a data-transition-type="backSlide" href="#all" data-toggle="tab">All</a></li>
            @if ($categories->isNotEmpty())
                @foreach ($categories as $c)
                    <li>
                        <a data-transition-type="backSlide" href="#category{{ $c->id }}" data-toggle="tab">
                            {{ $c->category_name }}
                        </a>
                    </li>
                @endforeach
            @else
                <div class="text-danger pb-2">Tidak ada item</div>
            @endif

        </ul>
        <!-- /.nav-tabs -->
    </div>
    <div class="tab-content outer-top-xs">
        <div class="tab-pane in active" id="all">
            <div class="product-slider">
                <div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="0">

                    @if ($products->isNotEmpty())
                        @foreach ($products as $product)
                            <div class="item item-carousel">
                                <div class="products">
                                    <div class="product">
                                        <div class="product-image">
                                            <div class="image"> <a
                                                    href="{{ url('/detail/' . $product->id . '/' . $product->product_slug) }}"><img
                                                        src="{{ Storage::url($product->product_thumbnail) }}"
                                                        alt=""></a> </div>
                                            <!-- /.image -->

                                            @if ($product->discount_price != 0)
                                                <div class="tag new">
                                                    <span>-{{ round($product->discount_price) }}%</span>
                                                </div>
                                            {{-- @else
                                                <div class="tag hot"><span>hot</span></div> --}}
                                            @endif


                                        </div>
                                        <!-- /.product-image -->

                                        <div class="product-info text-left">
                                            <h3 class="name"><a
                                                    href="{{ url('/detail/' . $product->id . '/' . $product->product_slug) }}">{{ $product->product_name }}</a>
                                            </h3>
                                            <div class="description"></div>

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
                        @endforeach
                    @else
                        <div class="text-danger pb-2">Tidak ada item</div>
                    @endif
                </div>
                <!-- /.home-owl-carousel -->
            </div>
            <!-- /.product-slider -->
        </div>
        <!-- /.tab-pane -->

        @foreach ($categories as $category)
            @php
                $productByCategory = App\Models\Product::where('category_id', $category->id)
                    ->orderBy('id', 'DESC')
                    ->get();
            @endphp


            <div class="tab-pane" id="category{{ $category->id }}">
                <div class="product-slider">
                    <div class="owl-carousel home-owl-carousel custom-carousel owl-theme">

                        @foreach ($productByCategory as $product)
                            <div class="item item-carousel">
                                <div class="products">
                                    <div class="product">
                                        <div class="product-image">
                                            <div class="image"> <a
                                                    href="{{ url('/detail/' . $product->id . '/' . $product->product_slug) }}"><img
                                                        src="{{ Storage::url($product->product_thumbnail) }}"
                                                        alt=""></a> </div>
                                            <!-- /.image -->

                                            @if ($product->discount_price != 0)
                                                <div class="tag new">
                                                    <span>{{ round($product->discount_price) }}
                                                        %</span>
                                                </div>
                                            @else
                                                <div class="tag hot"><span>hot</span></div>
                                            @endif


                                        </div>
                                        <!-- /.product-image -->

                                        <div class="product-info text-left">
                                            <h3 class="name"><a href="detail.html">{{ $product->product_name }}</a>
                                            </h3>
                                            {{--  <div class="rating rateit-small"></div>  --}}
                                            <div class="description"></div>

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
                        @endforeach


                    </div>
                    <!-- /.home-owl-carousel -->
                </div>
                <!-- /.product-slider -->
            </div>
            <!-- /.tab-pane -->
        @endforeach

    </div>
    <!-- /.tab-content -->
</div>
<!-- /.scroll-tabs -->
