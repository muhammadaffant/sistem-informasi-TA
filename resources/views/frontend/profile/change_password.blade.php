@php($title = 'Change Password')

@extends('frontend.main_master')

@section('content')
<div class="body-content">
    <div class="container">
        <div class="row">
            <div class="col-md-2"><br>
                @include('frontend.common.user_sidebar')
            </div>

            <div class="col-md-2"></div>

            <div class="col-md-6">
                <div class="card">
                    <h3 class="text-center"><span class="text-danger">Change Password</span></h3>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('user.update.password') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="current_password">Password Lama</label>
                            <input id="current_password" class="form-control" type="password" name="oldpassword">
                        </div>
                        <div class="form-group">
                            <label for="password">Password Baru</label>
                            <input id="password" class="form-control" type="password" name="password">
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation">
                            @error('password_confirmation')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <button type="submit" class="btn btn-danger">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="margin-top: 190px"></div>
<script>
    setTimeout(() => {
        const success = document.querySelector('.alert-success');
        const error = document.querySelector('.alert-danger');
        [success, error].forEach(el => {
            if (el) {
                el.style.transition = 'opacity 0.5s ease';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            }
        });
    }, 3000);
</script>

@endsection
