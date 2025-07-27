                  {{-- <div class="sidebar-widget outer-bottom-small wow fadeInUp">
                      <h3 class="section-title">Special Offer</h3>
                      <div class="sidebar-widget-body outer-top-xs">
                          <div
                              class="owl-carousel sidebar-carousel special-offer custom-carousel owl-theme outer-top-xs">

                              <div class="item">
                                  <div class="products special-product">
                                      @forelse ($specialOffer as $product)
                                          <div class="product">
                                              <div class="product-micro">
                                                  <div class="row product-micro-row">
                                                      <div class="col col-xs-5">
                                                          <div class="product-image">
                                                              <div class="image"> <a
                                                                      href="{{ url('/detail/' . $product->id . '/' . $product->product_slug) }}">
                                                                      <img src="{{ Storage::url($product->product_thumbnail) }}"
                                                                          alt=""> </a> </div>
                                                              <!-- /.image -->

                                                          </div>
                                                          <!-- /.product-image -->
                                                      </div>
                                                      <!-- /.col -->
                                                      <div class="col col-xs-7">
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
                                                          </div>
                                                      </div>
                                                      <!-- /.col -->
                                                  </div>
                                                  <!-- /.product-micro-row -->
                                              </div>
                                              <!-- /.product-micro -->

                                          </div>
                                      @empty
                                          <div class="text-danger">Tidak ada item</div>
                                      @endforelse
                                  </div>
                              </div>

                          </div>
                      </div>
                      <!-- /.sidebar-widget-body -->
                  </div>

                  <!-- /.sidebar-widget --> --}}
