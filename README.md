<div align="center">
  <h1>🛒 JastGo - Backend (Laravel)</h1>
  <p>Sistem API & Web Admin untuk Aplikasi JastGo (Jasa Titip Go)</p>
</div>

---

## 📌 Deskripsi Proyek
**JastGo Backend** adalah sistem pusat (API & Admin Panel) yang mengatur seluruh manajemen data dari aplikasi **JastGo**. Dibangun menggunakan framework **Laravel**, sistem ini menangani autentikasi, manajemen pesanan Jastip, riwayat transaksi, hingga integrasi pembayaran pihak ketiga.

---

## 🛠️ Persyaratan Sistem (Prerequisites)
Sebelum menjalankan proyek ini, pastikan komputer/laptop Anda sudah memiliki:
- **PHP** >= 8.1
- **Composer** (Package Manager PHP)
- **MySQL / MariaDB** (Disarankan menggunakan **Laragon** atau **XAMPP**)
- **Git**

---

## 🚀 Panduan Instalasi (Step-by-Step)

Ikuti langkah-langkah di bawah ini untuk menjalankan backend JastGo secara lokal di laptop Anda:

### 1. Clone Repository
Buka terminal (Command Prompt / PowerShell / Git Bash) dan ketikkan perintah berikut:
```bash
git clone https://github.com/dicki1207/jastgo-backend.git
cd jastgo-backend
```

### 2. Install Dependensi (Packages)
Jalankan composer untuk menginstal semua *library* PHP yang dibutuhkan:
```bash
composer install
```

### 3. Konfigurasi Environment (.env)
Duplikat file pengaturan bawaan untuk membuat file `.env`:
```bash
cp .env.example .env
```
*(Untuk pengguna Windows CMD bisa memakai perintah: `copy .env.example .env`)*

Buka file `.env` di teks editor (misalnya VS Code) dan sesuaikan bagian **Database** dengan database di komputer Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jastiplocal
DB_USERNAME=root
DB_PASSWORD=  # (Kosongkan jika menggunakan XAMPP/Laragon bawaan)
```
> **Penting:** Pastikan Anda sudah membuat database kosong (misalnya bernama `jastiplocal`) di phpMyAdmin / HeidiSQL Anda.

### 4. Generate Application Key
Buat kunci enkripsi keamanan aplikasi:
```bash
php artisan key:generate
```

### 5. Migrasi Database & Seeder
Buat tabel-tabel di database secara otomatis beserta data awalnya (jika ada):
```bash
php artisan migrate --seed
```

### 6. Link Storage (Untuk Menampilkan Gambar)
Agar gambar profil dan produk bisa dimunculkan dan diakses secara publik, jalankan perintah ini:
```bash
php artisan storage:link
```

### 7. Jalankan Server Lokal
Nyalakan mesin server Laravel Anda:
```bash
php artisan serve
```
Voila! Backend Anda sekarang sudah hidup dan berjalan di `http://127.0.0.1:8000`.

---

## 🔗 Menghubungkan Backend ke Aplikasi Flutter
Saat Anda menjalankan **Aplikasi JastGo (Flutter)** di HP atau Emulator, HP tersebut tidak akan bisa membaca alamat `127.0.0.1`. 

Anda wajib mengubah **IP Address API** di kodingan Flutter Anda (file `api_service.dart`) menggunakan **IP Address WiFi** laptop Anda (contoh: `192.168.1.10:8000/api`). Pastikan laptop dan HP tersambung ke jaringan WiFi yang sama!

---
<div align="center">
  <i>Dibuat dengan ❤️ untuk proyek JastGo</i>
</div>
