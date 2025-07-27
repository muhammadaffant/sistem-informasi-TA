@extends('layouts.stisla')

@section('title', 'Profile')
@section('content')

      <div class="section-body">
        <h2 class="section-title">{{ auth()->user()->fullname }}</h2>
        <p class="section-lead">
          Ubah informasi di halaman ini..
        </p>

        <div class="row mt-sm-4">
          <div class="col-12 col-md-12 col-lg-5">
            <div class="card">
            <div class="card profile-widget">
              <div class="mt-3 profile-widget-header">                     
                <img alt="image" src="/stisla/assets/img/avatar/avatar-1.png" class="rounded-circle profile-widget-picture">
                <div class="profile-widget-items">
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">username</div>
                    <div class="profile-widget-item-value">{{ auth()->user()->username }}</div>
                  </div>
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">Email</div>
                    <div class="profile-widget-item-value">{{ auth()->user()->email }}</div>
                  </div>
                  <div class="profile-widget-item">
                    <div class="profile-widget-item-label">Role</div>
                    <div class="profile-widget-item-value">{{ auth()->user()->roles->pluck('name')->join(', ') }}</div>
                  </div>
                </div>
              </div>
              <div class="profile-widget-description">
                <div class="profile-widget-name">{{ auth()->user()->username }}<div class="text-muted d-inline font-weight-normal"><div class="slash"></div> {{ auth()->user()->name }}</div></div>
              </div>
              {{-- <div class="card-footer text-center">
                <div class="font-weight-bold mb-2">Follow Ujang On</div>
                <a href="#" class="btn btn-social-icon btn-facebook mr-1">
                  <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="btn btn-social-icon btn-twitter mr-1">
                  <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="btn btn-social-icon btn-github mr-1">
                  <i class="fab fa-github"></i>
                </a>
                <a href="#" class="btn btn-social-icon btn-instagram">
                  <i class="fab fa-instagram"></i>
                </a>
              </div> --}}
            </div>
          </div>
        </div>
          <div class="col-12 col-md-12 col-lg-7">
            <div class="card">
              <form action="{{ route('admin.profile.update') }}" method="post" class="needs-validation" novalidate="">
                @csrf
                @method('PUT')
                @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible show fade" role="alert">
                  <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                      <span>&times;</span>
                    </button>
                    {{ session('success') }}
                  </div>
                </div>

                @elseif (session()->has('error'))
                <div class="alert alert-danger alert-dismissible show fade" role="alert">
                  <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                      <span>&times;</span>
                    </button>
                    {{ session('error') }}
                  </div>
                </div>
                @endif

                <div class="card-header">
                  <h4>Edit Profile</h4>
                </div>
                <div class="card-body">
                    <div class="row">                               
                      <div class="form-group col-md-6 col-12">
                        <label>fullName</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ auth()->user()->name }}">
                        @error('name') 
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                      <div class="form-group col-md-6 col-12">
                        <label>username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ auth()->user()->username }}">
                        @error('username')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                    </div>
                    <div class="row">
                      <div class="form-group col-md-6 col-12">
                        <label>Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ auth()->user()->email }}">
                        @error('email')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                        @enderror
                      </div>
                      {{-- <div class="form-group col-md-6 col-12">
                        <label>Phone</label>
                        <input type="tel" class="form-control" value="{{ auth()->user()->phone }}">
                      </div>
                    </div> --}}
                    {{-- <div class="row">
                      <div class="form-group col-12">
                        <label>Bio</label>
                        <textarea class="form-control summernote-simple">Ujang maman is a superhero name in <b>Indonesia</b>, especially in my family. He is not a fictional character but an original hero in my family, a hero for his children and for his wife. So, I use the name as a user in this template. Not a tribute, I'm just bored with <b>'John Doe'</b>.</textarea>
                      </div>
                    </div> --}}
                    {{-- <div class="row">
                      <div class="form-group mb-0 col-12">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" name="remember" class="custom-control-input" id="newsletter">
                          <label class="custom-control-label" for="newsletter">Subscribe to newsletter</label>
                          <div class="text-muted form-text">
                            You will get new information about products, offers and promotions
                          </div>
                        </div>
                      </div>
                    </div> --}}
                </div>
                <div class="card-footer text-right">
                  <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
   
  </div>
    
  <script>
    // Mengatur agar alert success dan error menghilang dalam 3 detik
    setTimeout(function() {
        // Menghilangkan alert setelah 3 detik
        const alertElements = document.querySelectorAll('.alert');
        alertElements.forEach(function(alert) {
            alert.style.transition = "opacity 0.5s ease";
            alert.style.opacity = "0";
            setTimeout(function() {
                alert.remove();
            }, 500); // Delay tambahan untuk transisi penghilangan
        });
    }, 2000); // 3000 ms = 3 detik
  </script>
@endsection