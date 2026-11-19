# Janji
Saya Muhammad Dzaka Indrianto dengan NIM 2508755 mengerjakan Tugas Praktikum 8 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.


## 1. Struktur Repositori

```text
tp_mvc25/
├── project/                          # Kode sumber aplikasi web berbasis arsitektur MVC
│   ├── assets/                       # Aset statis lokal (Bootstrap 5, jQuery, Popper)
│   ├── config/                       # Konfigurasi & koneksi database PDO
│   ├── controllers/                  # Layer Controller (alur request & response)
│   ├── models/                       # Layer Model (logika data & query relasional)
│   ├── views/                        # Layer View (antarmuka pengguna & layout modular)
│   └── index.php                     # Front Controller (Router utama aplikasi)
├── dokumentasi/                      # Rekaman layar (screen record) demo aplikasi
├── tp_mvc25.sql                      # Skema basis data relasional (DDL) dan data awal (DML)
└── README.md                         # Dokumentasi desain program, alur sistem, dan panduan instalasi
```

---

## 2. Desain Program & Arsitektur MVC

Aplikasi memisahkan tanggung jawab kode ke dalam lapisan-lapisan terstruktur agar mudah dipelihara dan dikembangkan:

1. **Front Controller (`project/index.php`)**
   * Bertindak sebagai pintu masuk tunggal (*single entry point*) yang menerima parameter URL `?page=<entitas>&action=<aksi>` dan meneruskannya ke *Controller* yang relevan.
2. **Model (`project/models/`)**
   * Mengelola seluruh logika data dan interaksi langsung dengan basis data MySQL melalui kelas koneksi `Database` (`project/config/Database.php`).
   * Terdiri dari `BaseModel`, `Department`, `Lecturer`, dan `Course`.
3. **View (`project/views/`)**
   * Bertanggung jawab menyajikan antarmuka pengguna (UI) berbasis Bootstrap 5 tanpa mencampurkan logika query SQL di dalamnya.
   * Menggunakan layout modular (`layouts/header.php` dan `layouts/footer.php`) agar bilah navigasi dan notifikasi *flash message* konsisten di seluruh halaman.
4. **Controller (`project/controllers/`)**
   * Menjadi penghubung antara *View* dan *Model*: menerima input form (`GET`/`POST`), melakukan validasi serta sanitasi data, memanggil metode *Model*, mengatur pesan status (`$_SESSION['flash']`), dan menentukan *View* yang akan ditampilkan.

---

## 3. Desain Basis Data Relasional (`tp_mvc25`)

Database **`tp_mvc25`** terdiri dari 3 tabel yang saling berelasi:

```text
+-------------------+       1 : N       +-------------------+       1 : N       +-------------------+
|    departments    |------------------>|     lecturers     |------------------>|      courses      |
+-------------------+                   +-------------------+                   +-------------------+
| PK id             |                   | PK id             |                   | PK id             |
| UQ department_code|                   |    name           |                   | UQ course_code    |
|    department_name|                   | UQ nidn           |                   |    course_name    |
|    faculty        |                   | UQ email          |                   |    credits        |
|    office_location|                   |    phone          |                   |    semester       |
|    created_at     |                   |    join_date      |                   | FK lecturer_id    |
+-------------------+                   | FK department_id  |                   |    created_at     |
                                        |    created_at     |                   +-------------------+
                                        +-------------------+
```

### Rincian Tabel & Relasi
* **`departments`** *(Tabel Baru 1)*: Menyimpan data program studi/departemen (`id`, `department_code`, `department_name`, `faculty`, `office_location`).
* **`lecturers`** *(Tabel Utama)*: Menyimpan data dosen. Ditambahkan atribut `email` serta *Foreign Key* `department_id` yang merujuk ke `departments(id)` (`ON UPDATE CASCADE ON DELETE SET NULL`).
* **`courses`** *(Tabel Baru 2)*: Menyimpan data mata kuliah (`id`, `course_code`, `course_name`, `credits`, `semester`, `lecturer_id`) dengan *Foreign Key* `lecturer_id` yang merujuk ke `lecturers(id)` (`ON UPDATE CASCADE ON DELETE CASCADE`).

---

## 4. Alur Kerja Aplikasi (Request-Response Flow)

1. Pengguna mengakses `project/index.php` (misalnya `index.php?page=courses&action=index`).
2. `index.php` menginisialisasi koneksi `Database` (PDO) dan memanggil `CourseController::index()`.
3. `CourseController` memanggil metode `Course::getAll()` pada *Model* untuk mengambil data mata kuliah yang telah di-`JOIN` dengan tabel `lecturers` dan `departments`.
4. *Model* mengembalikan hasil query dalam bentuk *associative array* ke *Controller*.
5. `CourseController` memanggil `$this->render('courses/index', [...])` untuk menyisipkan data ke dalam *View* dan menampilkannya ke browser pengguna.
6. Saat pengguna melakukan aksi **Create**, **Update**, atau **Delete**, *Controller* memvalidasi data, mengeksekusi operasi pada *Model*, menyimpan notifikasi ke `$_SESSION['flash']`, lalu melakukan *redirect* kembali ke halaman daftar (*PRG Pattern — Post/Redirect/Get*).

---

## 6. Dokumentasi Hasil Program

Rekaman layar (*screen record*) yang mendemonstrasikan alur lengkap operasi **CRUD** pada seluruh entitas (**Lecturers**, **Departments**, dan **Courses**) beserta keterkaitan relasi antar-tabel tersimpan di dalam folder [`dokumentasi/`](./dokumentasi/).
