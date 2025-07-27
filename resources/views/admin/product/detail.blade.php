<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <!-- Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalDetailLabel"><i class="fas fa-info-circle"></i> Detail Produk</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Body -->
            <div class="modal-body">
                <form id="detailForm">
                    <!-- Informasi Umum Produk -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product_name">Nama Produk</label>
                                <input type="text" id="product_name" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product_code">Kode Produk</label>
                                <input type="text" id="product_code" class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="form-group">
                        <label for="short_descp">Deskripsi Singkat</label>
                        <textarea id="short_descp" class="form-control" rows="3" disabled></textarea>
                    </div>

                    <div class="form-group">
                        <label for="long_descp">Deskripsi Lengkap</label>
                        <textarea id="long_descp" class="form-control" rows="5" disabled></textarea>
                    </div>

                    <!-- Kategori -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category">Kategori</label>
                                <input type="text" id="category" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="subcategory">Subkategori</label>
                                <input type="text" id="subcategory" class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Varian & Warna -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label>Varian Produk (Ukuran, Harga, Diskon, Stok)</label>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm text-center">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Ukuran</th>
                                                <th>Harga</th>
                                                <th>Diskon</th>
                                                {{-- <th>Stok</th> --}}
                                                <th>Harga Akhir</th> <th>Stok</th>
                                            </tr>
                                        </thead>
                                        <tbody id="variant_table_body">
                                            <!-- Diisi lewat JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="product_color">Warna</label>
                                <input type="text" id="product_color" class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Gambar Produk -->
                    <div class="form-group text-center">
                        <label for="product_thumbnail">Gambar Utama</label>
                        <div id="product_thumbnail" class="mt-2">
                            <!-- Gambar utama ditampilkan di sini -->
                        </div>
                    </div>

                    <div class="form-group text-center">
                        <label for="multi_images">Gambar Tambahan</label>
                        <div id="multi_images" class="mt-2 d-flex flex-wrap justify-content-center gap-2">
                            <!-- Gambar tambahan ditampilkan di sini -->
                        </div>
                    </div>

                    <!-- Status Produk -->
                    <div class="form-group">
                        <label for="status">Status Produk</label>
                        <input type="text" id="status" class="form-control" disabled>
                    </div>
                </form>
            </div>

            <!-- Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
