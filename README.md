

---

````md
# 📖 Buku Panduan & Alur Kerja Tim Proyek MahaKarya

Selamat datang di tim! Dokumen ini adalah **"Kitab Suci"** kita.

Tujuan dokumen ini adalah untuk menstandardisasi cara kita bekerja agar:
- tidak terjadi konflik,
- kode tetap bersih,
- semua orang bisa bekerja dengan nyaman.

Semua anggota tim **WAJIB** membaca dan mengikuti aturan ini.

---

## 1. 🎯 Filosofi Utama (Aturan Emas)

### **1. Satu Lingkungan**
Kita **HANYA** menggunakan **Laravel Sail (Docker)**.  
Dilarang memakai Herd, Valet, XAMPP, Laragon, atau environment lainnya.

Alasan:  
Lingkungan Sail menjamin semua device identik dan bebas bug *“di laptop saya jalan”*.

### **2. `main` Adalah Sakral**
Branch `main` adalah **Master Copy**.  
Kode di `main` harus:
- stabil,
- bisa berjalan,
- sudah di-review.

### **3. Dilarang Commit ke `main`**
Semua pekerjaan **WAJIB** dilakukan dalam branch.

### **4. Satu Fitur = Satu Branch**
Contoh:
- `fitur/crud-portfolio`
- `perbaikan/validasi-login`
- `refaktor/profile-controller`

### **5. Review Dulu, Baru Merge**
Kode tidak boleh masuk `main` sebelum:
- dibuat Pull Request (PR),
- direview dan di-approve oleh setidaknya 1 anggota tim.

---

## 2. ⚙️ Standar Lingkungan (Cara Pakai Sail)

> Perintah Sail hampir identik di semua OS.

---

### 🐧 **Untuk Pengguna Ubuntu (Linux)**

Disarankan membuat alias Sail (lihat `MahaKarya-Setup-Guide.md` langkah 6).

Menyalakan lingkungan:
```bash
sail up -d
````

Menjalankan perintah:

```bash
sail artisan ...
sail composer ...
sail npm ...
```

Mematikan lingkungan:

```bash
sail down
```

---

### 🪟 **Untuk Pengguna Windows**

**Prasyarat wajib:**

* Docker Desktop **harus** menyala.
* Laravel Herd **harus dimatikan** (Herd berebut port 80 & 3306 dengan Sail).

Menyalakan lingkungan:

```bash
sail up -d
```

Menjalankan perintah:

```bash
sail artisan ...
sail composer ...
sail npm ...
```

Mematikan lingkungan:

```bash
sail down
```

---

## 3. 🔄 Alur Kerja Wajib Git (Pull, Branch, Commit, Push, Merge)

Alur ini harus diikuti setiap hari.

---

### **Langkah 1: Memulai Hari / Mengerjakan Tugas Baru**

Selalu mulai dari `main` yang paling terbaru.

```bash
# 1. Pindah ke main
git checkout main

# 2. Ambil update terbaru dari GitHub
git pull origin main

# 3. Update migrasi / dependensi (jika ada perubahan)
sail artisan migrate
sail composer install
sail npm install
```

---

### **Langkah 2: Membuat Branch Baru**

Branch baru selalu dibuat dari `main` yang bersih.

```bash
git checkout -b <nama-branch-anda>
```

**Format penamaan branch (WAJIB):**

* Fitur baru → `fitur/<deskripsi-singkat>`
* Perbaikan bug → `perbaikan/<deskripsi-singkat>`
* Refaktor → `refaktor/<deskripsi-singkat>`

Contoh:

* `fitur/crud-portfolio`
* `fitur/halaman-profil-publik`
* `perbaikan/validasi-login`
* `refaktor/profile-controller`

---

### **Langkah 3: Ngoding (Coding & Committing)**

Commit sering. Jangan commit besar sekaligus.

```bash
git status
git add .
git commit -m "Tambah validasi untuk form portofolio"
```

**Format pesan commit yang benar:**

* ✔️ Tambah validasi untuk form portofolio
* ✔️ Perbaiki tampilan tombol hapus skill
* ❌ wip
* ❌ beberapa perbaikan
* ❌ fix

---

### **Langkah 4: Push ke GitHub**

Push pertama kali:

```bash
git push -u origin fitur/crud-portfolio
```

Push selanjutnya:

```bash
git push
```

---

### **Langkah 5: Membuat Pull Request (PR)**

1. Buka repository MahaKarya di GitHub.
2. Jika ada banner kuning “recent pushes”, klik **Compare & pull request**.
3. Isi judul PR — contoh: **Fitur: CRUD Portofolio**
4. Isi deskripsi PR.
5. Pilih reviewer (1–2 orang).
6. Klik **Create pull request**.

---

### **Langkah 6: Review & Merge**

#### Untuk Reviewer:

* Buka PR → tab **Files changed**
* Jika ada masalah → beri komentar
* Jika sudah oke → **Approve**

#### Untuk Pembuat PR (Setelah Approved):

* Klik **Squash and merge**
* Klik **Confirm**
* Klik **Delete branch**

---

## 4. 👥 Pembagian Tugas Awal (Vertical Slices)

### **Person 1 — Lead / Arsitek**

**Nama:** `[Isi Nama Anda]`

**Tugas Inti:**

* Membuat semua file Migration & Model (Profile, Portfolio, Skill, skill_user)
* Menentukan relasi antar Model
* Modifikasi halaman Profil bawaan Jetstream (bio, jurusan, angkatan)

**Tanggung Jawab:**

* Menjaga branch `main`
* Final merge semua PR
* Memastikan migrasi berjalan

---

### **Person 2 — Fitur Portofolio**

**Nama:** `[Isi Nama Anggota 1]`

**Tugas Inti:**

* Membuat Livewire Component `ManagePortfolios`
* CRUD lengkap Portofolio
* File Upload gambar portofolio (WithFileUploads)

**Tanggung Jawab:**

* Fitur portofolio dari A-Z

---

### **Person 3 — Fitur Publik & Keahlian**

**Nama:** `[Isi Nama Anggota 2]`

**Tugas Inti:**

* Membuat Livewire `ManageSkills` (Many-to-Many CRUD)
* Membuat `PublicProfileController`
* Membuat halaman profil publik (`/username`) untuk menampilkan:

  * bio
  * portfolio
  * skills

**Tanggung Jawab:**

* Tampilan publik & fitur skill

---

### 🎉 Selesai!

Dokumen ini akan terus diperbarui seiring bertambahnya fitur.

Patuhilah panduan ini — demi workflow yang sehat, kode yang bersih, dan tim yang bahagia.

```


