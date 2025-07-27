<div id="brands-carousel" class="logo-slider wow fadeInUp">
    <div class="logo-slider-inner">
        <div id="brand-slider" class="owl-carousel brand-slider custom-carousel owl-theme">
            @php
                $layanan = \App\Models\Layanan::all();
            @endphp

            @foreach ($layanan as $layanan)
                <div class="item m-t-15">
                </div>
                <!--/.item-->
            @endforeach
            <!--/.item-->
        </div>
        <!-- /.owl-carousel #logo-slider -->
    </div>
    <!-- /.logo-slider-inner -->

</div>
