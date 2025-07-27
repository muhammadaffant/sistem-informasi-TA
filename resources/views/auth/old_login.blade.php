@extends('layouts.guest')

@section('title', 'Halaman Login')

@section('content')
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
                <img src="{{ asset('/templates') }}/assets/img/stisla-fill.svg" alt="logo" width="100"
                    class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
                <div class="card-header">
                    <h4>Login</h4>
                </div>

                <div class="card-body">
                    <form id="loginForm" method="post" class="needs-validation" novalidate="">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control @error('auth') is-invalid @enderror" id="auth"
                                name="auth" value="{{ old('auth') }}" autocomplete="off" onfocus=this.value=''>

                            @error('auth')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="d-block">
                                <label for="password" class="control-label">Password</label>
                            </div>
                            <input type="password" class="form-control @error('password') is-invalid @enderror password"
                                id="password" name="password" onfocus=this.value='' autocomplete="off">

                            @error('password')
                                <span class="invalid-feedback">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="button" onclick="login()" id="loginButton"
                                class="btn btn-lg btn-primary btn-login mb-2">
                                <i class="fas fa-sign-in-alt"></i> <span id="buttonText">Masuk</span>
                                <span id="loadingSpinner" style="display:none;"><i
                                        class="fas fa-spinner fa-spin"></i></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-5 text-muted text-center">
                Belum punya akun? <a href="{{ route('register') }}">Buat Akun</a>
            </div>
            <div class="simple-footer">
                Copyright &copy; {{ date('Y') }}
            </div>
        </div>
    </div>

    <!-- Animasi Loading -->
    <div id="loading-animation"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(255, 255, 255, 0.7); z-index: 9999; align-items: center; justify-content: center;">
        <div>
            <img src="{{ asset('/templates/assets/img/loading.gif') }}" alt="Loading..." width="50">
            <p style="text-align: center; font-size: 14px;">Harap tunggu...</p>
        </div>
    </div>
@endsection

@push('css_vendor')
    <link rel="stylesheet" href="{{ asset('/templates/plugin/sweetalert2/bootstrap-4.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('/templates/plugin/sweetalert2/sweetalert2.min.js') }}"></script>
@endpush

@push('scripts')
    <script>
        // Menangani keypress event
        $(document).on('keypress', function(e) {
            if (e.which == 13) {
                login();
            }
        });

        // Fungsi untuk login
        // Fungsi untuk login
        function login() {
            let auth = $('#auth').val();
            let password = $('.password').val();

            if (!auth) {
                toastr.info('Email wajib diisi');
                return;
            }

            if (!password) {
                toastr.info('Password wajib diisi');
                return;
            }

            // Disable the button to prevent multiple clicks during the Ajax request
            const loginButton = $('#loginButton');
            const buttonText = $('#buttonText');
            const loadingSpinner = $('#loadingSpinner');

            loginButton.attr('disabled', true);
            buttonText.hide();
            loadingSpinner.show();

            $.ajax({
                type: 'POST',
                url: '{{ route('login') }}',
                data: $('#loginForm').serialize(),
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login berhasil',
                        text: 'Selamat anda berhasil login ke dalam sistem kami',
                        showConfirmButton: false,
                        timer: 3000
                    }).then(() => {
                        window.location.href = '{{ route('dashboard') }}';
                    });
                },
                error: function(errors) {
                    // Show error message
                    loopErrors(errors.responseJSON.errors);

                    Swal.fire({
                        icon: 'error', // Fixed typo from 'errors' to 'error'
                        title: 'Login gagal',
                        text: errors.responseJSON.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                },
                complete: function() {
                    // Re-enable the button and hide the loading indicator
                    loginButton.attr('disabled', false);
                    buttonText.show();
                    loadingSpinner.hide();
                }
            });
        }
    </script>
@endpush
