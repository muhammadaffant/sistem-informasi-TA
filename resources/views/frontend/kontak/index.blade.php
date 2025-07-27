{{-- @extends('frontend.main_master')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Kontak Kami</h2>
    <div class="row">
        <!-- Informasi Kontak -->
        <div class="col-md-5 scroll-tabs outer-top-vs wow fadeInUp">
            <h4>Alamat</h4>
            <p>Jl. Contoh No.123, Jakarta, Indonesia</p>
            <h4>Email</h4>
            <p><a href="mailto:info@contoh.com">info@contoh.com</a></p>
            <h4>Telepon</h4>
            <p><a href="tel:+62123456789">+62 123 456 789</a></p>
            
            <!-- Google Maps -->
            <div class="mt-3">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d31693.882255897024!2d106.8455998!3d-6.2087634!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e9e7e6a2a5%3A0xf8e9e8c5e9c5e9c5!2sJakarta!5e0!3m2!1sen!2sid!4v1627641234567" 
                    width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>

                <!-- Form Kontak -->
                <div class="col-md-6 scroll-tabs outer-top-vs wow fadeInUp" style="margin-left: 40px">
                    <h4>Kirim Pesan</h4>
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form action="3" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Pesan</label>
                            <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Kirim</button>
                    </form>
                </div>

        

    </div>
</div>
@endsection --}}



@extends('frontend.main_master')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Alamat Kami</h2>
    
    <!-- Google Maps -->
    <div class="mb-4">
        <iframe 
            {{-- src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.5539808599647!2d109.13266897587636!3d-6.94378466797785!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fb929455ff0cf%3A0x2372db0a61f74d97!2sJl.%20Katesraya%20No.11%2C%20Kenjari%2C%20Tembok%20Banjaran%2C%20Kec.%20Adiwerna%2C%20Kabupaten%20Tegal%2C%20Jawa%20Tengah%2052194!5e0!3m2!1sid!2sid!4v1731558333433!5m2!1sid!2sid"  --}}
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.5549563578015!2d109.13202227504392!3d-6.943668793056422!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6fb9f502417ca3%3A0x7ce478a912c98b84!2sViary%20Store!5e0!3m2!1sid!2sid!4v1752065584508!5m2!1sid!2sid" 
            width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
    
    <div class="row">

                <!-- Informasi Kontak -->
                <div class="col-md-6 scroll-tabs outer-top-vs wow fadeInUp" style="margin-left: 10px">
                    <div class="card p-4">
                        <h4>Informasi Kontak</h4>
                        
                        <!-- Alamat -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5><i class="fas fa-map-marker-alt"></i> Alamat</h5>
                                <p class="mb-0">Tegal,Jawa Tengah, Kecamatan adiwerna, Kabupaten Tegal, 52194</p>
                            </div>
                        </div>
        
                        <!-- Email -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5><i class="fas fa-envelope"></i> Email</h5>
                                <p class="mb-0">
                                    <a href="mailto:info@contoh.com" class="text-dark">viastores12@gmail.com</a>
                                </p>
                            </div>
                        </div>
        
                        <!-- Telepon -->
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5><i class="fas fa-phone-alt"></i> Telepon</h5>
                                <p class="mb-0">
                                    <a href="tel:+62123456789" class="text-dark">+62 895 380 045 741</a>
                                </p>
                            </div>
                        </div>
        
                    </div>
                </div>
        <!-- Form Kontak -->
        <div class="col-md-5 scroll-tabs outer-top-vs wow fadeInUp align-items-center" style="margin-left: 10px">
            <div class="card p-4">
                <h4>Kirim Pesan</h4>
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form action="{{ route('kontak.kirim') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="name">Nama</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="message">Pesan</label>
                        <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Kirim</button>
                </form>
            </div>
        </div>
        

    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

@endsection

