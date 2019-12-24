# SIPADU

## Deskripsi

SIPA (Sistem Informasi Penyimpanan Arsip) adalah aplikasi berbasis web yang digunakan untuk menyimpan arsip Jurusan Teknik Informatika Unesa secara digital.

SIPA merupakan project yang secara khusus dibuat untuk UAS Mata Kuliah Pemrograman Framework.

## Teknologi yang Digunakan

1. Bootstrap jQuery
2. Laravel
3. Vue Js
4. JWT (Json Web Token)
5. PostgreSQL

## Tutorial Setup

1. Pastikan sudah terinstall composer untuk menginstall dependecies Laravel. Ketik pada terminal :
    ```
    composer install
    ```

2. Pastikan sudah terinstall npm untuk menginstall dependecies Vue JS. Ketik pada terminal :
    ```
    npm install
    ```

3. Selanjutnya, buat duplikat file **.env.example** menjadi file **.env**. Bisa dengan cara manual atau dengan mengetik pada terminal :
    ```
    cp .env.example .env
    ```
   
4. Generate app key yang terenkripsi ke file **.env** dengan cara mengetik pada terminal :
    ```
    php artisan key:generate
    ```
   
5. Buat database baru, kosongan, tanpa isi.
   
6. Modifikasi *DB_HOST*, *DB_PORT*, *DB_DATABASE*, *DB_USERNAME*, dan *DB_PASSWORD* pada file **.env** sesuai database yang telah dibuat.
   
7. Migrasikan database dengan mengetik pada terminal :
    ```
    php artisan migrate
    ```
   
8. Jangan lupa lakukan symlink pada folder storage dengan mengetik pada terminal :
    ```
    php artisan Storage:link
    ```
    
9. Setelah itu program dapat dijalankan dengan mengetik pada terminal :
    ```
    php artisan serve
    ```
