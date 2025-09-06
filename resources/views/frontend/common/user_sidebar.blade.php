<br>

<!-- User Profile Section -->
<div class="text-center mb-3" style="padding: 15px; background: #f8f9fa; border-radius: 8px;">
    <div class="profile-avatar mb-3">
        <img 
            src="{{ Auth::user()->profile_photo_url }}" 
            alt="{{ Auth::user()->name }}" 
            class="rounded-circle" 
            style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #fff; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
        >
    </div>
    <h6 class="mb-1 font-weight-bold">{{ Auth::user()->name }}</h6>
    {{-- <small class="text-muted">{{ Auth::user()->email }}</small> --}}
    @if(Auth::user()->google_avatar_url)
        <br><small class="text-muted">
            <i class="fa fa-google text-danger"></i> Google User
        </small>
    @endif
</div>

<div class="list-group">
    <a href="{{ url('/') }}" class="btn btn-primary btn-sm btn-block">Home</a>
    <a href="{{ route('user.order') }}" class="btn btn-primary btn-sm btn-block">My Order</a>
    <a href="{{ route('user.profile.edit') }}" class="btn btn-primary btn-sm btn-block">Profile Update</a>
    <a href="{{ route('change.password') }}" class="btn btn-primary btn-sm btn-block">Change Password</a>
    <a href="{{ route('user.logout') }}" class="btn btn-danger btn-sm btn-block">Logout</a>
</div>

