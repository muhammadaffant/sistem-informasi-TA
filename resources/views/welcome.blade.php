@extends('layouts.front')

@section('content')
    <!-- Page Content -->
    <!-- Banner Starts Here -->
    <div class="banner header-text">
        <div class="owl-banner owl-carousel">
            <div class="banner-item-01">
                <div class="text-content">

                    <h2>Selamat Datang</h2>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner Ends Here -->
    {{-- service --}}
    <div class="service-section py-5">
        <div class="container">
            <div class="section-heading">
                <h2>Layanan Kami</h2>
            </div>
            <div class="row">
                <!-- Web Development Card -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img class="card-img-top" src="{{ asset('/frontend') }}/assets/images/web-development.jpg"
                            alt="Web Development">
                        <div class="card-body">
                            <h5 class="card-title">Web Development</h5>
                            <p class="card-text">We provide high-quality web development services to create responsive,
                                user-friendly, and scalable websites tailored to your needs.</p>
                        </div>
                    </div>
                </div>

                <!-- UI/UX Card -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img class="card-img-top" src="{{ asset('/frontend') }}/assets/images/ui-ux.jpg" alt="UI/UX">
                        <div class="card-body">
                            <h5 class="card-title">UI/UX Design</h5>
                            <p class="card-text">Our UI/UX design services ensure an intuitive and engaging experience for
                                your users, focusing on aesthetics and usability.</p>
                        </div>
                    </div>
                </div>

                <!-- Data Analyst Card -->
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img class="card-img-top" src="{{ asset('/frontend') }}/assets/images/data-analyst.jpg"
                            alt="Data Analyst">
                        <div class="card-body">
                            <h5 class="card-title">Data Analysis</h5>
                            <p class="card-text">Our data analysts help you make data-driven decisions by providing insights
                                from your data, ensuring business growth and efficiency.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="latest-products">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Produk Terbaru</h2>
                        <a href="#">Lihat semua produk <i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-item">
                        <a href="#"><img src="{{ asset('/frontend') }}/assets/images/product_01.jpg"
                                alt=""></a>
                        <div class="down-content">
                            <a href="#">
                                <h4>Tittle goes here</h4>
                            </a>
                            <h6>$25.75</h6>
                            <p>Lorem ipsume dolor sit amet, adipisicing elite. Itaque, corporis nulla aspernatur.</p>
                            <ul class="stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <span>Reviews (24)</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-item">
                        <a href="#"><img src="{{ asset('/frontend') }}/assets/images/product_02.jpg"
                                alt=""></a>
                        <div class="down-content">
                            <a href="#">
                                <h4>Tittle goes here</h4>
                            </a>
                            <h6>$30.25</h6>
                            <p>Lorem ipsume dolor sit amet, adipisicing elite. Itaque, corporis nulla aspernatur.</p>
                            <ul class="stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <span>Reviews (21)</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-item">
                        <a href="#"><img src="{{ asset('/frontend') }}/assets/images/product_03.jpg"
                                alt=""></a>
                        <div class="down-content">
                            <a href="#">
                                <h4>Tittle goes here</h4>
                            </a>
                            <h6>$20.45</h6>
                            <p>Sixteen Clothing is free CSS template provided by TemplateMo.</p>
                            <ul class="stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <span>Reviews (36)</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-item">
                        <a href="#"><img src="{{ asset('/frontend') }}/assets/images/product_04.jpg"
                                alt=""></a>
                        <div class="down-content">
                            <a href="#">
                                <h4>Tittle goes here</h4>
                            </a>
                            <h6>$15.25</h6>
                            <p>Lorem ipsume dolor sit amet, adipisicing elite. Itaque, corporis nulla aspernatur.</p>
                            <ul class="stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <span>Reviews (48)</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-item">
                        <a href="#"><img src="{{ asset('/frontend') }}/assets/images/product_05.jpg"
                                alt=""></a>
                        <div class="down-content">
                            <a href="#">
                                <h4>Tittle goes here</h4>
                            </a>
                            <h6>$12.50</h6>
                            <p>Lorem ipsume dolor sit amet, adipisicing elite. Itaque, corporis nulla aspernatur.</p>
                            <ul class="stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <span>Reviews (16)</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-item">
                        <a href="#"><img src="{{ asset('/frontend') }}/assets/images/product_06.jpg"
                                alt=""></a>
                        <div class="down-content">
                            <a href="#">
                                <h4>Tittle goes here</h4>
                            </a>
                            <h6>$22.50</h6>
                            <p>Lorem ipsume dolor sit amet, adipisicing elite. Itaque, corporis nulla aspernatur.</p>
                            <ul class="stars">
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                            </ul>
                            <span>Reviews (32)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="find-us">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Lokasi</h2>
                    </div>
                </div>
                <div class="col-md-8">
                    <div id="map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.5539808599647!2d109.13266897587636!3d-6.94378466797785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fb929455ff0cf%3A0x2372db0a61f74d97!2sJl.%20Katesraya%20No.11%2C%20Kenjari%2C%20Tembok%20Banjaran%2C%20Kec.%20Adiwerna%2C%20Kabupaten%20Tegal%2C%20Jawa%20Tengah%2052194!5e0!3m2!1sid!2sid!4v1731558333433!5m2!1sid!2sid"
                            width="100%" height="330px" frameborder="0" style="border:0" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="left-content">
                        <h4>About our office</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisic elit. Sed voluptate nihil eumester consectetur
                            similiqu consectetur.<br><br>Lorem ipsum dolor sit amet, consectetur adipisic elit. Et,
                            consequuntur, modi mollitia corporis ipsa voluptate corrupti.</p>
                        <ul class="social-icons">
                            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                            <li><a href="#"><i class="fa fa-behance"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
