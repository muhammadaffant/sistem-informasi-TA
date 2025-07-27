@extends('frontend.main_master')
@section('title', 'Layanan')
@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Layanan</h2>
    <div class="row">
        @if ($layanans->isNotEmpty())
            @foreach ($layanans as $layanan)
                <div class="col-md-4 mb-4 scroll-tabs outer-top-vs wow fadeInUp">
                    <div class="card p-4 shadow-lg">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-cogs"></i> {{ $layanan->nama_layanan }}</h5>
                            <p class="card-text">{{ $layanan->deskripsi }}</p>
                            <a href="{{ route('user.customorder') }}" class="btn btn-primary w-100 mt-3">Pesan Sekarang</a>
                            {{-- <a href="#" class="btn btn-primary w-100">Lihat Detail</a> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-12 text-center text-danger">Tidak ada layanan tersedia</div>
        @endif
    </div>
</div>
<div style="margin-top: 300px">

</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@endsection
