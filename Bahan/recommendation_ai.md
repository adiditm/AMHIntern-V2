# Rencana Implementasi Fitur Chat AI

Berdasarkan analisis pada struktur *template* aplikasi (seperti `main/loginform.php`, `manager/indexadmin.php`, `manager/indexnonadmin.php`, dan file `framework/`), berikut adalah rencana implementasi fitur Chat AI.

## 1. Rencana Penempatan Link / Widget Chat AI
Widget *chat* (biasanya berupa tombol mengambang / *floating button* di sudut kanan bawah) direkomendasikan untuk diletakkan dengan cara berikut agar kodenya tetap terpusat dan rapi:

* **Pusat Kode (Best Practice):** 
  Buat sebuah file baru khusus untuk UI widget chat, misalnya `framework/chat_widget.blade.php`. File ini akan menampung HTML, CSS, dan tag `<script>` yang dibutuhkan.

* **Injeksi pada Halaman Internal (Admin & Member):** 
  File `chat_widget.blade.php` di-`include_once` pada file `framework/admin_footside.blade.php` persis sebelum tag penutup `</body>`. Dengan demikian, widget akan otomatis muncul di seluruh halaman internal (seperti `indexadmin.php` dan `indexnonadmin.php`).

* **Injeksi pada Halaman Publik (Login):** 
  Karena halaman `main/loginform.php` tidak menggunakan framework `admin_footside.blade.php`, maka file `chat_widget.blade.php` harus di-`include_once` secara terpisah sebelum tag `</body>` pada file `main/loginform.php`.

## 2. Rekomendasi Layanan Chat AI (Prioritas Gratis/Murah)

### Opsi 1: Google Gemini API (Sangat Direkomendasikan)
* **Kelebihan:** Memiliki *Free Tier* (Gemini 1.5 Flash) yang sangat melimpah untuk penggunaan standar. Anda mendapatkan kapabilitas AI mutakhir tanpa biaya awal.
* **Cara Kerja:** Kita membuat desain antarmuka (UI) chat sendiri menggunakan HTML/CSS/JS di `chat_widget.blade.php`. Saat *user* mengirim pesan, JS akan melakukan *request* AJAX ke sebuah endpoint PHP buatan kita (misal: `main/api_chat.php`). Skrip PHP inilah yang secara aman akan berkomunikasi dengan Gemini API, sehingga API Key tidak bocor di sisi *client*.

### Opsi 2: Layanan Embed Pihak Ketiga (SaaS, ex: Fonnte / Aksita)
* **Kelebihan:** Implementasi sangat mudah. Cukup tempel (*copy-paste*) tag `<script>` yang mereka sediakan ke dalam `chat_widget.blade.php`. Tampilan (UI) langsung jadi dan dikelola oleh pihak ketiga.
* **Kekurangan:** Bergantung pada server pihak ketiga. Paket gratisnya biasanya sangat terbatas, dan Anda harus membayar per bulan jika batas penggunaan tercapai.

### Opsi 3: Tawk.to + Integrasi Backend AI
* **Kelebihan:** Tawk.to menyediakan UI widget *live chat* profesional secara gratis (mirip widget di Fonnte.com).
* **Cara Kerja:** Kita menggunakan widget Tawk.to di *frontend*. Agar bisa dijawab oleh AI, kita perlu mengatur fitur *Webhook* Tawk.to yang akan mengirim *chat* ke server PHP kita, lalu diteruskan ke OpenAI/Gemini. 
* **Kekurangan:** Konfigurasinya lebih rumit dibandingkan Opsi 1 atau Opsi 2.

### Opsi 4: Dialogflow Messenger (Google Cloud)
* **Kelebihan:** Menyediakan *widget chat* siap pakai. Sangat cocok jika Anda ingin membuat chatbot tipe tanya-jawab konvensional (FAQ/Q&A). Terdapat versi gratis.
* **Kekurangan:** Bukan tipe Generative AI (LLM) murni kecuali dikonfigurasi lebih lanjut.

## 3. Usulan Tahapan Eksekusi

Apabila rencana ini disetujui, berikut adalah langkah pengerjaan yang diusulkan:
1. **Pemilihan Layanan:** Menentukan satu layanan yang akan dipakai (Gemini API dengan *Custom UI*, atau *Embed Script* Aksita/Fonnte).
2. **Pembuatan Widget:** Membuat file `framework/chat_widget.blade.php`.
3. **Penyisipan Injeksi UI:** Melakukan *include* file widget tersebut ke dalam `framework/admin_footside.blade.php` dan `main/loginform.php`.
4. **Backend Integrasi (Khusus Opsi API):** Jika menggunakan API (seperti Gemini), membuat file `main/api_chat.php` beserta pengaturan API Key yang diletakkan pada `server/config.php`.
