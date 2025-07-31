
# 🖼️ Imagiboo - AI Gambar dari Imajinasi

> Ketik ide, langsung jadi gambar. Semudah itu.

## ✨ Deskripsi

**Imagiboo** adalah aplikasi web yang memungkinkan pengguna menghasilkan gambar dari deskripsi teks (text-to-image) menggunakan teknologi AI. Cocok untuk pelajar, content creator, marketer, hingga pengguna umum yang tidak bisa desain tapi ingin menuangkan imajinasi secara visual.

---

## 🚀 Fitur Utama

- 🎨 **Generate Gambar dari Teks**  
  Tulis deskripsi → hasil gambar langsung muncul.

- ⚡ **Cepat dan Instan**  
  Tidak perlu menunggu lama, hasil dalam hitungan detik.

- 🧠 **AI Terintegrasi (Replicate API)**  
  Menggunakan model AI canggih untuk menghasilkan gambar yang relevan.

- 🧑‍🎓 **Autentikasi Google (Firebase)**  
  Pengguna cukup login dengan akun Google.

- 🕹️ **Frontend Vue 3 + TailwindCSS**  
  UI modern, responsive, dan user-friendly.

- 🌐 **Backend Laravel 10**  
  Mengelola API dan komunikasi dengan model AI secara aman.

---

## 🔧 Instalasi Lokal

### 1. Clone Repository

```bash
git clone https://github.com/username/imagiboo.git
cd imagiboo
```

### 2. Setup Backend (Laravel)

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
```

### 3. Setup Frontend (Vue + Vite)

```bash
npm install
npm run build
```

### 4. Permission dan Storage

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data .
```

---

## 📦 Struktur Proyek

```
/public          <- asset publik (img/logo.png)
/resources       <- file Vue, views, dll
/routes          <- web & API routes Laravel
/app/Http        <- controller backend
.env             <- konfigurasi environment
vite.config.js   <- config Vite frontend
```

---

## 🎯 Target Pengguna

- Pelajar & Mahasiswa (presentasi & tugas)
- Content Creator (konten IG, TikTok, dll)
- Desainer & Marketer (ide visual cepat)
- Umum (tanpa skill desain)

---

## 💡 Rencana ke Depan

- Support berbagai gaya gambar (anime, realis, 3D)
- Dukungan login sosial media lainnya
- History & favorit gambar
- Export langsung ke media sosial

---

## 🔐 OAuth Error Note

Jika terjadi error seperti:

```
The current domain is not authorized for OAuth operations.
```

✅ Masuk ke Firebase Console → Authentication → Settings → **Authorized Domains**  
→ Tambahkan `your_domain_or_ip`.

---

## 📞 Kontak

- 📧 Email: rizqiarief022@gmail.com  
- 🧵 Instagram: [@rizqiariefwicak](https://instagram.com/rizqiariefwicak)  
- 📱 WhatsApp: 0895-1794-7731  

---

## 🙏 Terima Kasih
Terima kasih telah menjadi bagian dari perjalanan Imagiboo.  
Mari terus berimajinasi dan berkarya tanpa batas!
