# BimaSky - Aplikasi Marketplace Satelit

## Tentang Aplikasi

BimaSky adalah aplikasi marketplace untuk layanan satelit yang memungkinkan pelanggan untuk melihat, memesan, dan mengelola layanan satelit.

## Struktur Aplikasi

Aplikasi ini menggunakan pola MVC (Model-View-Controller) untuk memisahkan logika bisnis, tampilan, dan alur aplikasi.

- **Model**: Menangani logika bisnis dan interaksi dengan database
- **View**: Menangani tampilan dan presentasi data
- **Controller**: Menangani alur aplikasi dan menghubungkan model dengan view

## URL Bersih

Aplikasi ini menggunakan URL bersih tanpa ekstensi `.php`. Berikut adalah contoh URL:

- `http://localhost/mala/home` (bukan `http://localhost/mala/home.php`)
- `http://localhost/mala/produk` (bukan `http://localhost/mala/produk.php`)
- `http://localhost/mala/detail.produk/1` (bukan `http://localhost/mala/detail.produk.php?id=1`)

## Penggunaan UrlHelper

Untuk memastikan URL yang dihasilkan konsisten dan bersih, gunakan class `UrlHelper` yang telah disediakan. Berikut adalah contoh penggunaan:

```php
// Impor UrlHelper
require_once __DIR__ . '/../helpers/UrlHelper.php';

// Menghasilkan URL untuk halaman
$url = UrlHelper::url('home'); // Menghasilkan: /mala/home

// Menghasilkan URL dengan parameter
$url = UrlHelper::url('detail.produk', ['id' => 1]); // Menghasilkan: /mala/detail.produk/1

// Menghasilkan URL dengan multiple parameter
$url = UrlHelper::url('produk', ['kategori' => 'satelit', 'sort' => 'price']); // Menghasilkan: /mala/produk?kategori=satelit&sort=price

// Menghasilkan URL untuk asset
$cssUrl = UrlHelper::css('style.css'); // Menghasilkan: /mala/css/style.css
$jsUrl = UrlHelper::js('main.js'); // Menghasilkan: /mala/js/main.js
$imageUrl = UrlHelper::image('logo.png'); // Menghasilkan: /mala/assets/logo.png

// Redirect ke URL
UrlHelper::redirect('home'); // Redirect ke /mala/home
```

## Contoh Penggunaan di View

```php
<a href="<?= UrlHelper::url('home') ?>">Beranda</a>
<a href="<?= UrlHelper::url('produk') ?>">Produk</a>
<a href="<?= UrlHelper::url('detail.produk', ['id' => $product_id]) ?>">Detail Produk</a>
<img src="<?= UrlHelper::image('logo.png') ?>" alt="Logo">
<link rel="stylesheet" href="<?= UrlHelper::css('style.css') ?>">
<script src="<?= UrlHelper::js('main.js') ?>"></script>
```

## Catatan Penting

1. Jangan menggunakan ekstensi `.php` di URL
2. Gunakan `UrlHelper` untuk semua link di aplikasi
3. Jika perlu menambahkan parameter ke URL, gunakan array asosiatif sebagai parameter kedua di method `url()`
4. Untuk parameter `id`, URL akan dihasilkan dalam format `/mala/page/id` (bukan `/mala/page?id=id`)
5. Untuk parameter lain, URL akan dihasilkan dalam format `/mala/page?param=value`

## Keuntungan URL Bersih

1. **SEO-Friendly**: URL bersih lebih mudah diindeks oleh mesin pencari
2. **User-Friendly**: URL bersih lebih mudah dibaca dan diingat oleh pengguna
3. **Keamanan**: Menyembunyikan teknologi yang digunakan (PHP) dari URL
4. **Fleksibilitas**: Memungkinkan perubahan teknologi di belakang layar tanpa mengubah URL
5. **Profesional**: URL bersih memberikan kesan profesional pada aplikasi
