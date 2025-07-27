{{-- resources/views/admin/reviews/index.blade.php --}}
@extends('layouts.stisla')

@section('title', 'Manajemen Ulasan')

@section('content')
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <x-card>
                        <x-slot name="header">
                            <h4>Daftar Ulasan Produk</h4>
                        </x-slot>
                        <x-table>
                            <x-slot name="thead">
                                <th>No</th>
                                <th>Produk</th>
                                <th>Pengguna</th>
                                <th>Ulasan</th>
                                <th>Rating</th>
                                {{-- Kolom Status Dihapus --}}
                                <th>Aksi</th>
                            </x-slot>
                        </x-table>
                    </x-card>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

<div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">Balas Ulasan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="replyForm" method="POST">
                @csrf
                @method('POST')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Ulasan Pengguna:</label>
                        <p class="border p-2 bg-light" id="userComment"></p>
                    </div>
                    <div class="form-group">
                        <label for="admin_reply">Balasan Anda</label>
                        <textarea name="admin_reply" id="admin_reply" rows="5" class="form-control" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Balasan</button>
                </div>
            </form>
        </div>
    </div>
</div>


@include('includes.datatables')

@push('scripts')
<script>
    let table;
    $(function () {
        table = $('.table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: '{{ route('admin.reviews.data') }}'
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'product.product_name', name: 'product.product_name' },
                { data: 'user.name', name: 'user.name' },
                { data: 'comment', name: 'comment', orderable: false },
                { data: 'rating', name: 'rating', orderable: false, searchable: false },
                // { data: 'status', name: 'status' }, // <-- Kolom Status Dihapus
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
    
    // Hanya ada konfirmasi Hapus Data
    $(document).on('submit', '.form-delete', function(e) {
        e.preventDefault();
        let form = this;

        Swal.fire({
            title: 'Anda Yakin?',
            text: "Ulasan yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
      $(document).on('click', '.btn-reply', function() {
        let id = $(this).data('id');
        let userComment = $(this).data('comment');
        let adminReply = $(this).data('reply');

        // Set action URL untuk form
        let url = '{{ route("admin.reviews.reply.store", ":id") }}';
        $('#replyForm').attr('action', url.replace(':id', id));

        // Isi data ke modal
        $('#userComment').text(userComment);
        $('#admin_reply').val(adminReply);

        // Tampilkan modal
        $('#replyModal').modal('show');
    });

    // BARU: Script untuk submit form balasan via AJAX agar tidak reload
    $('#replyForm').on('submit', function(e) {
        e.preventDefault();
        let form = $(this);
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                $('#replyModal').modal('hide');
                table.ajax.reload(); // Muat ulang data di tabel
                Swal.fire('Berhasil!', response.success, 'success');
            },
            error: function(xhr) {
                Swal.fire('Gagal!', 'Terjadi kesalahan.', 'error');
            }
        });
    });

    // Skrip untuk .form-update-status DIHAPUS
</script>
@endpush