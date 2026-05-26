# DOKUMEN AUDIT KODE KEAMANAN (GOD-MODE EDITION - 40 VULNERABILITIES)
## JastGo (JastipLocal4)

Dokumen ini adalah hasil akhir penyisiran keamanan paling brutal (*Deep Dive Audit*) dari 100% struktur kode JastGo. Ditemukan **40 kerentanan (vulnerability)** dari berbagai level keparahan yang membuat aplikasi ini sepenuhnya bisa dikuasai, dirusak, atau dieksploitasi oleh *Hacker*. 

---

### KELOMPOK I: CELAH KEAMANAN KRITIS (SERVER & DATABASE TAKEOVER)
1. **Remote Code Execution (RCE) via File Upload**: `ProfileController` tidak mengganti ekstensi asli. Hacker bisa mengupload Web Shell `.php`.
2. **Account Takeover via Password Reset**: Sistem mereset *password* tanpa memverifikasi tautan ke email asli. Akun siapapun bisa dibajak.
3. **Privilege Escalation via Mass Assignment**: Kolom `role` bisa diisi. User biasa bisa memanipulasi *Request HTTP* untuk menjadi Admin.
4. **Stored XSS pada Notifikasi**: Sintaks `{!! !!}` merender script virus secara mentah. Hacker bisa mencuri *Cookie* Admin.
5. **Stored XSS via SVG Image**: Aturan validasi `image` mengizinkan format `.svg` yang bisa ditanami virus JavaScript.
6. **Broken Access Control (Kudeta Admin)**: Admin tingkat bawah bebas menghapus atau mengedit data *SuperAdmin*/Pemilik.

---

### KELOMPOK II: CELAH ROUTING & MIDDLEWARE (ROUTING FLAWS)
7. **Missing Middleware Auth (Fatal Error DoS)**: Rute `notifikasi/read-all` ada di luar pelindung `auth`. Pengunjung anonim bisa membuat server *Crash 500*.
8. **GET-Based CSRF (Penghancuran Sesi)**: Rute `/finish` yang menghapus keranjang memakai metode HTTP `GET`. Tautan gambar `<img src="/finish">` bisa menghancurkan sesi korban secara diam-diam.
9. **Route Name Collision**: Dua rute berbeda bernama `notifikasi.destroy`. Menyebabkan *Routing Bypass* internal Laravel.
10. **Functional Crash on Kategori**: Nama rute di `web.php` (`kategori.index`) tidak sesuai dengan Controller (`kategori-barang.index`). Aplikasi akan `Error 500` saat Admin menambah kategori.

---

### KELOMPOK III: MANIPULASI LOGIKA BISNIS (TRANSACTION THEFT)
11. **IDOR pada Upload Bukti Transfer**: Sistem tidak memvalidasi pesanan milik siapa. Orang bisa mengirim bukti transfer palsu ke pesanan pengguna lain untuk menyabotase mereka.
12. **Privilege Escalation Data Pesanan**: Jastiper diizinkan mengubah `total_harga` dan `alamat_pengiriman` dari pesanan yang sudah dibuat pembeli!
13. **Overselling (Manipulasi Stok Minus)**: Sistem tidak me-lock ketersediaan stok di keranjang. 100 orang bisa check-out barang sisa 1 secara bersamaan.
14. **Double Payout (Race Condition)**: Admin yang nge-lag dan menekan ganda pencairan dana akan mentransfer dana 2x lipat ke Jastiper.
15. **Bypass Validasi Barang**: Beranda lupa memfilter `status_validasi = DISETUJUI`. Barang ilegal/fiktif langsung bebas tayang ke publik.
16. **Penggantian Password Tanpa "Old-Password"**: Form ganti password tidak menanyakan *Password Lama*. Sangat rawan pembajakan perangkat.
17. **Cacat Logika Fitur Rekening Admin**: Filter `where('user_id', Auth::id())` di `RekeningController` membuat Admin hanya bisa melihat rekeningnya sendiri, mengunci fitur manajemen Jastiper.
18. **Cacat Integritas Sejarah Transaksi**: Barang yang dihapus sementara (*Soft Delete*) akan menghapus gambar aslinya secara permanen, merusak riwayat transaksi pembeli.
19. **Race Condition Persetujuan Pembayaran**: Karena stok baru dikurangi saat Admin mengeklik "Konfirmasi", orang yang membayar pertama bisa kalah cepat mendapatkan barang jika Admin mengeklik pesanan orang lain duluan.
20. **Salami Attack (Cacat Presisi Potongan Admin)**: Kalkulasi diskon 5% menggunakan pembagian yang tidak dibulatkan secara aman, menyebabkan hilangnya uang recehan di kas perusahaan ribuan kali.

---

### KELOMPOK IV: DENIAL OF SERVICE (SERANGAN BIKIN WEB DOWN)
21. **Database Exhaustion (Pesanan Bodong)**: Tanpa *Rate Limit*, bot bisa memproduksi jutaan *Checkout* sampah dalam sejam, mematikan database.
22. **Disk Storage Exhaustion (Server Penuh)**: Hacker bebas mengupload jutaan gambar "Bukti Transfer" ke pesanan fiktif, menyedot 100% *Harddisk Server*.
23. **Session Memory Exhaustion (Spam Keranjang)**: Menyuntikkan 100.000 ID Barang ke *Keranjang Session* menghabiskan memori RAM Server seketika.
24. **Unrestricted Registration (Bot Spam Akun)**: Form pendaftaran tanpa CAPTCHA akan membanjiri database JastGo dengan ribuan akun fiktif.
25. **Unrestricted Search (Regex DoS)**: Teks pencarian berkarakter liar `%%%%%%%%` membuat CPU Database `MySQL` macet dan kepanasan (Overload).
26. **Numeric Overflow DoS**: Validasi harga menerima input angka raksasa `1e30`. Aplikasi akan meledak saat menyimpan angka ini ke *Database*.
27. **Missing Pagination Limits**: Mengambil ratusan data statis `User::limit(200)` sekaligus di halaman edit pesanan membuat browser komputer menjadi membeku (*Hang/Freeze*).
28. **Missing Rate-Limiting on File Uploads**: Hacker dapat menekan tombol upload "Bukti TF" ribuan kali pada satu pesanan, menduplikasi ribuan baris `AlurDana` sekaligus.
29. **Spamming API pada JastiperFollow**: Tidak ada jeda detik untuk menekan "Follow Jastiper", menyebabkan bot bisa melakukan klik 1.000 kali per detik.
30. **No Session Timeout Invalidation**: Sesi pengguna tidak terhapus otomatis walau peran mereka diganti dari User ke Jastiper, menimbulkan tabrakan logika di halaman *Dashboard*.

---

### KELOMPOK V: KEBOCORAN PRIVASI & IDENTITAS (INFORMATION EXPOSURE)
31. **Detailed Error Disclosure**: Pesan galat memunculkan nama tabel dan Query SQL. Hacker mendapatkan peta *Database* JastGo secara gratis.
32. **Email Enumeration (Memanen Data Target)**: Form "Lupa Sandi" terang-terangan membocorkan mana email yang "Aktif" dan mana yang "Tidak".
33. **Impersonasi Identitas Pribadi**: Sistem pendaftaran tidak meminta klik tautan verifikasi email. Hacker mendaftar dengan akun email sembarang orang.
34. **Kebijakan Password Lemah**: Password tidak mensyaratkan huruf kapital atau simbol. Diretas seketika dengan *Dictionary Attack*.
35. **Sensitive Data in Plain Text**: Nomor rekening Bank tercatat tanpa enkripsi. Jika Database dicuri, semua data perbankan Jastiper bocor ke internet.
36. **IDOR on File Access (Kebocoran Transaksi)**: Foto Bukti Transfer tersimpan di URL publik. Siapapun yang menebak nama filenya bisa melihat transaksi keuangan orang lain tanpa izin.
37. **Missing Security Headers**: Aplikasi tidak memasang `X-Frame-Options`, membiarkan *Hacker* memasang web JastGo di dalam iFrame penipuan (*Clickjacking*).
38. **Insecure Cookie Configuration**: *Session Cookie* tidak mengaktifkan bendera `Secure` dan `HttpOnly`, sangat mudah disadap di jaringan Wi-Fi Publik.
39. **Information Leak via Soft Delete Relations**: Menghapus `User` (Jastiper) menggunakan *Soft Delete* akan memicu `Fatal Error 500` saat pembeli mencoba melihat riwayat pesanan (Karena mencoba mengakses nama dari *null object*).
40. **No 2FA on Admin Panel**: Gerbang kontrol utama (Admin) hanya dilindungi satu lapis password standar tanpa fitur verifikasi 2 Langkah, menjadikannya sasaran empuk para peretas tingkat lanjut.
