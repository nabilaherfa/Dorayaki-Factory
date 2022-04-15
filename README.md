# Milestone 1: Monolithic Web Application
> Tugas Besar 1 IF3110 Pengembangan Aplikasi Berbasis Web

## Table of Contents
- [Description](#description)
- [Requirements](#requirements)
- [Installation](#installation)
- [How to Run Server](#how-to-run-server)
- [Screenshots](#screenshots)

## Description
Doremonangis, robot dari masa depan sedang mencoba untuk membuka suatu bisnis waralaba pada bidang F&B, yaitu membuat dorayaki kekinian (rasa pempek, rasa KFC, rasa nasi padang, dan lain-lain) di tahun 2021 ini. Mobita, teman baiknya membantunya untuk mendirikan usaha dorayakinya dengan menjadi Co-Founder sekaligus CTO dari usaha Doremonangis yang bernama “Stand with Dorayaki”.

Selaku CTO, Mobita tentu dipekerjakan oleh Doremonangis untuk membuat sebuah sistem untuk memanajemen tokonya. Akan tetapi, karena Mobita adalah anak yang pemalas, toko Doremonangis sudah memiliki banyak cabang di berbagai tempat. Sehingga, sistem yang dibuat harus menyesuaikan kebutuhan bisnis dari tokonya, apalagi sekarang banyak toko yang mulai kehabisan stok Dorayaki rasa pempek!

Sistem yang dibuat adalah sebuah sistem informasi yang digunakan untuk melakukan manajemen/pengelolaan stok. Sistem dapat diakses oleh user maupun admin. Admin dapat melakukan pengelolaan dorayaki dengan menambahkan/menghapus varian dorayaki dan menambahkan stok dorayaki. Sedangkan, user dapat melihat varian dorayaki dan membeli varian dorayaki yang ada.

## Requirements
- XAMPP
- PHP
- HTML
- SQLite3
- JavaScript
- CSS

## Installation
1. Install XAMPP (if not yet installed) [here](https://www.apachefriends.org/index.html).
2. Make changes to `php.ini` by uncommenting the following lines:
    ```
    extension_dir = "<php installation directory>/php-7.4.3/ext"
    extension=pdo_sqlite
    extension=sqlite3
    sqlite3.extension_dir = "<php installation directory>/php-7.4.3/ext"
    ```

## How to Run Server
1. Copy `src` folder to `<XAMPP installation directory>/htdocs` (default: `C:/xampp/htdocs`)
2. Run XAMPP
3. Start Apache server
4. Open `localhost/src/login.php` on your browser

## Screenshots
![Dashboard](/screenshots/dashboard.png)
![Detail](/screenshots/detail.png)
![Hapus Dorayaki](/screenshots/hapusdorayaki.png)
![Login](/screenshots/login.png)
![Pembelian](/screenshots/pembelian1.png)
![Register](/screenshots/register.png)
![Riwayat](/screenshots/riwayat.png)
![Searching](/screenshots/searching.png)
![Penambahan](/screenshots/penambahan.jpg)

