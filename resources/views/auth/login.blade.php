@extends('frontend.main_master')

@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('/') }}">Home</a></li>
                    <li class='active'>Login</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div>

    <div class="body-content">
        <div class="container">
            <div class="sign-in-page">
                <div class="row">
                    <!-- Sign-in -->
                    <div class="col-md-6 col-sm-6 sign-in">
                        <h4 class="">Sign in</h4>
                        <p class="">Hello, Welcome to your account.</p>
                        <form method="POST" action="{{ route('login.user') }}" role="form">
                            @csrf
                            <div class="form-group">
                                <label class="info-title" for="email">Email <span>*</span></label>
                                <input type="text" name="email" class="form-control unicase-form-control text-input" required
                                    id="email">
                                @error('email', 'login')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="info-title" for="password">Password <span>*</span></label>
                                <input type="password" name="password" class="form-control unicase-form-control text-input" required
                                    id="password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="radio outer-xs">
                                {{-- <label>
                                    <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">Remember
                                    me!
                                </label> --}}
                                <a href="{{ route('password.request') }}" class="forgot-password pull-right">Forgot your
                                    Password?</a>
                            </div>
                            <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Login</button>
                            <div class="text-center" style="margin-top: 20px;">
                                <p>Atau login dengan</p>
                                <a href="{{ route('auth.google.redirect') }}" class="btn btn-danger">
                                    <i class="fa fa-google"></i> Login dengan Google
                                </a>
                            </div>
                        </form>
                    </div>
                    <!-- Sign-in -->

                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="col-md-6 col-sm-6 create-new-account">
                            <h4 class="checkout-subtitle">Create a new account</h4>
                            <p class="text title-tag-line">Create your new account.</p>
                            <form class="register-form outer-top-xs" role="form">
                                <div class="form-group">
                                    <label class="info-title" for="name">Nama Lengkap <span>*</span></label>
                                    <input type="string" name="name"
                                        class="form-control unicase-form-control text-input" id="name"
                                        autocomplete="off">

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="info-title" for="username">Username <span>*</span></label>
                                    <input type="text" name="username"
                                        class="form-control unicase-form-control text-input" id="username"
                                        autocomplete="off">
                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="info-title" for="email">Email Aktif <span>*</span></label>
                                    <input type="email" name="email"
                                        class="form-control unicase-form-control text-input" id="email"
                                        autocomplete="off">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="info-title" for="numberphone">Nomor Handphone <span>*</span></label>
                                    <input type="number" name="numberphone"
                                        class="form-control unicase-form-control text-input" id="numberphone"
                                        autocomplete="off">
                                    @error('numberphone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="info-title" for="password">Password <span>*</span></label>
                                    <input type="password" name="password"
                                        class="form-control unicase-form-control text-input" id="password"
                                        autocomplete="off">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label class="info-title" for="password_confirmation">Confirm Password
                                        <span>*</span></label>
                                    <input type="password" name="password_confirmation"
                                        class="form-control unicase-form-control text-input" id="password_confirmation"
                                        autocomplete="off">
                                </div>
                                <button type="submit" class="btn-upper btn btn-primary checkout-page-button">Sign
                                    Up</button>
                            </form>
                        </div>
                    </form>
                </div>
            </div>
            <!-- ============================================== BRANDS CAROUSEL ============================================== -->
            @include('frontend.body.brands')

            <!-- ============================================== BRANDS CAROUSEL : END ============================================== -->
        </div>
    </div>
@endsection
