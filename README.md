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

**Alasan:**  
Lingkungan Sail menjamin semua device identik dan bebas bug *"di laptop saya jalan"*.

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

### 🐧 **Untuk Pengguna Ubuntu (Linux)**

Disarankan membuat alias Sail.

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

### 🪟 **Untuk Pengguna Windows**

**Prasyarat wajib:**
- Docker Desktop **harus** menyala
- Laravel Herd **harus dimatikan** (Herd berebut port 80 & 3306 dengan Sail)

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

### **Langkah 2: Membuat Branch Baru**

Branch baru selalu dibuat dari `main` yang bersih.

```bash
git checkout -b <nama-branch-anda>
```

**Format penamaan branch (WAJIB):**
- Fitur baru → `fitur/<deskripsi-singkat>`
- Perbaikan bug → `perbaikan/<deskripsi-singkat>`
- Refaktor → `refaktor/<deskripsi-singkat>`

Contoh:
- `fitur/crud-portfolio`
- `fitur/halaman-profil-publik`
- `perbaikan/validasi-login`
- `refaktor/profile-controller`

### **Langkah 3: Ngoding (Coding & Committing)**

Commit sering. Jangan commit besar sekaligus.

```bash
git status
git add .
git commit -m "Tambah validasi untuk form portofolio"
```

**Contoh commit yang benar:**
- ✅ Tambah validasi untuk form portofolio  
- ✅ Perbaiki tampilan tombol hapus skill  
- ❌ wip  
- ❌ beberapa perbaikan  
- ❌ fix  

### **Langkah 4: Push ke GitHub**

Push pertama kali:

```bash
git push -u origin fitur/crud-portfolio
```

Push selanjutnya:

```bash
git push
```

### **Langkah 5: Membuat Pull Request (PR)**

1. Buka repository MahaKarya di GitHub
2. Jika ada banner kuning "recent pushes", klik **Compare & pull request**
3. Isi judul PR — contoh: **Fitur: CRUD Portofolio**
4. Isi deskripsi PR
5. Pilih reviewer (1–2 orang)
6. Klik **Create pull request**

### **Langkah 6: Review & Merge**

#### Untuk Reviewer:
- Buka PR → tab **Files changed**
- Jika ada masalah → beri komentar
- Jika sudah oke → **Approve**

#### Untuk Pembuat PR (Setelah Approved):
- Klik **Squash and merge**
- Klik **Confirm**
- Klik **Delete branch**

---

## 4. 👥 Pembagian Tugas Awal (Vertical Slices)

### **Person 1: Lead & Database Architect**

**Fokus:** Integritas Data & Profil Pengguna Inti  
**Branch Awal:** `fitur/database-dan-profil-core`

**Tugas:**
- **Arsitektur Database (Migrations):**
  - Buat Model & Migration untuk:
    - Profile: user_id (FK), bio (text, nullable), avatar (string, nullable), jurusan (string), angkatan (year/integer)
    - Portfolio: user_id (FK), title, description (text), link (string, nullable), image (string)
    - Skill: name (string, unique)
    - skill_user (Pivot Table): user_id (FK), skill_id (FK). Gunakan constraint onDelete('cascade')

- **Eloquent Relationships (Models):**
  - Definisikan relasi di file Model PHP agar Person 2 & 3 bisa langsung memanggilnya
  - User: hasOne(Profile), hasMany(Portfolio), belongsToMany(Skill)
  - Portfolio & Profile: belongsTo(User)

- **Modifikasi Jetstream/Fortify (Update Profile):**
  - Modifikasi `app/Actions/Fortify/UpdateUserProfileInformation.php`
  - Tambahkan validasi dan logika simpan untuk field bio, jurusan, dan angkatan
  - Edit view `resources/views/profile/update-profile-information-form.blade.php` untuk menambah input field tersebut

### **Person 2: Portfolio Manager (Backend Logic Heavy)**

**Fokus:** CRUD Kompleks & File Handling  
**Branch Awal:** `fitur/crud-portfolio-livewire`

**Tugas:**
- **Livewire Component (ManagePortfolios):**
  - Gunakan `php artisan make:livewire ManagePortfolios`
  - Jangan gunakan Resource Controller biasa. Kita pakai Single Page Component di dashboard

- **File Upload System:**
  - Implementasikan trait `use WithFileUploads`
  - Pastikan validasi gambar: `image|max:1024` (1MB)
  - Gunakan `$this->image->store('portfolios', 'public')` untuk menyimpan fisik file
  - **Penting:** Jangan lupa buat symlink di server (`sail artisan storage:link`) agar gambar muncul

- **CRUD State Management:**
  - Gunakan property publik `$title`, `$description`, `$link`, `$image` untuk binding ke form
  - Buat fungsi `resetInputFields()` untuk membersihkan form setelah submit
  - Gunakan Modal (Alpine.js atau Livewire boolean) untuk form Tambah/Edit agar UX lebih mulus tanpa pindah halaman

### **Person 3: Public Facade & Relations Manager**

**Fokus:** Many-to-Many Logic & Public Presentation  
**Branch Awal:** `fitur/skills-dan-public-view`

**Tugas:**
- **Livewire Component (ManageSkills):**
  - Implementasi Many-to-Many
  - Logic Tambah: Saat user mengetik skill (misal "Laravel"), cek dulu di DB `Skill::firstOrCreate(...)`. Jangan buat duplikat nama skill di tabel master
  - Logic Attach: Gunakan `$user->skills()->syncWithoutDetaching($skill->id)` agar user tidak punya skill ganda yang sama

- **Public Controller (PublicProfileController):**
  - Gunakan Route Model Binding pada kolom username
  - Performance: Gunakan Eager Loading untuk mencegah N+1 Query
  - Contoh: `$user->load(['profile', 'portfolios', 'skills'])`

- **Public View (Blade):**
  - Buat tampilan profil yang cantik dan responsif
  - Tampilkan Avatar, Bio, Daftar Skill (sebagai badges), dan Grid Portofolio
  - Pastikan layout Mobile-Friendly (gunakan class Tailwind `grid-cols-1 md:grid-cols-3`)

---

## 🎉 Selesai!

Dokumen ini akan terus diperbarui seiring bertambahnya fitur.  
Patuhilah panduan ini — demi workflow yang sehat, kode yang bersih, dan tim yang bahagia.