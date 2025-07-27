@php($title = 'Profile')

@extends('frontend.main_master')

@section('content')
    <div class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-md-2">
                    <br>
                    @include('frontend.common.user_sidebar')
                </div>
                <div class="col-md-2">

                </div>
                <div class="col-md-6">
                    <div class="card">
                        <h3 class="text-center"><span class="text-danger">Hi...</span>
                            <strong>{{ Auth::user()->name }}</strong> 
                            <br><br>Edit Profile
                        </h3>

                        @if(session('success'))
                            <div class="alert alert-success" id="alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('user.profile.update') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input id="name" class="form-control" type="text" name="name" value="{{ $user->name }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" class="form-control" type="email" name="email" value="{{ $user->email }}">
                            </div>
                            <div class="form-group">
                                <label for="numberphone">Nomor Hp</label>
                                <input id="numberphone" class="form-control" type="number" name="numberphone" value="{{ $user->numberphone }}">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-danger">Update</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div style="margin-top: 190px">

    </div>


    <script>
    setTimeout(function () {
        const alertBox = document.getElementById('alert-success');
        if (alertBox) {
            alertBox.style.transition = 'opacity 0.5s ease';
            alertBox.style.opacity = '0';
            setTimeout(() => alertBox.remove(), 500); // Hapus elemen dari DOM setelah fade out
        }
    }, 3000); // 3000ms = 3 detik
</script>

@endsection
