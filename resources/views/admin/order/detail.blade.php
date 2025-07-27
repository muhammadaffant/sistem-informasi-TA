<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalDetailLabel"><i class="fas fa-info-circle"></i> Detail Produk</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="detailForm">
                    <!-- Informasi Produk -->
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

                    <div class="form-group">
                        <label for="short_descp">Deskripsi Singkat</label>
                        <textarea id="short_descp" class="form-control" rows="6" disabled></textarea>
                    </div>

                    <div class="form-group">
                        <label for="long_descp">Deskripsi Lengkap</label>
                        <textarea id="long_descp" class="form-control" rows="30"></textarea>
                    </div>

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

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product_size">Ukuran</label>
                                <input type="text" id="product_size" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="product_color">Warna</label>
                                <input type="text" id="product_color" class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="selling_price">Harga Jual</label>
                        <input type="text" id="selling_price" class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label for="discount_price">Harga Diskon</label>
                        <input type="text" id="discount_price" class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label for="product_qty">Jumlah Stok</label>
                        <input type="text" id="product_qty" class="form-control" disabled>
                    </div>

                    <!-- Gambar Utama -->
                    <div class="form-group text-center">
                        <label for="product_thumbnail">Gambar Produk</label>
                        <div id="product_thumbnail">
                            <!-- Gambar tambahan akan ditampilkan di sini -->
                        </div>
                    </div>

                    <!-- Gambar Tambahan -->
                    <div class="form-group text-center">
                        <label for="multi_images">Gambar Lainnya</label>
                        <div id="multi_images">
                            <!-- Gambar tambahan akan ditampilkan di sini -->
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="status">Status Produk</label>
                        <input type="text" id="status" class="form-control" disabled>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
