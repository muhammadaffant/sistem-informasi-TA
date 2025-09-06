# Fitur Estimasi Pemesanan Custom Order

## Deskripsi
Fitur ini menambahkan estimasi waktu pengerjaan pada sistem custom order berdasarkan total kuantitas yang dipesan. Estimasi akan ditampilkan secara real-time kepada user sehingga mereka dapat mengetahui berapa lama pesanan mereka akan selesai.

## Implementasi

### 1. Database
- Menambahkan kolom `estimated_days` pada tabel `custom_orders`
- Migration: `2025_08_26_100000_add_estimated_days_to_custom_orders_table.php`

### 2. Model (CustomOrder.php)
- Method `calculateEstimatedDays($totalQuantity)` untuk menghitung estimasi berdasarkan kuantitas:
  - ≤ 12 pcs: 3 hari
  - 13-50 pcs: 5 hari  
  - 51-100 pcs: 7 hari
  - 101-200 pcs: 10 hari
  - > 200 pcs: 14 hari
- Method `getEstimatedCompletionDateAttribute()` untuk mendapatkan tanggal perkiraan selesai

### 3. Controller (UserCustomOrderController.php)
- Method `calculateEstimation()` API endpoint untuk menghitung estimasi real-time
- Update method `store()` untuk menyimpan estimasi saat membuat pesanan
- Method `getWorkingDaysInfo()` untuk memberikan informasi kategori pesanan

### 4. Routes
- Tambah route: `POST /api/calculate-estimation` untuk API estimasi

### 5. Frontend

#### Form Custom Order (index.blade.php)
- Tampilan estimasi real-time di sidebar ringkasan pesanan
- Update otomatis saat user mengubah kuantitas
- Tampilan estimasi di modal konfirmasi

#### History (history.blade.php)
- Kolom estimasi di tabel history
- Menampilkan jumlah hari dan tanggal perkiraan selesai

#### Detail (detail.blade.php)
- Card informasi estimasi lengkap dengan tanggal pesan dan perkiraan selesai
- Kategori informasi pesanan (cepat, standar, sedang, besar, jumbo)

#### Admin Panel (admin/customorder/index.blade.php)
- Kolom estimasi hari di DataTables
- Badge informasi untuk estimasi

## Cara Kerja

1. **Real-time Calculation**: Saat user mengisi kuantitas, sistem otomatis menghitung estimasi melalui AJAX
2. **Visual Feedback**: Estimasi ditampilkan dengan informasi tanggal dan kategori pesanan
3. **Database Storage**: Estimasi disimpan saat pesanan dibuat dan dapat digunakan untuk tracking
4. **Admin Visibility**: Admin dapat melihat estimasi untuk semua pesanan

## Kategori Estimasi

- **Pesanan Cepat** (≤3 hari): Untuk pesanan kecil hingga 12 pcs
- **Pesanan Standar** (≤5 hari): Untuk pesanan menengah 13-50 pcs
- **Pesanan Sedang** (≤7 hari): Untuk pesanan 51-100 pcs
- **Pesanan Besar** (≤10 hari): Untuk pesanan 101-200 pcs
- **Pesanan Jumbo** (≤14 hari): Untuk pesanan besar > 200 pcs

## Manfaat

1. **User Experience**: User dapat mengetahui kapan pesanan mereka selesai
2. **Transparansi**: Sistem memberikan informasi yang jelas tentang waktu pengerjaan
3. **Planning**: User dapat merencanakan kebutuhan mereka berdasarkan estimasi
4. **Admin Management**: Admin dapat menggunakan estimasi untuk manajemen produksi
5. **Customer Satisfaction**: Mengurangi pertanyaan berulang tentang status pesanan
