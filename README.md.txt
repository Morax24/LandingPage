							 MANUAL BOOK ADMIN PANEL
 Sistem Management Website Waluya Land

---

 INFORMASI LOGIN ADMIN
- URL Login: /login (tambahkan setelah domain website anda)
- Username: admin@malayaland.com
- Password: password123

 HALAMAN SETELAH LOGIN
Setelah login berhasil, Anda akan diarahkan ke: DASHBOARD ADMIN (/admin/dashboard)

Dashboard berisi:
1. Statistik pengunjung website
2. Grafik aktivitas terbaru
3. Media terbaru yang diupload
4. Testimoni pending review
5. Quick access menu ke semua fitur

---

 NAVIGASI SIDEBAR
Setelah login, sidebar kiri menampilkan menu:

MENU UTAMA:
1. Dashboard - Halaman utama dengan statistik
2. Kelola Pesan - Manajemen pesan/forum dari pengunjung
3. Kelola Testimoni - Manajemen testimoni website
4. Media Library - Manajemen gambar & video

---

 DAFTAR FITUR UTAMA

 1. DASHBOARD ANALYTICS
Lokasi: Halaman utama setelah login (/admin/dashboard)
Fitur:
- Statistik pengunjung harian
- Grafik aktivitas website
- Data media terbaru
- Update aktivitas real-time

 2. KELOLA TESTIMONI
URL: /admin/testimonials

Fungsi Utama:
- Approve/Reject testimoni pengunjung
- Tambah testimoni manual
- Hapus testimoni tidak pantas
- Filter berdasarkan status

Fitur Khusus:
- Bulk Actions: Manage multiple testimonials sekaligus
- Auto-approve: Status default approved untuk tambah manual
- Email Auto-fill: Tidak perlu input email manual
- Random Data Generator: Untuk testing

 3. MEDIA LIBRARY
URL: /admin/media

Tiga Halaman Utama:

A. MEDIA INDEX (Daftar Media)
- Tampilkan semua file media
- Filter: Status, Type, Section, Search
- Bulk actions: Delete/Activate/Deactivate massal
- Preview thumbnail

B. MEDIA CREATE (Upload Baru)
- Upload berdasarkan section yang ditentukan:
  Hero: 1 gambar (utama website)
  Story: 1 gambar (background)
  Features: 4 gambar (fitur unggulan)
  Aktivitas: 6 gambar (tutorial)
  Products: 2 gambar + harga
- Drag & drop upload
- Auto-generate form sesuai jumlah yang dibutuhkan

C. MEDIA EDIT (Update Media)
- Edit metadata: title, description, section
- Atur harga (khusus products)
- Toggle active/inactive
- Preview file
- Delete media

---

 WORKFLOW SETELAH LOGIN

Step-by-step setelah berhasil login:

1. Login - Masuk ke /login dengan credentials
2. Redirect - Otomatis ke /admin/dashboard
3. Dashboard - Lihat overview website:
   - Pengunjung hari ini
   - Testimoni pending
   - Media terbaru
4. Navigasi - Gunakan sidebar untuk akses fitur:
   - Klik "Kelola Testimoni" untuk manage testimoni
   - Klik "Media Library" untuk manage media
5. Logout - Klik tombol logout di sidebar footer

Quick Access dari Dashboard:
- Statistik - Klik card untuk detail
- Recent Activity - Timeline aktivitas terbaru
- Recent Users - Daftar user baru register
- Recent Media - Media yang baru diupload

---

 PETUNJUK PENGGUNAAN

 A. MENAMBAH TESTIMONI BARU
1. Klik "Kelola Testimoni" di sidebar
2. Klik tombol "+ Tambah Testimoni"
3. Isi form:
   - Nama (required)
   - Instansi (optional)
   - Pesan testimoni (required)
4. Klik "Simpan Testimoni"
5. Testimoni langsung tampil di website (auto-approved)

 B. UPLOAD MEDIA BARU
1. Klik "Media Library" di sidebar
2. Klik "Upload Media"
3. Pilih section yang diinginkan
4. Sistem auto-generate form sesuai kebutuhan section
5. Upload file (drag & drop atau klik)
6. Isi judul dan deskripsi masing-masing
7. Untuk section "Products": isi harga
8. Klik "Upload Media"

 C. MENGATUR VISIBILITY MEDIA
1. Buka Media Library
2. Gunakan filter untuk mencari media
3. Klik "Edit" pada media yang diinginkan
4. Centang/Uncentang "Aktifkan media ini"
5. Klik "Simpan Perubahan"

 D. BULK ACTIONS (Testimoni & Media)
1. Centang checkbox pada item yang ingin di-manage
2. Panel bulk actions akan muncul
3. Pilih action yang diinginkan:
   - Approve/Reject (testimoni)
   - Delete (keduanya)
   - Activate/Deactivate (media)
4. Konfirmasi action
5. Sistem proses semua item sekaligus

---

 SPESIFIKASI TEKNIS

 VALIDASI DATA
Testimoni:
- Nama: required, max 255 karakter
- Pesan: required, min 10 karakter

Media Upload:
- File size: max 10MB (image), 50MB (video)
- Format: JPG, PNG, WebP, MP4
- Price: max Rp 9.999.999.999,99 (khusus products)

 SECTION CONFIGURATION
hero: 1 gambar required
story: 1 gambar required
features: 4 gambar required
aktivitas: 6 gambar required
products: 2 gambar required + harga

 MOBILE COMPATIBILITY
- Responsive design untuk semua ukuran layar
- Touch-friendly interface
- Mobile menu toggle (hamburger icon)
- Optimized forms untuk mobile

---

 TROUBLESHOOTING

 MASALAH UMUM

1. Login Gagal
   Penyebab: Username/password salah
   Solusi: Pastikan admin@malayaland.com dan password123

2. Tidak Redirect ke Dashboard
   Penyebab: Session error
   Solusi: Clear cache browser dan login ulang

3. File Upload Gagal
   Penyebab: File terlalu besar / format tidak didukung
   Solusi: Compress file atau gunakan format yang sesuai

4. Testimoni Tidak Muncul di Website
   Penyebab: Status masih "pending"
   Solusi: Approve testimoni di admin panel

 ERROR HANDLING
- Form validation dengan error message jelas
- Confirmation dialog untuk delete actions
- Success/error notification setelah setiap action
- Auto-redirect dengan parameter filter yang terjaga

---

 KEAMANAN
1. Auto-logout setelah periode idle tertentu
2. Session management yang aman
3. CSRF protection untuk semua form
4. Password hashing dengan bcrypt

---

Update Terakhir: 22 Desember 2025
Sistem: Laravel 12, PHP 8.2, MySQL 8.0