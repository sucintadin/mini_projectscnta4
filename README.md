# 🌿 Garden Bloom — Botanical & Nursery Inventory Management System

> **Mini Project Pertemuan 5: Laravel CRUD Fundamental & Arsitektur MVC**  
> Tema: **Garden Bloom (Toko Tanaman Hias, Sukulen, Bonsai, & Produk Nursery)**

Aplikasi manajemen inventaris tanaman berbasis framework **Laravel** yang menerapkan standar arsitektur **Model-View-Controller (MVC)**, operasi **CRUD (Create, Read, Update, Delete)** lengkap menggunakan Resource Controller, validasi data bersisi server, relasi database Eloquent (`Category hasMany Product`), migrasi, seeder dengan data uji realistis, pagination dengan persistensi query string, serta penerapan aturan bisnis stok (*Stock Management & Low-Stock Alerts*).

---

## 📋 Checklist Penilaian Pertemuan 5

| Komponen Penilaian | Bobot | Status | Bukti Implementasi |
| :--- | :---: | :---: | :--- |
| **Environment dan konfigurasi** | 10% | ✅ Selesai | File `.env` terkonfigurasi (SQLite/MySQL), APP_KEY aktif, PHP 8.2 & Composer siap |
| **Pemahaman MVC dan alur request** | 15% | ✅ Selesai | Alur jelas: `Request ➔ Route ➔ Controller ➔ Model ➔ DB ➔ Response (Blade)` |
| **Routing dan controller** | 15% | ✅ Selesai | `Route::resource('products')`, `CategoryController`, `DashboardController`, `route:list` rapi |
| **Blade dan form** | 15% | ✅ Selesai | Layout master (`layouts/app.blade.php`), `@csrf`, `@method`, escaping `{{ }}`, pesan error `@error` |
| **Migration, model, seeder** | 15% | ✅ Selesai | Migrasi `categories` & `products` dengan FK, Seeder 6 kategori & 17+ varietas tanaman |
| **Eloquent dan relationship** | 15% | ✅ Selesai | `Category hasMany Product` & `Product belongsTo Category`, eager loading `with('category')` |
| **Migrasi fitur Inventory P4** | 15% | ✅ Selesai | Business rule stok (aman, menipis, habis), validasi harga/stok non-negatif, aksi quick restock |

---

## 🏛️ Arsitektur MVC & Siklus Alur Request

Aplikasi ini mengimplementasikan pemisahan tanggung jawab (*Separation of Concerns*) sesuai pola MVC:

```
                      +-------------------+
                      |   Client Browser  |
                      +-------------------+
                                | 1. HTTP Request (GET/POST/PUT/DELETE)
                                v
                      +-------------------+
                      |  routes/web.php   | (Routing)
                      +-------------------+
                                | 2. Menjalankan Action Controller yang Sesuai
                                v
               +----------------------------------+
               | Controllers                      | (Business Logic & Flow)
               | (ProductController, Dashboard,   |
               |  CategoryController)             |
               +----------------------------------+
                     |                     ^
    3. Query/Simpan  |                     | 4. Data Collection / Status
                     v                     |
           +--------------------+          |
           | Models (Eloquent)  |----------+
           | (Product, Category)|
           +--------------------+
                     |
    Interaksi Database (SQLite / MariaDB)
                     v
           +--------------------+
           |  Database Storage  |
           +--------------------+
                     |
     5. Pass Data ke Blade View Template
                     v
           +----------------------------------+
           | Views (Blade Templates)          | (User Interface & HTML)
           | - layouts/app.blade.php          |
           | - products/index, create, show   |
           +----------------------------------+
                     | 6. HTTP Response (Rendered HTML)
                     v
              +--------------+
              | User Display |
              +--------------+
```

### Penjelasan Tahapan Alur Request:
1. **Request**: Pengguna mengirim permintaan HTTP melalui browser (misalnya: menekan tombol `Simpan Tanaman` pada form create).
2. **Route**: `routes/web.php` menangkap request dan mencocokkan method & URL dengan Controller yang bertugas (contoh: `POST /products` ➔ `ProductController@store`).
3. **Controller**: Menerima request, memproses validasi keamanan (`@csrf` token, aturan `required`, `numeric >= 0`, `unique:sku`), dan menyiapkan data.
4. **Model (Eloquent)**: Controller memanggil Eloquent Model (`Product::create($validated)`), Model melakukan query SQL ke database penyimpanan.
5. **Database**: Menyimpan record baru atau mengambil data yang diminta.
6. **Response**: Controller mengarahkan pengguna (*Redirect*) dengan session flash message (`with('success', ...)`), Blade me-render template HTML dengan data terbaru ke layar browser pengguna.

---

## 🚀 Panduan Instalasi & Menjalankan Project

Ikuti langkah mudah berikut untuk menjalankan project ini di komputer lokal:

### 1. Masuk ke Direktori Project
```powershell
cd c:\Users\USER\OneDrive\Documents\mini_projectscnta4
```

### 2. Konfigurasi Environment (`.env`)
Pastikan file `.env` sudah ada. Jika belum, salin dari `.env.example`:
```powershell
cp .env.example .env
php artisan key:generate
```
*Catatan: Konfigurasi default menggunakan SQLite yang langsung bekerja tanpa perlu menjalankan MySQL XAMPP (`DB_CONNECTION=sqlite`).*

### 3. Jalankan Database Migration & Seeder
Perintah ini akan membuat semua tabel dari database kosong dan mengisinya dengan data uji botani:
```powershell
php artisan migrate:fresh --seed
```

### 4. Jalankan Server Lokal Laravel
```powershell
php artisan serve
```

Aplikasi siap diakses pada browser melalui URL:  
👉 **`http://127.0.0.1:8000`** atau **`http://localhost:8000`**

---

## 🧪 Demonstrasi Alur Lengkap CRUD (Tugas Pertemuan)

Sesuai instruksi deliverable, berikut alur lengkap pengujian fitur:

### 1. Membuka Form (`GET /products/create`)
- Klik menu **"Tambah Tanaman"** pada navbar atas atau tombol di dashboard.
- Halaman menampilkan form penambahan tanaman dengan token `@csrf` terpasang otomatis dan dropdown kategori terisi dari database.

### 2. Validasi Data Masukan
- Coba tekan tombol **"Simpan Tanaman Baru"** tanpa mengisi data, atau masukkan angka negatif pada stok/harga.
- **Hasil**: Sistem menolak input, tidak menyimpan data ke database, mengembalikan pesan kesalahan ramah (*error alert*) per kolom:
  - *Nama tanaman atau produk wajib diisi.*
  - *Kode SKU produk wajib diisi.*
  - *Harga tidak boleh bernilai negatif.*
  - *Stok tidak boleh kurang dari 0.*

### 3. Simpan Data Baru (`POST /products`)
- Isi form dengan data tanaman baru:
  - **Nama Tanaman**: `Bonsai Sakura Haruno`
  - **Nama Ilmiah**: `Prunus serrulata`
  - **Kategori**: `Bonsai & Tanaman Kayu Eksotis`
  - **SKU**: `GB-BON-077`
  - **Harga**: `850000`
  - **Stok Awal**: `6`
  - **Batas Minimum Stok**: `2`
  - **Kebutuhan Cahaya**: `Matahari Penuh Terik`
  - **Jadwal Siram**: `1-2 Hari Sekali`
  - **URL Foto**: `https://images.unsplash.com/photo-1522383225653-ed111181a951?auto=format&fit=crop&w=600&q=80`
  - **Deskripsi**: `Bonsai bunga sakura mekar elegan bernuansa musim semi Jepang.`
- Tekan tombol **"Simpan Tanaman Baru"**.

### 4. Redirect & Notifikasi Sukses
- Sistem melakukan redirect otomatis ke **`GET /products`** dengan status HTTP 302.
- Muncul banner hijau flash alert:  
  *“Tanaman 'Bonsai Sakura Haruno' berhasil ditambahkan ke inventaris Garden Bloom!”*

### 5. Tampilkan Data (Pencarian & Filtering)
- Tanaman baru langsung muncul pada katalog.
- Fitur pencarian live (`?search=Sakura`) akan menampilkan tanaman tersebut.
- Parameter filter tetap dipertahankan pada link pagination melalui method `->withQueryString()`.

### 6. Detail, Ubah Data & Hapus
- **Lihat Detail (`GET /products/{id}`)**: Menampilkan profil lengkap botani, panduan cahaya & air, nilai valuasi aset, serta widget quick restock.
- **Ubah Data (`GET /products/{id}/edit` & `PUT`)**: Mengubah stok atau harga dengan data form yang otomatis terisi data lama (`old()`).
- **Hapus Data (`DELETE /products/{id}`)**: Modal konfirmasi pop-up yang aman untuk mencegah penghapusan tanaman yang tidak disengaja.

---

## 📦 Business Rule Stok (Fitur Inventori P4)

1. **Status Ketersediaan Real-Time**:
   - 🟢 **Stok Tersedia**: Jumlah stok fisik berada di atas batas minimum (`stock > min_stock`).
   - 🟡 **Stok Menipis**: Jumlah stok berada di batas minimum atau di bawahnya (`stock <= min_stock && stock > 0`).
   - 🔴 **Stok Habis**: Jumlah persediaan telah mencapai `0`.
2. **Proteksi Angka Non-Negatif**:
   - Stok fisik maupun harga tidak dapat disetel ke nilai negatif baik melalui form create, update, maupun quick adjust.
3. **Quick Restock & Adjustment**:
   - Tombol `-1` (pengurangan stok terjual), `+1`, dan `+5` / `+10` (restock batch) dapat dieksekusi instan langsung dari tabel katalog atau detail tanaman.

---

## 🛣️ Daftar Rute Aplikasi (`php artisan route:list`)

```
Method       URI                       Nama Route              Controller & Action
----------------------------------------------------------------------------------------------------
GET|HEAD     /                         dashboard               DashboardController@index
GET|HEAD     products                  products.index          ProductController@index
POST         products                  products.store          ProductController@store
GET|HEAD     products/create           products.create         ProductController@create
GET|HEAD     products/{product}        products.show           ProductController@show
PUT|PATCH    products/{product}        products.update         ProductController@update
DELETE       products/{product}        products.destroy        ProductController@destroy
GET|HEAD     products/{product}/edit   products.edit           ProductController@edit
PATCH        products/{product}/stock  products.update-stock   ProductController@updateStock
GET|HEAD     categories                categories.index        CategoryController@index
POST         categories                categories.store        CategoryController@store
GET|HEAD     categories/create         categories.create       CategoryController@create
GET|HEAD     categories/{category}     categories.show         CategoryController@show
PUT|PATCH    categories/{category}     categories.update       CategoryController@update
DELETE       categories/{category}     categories.destroy      CategoryController@destroy
GET|HEAD     categories/{category}/edit categories.edit       CategoryController@edit
```

---

## 🧪 Pengujian Otomatis (Automated Tests)

Semua fungsionalitas CRUD telah diuji menggunakan PHPUnit / Pest:
```powershell
php artisan test --filter=GardenBloomCrudTest
```

**Hasil Pengujian:**
```
PASS  Tests\Feature\GardenBloomCrudTest
✓ dashboard displays correctly
✓ product index and search
✓ create form displays categories
✓ product store validation errors
✓ product can be created successfully
✓ product show view
✓ product can be updated
✓ product can be deleted
✓ stock adjustment prevents negative stock

Tests:    9 passed (34 assertions)
Duration: 1.10s
```

---
*Garden Bloom Nursery Inventory Management System — Dibuat untuk memenuhi seluruh kriteria evaluasi praktikum Laravel Fundamental (Pertemuan 5).*
