
=======
# KomikPiece
=======
# 📚 KomikKu — Website Baca Komik Laravel

**KomikPiece** adalah aplikasi web berbasis Laravel yang memungkinkan pengguna untuk melihat, mencari, dan membaca komik. Pengguna dapat melakukan registrasi, login, mengakses dashboard pribadi, dan melihat populer komik.

---

## 🚀 Fitur Utama

- 🔍 Pencarian komik berdasarkan judul
- 📂 Tampilan daftar komik dengan gambar cover, rating, bahasa, dan chapter
- 👤 Sistem autentikasi (register, login, logout)
- 🛡️ Middleware `auth` dan `verified` untuk membatasi akses dashboard
- 📊 Dashboard dengan:
  - Status akun
  - Koleksi komik favorit
  - Riwayat bacaan
  - Komik populer

---

## 🛠️ Instalasi

### 1. Clone Repository 
- git clone https://github.com/LepangMbojo/KomikPiece.git

### 2. instal dependency
- composer install
- npm install
- npm run dev

### 3. Konfigurasi .env
- cp .env.example .env
- php artisan key:generate

### 4. Migrasi dan seed
- php artisan migrate:fresh --seed
- php artisan storage:link
  
### 5. Jalankan
- php artisan serve
