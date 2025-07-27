                   {{--  SECTTION CATEGORY  --}}


                   {{-- <section class="section featured-product wow fadeInUp">
                       @if ($skip_category_0 != null)
                           <h3 class="section-title">Category {{ $skip_category_0->category_name }}</h3>
                       @else
                           <h3 class="section-title">Category</h3>
                       @endif
                       <div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">

                           @if ($skip_product_0->isNotEmpty())
                               @foreach ($skip_product_0 as $product)
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
                                                               Rp. {{ format_uang($product->price_after_discount) }}
                                                           </span>
                                                           <span class="price-before-discount">Rp.
                                                               {{ $product->selling_price }}</span>
                                                       </div>
                                                   @endif

                                               </div>
                                               <!-- /.product-info -->
                                               <div class="cart clearfix animate-effect">
                                                   <div class="action">
                                                       <ul class="list-unstyled">
                                                           <li class="add-cart-button btn-group">
                                                               <button data-toggle="modal" id="{{ $product->id }}"
                                                                   onclick="productView(this.id)"
                                                                   data-target="#staticBackdrop"
                                                                   class="btn btn-primary icon" type="button"
                                                                   title="Add Cart"> <i class="fa fa-shopping-cart"></i>
                                                               </button>

                                                               <button class="btn btn-primary cart-btn"
                                                                   type="button">Add to
                                                                   cart</button>
                                                           </li>

                                                           <li class="add-cart-button btn-group"> <button type="submit"
                                                                   onclick="addToWislist(this.id)"
                                                                   id="{{ $product->id }}" data-toggle="tooltip"
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
                               @endforeach
                           @else
                               <div class="text-danger pb-5 mb-3">Tidak ada item</div>
                           @endif
                       </div>
                   </section>


                   <section class="section featured-product wow fadeInUp">
                       @if ($skip_category_1 != null)
                           <h3 class="section-title">Category {{ $skip_category_1->category_name }}</h3>
                           <div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">

                               @if ($skip_product_1->isNotEmpty())
                                   @foreach ($skip_product_1 as $product)
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
                                                                   {{ $product->selling_price }}</span>
                                                           </div>
                                                       @endif

                                                   </div>
                                                   <!-- /.product-info -->
                                                   <div class="cart clearfix animate-effect">
                                                       <div class="action">
                                                           <ul class="list-unstyled">
                                                               <li class="add-cart-button btn-group">
                                                                   <button data-toggle="modal" id="{{ $product->id }}"
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
                                                                       id="{{ $product->id }}" data-toggle="tooltip"
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
                                   @endforeach
                               @else
                                   <div class="text-danger mb-3">Tidak ada item</div>
                               @endif

                           </div>
                           <!-- /.home-owl-carousel -->
                       @else
                       @endif

                   </section> --}}

                   {{--  BRAND   --}}
                   {{-- <section class="section featured-product wow fadeInUp">
                       @if ($skip_brand_5 != null)
                           <h3 class="section-title">Brand {{ $skip_brand_5->brand_name }}</h3>
                           <div class="owl-carousel home-owl-carousel custom-carousel owl-theme outer-top-xs">

                               @if ($skip_product_5->isNotEmpty())
                                   @foreach ($skip_product_5 as $product)
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
                                                                   {{ $product->selling_price }}</span>
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
                                                                       id="{{ $product->id }}" data-toggle="tooltip"
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
                                   @endforeach
                               @else
                                   <div class="text-danger mb-3">Tidak ada item</div>
                               @endif

                           </div>
                           <!-- /.home-owl-carousel -->
                       @else
                       @endif
                   </section> --}}
