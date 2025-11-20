# 🚀 Buku Panduan Lengkap Proyek MahaKarya

Dokumen ini adalah **"Kitab Suci"** tim yang berisi panduan instalasi dan alur kerja standar. Semua anggota tim **WAJIB** membaca dan mengikuti aturan ini.

---

## 📋 Prasyarat (Wajib Install Dulu)

Sebelum mulai, pastikan laptop kalian sudah terinstall:

1. **Docker Desktop**
   - Pastikan statusnya **"Engine Running"** (Hijau)
   - **Pengguna Windows:** Pastikan settingan *Use WSL 2 based engine* dicentang di settings Docker

2. **Git**

3. **VS Code** (Disarankan)

---

## 🛠️ Panduan Instalasi Proyek

### Langkah 1: Clone & Persiapan File

```bash
# 1. Clone repository
git clone https://github.com/username-kalian/mahakarya.git

# 2. Masuk ke folder proyek
cd mahakarya

# 3. Duplikat file environment
# Windows:
copy .env.example .env
# Mac/Linux/Git Bash:
cp .env.example .env
```

### Langkah 2: Instalasi Vendor dengan Docker

**🐧 Linux/macOS:**
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

**🪟 Windows (PowerShell):**
```powershell
docker run --rm ^
    -v "%cd%":/var/www/html ^
    -w /var/www/html ^
    laravelsail/php82-composer:latest ^
    composer install --ignore-platform-reqs
```

### Langkah 3: Menyalakan Sail

```bash
./vendor/bin/sail up -d
```

> **Note:** Proses pertama kali akan lama (5-10 menit) karena mendownload image.

### Langkah 4: Setup Aplikasi

```bash
# 1. Generate Application Key
./vendor/bin/sail artisan key:generate

# 2. Migrasi Database
./vendor/bin/sail artisan migrate

# 3. (Opsional) Data dummy
./vendor/bin/sail artisan db:seed
```

### Langkah 5: Setup Frontend

```bash
# 1. Install Node modules
./vendor/bin/sail npm install

# 2. Jalankan dev server (biarkan terminal terbuka)
./vendor/bin/sail npm run dev
```

### ✅ Selesai!

Buka browser dan akses: **http://localhost**

---

## ⚙️ Standar Lingkungan Development

### **Filosofi Utama: Satu Lingkungan**
Kita **HANYA** menggunakan **Laravel Sail (Docker)**. Dilarang memakai Herd, Valet, XAMPP, Laragon, atau environment lainnya.

### **Perintah Sail Standar**

```bash
# Menyalakan lingkungan
sail up -d

# Perintah Laravel
sail artisan [command]
sail composer [command]

# Perintah Frontend
sail npm [command]
sail npm run dev

# Mematikan lingkungan
sail down
```

**🪟 Windows:** Pastikan Docker Desktop menyala dan Laravel Herd **dimatikan** (berebut port 80 & 3306).

---

## 🔄 Alur Kerja Git (WAJIB DIIKUTI)

### **Aturan Emas:**
- `main` adalah branch sakral (harus stabil)
- **Dilarang** commit langsung ke `main`
- Satu fitur = satu branch
- Review dulu, baru merge

### **Langkah Harian:**

#### 1. Memulai Hari / Tugas Baru
```bash
# 1. Pindah ke main
git checkout main

# 2. Ambil update terbaru
git pull origin main

# 3. Update dependensi (jika ada perubahan)
sail artisan migrate
sail composer install
sail npm install
```

#### 2. Membuat Branch Baru
```bash
git checkout -b <nama-branch-anda>
```

**Format penamaan branch:**
- Fitur baru → `fitur/<deskripsi-singkat>`
- Perbaikan bug → `perbaikan/<deskripsi-singkat>`
- Refaktor → `refaktor/<deskripsi-singkat>`

**Contoh:**
- `fitur/crud-portfolio`
- `perbaikan/validasi-login`
- `refaktor/profile-controller`

#### 3. Ngoding & Committing
```bash
git add .
git commit -m "Tambah validasi untuk form portofolio"
```

**Contoh commit message:**
- ✅ "Tambah validasi untuk form portofolio"
- ✅ "Perbaiki tampilan tombol hapus skill"
- ❌ "wip", "beberapa perbaikan", "fix"

#### 4. Push ke GitHub
```bash
# Push pertama
git push -u origin fitur/crud-portfolio

# Push selanjutnya
git push
```

#### 5. Membuat Pull Request (PR)
1. Buka repository di GitHub
2. Klik **Compare & pull request**
3. Isi judul: **Fitur: CRUD Portofolio**
4. Pilih reviewer (1-2 orang)
5. Klik **Create pull request**

#### 6. Review & Merge
**Reviewer:** 
- Buka PR → **Files changed**
- Beri komentar jika ada masalah
- **Approve** jika sudah oke

**Pembuat PR (setelah approved):**
- **Squash and merge**
- **Delete branch**

---

## 👥 Pembagian Tugas & Tanggung Jawab

### **Person 1: Lead & Database Architect**
**Branch:** `fitur/database-dan-profil-core`

**Tugas:**
- ✅ **Migrations:** Profile, Portfolio, Skill, skill_user (pivot)
- ✅ **Models:** Eloquent relationships (User → Profile, Portfolio, Skill)
- ✅ **Profile System:** Modifikasi Jetstream/Fortify untuk field tambahan (bio, jurusan, angkatan)

### **Person 2: Portfolio Manager**
**Branch:** `fitur/crud-portfolio-livewire`

**Tugas:**
- ✅ **Livewire Component:** `ManagePortfolios` dengan CRUD lengkap
- ✅ **File Upload:** Handling gambar portfolio dengan validasi
- ✅ **Storage:** Setup `storage:link` dan penyimpanan file

### **Person 3: Public Facade & Relations**
**Branch:** `fitur/skills-dan-public-view`

**Tugas:**
- ✅ **Skills System:** Many-to-many dengan autocomplete
- ✅ **Public Profile:** Controller dan view untuk profil publik
- ✅ **Frontend:** Tampilan responsif dengan Tailwind CSS

---

## 📋 Daftar Fitur Wajib

### **A. Dashboard (Area Login User)**
- ✅ **Autentikasi:** Login, Register, Reset Password
- ✅ **Profile Management:** Update avatar, bio, jurusan, angkatan, social links
- ✅ **Portfolio CRUD:** Create, read, update, delete portfolio projects
- ✅ **Skills Management:** Tagging system dengan autocomplete

### **B. Sisi Publik (Halaman Profil)**
- ✅ **Landing Page:** Penjelasan "Apa itu MahaKarya?"
- ✅ **Public Profile:** URL cantik (`mahakarya.test/u/username`)
- ✅ **Portfolio Display:** Grid portofolio yang responsive
- ✅ **Skills Display:** Badges/tags untuk keahlian

---

## 🛠️ Roadmap Teknis

### **Tahap 1: Database & Model (Person 1)**
```
ERD:
users 1 --- 1 profiles
users 1 --- N portfolios  
users N --- N skills (pivot: skill_user)
```

**Migrations:**
- `create_profiles_table`
- `create_portfolios_table`
- `create_skills_table` 
- `create_skill_user_table`

### **Tahap 2: Backend & Dashboard (Person 2)**
- Livewire Components: `ManagePortfolios`, `CreatePortfolio`
- Image handling dengan Laravel Storage
- Route grouping dengan middleware auth

### **Tahap 3: Frontend & Public (Person 3)**
- Controller: `PublicProfileController` dengan method `show($username)`
- Blade templates dengan Tailwind CSS Grid
- Many-to-many skill management

---

## 📝 Checklist Aset Coding

### **Database & Models**
- [ ] `create_profiles_table` migration
- [ ] `create_portfolios_table` migration
- [ ] `create_skills_table` migration
- [ ] `create_skill_user_table` migration
- [ ] `Profile.php` model dengan relationships
- [ ] `Portfolio.php` model dengan relationships  
- [ ] `Skill.php` model dengan relationships

### **Livewire & Controllers**
- [ ] `ManagePortfolios.php` Livewire component
- [ ] `ManageSkills.php` Livewire component
- [ ] `PublicProfileController.php` controller

### **Views & Frontend**
- [ ] `manager.blade.php` (dashboard portfolio)
- [ ] `profile-show.blade.php` (halaman publik)
- [ ] Update `update-profile-information-form.blade.php`

---

## 🆘 Troubleshooting

**Q: Error `port is already allocated`?**  
A: Matikan **XAMPP/Laragon/Herd** karena berebut port 80 & 3306 dengan Docker.

**Q: Perintah `./vendor/bin/sail` terlalu panjang?**  
A: Buat alias:
- **Windows:** `alias sail='sh vendor/bin/sail'`
- **Linux/Mac:** `alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'`

**Q: Database error / Connection refused?**  
A: Coba `./vendor/bin/sail down -v` lalu `up` lagi.

**Q: Gambar tidak muncul?**  
A: Pastikan sudah menjalankan `sail artisan storage:link`

---

## 🎯 Filosofi Tim

1. **Konsistensi:** Semua pakai Sail, tidak ada environment lain
2. **Kolaborasi:** Branch, PR, review - setiap fitur
3. **Kualitas:** Kode di `main` harus stabil dan ter-test
4. **Komunikasi:** Saling review dan bantu troubleshooting

---

## 🚀 Mulai Bekerja!

1. **Pilih tugas** sesuai pembagian di atas
2. **Ikuti alur Git** yang sudah ditentukan  
3. **Commit sering** dengan pesan yang jelas
4. **Buat PR** untuk setiap fitur
5. **Review** kode teman sekelas

**Selamat berkoding! 🎉**