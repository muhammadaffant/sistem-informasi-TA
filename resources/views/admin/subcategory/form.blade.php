<x-modal data-backdrop="static" data-keyboard="false" size="modal-lg">
    <x-slot name="title">
        Tambah
    </x-slot>

    @method('POST')

    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label>Nama kategori</label>
                <select class="form-control select2" tabindex="-1" aria-hidden="true" name="category_id" id="category_id">
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="subcategory_name">Nama Sub Kategori</label>
                <input type="text" class="form-control" name="subcategory_name" id="subcategory_name"
                    autocomplete="off">
            </div>
        </div>
    </div>

    {{-- Kolom Slug ditambahkan di sini --}}
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="form-group">
                <label for="slug">Slug</label>
                <input type="text" class="form-control" name="slug" id="slug" autocomplete="off" disabled>
            </div>
        </div>
    </div>

    <x-slot name="footer">
        <button type="button" onclick="submitForm(this.form)" class="btn btn-sm btn-primary" id="submitBtn">
            <i class="fas fa-save mr-1"></i>
            Simpan</button>
        <button type="button" data-dismiss="modal" class="btn btn-sm btn-danger">
            <i class="fas fa-times"></i>
            Close
        </button>
    </x-slot>
</x-modal>

{{-- Tambahkan script ini di halaman Anda --}}
<script>
    // Pilih elemen input nama subkategori dan slug
    const subcategoryNameInput = document.getElementById('subcategory_name');
    const slugInput = document.getElementById('slug');

    // Tambahkan event listener saat ada ketikan di input nama subkategori
    subcategoryNameInput.addEventListener('keyup', function () {
        // Buat slug secara otomatis
        const slug = this.value
            .toLowerCase() // Ubah jadi huruf kecil
            .trim() // Hapus spasi di awal dan akhir
            .replace(/[^a-z0-9\s-]/g, '') // Hapus karakter selain huruf, angka, spasi, dan strip
            .replace(/\s+/g, '-') // Ganti spasi dengan strip
            .replace(/-+/g, '-'); // Ganti beberapa strip menjadi satu

        // Masukkan hasilnya ke input slug
        slugInput.value = slug;
    });

    // Ubah fungsi submitForm agar mengaktifkan kolom slug sebelum dikirim
    function submitForm(form) {
        // Aktifkan kolom slug agar nilainya ikut terkirim
        document.getElementById('slug').disabled = false;
        
        // Lanjutkan proses submit form (bisa dengan AJAX atau form.submit() biasa)
        // Contoh:
        // form.submit();
        console.log('Form akan disubmit...');

        // Sebaiknya nonaktifkan kembali jika submit gagal agar user tidak bisa mengubahnya
        // document.getElementById('slug').disabled = true;
    }
</script>