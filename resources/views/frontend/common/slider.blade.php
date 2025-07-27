{{-- <div id="hero">
    <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
        @if ($sliders->isNotEmpty())
            @foreach ($sliders as $slider)
                <div class="item" style="background-image: url({{ Storage::url($slider->slider_img) }})">
                    <div class="container-fluid">
                        <div class="caption bg-color vertical-center text-left">
                            <div class="big-text fadeInDown-1"> {{ $slider->title }}</div>
                            <div class="excerpt fadeInDown-2 hidden-xs"> <span>
                                </span> </div>
                                <div class="button-holder fadeInDown-3"> <a href="#"
                                    class="btn-lg btn btn-uppercase btn-primary shop-now-button">Shop
                                    Now</a> </div>
                        </div>
                        <!-- /.caption -->
                    </div>
                    <!-- /.container-fluid -->
                </div>
            @endforeach
        @else
            <div class="text-danger pb-2">Tidak ada item</div>
        @endif
    </div>
    <!-- /.owl-carousel -->
</div> --}}

{{-- <div id="hero">
    <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
        @if ($sliders->isNotEmpty())
            @foreach ($sliders as $slider)
                <div class="item" style="background-image: url({{ Storage::url($slider->slider_img) }})">
    <div class="container">
        <div class="row">
            <div class="text col-md-8 d-flex flex-column justify-content-center">
                <h1 class="display-4" style="margin-top: 100px">Selamat Datang DI Viary Konveksi</h1>
                <p class="lead mt-3">{{ $slider->description }}</p>
                <a href="{{ route('user.customorder') }}" class="btn btn-primary btn-lg mt-3">Buat Sekarang</a>
            </div>
        </div>
    </div>
                    <!-- /.container-fluid -->
                </div>
            @endforeach
        @else
            <div class="text-danger pb-2">Tidak ada item</div>
        @endif
    </div>
    <!-- /.owl-carousel -->
</div>

<style>
    .text {
        color: #157ed2;
        font-weight: 900;
    }
</style> --}}

<div id="hero">
    <div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
        @if ($sliders->isNotEmpty())
            @foreach ($sliders as $slider)
<div class="item" style="background-image: url({{ Storage::url($slider->slider_img) }}); background-size: cover; background-position: center;">
    <div class="container">
        <div class="row justify-content-center justify-content-md-start">
            <div class="text col-12 col-md-8 text-center text-md-left d-flex flex-column justify-content-center py-5"><br><br>
                <h1 class="display-6 display-md-4 fw-bold mb-3" style="margin-top: 50px">{{ $slider->title }}</h1>
                <p class="lead mb-3">{{ $slider->description }}</p>
                <a href="{{ route('user.customorder') }}" class="btn btn-primary btn-lg">Pesan Sekarang</a>
            </div>
        </div>
    </div>
</div>

            @endforeach
        @else
            <div class="text-danger pb-2">Tidak ada item</div>
        @endif
    </div>
    <!-- /.owl-carousel -->
</div>

<style>
.text {
    color: #157ed2;
    font-weight: 900;
}

/* Tambahan media query agar lebih responsif */
@media (max-width: 576px) {
    .text h1 {
        font-size: 1.5rem;
    }

    .text p.lead {
        font-size: 1rem;
    }

    .btn-lg {
        font-size: 1rem;
        padding: 0.5rem 1rem;
    }

    #hero .item {
        min-height: 300px; /* Lebih pendek di mobile */
        padding-top: 2rem;
        padding-bottom: 2rem;
    }
}

</style>

