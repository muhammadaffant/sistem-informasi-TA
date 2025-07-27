<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ghazlan.co - Custom Order</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .header-banner {
            background: url('https://via.placeholder.com/1200x300') no-repeat center center;
            background-size: cover;
            height: 300px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .custom-card {
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .alert-custom {
            background-color: #e9f8e9;
            border: 1px solid #a2d3a2;
            color: #317231;
        }

        .form-control:disabled {
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">Ghazlan.co</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Etalase</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Feed</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Katalog</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Konveksi</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="header-banner">
        <div>GHAZLAN.co<br><small>"Kualitas Prioritas Utama Kami Demi Kepuasan Pelanggan"</small></div>
    </div>

    <div class="container my-4">
        <div class="alert alert-custom">
            <strong>Perhatian:</strong> Pesanan konveksi akan diproses satu hari setelah melakukan pembayaran.
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="custom-card">
                    <div class="section-title">Custom Desain Pakaian Sesuai Keinginanmu Di sini!</div>
                    <form>
                        <div class="mb-3">
                            <label for="kategori-produk" class="form-label">Kategori Produk</label>
                            <select id="kategori-produk" class="form-select">
                                <option>Pilih kategori produk</option>
                                <option>Kaos</option>
                                <option>Kemeja</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pilih-kain" class="form-label">Pilih Kain</label>
                            <select id="pilih-kain" class="form-select">
                                <option>Pilih kain</option>
                                <option>Kain Katun</option>
                                <option>Kain Polyester</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="pilih-sablon" class="form-label">Pilih Sablon</label>
                            <select id="pilih-sablon" class="form-select">
                                <option>Pilih sablon</option>
                                <option>Sablon Rubber</option>
                                <option>Sablon Plastisol</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" id="jumlah" class="form-control" value="1" min="1">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Model Barang</label>
                            <div class="form-check">
                                <input type="radio" id="lengan-panjang" name="model" class="form-check-input">
                                <label for="lengan-panjang" class="form-check-label">Lengan Panjang</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="lengan-pendek" name="model" class="form-check-input">
                                <label for="lengan-pendek" class="form-check-label">Lengan Pendek</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Desain Barang</label>
                            <div class="form-check">
                                <input type="radio" id="jasa-ya" name="jasa" class="form-check-input">
                                <label for="jasa-ya" class="form-check-label">Ya</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" id="jasa-tidak" name="jasa" class="form-check-input">
                                <label for="jasa-tidak" class="form-check-label">Tidak</label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Pesan Sekarang</button>
                    </form>
                </div>
            </div>
            <div class="col-md-5">
                <div class="custom-card">
                    <div class="section-title">Detail Pesananmu</div>
                    <ul class="list-group">
                        <li class="list-group-item">Kategori Produk: -</li>
                        <li class="list-group-item">Jenis Kain: -</li>
                        <li class="list-group-item">Jenis Sablon: -</li>
                        <li class="list-group-item">Jumlah: -</li>
                        <li class="list-group-item">Model Barang: -</li>
                        <li class="list-group-item">Desain Barang: -</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add JavaScript here if necessary for interactivity
    </script>
</body>

</html>
