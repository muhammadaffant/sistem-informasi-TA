# Custom Order Design Management

## Fitur Baru: Tampilan Desain Depan dan Belakang

### Deskripsi
Sistem sekarang mendukung penampilan desain depan dan belakang kaos pada halaman detail admin custom order.

### Fitur yang Ditambahkan

1. **Database Schema**
   - `file_design_front` - Kolom untuk menyimpan file desain depan
   - `file_design_back` - Kolom untuk menyimpan file desain belakang
   - `front_position` - Posisi desain depan
   - `back_position` - Posisi desain belakang

2. **Tampilan Admin**
   - Preview gambar desain depan dan belakang secara terpisah
   - Modal untuk melihat gambar dalam ukuran penuh
   - Download gambar desain
   - Loading state saat memuat gambar
   - Error handling jika gambar gagal dimuat

3. **Backend Support**
   - Upload multiple design files (front dan back)
   - Kompatibilitas dengan sistem lama (file_design)
   - Validasi dan storage management

### Cara Kerja

1. **Frontend (User Order)**
   - User dapat upload desain depan (wajib)
   - User dapat upload desain belakang (opsional)
   - Sistem menyimpan posisi untuk masing-masing desain

2. **Backend Processing**
   - Controller memproses upload file depan dan belakang
   - File disimpan di storage dengan nama yang unik
   - Database menyimpan path file dan informasi posisi

3. **Admin Dashboard**
   - Admin dapat melihat preview desain depan dan belakang
   - Klik pada gambar untuk melihat ukuran penuh
   - Download gambar desain untuk keperluan produksi

### Tampilan UI

- **Desain Depan**: Border hijau dengan ikon T-shirt
- **Desain Belakang**: Border abu-abu dengan ikon layer
- **Desain Lama**: Border biru dengan ikon image (fallback)

### Struktur File

```
resources/views/admin/customorder/
├── detail.blade.php (Modal detail yang diperbarui)
└── index.blade.php (JavaScript dan CSS yang diperbarui)

app/Http/Controllers/User/
└── UserCustomOrderController.php (Upload logic)

app/Models/
└── CustomOrder.php (Model fields)

database/migrations/
└── 2025_09_01_205713_add_front_back_design_fields_to_custom_orders_table.php
```

### Kompatibilitas

Sistem tetap kompatibel dengan data lama yang hanya memiliki satu file desain (`file_design`). Jika tidak ada desain depan/belakang, sistem akan menampilkan desain utama sebagai fallback.

### CSS Classes

- `.design-wrapper` - Container utama desain
- `.design-image-container` - Container gambar dengan efek hover
- `.design-info` - Panel informasi desain
- `.btn-design-action` - Tombol aksi dengan animasi

### JavaScript Functions

- `showImageModal(imageSrc, title)` - Menampilkan modal gambar
- `imageLoaded()` - Callback ketika gambar berhasil dimuat
- `imageError()` - Callback ketika gambar gagal dimuat
