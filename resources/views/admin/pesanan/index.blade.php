@extends('layouts.app')

@section('title', 'Daftar Pemesanan')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>@yield('title')</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">@yield('title')</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <x-card>
                            <x-slot name="header">
                                <button onclick="addForm(`{{ route('pesanan.store') }}`)" class="btn btn-sm btn-primary"><i
                                        class="fas fa-plus-circle"></i> Tambah
                                    Data</button>
                            </x-slot>
                            <x-table class="table_pemesanan">
                                <x-slot name="thead">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Telepon</th>
                                    <th>Kategori</th>
                                    <th>Keperluan</th>
                                    <th>Gambar</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </x-slot>
                            </x-table>
                        </x-card>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('admin.pesanan.ubahstatus')
    @include('admin.pesanan.detail')
@endsection

@push('scripts')
    <script>
        $(function() {
            $('body').addClass('sidebar-collapse sidebar-mini');
        });

        let table = $('.table_pemesanan').DataTable({
            processing: true,
            serverSide: true,
            autoWidth: false,
            responsive: true,
            ajax: {
                url: '{{ route('pesanan.data') }}'
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'nama_lengkap'
                },
                {
                    data: 'telepon'
                },
                {
                    data: 'kategori.nama_kategori'
                },
                {
                    data: 'keperluan'
                },
                {
                    data: 'gambar'
                },

                {
                    data: 'status'
                },
                {
                    data: 'aksi',
                    name: 'aksi',
                    orderable: false,
                    searchable: false
                },
            ]
        });

        $(document).on('click', '.change-status', function() {
            let id = $(this).data('id'); // Ambil ID pemesanan
            let status = $(this).data('status'); // Ambil status dari data-status

            // Isi ID pemesanan ke dalam input hidden di modal
            $('#statusModal').find('input[name="id"]').val(id);

            // Set nilai dropdown status dengan nilai yang diambil dari data-status
            $('#statusModal').find('select[name="status"]').val(status);

            // Tampilkan modal
            $('#statusModal').modal('show');
        });


        // Kirim perubahan status melalui AJAX
        $('#statusForm').on('submit', function(e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: '{{ route('pesanan.updateStatus') }}',
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Status berhasil diubah!',
                        });
                        $('#statusModal').modal('hide');
                        table.ajax.reload()
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: response.message || 'Terjadi kesalahan!',
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Terjadi kesalahan!',
                    });
                }
            });
        });

        function detailForm(url) {
            $.get(url, function(response) {
                const data = response.data;

                console.log(response.data.status)
                $('#nama').val(data.nama_lengkap);
                $('#telepon').val(data.telepon);
                $('#alamat').val(data.alamat);
                $('#kategori').val(data.kategori.nama_kategori);
                $('#keperluan').val(data.keperluan);
                $('#gambar').attr('src', data.gambar);
                $('#keterangan').val(data.keterangan);
                $('#status_pesanan').val(data.status);

                // Mengecek apakah pesanan_detail ada dan berupa array
                if (data.pesanan_detail && Array.isArray(data.pesanan_detail) && data.pesanan_detail.length >
                    0) {
                    let tableContent = '';
                    data.pesanan_detail.forEach(detail => {
                        tableContent += `
                    <tr>
                        <td>${detail.size}</td>
                        <td>${detail.quantity}</td>
                    </tr>
                `;
                    });
                    $('#detailTable tbody').html(tableContent);
                } else {
                    $('#detailTable tbody').html('<tr><td colspan="2">Tidak ada detail pemesanan</td></tr>');
                }

                $('#modalDetail').modal('show');
            }).fail(function() {
                alert('Gagal mengambil data!');
            });
        }
    </script>
@endpush
