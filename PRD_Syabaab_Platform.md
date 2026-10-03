# Product Requirements Document (PRD)
## Syabaab Platform

---

| Atribut | Detail |
|---|---|
| **Nama Proyek** | Syabaab Platform |
| **Versi Dokumen** | v1.0.0 |
| **Tanggal** | 12 Juni 2026 |
| **Status** | Draft |
| **Tech Stack** | PHP Laravel, SQLite |
| **Bahasa Platform** | Bilingual (Bahasa Indonesia & English) |

---

## Daftar Isi

1. [Executive Summary](#1-executive-summary)
2. [Latar Belakang & Tujuan](#2-latar-belakang--tujuan)
3. [Stakeholders](#3-stakeholders)
4. [User Personas](#4-user-personas)
5. [Scope & Batasan](#5-scope--batasan)
6. [Arsitektur Sistem](#6-arsitektur-sistem)
7. [Fitur & Requirements](#7-fitur--requirements)
   - 7.1 [Modul Autentikasi & Manajemen Akun](#71-modul-autentikasi--manajemen-akun)
   - 7.2 [Modul LMS — Syabaab Creative Academy](#72-modul-lms--syabaab-creative-academy)
   - 7.3 [Landing Page — Syabaab Creative Agency](#73-landing-page--syabaab-creative-agency)
   - 7.4 [Sistem Pembayaran](#74-sistem-pembayaran)
   - 7.5 [Admin Panel](#75-admin-panel)
   - 7.6 [Leaderboard & Podium Prestasi](#76-leaderboard--podium-prestasi)
8. [Non-Functional Requirements](#8-non-functional-requirements)
9. [User Stories](#9-user-stories)
10. [Database Schema (ERD Overview)](#10-database-schema-erd-overview)
11. [Sitemap & Navigasi](#11-sitemap--navigasi)
12. [Timeline & Milestones (MVP)](#12-timeline--milestones-mvp)
13. [Risiko & Mitigasi](#13-risiko--mitigasi)
14. [Acceptance Criteria](#14-acceptance-criteria)
15. [Glosarium](#15-glosarium)

---

## 1. Executive Summary

Syabaab Platform adalah web platform terpadu berbasis PHP Laravel yang menggabungkan dua entitas utama dalam satu ekosistem digital:

- **Syabaab Creative Academy** — platform media pembelajaran (LMS) bagi komunitas kreatif yang menyediakan kelas desain grafis, fotografi & videografi, music & audio production, serta content writing/copywriting.
- **Syabaab Creative Agency** — landing page informatif untuk menampilkan portofolio, layanan, testimoni klien, dan formulir pengajuan proyek agensi kreatif.

Platform ini dirancang untuk melayani hingga **<100 pengguna aktif** pada tahun pertama dengan target pengembangan MVP dalam **1–2 bulan**, menggunakan **SQLite** sebagai database dan mendukung tampilan **bilingual (Indonesia & Inggris)**.

---

## 2. Latar Belakang & Tujuan

### 2.1 Latar Belakang

Komunitas kreatif membutuhkan wadah digital yang tidak hanya menyajikan konten pembelajaran berkualitas, tetapi juga memperkenalkan kapabilitas profesional agensi kepada calon klien. Saat ini, kedua kebutuhan tersebut belum tersedia dalam satu platform yang terintegrasi.

### 2.2 Tujuan Produk

| No | Tujuan | Indikator Keberhasilan |
|----|--------|------------------------|
| 1 | Menyediakan akses pembelajaran kreatif yang terstruktur | Minimal 5 kursus aktif berjalan di fase MVP |
| 2 | Memperkenalkan layanan agensi kepada calon klien | Form konsultasi menerima minimal 3 pengajuan/bulan |
| 3 | Monetisasi kelas & layanan agensi | Integrasi pembayaran transfer bank & QRIS aktif |
| 4 | Memotivasi peserta melalui sistem gamifikasi | Leaderboard aktif dengan minimal 10 entri peserta |
| 5 | Mempermudah pengelolaan konten oleh admin | Semua konten dapat dikelola melalui Admin Panel |

### 2.3 Problem Statement

- Tidak ada platform terpadu yang menggabungkan LMS dan landing page agensi kreatif.
- Proses pendaftaran kelas dan pembayaran masih manual dan tidak efisien.
- Peserta tidak memiliki motivasi berbasis data untuk meningkatkan performa belajar.
- Klien potensial tidak memiliki satu titik akses untuk menjelajahi portofolio dan mengajukan proyek.

---

## 3. Stakeholders

| Stakeholder | Peran | Keterlibatan |
|---|---|---|
| **Syabaab Creative Academy** | Penyedia konten pembelajaran | Mengelola kursus, instruktur, dan peserta |
| **Syabaab Creative Agency** | Pemilik halaman agensi | Mengelola portofolio, layanan, dan leads klien |
| **Tim Developer** | Pengembang platform | Membangun dan memelihara sistem |
| **Product Manager** | Pemilik produk | Mendefinisikan kebutuhan dan prioritas fitur |

---

## 4. User Personas

### 4.1 Siswa / Pelajar
> **Nama Persona:** Rizki, 22 tahun, mahasiswa desain  
> **Kebutuhan:** Mengakses materi kursus kapan saja, mengikuti quiz, mendapatkan sertifikat, dan melihat peringkatnya dibanding peserta lain.  
> **Pain Point:** Sulit menemukan kursus kreatif terjangkau dengan pengajar yang kompeten.

### 4.2 Instruktur / Mentor
> **Nama Persona:** Hana, 30 tahun, desainer grafis profesional  
> **Kebutuhan:** Mengupload modul video dan teks, membuat quiz, memantau progres siswa.  
> **Pain Point:** Platform LMS lain terlalu kompleks atau mahal untuk pengelolaan kelas skala kecil.

### 4.3 Admin Platform
> **Nama Persona:** Farhan, 28 tahun, tim Syabaab  
> **Kebutuhan:** Mengelola seluruh konten, pengguna, pembayaran, dan analitik dalam satu dashboard.  
> **Pain Point:** Harus menggunakan banyak tools terpisah untuk manajemen platform.

### 4.4 Klien Agensi
> **Nama Persona:** Budi, 40 tahun, pemilik bisnis UMKM  
> **Kebutuhan:** Melihat portofolio agensi, memahami layanan yang tersedia, dan mengajukan proyek secara mudah.  
> **Pain Point:** Sulit menemukan agensi kreatif lokal yang terpercaya dengan portofolio yang transparan.

### 4.5 Tamu / Pengunjung Umum
> **Nama Persona:** Sari, 19 tahun, pelajar SMA  
> **Kebutuhan:** Menjelajahi kursus yang tersedia sebelum mendaftar.  
> **Pain Point:** Tidak dapat melihat preview kursus sebelum melakukan registrasi.

---

## 5. Scope & Batasan

### 5.1 Dalam Scope (In Scope)

- Sistem autentikasi (register, login, lupa password)
- LMS lengkap: video, modul teks, quiz, sertifikat, leaderboard
- Model pembelajaran campuran (self-paced & cohort-based)
- Landing page agensi dengan portofolio, layanan, testimoni, blog, dan form konsultasi
- Sistem pembayaran manual (transfer bank & QRIS)
- Admin panel dengan CMS, analitik, role & permission, notifikasi email, dark mode
- Leaderboard & podium prestasi peserta (di LMS dan di halaman agensi)
- Dukungan bilingual (Indonesia & Inggris)
- Bidang kursus: Desain Grafis, Fotografi & Videografi, Music & Audio Production, Content Writing/Copywriting

### 5.2 Di Luar Scope (Out of Scope) — Fase 1

- Aplikasi mobile native (iOS/Android)
- Integrasi payment gateway otomatis (Midtrans/Xendit)
- Live streaming / webinar terintegrasi
- Forum diskusi komunitas
- Sistem afiliasi/referral
- Multi-tenancy (platform untuk lebih dari satu organisasi)

---

## 6. Arsitektur Sistem

### 6.1 Technology Stack

| Layer | Teknologi |
|---|---|
| **Backend** | PHP 8.x, Laravel 11.x |
| **Database** | SQLite |
| **Frontend** | Blade Template Engine, TailwindCSS, Alpine.js |
| **Media Storage** | Laravel Storage (local filesystem) |
| **Email** | Laravel Mail (SMTP / Mailtrap untuk dev) |
| **Authentication** | Laravel Breeze / Sanctum |
| **Session & Cache** | File-based (Laravel default) |

### 6.2 Struktur Modul Aplikasi

```
syabaab-platform/
├── Academy (LMS)
│   ├── Courses (Kursus)
│   ├── Modules (Modul: Video & Teks)
│   ├── Quizzes (Quiz & Ujian)
│   ├── Enrollments (Pendaftaran)
│   ├── Certificates (Sertifikat)
│   └── Leaderboard (Peringkat)
│
├── Agency (Landing Page)
│   ├── Portfolio
│   ├── Services
│   ├── Testimonials
│   ├── Blog
│   ├── Project Inquiry (Form Konsultasi)
│   └── Agency Leaderboard
│
├── Payment
│   ├── Orders
│   ├── Payment Confirmation
│   └── Invoices
│
└── Admin Panel
    ├── Dashboard Analytics
    ├── User Management
    ├── Content Management (CMS)
    ├── Role & Permission
    ├── Email Notification
    └── Settings (Dark Mode, Language)
```

---

## 7. Fitur & Requirements

### 7.1 Modul Autentikasi & Manajemen Akun

#### Functional Requirements

| ID | Fitur | Deskripsi | Prioritas |
|----|-------|-----------|-----------|
| AUTH-01 | Registrasi Akun | Pengguna mendaftar dengan nama, email, password | High |
| AUTH-02 | Login / Logout | Autentikasi dengan email & password | High |
| AUTH-03 | Lupa Password | Reset password via email | High |
| AUTH-04 | Profil Pengguna | Edit nama, foto profil, bio, preferensi bahasa | Medium |
| AUTH-05 | Role Management | Peran: Admin, Instruktur, Siswa, Tamu | High |
| AUTH-06 | Verifikasi Email | Konfirmasi email setelah registrasi | Medium |

#### Role & Permission Matrix

| Fitur | Admin | Instruktur | Siswa | Tamu |
|-------|-------|------------|-------|------|
| Kelola semua konten | ✅ | ❌ | ❌ | ❌ |
| Upload kursus | ✅ | ✅ | ❌ | ❌ |
| Akses materi kursus | ✅ | ✅ | ✅ | ❌ |
| Preview kursus | ✅ | ✅ | ✅ | ✅ |
| Mengikuti quiz | ✅ | ✅ | ✅ | ❌ |
| Lihat leaderboard | ✅ | ✅ | ✅ | ✅ |
| Akses admin panel | ✅ | ❌ | ❌ | ❌ |
| Form konsultasi agensi | ✅ | ✅ | ✅ | ✅ |

---

### 7.2 Modul LMS — Syabaab Creative Academy

#### 7.2.1 Manajemen Kursus

| ID | Fitur | Deskripsi | Prioritas |
|----|-------|-----------|-----------|
| LMS-01 | Daftar Kursus | Halaman katalog kursus dengan filter kategori & harga | High |
| LMS-02 | Detail Kursus | Preview kursus, deskripsi, instruktur, silabus, harga | High |
| LMS-03 | Kategori Kursus | Desain Grafis, Fotografi & Videografi, Music & Audio, Content Writing | High |
| LMS-04 | Pendaftaran Kursus | Siswa mendaftar kursus (berbayar/gratis) | High |
| LMS-05 | Model Pembelajaran | Self-paced dan Cohort-based (jadwal tetap) | High |
| LMS-06 | Progress Tracking | Persentase penyelesaian materi per kursus | Medium |

#### 7.2.2 Modul Konten

| ID | Fitur | Deskripsi | Prioritas |
|----|-------|-----------|-----------|
| LMS-07 | Video Pembelajaran | Upload & streaming video materi (format MP4) | High |
| LMS-08 | Modul Teks / Artikel | Konten teks dengan rich-text editor (Markdown/HTML) | High |
| LMS-09 | Urutan Modul | Instruktur menentukan urutan konten pembelajaran | Medium |
| LMS-10 | Akses Terkunci | Modul berikutnya terbuka setelah modul sebelumnya selesai | Medium |

#### 7.2.3 Quiz & Ujian

| ID | Fitur | Deskripsi | Prioritas |
|----|-------|-----------|-----------|
| LMS-11 | Buat Quiz | Instruktur membuat soal pilihan ganda/essay per modul | High |
| LMS-12 | Ikuti Quiz | Siswa mengerjakan quiz dengan batas waktu opsional | High |
| LMS-13 | Nilai Otomatis | Penilaian otomatis untuk soal pilihan ganda | High |
| LMS-14 | Riwayat Nilai | Siswa dapat melihat histori nilai quiz | Medium |
| LMS-15 | Batas Pengulangan | Admin/instruktur mengatur berapa kali quiz dapat diulang | Low |

#### 7.2.4 Sertifikat

| ID | Fitur | Deskripsi | Prioritas |
|----|-------|-----------|-----------|
| LMS-16 | Generate Sertifikat | Sertifikat otomatis setelah menyelesaikan seluruh modul & lulus quiz | High |
| LMS-17 | Download Sertifikat | Siswa mengunduh sertifikat dalam format PDF | High |
| LMS-18 | Verifikasi Sertifikat | URL unik untuk verifikasi keaslian sertifikat | Medium |

---

### 7.3 Landing Page — Syabaab Creative Agency

| ID | Fitur | Deskripsi | Prioritas |
|----|-------|-----------|-----------|
| AGN-01 | Hero Section | Headline, tagline, CTA utama agensi | High |
| AGN-02 | Daftar Layanan | Kartu layanan yang ditawarkan agensi (dengan ikon & deskripsi) | High |
| AGN-03 | Portfolio / Showcase | Galeri karya agensi, dapat difilter per kategori | High |
| AGN-04 | Testimoni Klien | Carousel testimoni dari klien yang pernah bekerja sama | High |
| AGN-05 | Blog / Artikel | Artikel kreatif yang dapat dikelola admin (CMS) | Medium |
| AGN-06 | Form Konsultasi | Form pengajuan proyek: nama, email, jenis layanan, deskripsi proyek | High |
| AGN-07 | About Agency | Sejarah, visi misi, dan nilai-nilai agensi | Medium |
| AGN-08 | Podium Prestasi | Menampilkan peserta terbaik Academy di halaman Agensi | Medium |
| AGN-09 | CTA ke Academy | Tombol/section yang mengarahkan pengunjung ke platform LMS | Low |

---

### 7.4 Sistem Pembayaran

| ID | Fitur | Deskripsi | Prioritas |
|----|-------|-----------|-----------|
| PAY-01 | Halaman Checkout | Ringkasan pesanan sebelum pembayaran | High |
| PAY-02 | Metode Transfer Bank | Menampilkan nomor rekening dan instruksi transfer | High |
| PAY-03 | Metode QRIS | Menampilkan QR Code statis untuk pembayaran | High |
| PAY-04 | Upload Bukti Bayar | Siswa/klien mengupload foto bukti pembayaran | High |
| PAY-05 | Konfirmasi Manual | Admin memverifikasi dan mengkonfirmasi pembayaran | High |
| PAY-06 | Invoice Otomatis | Sistem mengirim invoice PDF via email setelah konfirmasi | Medium |
| PAY-07 | Riwayat Transaksi | Pengguna melihat riwayat semua transaksi | Medium |
| PAY-08 | Status Pembayaran | Status: Pending → Diterima → Dikonfirmasi / Ditolak | High |

#### Alur Pembayaran

```
Pengguna pilih kursus/layanan
        ↓
Halaman Checkout (ringkasan order)
        ↓
Pilih metode: Transfer Bank / QRIS
        ↓
Upload bukti pembayaran
        ↓
Status: PENDING (menunggu verifikasi)
        ↓
Admin verifikasi bukti bayar
        ↓
Status: DIKONFIRMASI → akses kursus/layanan dibuka
        + Invoice dikirim via Email
```

---

### 7.5 Admin Panel

#### 7.5.1 Dashboard Analitik

| ID | Fitur | Deskripsi | Prioritas |
|----|-------|-----------|-----------|
| ADM-01 | Statistik Pengguna | Jumlah total siswa, instruktur, tamu aktif | High |
| ADM-02 | Statistik Kursus | Kursus terpopuler, tingkat penyelesaian | High |
| ADM-03 | Statistik Pendapatan | Total pendapatan, transaksi pending, grafik per bulan | High |
| ADM-04 | Statistik Leads Agensi | Jumlah form konsultasi masuk per bulan | Medium |

#### 7.5.2 Content Management System (CMS)

| ID | Fitur | Deskripsi | Prioritas |
|----|-------|-----------|-----------|
| ADM-05 | Kelola Kursus | CRUD kursus, kategori, modul, quiz | High |
| ADM-06 | Kelola Halaman Agensi | CRUD portfolio, layanan, testimoni, blog | High |
| ADM-07 | Kelola Pengguna | Lihat, edit, suspend, hapus akun pengguna | High |
| ADM-08 | Kelola Pembayaran | Verifikasi, konfirmasi, tolak transaksi | High |
| ADM-09 | Kelola Sertifikat | Template sertifikat, lihat sertifikat yang diterbitkan | Medium |

#### 7.5.3 Notifikasi Email Otomatis

| ID | Trigger | Penerima | Prioritas |
|----|---------|----------|-----------|
| NOT-01 | Registrasi berhasil | Pengguna baru | High |
| NOT-02 | Verifikasi email | Pengguna baru | High |
| NOT-03 | Pembayaran diterima / dikonfirmasi | Siswa / Klien | High |
| NOT-04 | Pembayaran ditolak | Siswa / Klien | High |
| NOT-05 | Sertifikat tersedia | Siswa | Medium |
| NOT-06 | Form konsultasi masuk | Admin & Klien | Medium |
| NOT-07 | Pengumuman kelas baru | Siswa terdaftar | Low |

#### 7.5.4 Pengaturan Tampilan

| ID | Fitur | Deskripsi | Prioritas |
|----|-------|-----------|-----------|
| ADM-10 | Dark Mode | Toggle dark/light mode untuk admin dan pengguna | Medium |
| ADM-11 | Pilihan Bahasa | Switcher bahasa Indonesia / Inggris di semua halaman | High |
| ADM-12 | Role & Permission | Admin mengatur hak akses per peran pengguna | High |

---

### 7.6 Leaderboard & Podium Prestasi

| ID | Fitur | Deskripsi | Prioritas |
|----|-------|-----------|-----------|
| LDR-01 | Perhitungan Poin | Poin dihitung berdasarkan: nilai quiz, jumlah kursus selesai, kecepatan penyelesaian | High |
| LDR-02 | Leaderboard Global | Peringkat semua siswa aktif di seluruh kursus | High |
| LDR-03 | Leaderboard Per Kursus | Peringkat siswa dalam satu kursus tertentu | Medium |
| LDR-04 | Podium Top 3 | Tampilan visual podium (🥇🥈🥉) untuk 3 peserta terbaik | High |
| LDR-05 | Leaderboard di Agensi | Menampilkan podium prestasi di landing page agensi | Medium |
| LDR-06 | Badge / Label | Label "Top Performer" untuk siswa peringkat teratas | Low |

#### Rumus Perhitungan Poin

```
Total Poin = (Rata-rata Nilai Quiz × 0.5) + (Kursus Selesai × 100) + (Bonus Kecepatan)

Bonus Kecepatan:
- Selesai < 50% dari durasi kursus  → +50 poin
- Selesai 50–75% dari durasi kursus → +25 poin
- Selesai > 75% dari durasi kursus  → +0 poin
```

---

## 8. Non-Functional Requirements

| Kategori | Requirement | Target |
|----------|-------------|--------|
| **Performa** | Waktu muat halaman utama | < 3 detik |
| **Keamanan** | Proteksi CSRF, XSS, SQL Injection | Laravel built-in protection |
| **Keamanan** | Password hashing | bcrypt (Laravel default) |
| **Skalabilitas** | Kapasitas pengguna awal | < 100 pengguna aktif |
| **Ketersediaan** | Uptime target | 99% (shared hosting) |
| **Kompatibilitas** | Browser support | Chrome, Firefox, Safari, Edge (2 versi terakhir) |
| **Responsivitas** | Tampilan mobile-friendly | Responsive di layar 320px–1920px |
| **Aksesibilitas** | Bahasa | Bilingual Indonesia & Inggris |
| **Backup** | Database backup | Mingguan (manual / scheduled) |
| **Media** | Ukuran maksimal upload video | 500 MB per file |

---

## 9. User Stories

### Siswa / Pelajar

```
US-001: Sebagai siswa, saya ingin mendaftar akun agar dapat mengakses kursus.
US-002: Sebagai siswa, saya ingin menjelajahi katalog kursus berdasarkan kategori agar 
         mudah menemukan kursus yang relevan.
US-003: Sebagai siswa, saya ingin menonton video pembelajaran dan membaca modul teks 
         agar dapat belajar kapan saja.
US-004: Sebagai siswa, saya ingin mengikuti quiz setelah setiap modul agar dapat 
         mengukur pemahaman saya.
US-005: Sebagai siswa, saya ingin mendapatkan dan mengunduh sertifikat setelah 
         menyelesaikan kursus agar dapat menunjukkan pencapaian saya.
US-006: Sebagai siswa, saya ingin melihat posisi saya di leaderboard agar termotivasi 
         untuk belajar lebih giat.
US-007: Sebagai siswa, saya ingin memilih bahasa Indonesia atau Inggris agar lebih 
         nyaman menggunakan platform.
```

### Instruktur / Mentor

```
US-008: Sebagai instruktur, saya ingin mengupload video dan modul teks agar siswa 
         dapat mengakses materi pembelajaran saya.
US-009: Sebagai instruktur, saya ingin membuat soal quiz per modul agar dapat 
         mengevaluasi pemahaman siswa.
US-010: Sebagai instruktur, saya ingin melihat progres siswa di kursus saya agar 
         dapat memberikan dukungan yang tepat.
```

### Admin Platform

```
US-011: Sebagai admin, saya ingin melihat dashboard analitik agar dapat memantau 
         performa platform secara keseluruhan.
US-012: Sebagai admin, saya ingin memverifikasi pembayaran manual agar siswa dapat 
         segera mengakses kursus yang dibeli.
US-013: Sebagai admin, saya ingin mengelola konten agensi (portfolio, layanan, blog) 
         melalui CMS agar website selalu diperbarui.
US-014: Sebagai admin, saya ingin mengatur role dan permission pengguna agar keamanan 
         platform terjaga.
```

### Klien Agensi

```
US-015: Sebagai klien, saya ingin melihat portfolio dan layanan agensi agar dapat 
         menilai kualitas kerja mereka.
US-016: Sebagai klien, saya ingin mengisi form konsultasi agar dapat mengajukan 
         proyek dengan mudah.
US-017: Sebagai klien, saya ingin membaca testimoni klien lain agar lebih yakin 
         menggunakan jasa agensi.
```

### Tamu / Pengunjung Umum

```
US-018: Sebagai tamu, saya ingin melihat preview kursus yang tersedia agar dapat 
         mempertimbangkan sebelum mendaftar.
US-019: Sebagai tamu, saya ingin melihat leaderboard publik agar tahu siapa saja 
         peserta terbaik di platform ini.
```

---

## 10. Database Schema (ERD Overview)

### Tabel Utama

```
USERS
├── id (PK)
├── name
├── email (unique)
├── password
├── role (enum: admin, instructor, student, guest)
├── avatar
├── bio
├── language_preference (enum: id, en)
├── email_verified_at
└── timestamps

COURSES
├── id (PK)
├── instructor_id (FK → users)
├── category_id (FK → categories)
├── title
├── slug (unique)
├── description
├── thumbnail
├── price
├── type (enum: self_paced, cohort)
├── cohort_start_date
├── is_published
└── timestamps

CATEGORIES
├── id (PK)
├── name
├── slug
└── timestamps

MODULES
├── id (PK)
├── course_id (FK → courses)
├── title
├── type (enum: video, text)
├── content (text/path)
├── order
├── is_locked
└── timestamps

QUIZZES
├── id (PK)
├── module_id (FK → modules)
├── title
├── time_limit_minutes
├── max_attempts
└── timestamps

QUIZ_QUESTIONS
├── id (PK)
├── quiz_id (FK → quizzes)
├── question
├── type (enum: multiple_choice, essay)
├── options (JSON)
├── correct_answer
└── timestamps

ENROLLMENTS
├── id (PK)
├── user_id (FK → users)
├── course_id (FK → courses)
├── status (enum: active, completed)
├── enrolled_at
└── timestamps

MODULE_PROGRESS
├── id (PK)
├── user_id (FK → users)
├── module_id (FK → modules)
├── is_completed
└── completed_at

QUIZ_ATTEMPTS
├── id (PK)
├── user_id (FK → users)
├── quiz_id (FK → quizzes)
├── score
├── answers (JSON)
└── attempted_at

CERTIFICATES
├── id (PK)
├── user_id (FK → users)
├── course_id (FK → courses)
├── certificate_code (unique)
├── issued_at
└── pdf_path

LEADERBOARD_SCORES
├── id (PK)
├── user_id (FK → users)
├── course_id (FK → courses, nullable)
├── total_points
├── quiz_avg_score
├── courses_completed
└── updated_at

ORDERS
├── id (PK)
├── user_id (FK → users)
├── orderable_type (courses/agency_services)
├── orderable_id
├── amount
├── payment_method (enum: bank_transfer, qris)
├── payment_proof_path
├── status (enum: pending, confirmed, rejected)
└── timestamps

AGENCY_PORTFOLIOS
├── id (PK)
├── title
├── category
├── image_path
├── description
└── timestamps

AGENCY_SERVICES
├── id (PK)
├── title
├── description
├── icon
├── price_range
└── timestamps

AGENCY_TESTIMONIALS
├── id (PK)
├── client_name
├── client_company
├── content
├── avatar
├── rating
└── timestamps

BLOG_POSTS
├── id (PK)
├── author_id (FK → users)
├── title
├── slug (unique)
├── content
├── thumbnail
├── is_published
└── timestamps

PROJECT_INQUIRIES
├── id (PK)
├── name
├── email
├── service_type
├── project_description
├── budget_range
├── status (enum: new, in_review, responded)
└── timestamps
```

---

## 11. Sitemap & Navigasi

### Halaman Publik (Tamu & Pengguna)

```
/                          → Beranda (Hero + CTA Academy & Agency)
/academy                   → Halaman utama LMS
  /academy/courses         → Katalog kursus
  /academy/courses/{slug}  → Detail kursus
  /academy/leaderboard     → Leaderboard global
/agency                    → Landing page agensi
  /agency/portfolio        → Galeri portfolio
  /agency/services         → Daftar layanan
  /agency/blog             → Blog artikel kreatif
  /agency/blog/{slug}      → Detail artikel
  /agency/contact          → Form konsultasi proyek
/auth/register             → Halaman daftar akun
/auth/login                → Halaman masuk
/auth/forgot-password      → Lupa password
```

### Halaman Terautentikasi

```
/dashboard                 → Dashboard pengguna
/my-courses                → Kursus yang diikuti
/my-courses/{id}/learn     → Halaman belajar (modul + video + quiz)
/my-certificates           → Daftar sertifikat
/profile                   → Profil & pengaturan akun
/orders                    → Riwayat transaksi
/orders/{id}               → Detail transaksi + upload bukti bayar
```

### Halaman Admin

```
/admin/dashboard           → Dashboard analitik
/admin/users               → Manajemen pengguna
/admin/courses             → Manajemen kursus & modul
/admin/quizzes             → Manajemen quiz
/admin/certificates        → Manajemen sertifikat
/admin/orders              → Manajemen & verifikasi pembayaran
/admin/agency/portfolio    → CMS portfolio agensi
/admin/agency/services     → CMS layanan agensi
/admin/agency/testimonials → CMS testimoni
/admin/blog                → CMS blog
/admin/inquiries           → Manajemen form konsultasi
/admin/leaderboard         → Kelola leaderboard & poin
/admin/settings            → Pengaturan umum platform
```

---

## 12. Timeline & Milestones (MVP)

Target pengembangan: **6–8 minggu (1–2 bulan)**

| Minggu | Fase | Deliverable |
|--------|------|-------------|
| **Minggu 1** | Setup & Foundation | Setup Laravel project, konfigurasi SQLite, autentikasi dasar, role & permission, routing utama |
| **Minggu 2** | Core LMS — Backend | CRUD kursus, modul (video & teks), kategori, enrollment system |
| **Minggu 3** | Core LMS — Frontend | Halaman katalog, detail kursus, halaman belajar, progress tracking |
| **Minggu 4** | Quiz, Sertifikat & Leaderboard | Sistem quiz, penilaian otomatis, generate sertifikat PDF, perhitungan poin & leaderboard |
| **Minggu 5** | Agency Landing Page | Halaman portfolio, layanan, testimoni, blog, form konsultasi, podium prestasi |
| **Minggu 6** | Sistem Pembayaran & Email | Checkout, upload bukti bayar, verifikasi manual, notifikasi email otomatis |
| **Minggu 7** | Admin Panel & CMS | Dashboard analitik, manajemen pengguna & konten, dark mode, bilingual |
| **Minggu 8** | Testing, QA & Deployment | Unit testing, UAT bersama stakeholder, bug fixing, deployment ke server produksi |

---

## 13. Risiko & Mitigasi

| No | Risiko | Kemungkinan | Dampak | Mitigasi |
|----|--------|-------------|--------|----------|
| 1 | Waktu pengembangan melambat karena kompleksitas fitur | Sedang | Tinggi | Prioritaskan fitur MVP core; defer fitur non-critical ke v1.1 |
| 2 | SQLite tidak scalable jika pengguna tumbuh cepat | Rendah | Sedang | Rancang migrasi ke MySQL/PostgreSQL di versi berikutnya |
| 3 | Proses verifikasi pembayaran manual lambat | Sedang | Sedang | Buat SLA admin 1x24 jam; notifikasi email otomatis ke admin |
| 4 | Ukuran file video besar membebani server | Sedang | Tinggi | Batasi ukuran upload 500MB; pertimbangkan YouTube embed untuk v1.1 |
| 5 | Konflik kebutuhan antara dua stakeholder | Rendah | Sedang | Tetapkan PIC per stakeholder; review bersama setiap sprint |
| 6 | Bilingual tidak konsisten di semua halaman | Sedang | Rendah | Gunakan Laravel Localization dari awal; audit sebelum launch |

---

## 14. Acceptance Criteria

### MVP Launch Checklist

- [ ] Pengguna dapat mendaftar, login, dan logout dengan aman
- [ ] Minimal 5 kursus aktif dapat diakses siswa terdaftar
- [ ] Video pembelajaran dapat ditonton di halaman kursus
- [ ] Modul teks dapat dibaca dengan format yang baik
- [ ] Quiz dapat dikerjakan dan nilai tampil setelah submit
- [ ] Sertifikat otomatis tergenerate dan dapat diunduh dalam format PDF
- [ ] Leaderboard menampilkan peringkat peserta secara akurat
- [ ] Landing page agensi menampilkan semua section (portfolio, layanan, testimoni, blog, form)
- [ ] Form konsultasi mengirim email notifikasi ke admin
- [ ] Checkout, upload bukti bayar, dan konfirmasi pembayaran berjalan
- [ ] Admin dapat mengelola semua konten melalui panel admin
- [ ] Dark mode berfungsi di seluruh halaman
- [ ] Bilingual switcher (ID/EN) berfungsi di seluruh halaman
- [ ] Platform responsif di desktop dan mobile
- [ ] Tidak ada critical bug saat UAT bersama stakeholder

---

## 15. Glosarium

| Istilah | Definisi |
|---------|----------|
| **LMS** | Learning Management System — sistem pengelolaan pembelajaran online |
| **MVP** | Minimum Viable Product — versi pertama produk dengan fitur inti yang fungsional |
| **Cohort-based** | Model pembelajaran dengan jadwal tetap dan satu angkatan belajar bersama |
| **Self-paced** | Model pembelajaran mandiri tanpa jadwal tetap |
| **QRIS** | Quick Response Code Indonesian Standard — standar kode QR pembayaran nasional |
| **CMS** | Content Management System — sistem untuk mengelola konten tanpa coding |
| **CRUD** | Create, Read, Update, Delete — operasi dasar manajemen data |
| **UAT** | User Acceptance Testing — pengujian oleh pengguna nyata sebelum launch |
| **Leaderboard** | Papan peringkat peserta berdasarkan poin yang dikumpulkan |
| **Podium** | Tampilan visual top 3 peserta terbaik |
| **ERD** | Entity Relationship Diagram — diagram relasi antar tabel database |
| **Role** | Peran pengguna dalam sistem (Admin, Instruktur, Siswa, Tamu) |
| **Permission** | Hak akses yang diberikan berdasarkan role pengguna |

---

*Dokumen ini adalah living document yang akan diperbarui seiring perkembangan proyek.*

**Dibuat oleh:** Product Manager — Syabaab Platform  
**Tanggal:** 12 Juni 2026  
**Versi:** 1.0.0
