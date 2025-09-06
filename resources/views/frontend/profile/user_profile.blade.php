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

                        <!-- Profile Photo Section -->
                        <div class="text-center mb-4" style="padding: 20px;">
                            <div class="profile-photo-container" style="position: relative; display: inline-block;">
                                <img 
                                    src="{{ Auth::user()->profile_photo_url }}" 
                                    alt="{{ Auth::user()->name }}" 
                                    class="rounded-circle" 
                                    style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #dee2e6;"
                                >
                                @if(Auth::user()->google_avatar_url)
                                    {{-- <small class="d-block mt-2 text-muted">
                                        <i class="fa fa-google text-danger"></i> 
                                        Avatar dari Google
                                    </small> --}}
                                    <div class="mt-2">
                                        <a href="{{ route('user.remove.google.avatar') }}" 
                                           class="btn btn-sm btn-outline-secondary"
                                           onclick="return confirm('Yakin ingin menghapus avatar Google?')">
                                            <i class="fa fa-times"></i> Hapus Avatar Google
                                        </a>
                                    </div>
                                @else
                                    <small class="d-block mt-2 text-muted">
                                        Avatar Default
                                    </small>
                                    @if(Auth::user()->google_id)
                                        <div class="mt-2">
                                            <small class="d-block text-info">
                                                <i class="fa fa-info-circle"></i> 
                                                Untuk menggunakan avatar Google, logout dan login kembali dengan Google
                                            </small>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>

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
