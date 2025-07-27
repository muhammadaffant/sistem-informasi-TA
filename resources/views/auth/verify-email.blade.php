@extends('frontend.main_master')

@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class='active'>Verifikasi Email</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div>

    <div class="body-content">
        <div class="container">
            <div class="sign-in-page">
                <div class="row">
                    <div class="col-md-12 col-sm-12 sign-in">
                        <h4 class="">Verifikasi Email</h4>
                        <p class="">
                            @if (session('status') == 'verification-link-sent')
                                <div class="alert alert-success">
                                    {{ __('Link verifikasi baru telah dikirim ke alamat email Anda:') }}
                                    <strong>{{ Auth::user()->email }}</strong>
                                </div>
                            @else
                                {{ __('Sebelum melanjutkan, silakan periksa email Anda untuk link verifikasi di:') }}
                                <strong>{{ Auth::user()->email }}</strong>
                            @endif
                        </p>
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Kirim Ulang Link
                                Verifikasi</button>
                        </form>
                        <p class="mt-3">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </p>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="margin-top: 310px">

    </div>
@endsection
