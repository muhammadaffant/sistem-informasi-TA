@extends('layouts.stisla')

@section('title', 'Data Karyawan')

@push('css')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
    <style>
        .currency-input {
            position: relative;
        }
        .currency-symbol {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6c757d;
        }
        .currency-input input {
            padding-left: 35px;
        }
        .gaji-bersih-display {
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            padding: 0.375rem 0.75rem;
            border-radius: 0.25rem;
            font-weight: bold;
            color: #28a745;
        }
    </style>
@endpush

@section('content')
    <div class="section-header">
        {{-- <h1>Data Karyawan</h1> --}}
        <div class="section-header-breadcrumb">
            {{-- <div class="breadcrumb-item active"><a href="#">Dashboard</a></div> --}}
            {{-- <div class="breadcrumb-item">Data Karyawan</div> --}}
        </div>
    </div>

    <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Form Input Karyawan</h4>
                                <div class="card-header-action">
                                    {{-- <button class="btn btn-primary" id="btn-tambah">
                                        <i class="fas fa-plus"></i> Tambah Karyawan
                                    </button> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Form Input Karyawan -->
                                <form id="form-karyawan" class="mb-4">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nip">NIP <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="nip" name="nip" placeholder="Masukkan NIP" required>
                                                <div class="invalid-feedback" id="error-nip"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="nama">Nama <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" required>
                                                <div class="invalid-feedback" id="error-nama"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Masukkan Alamat" required></textarea>
                                        <div class="invalid-feedback" id="error-alamat"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="gaji_pokok">Gaji Pokok <span class="text-danger">*</span></label>
                                                <div class="currency-input">
                                                    {{-- <span class="currency-symbol">Rp</span> --}}
                                                    <input type="number" class="form-control gaji-input" id="gaji_pokok" name="gaji_pokok" placeholder="0" min="0" step="1000" required>
                                                </div>
                                                <div class="invalid-feedback" id="error-gaji_pokok"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="tunjangan_kehadiran">Tunjangan Kehadiran</label>
                                                <div class="currency-input">
                                                    {{-- <span class="currency-symbol">Rp</span> --}}
                                                    <input type="number" class="form-control gaji-input" id="tunjangan_kehadiran" name="tunjangan_kehadiran" placeholder="0" min="0" step="1000" value="0">
                                                </div>
                                                <div class="invalid-feedback" id="error-tunjangan_kehadiran"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="uang_lembur">Utang</label>
                                                <div class="currency-input">
                                                    {{-- <span class="currency-symbol">Rp</span> --}}
                                                    <input type="number" class="form-control gaji-input" id="uang_lembur" name="uang_lembur" placeholder="0" min="0" step="1000" value="0">
                                                </div>
                                                <div class="invalid-feedback" id="error-uang_lembur"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Gaji Bersih</label>
                                                <div class="gaji-bersih-display" id="gaji-bersih-display">
                                                    Rp 0
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group text-right">
                                        <button type="button" class="btn btn-secondary" id="btn-reset">
                                            <i class="fas fa-undo"></i> Cansel
                                        </button>
                                        <button type="submit" class="btn btn-primary" id="btn-simpan">
                                            <i class="fas fa-save"></i> Simpan
                                        </button>
                                    </div>
                                </form>

                                <!-- Tabel Data Karyawan -->
                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-karyawan">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>NIP</th>
                                                <th>Nama</th>
                                                <th>Alamat</th>
                                                <th>Gaji Pokok</th>
                                                <th>Tunjangan Kehadiran</th>
                                                <th>Utang</th>
                                                <th>Gaji Bersih</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($karyawan as $index => $item)
                                                <tr id="row-{{ $item->id }}">
                                                    <td class="text-center">{{ $karyawan->firstItem() + $index }}</td>
                                                    <td>{{ $item->nip }}</td>
                                                    <td>{{ $item->nama }}</td>
                                                    <td>{{ Str::limit($item->alamat, 50) }}</td>
                                                    <td>{{ $item->formatted_gaji_pokok }}</td>
                                                    <td>{{ $item->formatted_tunjangan_kehadiran }}</td>
                                                    <td>{{ $item->formatted_uang_lembur }}</td>
                                                    <td class="text-success font-weight-bold">{{ $item->formatted_gaji_bersih }}</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $item->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $item->id }}">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">Tidak ada data karyawan</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination -->
                                <div class="float-right">
                                    {{ $karyawan->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="modal-edit-label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-edit-label">Edit Data Karyawan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-edit">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit-id" name="id">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit-nip">NIP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit-nip" name="nip" placeholder="Masukkan NIP" required>
                                    <div class="invalid-feedback" id="edit-error-nip"></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="edit-nama">Nama <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit-nama" name="nama" placeholder="Masukkan Nama" required>
                                    <div class="invalid-feedback" id="edit-error-nama"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="edit-alamat">Alamat <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit-alamat" name="alamat" rows="3" placeholder="Masukkan Alamat" required></textarea>
                            <div class="invalid-feedback" id="edit-error-alamat"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit-gaji_pokok">Gaji Pokok <span class="text-danger">*</span></label>
                                    <div class="currency-input">
                                        <span class="currency-symbol">Rp</span>
                                        <input type="number" class="form-control edit-gaji-input" id="edit-gaji_pokok" name="gaji_pokok" placeholder="0" min="0" step="1000" required>
                                    </div>
                                    <div class="invalid-feedback" id="edit-error-gaji_pokok"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit-tunjangan_kehadiran">Tunjangan Kehadiran</label>
                                    <div class="currency-input">
                                        <span class="currency-symbol">Rp</span>
                                        <input type="number" class="form-control edit-gaji-input" id="edit-tunjangan_kehadiran" name="tunjangan_kehadiran" placeholder="0" min="0" step="1000">
                                    </div>
                                    <div class="invalid-feedback" id="edit-error-tunjangan_kehadiran"></div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit-uang_lembur">Utang</label>
                                    <div class="currency-input">
                                        <span class="currency-symbol">Rp</span>
                                        <input type="number" class="form-control edit-gaji-input" id="edit-uang_lembur" name="uang_lembur" placeholder="0" min="0" step="1000">
                                    </div>
                                    <div class="invalid-feedback" id="edit-error-uang_lembur"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Gaji Bersih</label>
                                    <div class="gaji-bersih-display" id="edit-gaji-bersih-display">
                                        Rp 0
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraries -->
    <script src="{{ asset('stisla/node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('stisla/node_modules/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Fungsi untuk menghitung gaji bersih
            function calculateGajiBersih(prefix = '') {
                const gajiPokok = parseFloat($(`#${prefix}gaji_pokok`).val()) || 0;
                const tunjanganKehadiran = parseFloat($(`#${prefix}tunjangan_kehadiran`).val()) || 0;
                const utang = parseFloat($(`#${prefix}uang_lembur`).val()) || 0;
                
                const gajiBersih = gajiPokok + tunjanganKehadiran - utang;
                const formattedGajiBersih = 'Rp ' + new Intl.NumberFormat('id-ID').format(gajiBersih);
                
                $(`#${prefix}gaji-bersih-display`).text(formattedGajiBersih);
                
                return gajiBersih;
            }

            // Fungsi untuk format currency
            function formatCurrency(amount) {
                return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
            }

            // Fungsi untuk menambah row ke tabel
            function addRowToTable(data) {
                const rowCount = $('#table-karyawan tbody tr').length;
                let newRowNumber;
                
                if ($('#table-karyawan tbody tr:first').text().includes('Tidak ada data')) {
                    $('#table-karyawan tbody').empty();
                    newRowNumber = 1;
                } else {
                    newRowNumber = rowCount + 1;
                }

                const newRow = `
                    <tr id="row-${data.id}">
                        <td class="text-center">${newRowNumber}</td>
                        <td>${data.nip}</td>
                        <td>${data.nama}</td>
                        <td>${data.alamat.length > 50 ? data.alamat.substring(0, 50) + '...' : data.alamat}</td>
                        <td>${formatCurrency(data.gaji_pokok)}</td>
                        <td>${formatCurrency(data.tunjangan_kehadiran)}</td>
                        <td>${formatCurrency(data.uang_lembur)}</td>
                        <td class="text-success font-weight-bold">${formatCurrency(data.gaji_bersih)}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-primary btn-edit" data-id="${data.id}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger btn-delete" data-id="${data.id}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
                
                $('#table-karyawan tbody').prepend(newRow);
            }

            // Fungsi untuk update row di tabel
            function updateRowInTable(data) {
                const row = $(`#row-${data.id}`);
                if (row.length) {
                    row.find('td:eq(1)').text(data.nip);
                    row.find('td:eq(2)').text(data.nama);
                    row.find('td:eq(3)').text(data.alamat.length > 50 ? data.alamat.substring(0, 50) + '...' : data.alamat);
                    row.find('td:eq(4)').text(formatCurrency(data.gaji_pokok));
                    row.find('td:eq(5)').text(formatCurrency(data.tunjangan_kehadiran));
                    row.find('td:eq(6)').text(formatCurrency(data.uang_lembur));
                    row.find('td:eq(7)').text(formatCurrency(data.gaji_bersih));
                }
            }

            // Event listener untuk input gaji (form tambah)
            $('.gaji-input').on('input', function() {
                calculateGajiBersih();
            });

            // Event listener untuk input gaji (form edit)
            $(document).on('input', '.edit-gaji-input', function() {
                calculateGajiBersih('edit-');
            });

            // Submit form tambah
            $('#form-karyawan').on('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                
                $.ajax({
                    url: '{{ route("karyawan.store") }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('#btn-simpan').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyimpan...');
                        $('.form-control').removeClass('is-invalid');
                        $('.invalid-feedback').text('');
                    },
                    success: function(response) {
                        if (response.success) {
                            // Reset form
                            $('#form-karyawan')[0].reset();
                            $('#gaji-bersih-display').text('Rp 0');
                            
                            // Tambah row ke tabel
                            addRowToTable(response.data);
                            
                            // Show success message
                            Swal.fire('Berhasil!', response.message, 'success');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $(`#${key}`).addClass('is-invalid');
                                $(`#error-${key}`).text(value[0]);
                            });
                        } else {
                            Swal.fire('Error!', 'Terjadi kesalahan saat menyimpan data', 'error');
                        }
                    },
                    complete: function() {
                        $('#btn-simpan').prop('disabled', false).html('<i class="fas fa-save"></i> Simpan');
                    }
                });
            });

            // Reset form
            $('#btn-reset').on('click', function() {
                $('#form-karyawan')[0].reset();
                $('.form-control').removeClass('is-invalid');
                $('.invalid-feedback').text('');
                $('#gaji-bersih-display').text('Rp 0');
            });

            // Edit karyawan
            $(document).on('click', '.btn-edit', function() {
                const id = $(this).data('id');
                
                $.ajax({
                    url: `/karyawan/${id}`,
                    type: 'GET',
                    success: function(response) {
                        $('#edit-id').val(response.id);
                        $('#edit-nip').val(response.nip);
                        $('#edit-nama').val(response.nama);
                        $('#edit-alamat').val(response.alamat);
                        $('#edit-gaji_pokok').val(response.gaji_pokok);
                        $('#edit-tunjangan_kehadiran').val(response.tunjangan_kehadiran);
                        $('#edit-uang_lembur').val(response.uang_lembur);
                        
                        calculateGajiBersih('edit-');
                        $('#modal-edit').modal('show');
                    },
                    error: function() {
                        Swal.fire('Error!', 'Gagal mengambil data karyawan', 'error');
                    }
                });
            });

            // Submit form edit
            $('#form-edit').on('submit', function(e) {
                e.preventDefault();
                
                const id = $('#edit-id').val();
                const formData = new FormData(this);
                
                $.ajax({
                    url: `/karyawan/${id}`,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $('.form-control').removeClass('is-invalid');
                        $('.invalid-feedback').text('');
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update row di tabel
                            updateRowInTable(response.data);
                            
                            // Tutup modal
                            $('#modal-edit').modal('hide');
                            
                            // Show success message
                            Swal.fire('Berhasil!', response.message, 'success');
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $(`#edit-${key}`).addClass('is-invalid');
                                $(`#edit-error-${key}`).text(value[0]);
                            });
                        } else {
                            Swal.fire('Error!', 'Terjadi kesalahan saat mengupdate data', 'error');
                        }
                    }
                });
            });

            // Delete karyawan
            $(document).on('click', '.btn-delete', function() {
                const id = $(this).data('id');
                
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data karyawan akan dihapus secara permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/karyawan/${id}`,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Hapus row dari tabel
                                    $(`#row-${id}`).fadeOut(500, function() {
                                        $(this).remove();
                                        
                                        // Update nomor urut
                                        updateRowNumbers();
                                        
                                        // Cek jika tabel kosong
                                        if ($('#table-karyawan tbody tr').length === 0) {
                                            $('#table-karyawan tbody').html(`
                                                <tr>
                                                    <td colspan="9" class="text-center">Tidak ada data karyawan</td>
                                                </tr>
                                            `);
                                        }
                                    });
                                    
                                    Swal.fire('Berhasil!', response.message, 'success');
                                }
                            },
                            error: function() {
                                Swal.fire('Error!', 'Gagal menghapus data karyawan', 'error');
                            }
                        });
                    }
                });
            });

            // Fungsi untuk update nomor urut setelah delete
            function updateRowNumbers() {
                $('#table-karyawan tbody tr').each(function(index) {
                    $(this).find('td:first').text(index + 1);
                });
            }

            // Initialize DataTable if needed
            // $('#table-karyawan').DataTable();
        });
    </script>
@endpush
