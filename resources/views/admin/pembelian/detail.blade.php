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
                        <!-- Informasi Nama dan Email -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama"><i class="fas fa-user"></i> Nama Lengkap</label>
                                <input type="text" id="nama" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email"><i class="fas fa-envelope"></i> Email</label>
                                <input type="text" id="email" class="form-control" disabled>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Produk -->
                    <div class="form-group">
                        <div class="alert alert-primary">
                            <label for="detailTable"><i class="fas fa-list-alt"></i> Detail Pembelian</label>
                        </div>
                        <table id="detailTable" class="table table-striped table-hover table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data Pesanan akan ditambahkan di sini -->
                            </tbody>
                        </table>
                    </div>

                    <!-- Status dan Total Harga -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <div class="alert alert-info">
                                <h5><i class="fas fa-clipboard-check"></i> Status Pesanan</h5>
                                <p id="statusPesanan" class="font-weight-bold text-uppercase">Pending</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="alert alert-success">
                                <h5><i class="fas fa-money-bill-wave"></i> Total Harga</h5>
                                <p id="totalHarga" class="font-weight-bold text-danger">Rp 0</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fas fa-times"></i>
                    Tutup</button>
            </div>
        </div>
    </div>
</div>
