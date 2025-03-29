# Fansite PSS Sleman

Fansite PSS Sleman adalah platform komunitas yang dirancang dalam menyediakan informasi wikipedia klub, forum diskusi, serta toko merchandise bagi para suporter PSS Sleman.

## Fitur Utama
- **Wikipedia Klub**: Informasi mendalam mengenai sejarah dan profil PSS Sleman.
- **Forum Tanya Jawab**: Tempat berdiskusi dan berbagi informasi bagi suporter.
- **Merchandise Store**: Toko online untuk membeli produk resmi PSS Sleman.

## Teknologi yang Digunakan
- **Frontend**: HTML, CSS, JavaScript
- **Backend**: PHP
- **Database**: MySQL (phpMyAdmin)

## Struktur Folder
```
PSSFansite/
│── author/        # admin panel aktor author
│── components/    # komponen frontend
│── img/           # menghimpun gambar default
│── seller/        # admin panel aktor seller
│── slemania/      # tanpilan home
│── uploaded_img/  # menghimpun gambar yang diunggah aktor seller/author
│── pssfansite.sql # Database SQL
│── README.md      # Dokumentasi proyek
```

## Instalasi dan Penggunaan
### Persyaratan
Sebelum memulai instalasi, pastikan Anda memiliki:
- XAMPP (untuk menjalankan server lokal dan phpMyAdmin)
- Browser Web (Google Chrome, Mozilla Firefox, dll.)

### Langkah Instalasi
1. **Clone Repository**
   ```sh
   git clone https://github.com/Fariadeeb/PSSFansite.git
   cd PSSFansite
   ```
2. **Konfigurasi Database**
   - Jalankan XAMPP dan aktifkan Apache serta MySQL.
   - Buat database baru di phpMyAdmin dengan nama `pssfansite`.
   - Import file `pssfansite.sql` yang tersedia dalam repository.
   - Pastikan file connect.php sesuai dengan nama db pada phpmyadmin.
   - Buat dan tambah folder uploaded_img jikalau belum ada.

5. **Akses Aplikasi**
   - Buka browser dan akses `http://localhost/PSSFansite/slemania` untuk menampilkan tampilan slemania
   - Buka browser dan akses `http://localhost/PSSFansite/author` untuk menampilkan tampilan dashboard author
   - Buka browser dan akses `http://localhost/PSSFansite/seller` untuk menampilkan tampilan dashboard seller

