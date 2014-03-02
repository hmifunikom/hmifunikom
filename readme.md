# Website Sistem Informasi HMIF

## Overview

Website ini menggunakan framework [Laravel](http://laravel.com/docs/quick) untuk mempermudah agar tidak membuat corenya dari awal. Sengaja tidak menggunakan wordpress/joomla agar bisa dicustom secara menyeluruh. Karena github tidak ada free private repo, maka terpaksa menggunakan bitbucket.

**version 1.01**

Frontend :

- Homepage
- List acara per bulan
- Pesan tiket 

Backend :

- Keanggotaan
    - Kas
    - No. Handphone
    - Email
- Acara
    - Deksripsi acara
    - Waktu acara
    - Peserta acara

## Contribute

Untuk berkontribusi, silahkan install terlebih dahulu Git di dalam komputer : 

1. Install [composer](https://getcomposer.org/Composer-Setup.exe).
2. Clone repo dari bitbucket.
3. Jalankan perintah `composer install` lalu `composer update`.
4. Import database DATABASE.sql ke mysql, bisa melalui phpmyadmin.
5. Set settingan database pada file : `app/config/database.php` pada line 55.
6. Buka web melalui localhost `http://localhost/folderwebhmif/public` dan untuk panel `http://localhost/folderwebhmif/public/panel`.
7. Login dengan menggunakan username `admin` dan password `password`.

**Requirements: PHP 5.37, Apache(mod-rewrite enabled)**

## Library

Selain Laravel, website ini juga menggunakan beberapa library package dari [Packagist](http://packagist.org) : 

- [Laravel 4](http://laravel.com/docs/quick)
- [Laravel 4 Artisan Generator](https://github.com/JeffreyWay/Laravel-4-Generators)
- [Ardent - Self validating ORM](https://github.com/laravelbook/ardent)
- [Former - Bootstrap form builder](https://github.com/Anahkiasen/former)
- [Boostrapper - HTML Bootstrap tags generator](https://github.com/patricktalmadge/bootstrapper)
- [Gravatar](https://github.com/thomaswelton/laravel-gravatar)
- [Asset Management PHP](https://github.com/kriswallsmith/assetic)
- [Imagine - PHP Image Manipulation Library](https://github.com/Intervention/image)
- [Laravel Log Viewer](https://github.com/mikemand/logviewer)
- [Laravel Authorization System](https://github.com/machuga/authority-l4)
- [Easy Slug Generator for Laravel Eloquent](https://github.com/cviebrock/eloquent-sluggable)
- [Parsedown - PHP Markdown Parser](https://github.com/erusev/parsedown)
- [PHP QRCode Generator](https://github.com/endroid/QrCode)
- [vCard Manipulator (Belum diimplementasi untuk generate kontak keanggotaan ke file .vcf)](https://github.com/fruux/sabre-vobject)

## Todos

- Fix tiket acara versi print
- Profile keanggotaan
- Gallery acara
- Integrasi keanggotaan dan acara (kepanitiaan)
- Generate contact anggota ke file .vcf
- Integrasi dengan sistem desktop perpus IF
- IF Center
- Arsip HMIF