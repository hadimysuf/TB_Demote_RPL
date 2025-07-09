<?php
// index.php hasil konversi dari index.html
// Tidak perlu autentikasi session di halaman landing page utama
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Demote - Kolaborasi & Refleksi Emosi</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://unpkg.com/@tailwindcss/typography"></script>
  <style>
    /* Animasi fadeInUp */
    .animate-fadeInUp {
      animation: fadeInUp 1.2s cubic-bezier(0.23, 1, 0.32, 1);
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(40px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    /* Animasi scale saat hover pada card */
    .hover\:scale-105:hover {
      transform: scale(1.05);
      transition: transform 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    }

    /* Animasi pulse pada tombol CTA */
    .animate-pulse-slow {
      animation: pulse 2.5s infinite;
    }

    @keyframes pulse {

      0%,
      100% {
        box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
      }

      50% {
        box-shadow: 0 0 0 16px rgba(59, 130, 246, 0.1);
      }
    }

    /* Navbar glassmorphism effect */
    .glass-navbar {
      background: rgba(30, 58, 138, 0.85);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      border-bottom: 1.5px solid rgba(59, 130, 246, 0.10);
    }

    /* Floating animated shapes */
    .floating-shape {
      position: absolute;
      z-index: 0;
      opacity: 0.18;
      pointer-events: none;
      animation: floatShape 7s ease-in-out infinite alternate;
    }

    @keyframes floatShape {
      from {
        transform: translateY(0) scale(1);
      }

      to {
        transform: translateY(-30px) scale(1.08);
      }
    }

    /* Fade in for section cards */
    .animate-fadeInCard {
      animation: fadeInCard 1.2s cubic-bezier(0.23, 1, 0.32, 1);
    }

    @keyframes fadeInCard {
      from {
        opacity: 0;
        transform: scale(0.96) translateY(30px);
      }

      to {
        opacity: 1;
        transform: scale(1) translateY(0);
      }
    }

    /* Subtle hover shadow for cards */
    .hover\:shadow-xl:hover {
      box-shadow: 0 8px 32px 0 rgba(59, 130, 246, 0.18);
      transition: box-shadow 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    }

    /* Animated underline for nav */
    .nav-underline {
      position: relative;
      overflow: hidden;
    }

    .nav-underline::after {
      content: '';
      position: absolute;
      left: 0;
      right: 0;
      bottom: -2px;
      height: 2px;
      background: linear-gradient(90deg, #4f8cff 0%, #2c3e50 100%);
      width: 0;
      transition: width 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .nav-underline:hover::after {
      width: 100%;
    }
  </style>
</head>

<body>
  <nav class="flex items-center justify-between glass-navbar text-white px-6 py-4 shadow-lg relative animate-fadeInUp">
    <div class="flex items-center gap-3 font-bold text-lg">
      <img src="img/demote_logos.png" alt="Logo Demote" class="h-10 w-auto rounded-md bg-white shadow transition-transform duration-300 hover:scale-110" onerror="this.src='https://placehold.co/60x38?text=Logo'">
      <span class="tracking-wide">Demote</span>
    </div>
    <div class="flex gap-4">
      <a href="login.php" class="nav-underline hover:text-blue-400 font-semibold transition-colors duration-300">Login</a>
      <a href="register.php" class="nav-underline hover:text-blue-400 font-semibold transition-colors duration-300">Register</a>
    </div>
    <!-- Floating shapes for navbar -->
    <div class="floating-shape" style="top:-30px;left:10vw;">
      <svg width="60" height="60">
        <circle cx="30" cy="30" r="28" fill="#4f8cff" />
      </svg>
    </div>
    <div class="floating-shape" style="top:10px;right:8vw;animation-delay:2s;">
      <svg width="36" height="36">
        <rect x="0" y="0" width="36" height="36" rx="12" fill="#2c3e50" />
      </svg>
    </div>
  </nav>
  <section class="flex flex-col items-center justify-center min-h-[60vh] text-center text-white pt-8 relative overflow-hidden bg-gradient-to-br from-blue-400 to-blue-900">
    <!-- Background kelas.jpg -->
    <div class="absolute inset-0 w-full h-full z-0">
      <img src="img/kelas.jpg" alt="Suasana Kelas" class="w-full h-full object-cover object-center opacity-100 blur-[2px] scale-105" style="filter: grayscale(10%) brightness(0.85);">
      <div class="absolute inset-0 bg-gradient-to-br from-blue-400/80 to-blue-900/90"></div>
    </div>
    <img src="img/demote_logos.png" class="w-24 h-24 mb-4 bg-white rounded-xl shadow-lg z-10 relative animate-fadeInUp" alt="Logo Demote" onerror="this.src='https://placehold.co/90x90?text=Logo'">
    <svg class="absolute left-1/2 top-2/3 -translate-x-1/2 -translate-y-1/2 opacity-25 z-0 pointer-events-none animate-pulse" width="340" height="180" viewBox="0 0 340 180" fill="none" xmlns="http://www.w3.org/2000/svg">
      <ellipse cx="170" cy="150" rx="120" ry="18" fill="#4f8cff" opacity="0.18" />
      <circle cx="70" cy="90" r="38" fill="#eaf1fb" stroke="#4f8cff" stroke-width="3" />
      <circle cx="270" cy="80" r="32" fill="#eaf1fb" stroke="#2c3e50" stroke-width="3" />
      <rect x="110" y="40" width="120" height="60" rx="18" fill="#fff" stroke="#4f8cff" stroke-width="2.5" />
      <rect x="130" y="60" width="80" height="20" rx="8" fill="#eaf1fb" />
      <circle cx="150" cy="70" r="4" fill="#4f8cff" />
      <circle cx="170" cy="70" r="4" fill="#4f8cff" />
      <circle cx="190" cy="70" r="4" fill="#4f8cff" />
      <rect x="120" y="110" width="100" height="12" rx="6" fill="#eaf1fb" />
      <rect x="140" y="128" width="60" height="8" rx="4" fill="#4f8cff" opacity="0.5" />
      <circle cx="70" cy="90" r="12" fill="#4f8cff" opacity="0.25" />
      <circle cx="270" cy="80" r="10" fill="#2c3e50" opacity="0.18" />
    </svg>
    <h1 class="text-3xl md:text-4xl font-bold mb-2 z-10 relative animate-fadeInUp">Selamat Datang di Demote</h1>
    <p class="text-lg max-w-xl mx-auto mb-6 z-10 relative animate-fadeInUp">Platform kolaborasi diskusi dan refleksi emosi untuk mahasiswa & dosen. Pantau, analisis, dan tingkatkan kualitas diskusi serta pemahaman emosi secara modern dan terintegrasi.</p>
    <a href="login.php" class="inline-block bg-gradient-to-r from-blue-500 to-blue-900 text-white font-bold rounded-md px-8 py-3 shadow-lg hover:from-blue-700 hover:to-blue-500 transition z-10 relative animate-fadeInUp animate-pulse-slow">Mulai Sekarang</a>
  </section>
  <div class="bg-white rounded-xl shadow-xl max-w-4xl mx-auto my-10 p-8">
    <h2 class="text-center mb-8 text-2xl font-bold text-blue-900 animate-fadeInUp">Fitur Utama Demote</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-blue-50 rounded-lg shadow p-5 text-center hover:scale-105 hover:shadow-xl cursor-pointer transition-all animate-fadeInCard">
        <h3 class="mb-2 text-blue-600 font-bold">Dashboard Interaktif</h3>
        <p class="text-gray-700">Monitoring aktivitas diskusi, refleksi, dan statistik emosi secara real-time.</p>
      </div>
      <div class="bg-blue-50 rounded-lg shadow p-5 text-center hover:scale-105 hover:shadow-xl cursor-pointer transition-all animate-fadeInCard" style="animation-delay:0.1s;">
        <h3 class="mb-2 text-blue-600 font-bold">Diskusi Kolaboratif</h3>
        <p class="text-gray-700">Fasilitasi diskusi kelompok dengan room, chat, dan pantauan dosen.</p>
      </div>
      <div class="bg-blue-50 rounded-lg shadow p-5 text-center hover:scale-105 hover:shadow-xl cursor-pointer transition-all animate-fadeInCard" style="animation-delay:0.2s;">
        <h3 class="mb-2 text-blue-600 font-bold">Refleksi Emosi</h3>
        <p class="text-gray-700">Form refleksi emosi setelah diskusi, analisis otomatis, dan visualisasi chart.</p>
      </div>
      <div class="bg-blue-50 rounded-lg shadow p-5 text-center hover:scale-105 hover:shadow-xl cursor-pointer transition-all animate-fadeInCard" style="animation-delay:0.3s;">
        <h3 class="mb-2 text-blue-600 font-bold">Laporan & Export</h3>
        <p class="text-gray-700">Rekap aktivitas, emosi, dan export PDF untuk kebutuhan evaluasi.</p>
      </div>
    </div>
  </div>
  <div class="bg-white rounded-xl shadow-xl max-w-4xl mx-auto my-10 p-8">
    <h2 class="text-center mb-8 text-2xl font-bold text-blue-900 animate-fadeInUp">Keuntungan Menggunakan Demote</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      <div class="bg-blue-50 rounded-lg shadow p-5 text-center hover:scale-105 hover:shadow-xl cursor-pointer transition-all animate-fadeInCard">
        <h3 class="mb-2 text-blue-600 font-bold">Kolaborasi Efektif</h3>
        <p class="text-gray-700">Meningkatkan interaksi dan partisipasi mahasiswa dalam diskusi.</p>
      </div>
      <div class="bg-blue-50 rounded-lg shadow p-5 text-center hover:scale-105 hover:shadow-xl cursor-pointer transition-all animate-fadeInCard" style="animation-delay:0.1s;">
        <h3 class="mb-2 text-blue-600 font-bold">Monitoring Emosi</h3>
        <p class="text-gray-700">Dosen dapat memantau perkembangan emosi dan dinamika kelompok.</p>
      </div>
      <div class="bg-blue-50 rounded-lg shadow p-5 text-center hover:scale-105 hover:shadow-xl cursor-pointer transition-all animate-fadeInCard" style="animation-delay:0.2s;">
        <h3 class="mb-2 text-blue-600 font-bold">Evaluasi Mudah</h3>
        <p class="text-gray-700">Data diskusi dan refleksi terekam otomatis, siap dievaluasi kapan saja.</p>
      </div>
      <div class="bg-blue-50 rounded-lg shadow p-5 text-center hover:scale-105 hover:shadow-xl cursor-pointer transition-all animate-fadeInCard" style="animation-delay:0.3s;">
        <h3 class="mb-2 text-blue-600 font-bold">UI Modern & Responsif</h3>
        <p class="text-gray-700">Tampilan profesional, mudah digunakan di berbagai perangkat.</p>
      </div>
    </div>
  </div>
  <div class="bg-white rounded-xl shadow-xl max-w-3xl mx-auto my-10 p-8">
    <h2 class="text-center mb-8 text-2xl font-bold text-blue-900 animate-fadeInUp">Tata Cara Penggunaan Demote</h2>
    <ol class="list-decimal list-inside text-gray-800 space-y-2 max-w-xl mx-auto animate-fadeInUp">
      <li>Daftar akun sebagai dosen atau mahasiswa.</li>
      <li>Login ke aplikasi Demote.</li>
      <li>Buat atau gabung ke room diskusi sesuai peran.</li>
      <li>Lakukan diskusi dan pantau aktivitas secara real-time.</li>
      <li>Isi form refleksi emosi setelah diskusi selesai.</li>
      <li>Lihat rekap, statistik, dan export laporan sesuai kebutuhan.</li>
    </ol>
    <div class="text-center mt-8 animate-fadeInUp">
      <a href="login.php" class="inline-block bg-gradient-to-r from-blue-500 to-blue-900 text-white font-bold rounded-md px-8 py-3 shadow-lg hover:from-blue-700 hover:to-blue-500 transition animate-pulse-slow">Login Sekarang</a>
    </div>
  </div>
</body>

</html>