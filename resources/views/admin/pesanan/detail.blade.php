<!-- Modal Detail -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalDetailLabel"><i class="fas fa-info-circle"></i> Detail Pesanan</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="detailForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap</label>
                                <input type="text" id="nama" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telepon">Telepon</label>
                                <input type="text" id="telepon" class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alamat">Alamat Pengiriman</label>
                        <textarea id="alamat" class="form-control" rows="3" disabled></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <input type="text" id="kategori" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="keperluan">Keperluan</label>
                                <input type="text" id="keperluan" class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Tampilkan Gambar Pesanan -->
                    <div class="form-group text-center">
                        <label for="gambar">Gambar Pesanan</label>
                        <div>
                            <img id="gambar" class="img-fluid rounded" alt="Gambar Pesanan"
                                style="max-width: 300px; height: auto; border: 1px solid #ddd;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea id="keterangan" class="form-control" rows="3" disabled></textarea>
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <input type="text" id="status_pesanan" class="form-control" disabled>
                    </div>

                    <!-- Tabel Ukuran dan Jumlah Pesanan -->
                    <div class="form-group">

                        <div class="alert alert-primary">
                            <label for="pesananDetailsTable">Ukuran dan Jumlah Pesanan</label>
                        </div>
                        <table id="detailTable" class="table table-striped table-hover table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ukuran</th>
                                    <th>Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data Pesanan akan ditambahkan di sini -->
                            </tbody>
                        </table>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
