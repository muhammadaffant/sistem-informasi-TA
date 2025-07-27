    {{-- <div class="sidebar-widget hot-deals wow fadeInUp outer-bottom-xs">
        <h3 class="section-title">hot deals</h3>
        <div class="owl-carousel sidebar-carousel custom-carousel owl-theme outer-top-ss">

            @if ($hotDeals->isNotEmpty())
                @foreach ($hotDeals as $product)
                    <div class="item">
                        <div class="products">
                            <div class="hot-deal-wrapper">
                                <div class="image">
                                    <img src="{{ Storage::url($product->product_thumbnail) }}" alt="">
                                </div>
                                @if ($product->discount_price != 0)
                                    <div class="sale-offer-tag"><span>{{ $product->discount_price }} %<br>
                                            off</span></div>
                                @else
                                    <div class="sale-offer-tag"><span>hot</span></div>
                                @endif

                            </div>
                            <!-- /.hot-deal-wrapper -->

                            <div class="product-info text-left m-t-20">
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


                            </div>
                            <!-- /.product-info -->

                            <div class="cart clearfix animate-effect">
                                <div class="action">
                                    <div class="add-cart-button btn-group">
                                        <button data-toggle="modal" id="{{ $product->id }}"
                                            onclick="productView(this.id)" data-target="#staticBackdrop"
                                            class="btn btn-primary icon" type="button" title="Add Cart"> <i
                                                class="fa fa-shopping-cart"></i>
                                        </button>

                                        <button data-toggle="modal" id="{{ $product->id }}"
                                            onclick="productView(this.id)" data-target="#staticBackdrop"
                                            class="btn btn-primary cart-btn" type="button">Add to
                                            cart</button>
                                    </div>
                                </div>
                                <!-- /.action -->
                            </div>
                            <!-- /.cart -->
                        </div>
                    </div>
                @endforeach
            @else
            @endif
        </div>
        <!-- /.sidebar-widget -->
    </div> --}}
