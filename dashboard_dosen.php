<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'dosen') {
  header("Location: index.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Dashboard Dosen - Demote</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Custom animasi dan style modern, style lama dihapus */
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

    .glass-navbar {
      background: rgba(30, 58, 138, 0.85);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      border-bottom: 1.5px solid rgba(59, 130, 246, 0.10);
    }

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
  </style>
  </style>
</head>

<body class="min-h-screen flex flex-col bg-gradient-to-br from-blue-400 to-blue-900 relative">
  <!-- Floating shapes background -->
  <div class="fixed inset-0 -z-10">
    <div class="floating-shape bg-blue-400 w-60 h-60 top-10 left-10"></div>
    <div class="floating-shape bg-purple-300 w-40 h-40 bottom-20 right-20"></div>
    <div class="floating-shape bg-cyan-300 w-32 h-32 top-1/2 left-1/2"></div>
  </div>

  <!-- Navbar glassmorphism -->
  <nav class="glass-navbar flex items-center justify-between text-white px-6 py-4 shadow-lg relative animate-fadeInUp z-20">
    <div class="flex items-center gap-3 font-bold text-lg">
      <img src="img/demote_logos.png" alt="Logo Demote" class="h-10 w-auto rounded-md bg-white shadow transition-transform duration-300 hover:scale-110" onerror="this.src='https://placehold.co/60x38?text=Logo'">
      <span class="tracking-wide">Demote</span>
      <span class="ml-2 text-base font-normal hidden md:inline">| Dashboard Dosen</span>
    </div>
    <div class="flex gap-4">
      <a href="dashboard_dosen.php" class="nav-underline hover:text-blue-400 font-semibold transition-colors duration-300">Dashboard</a>
      <a href="pantau_diskusi.php" class="nav-underline hover:text-blue-400 font-semibold transition-colors duration-300">Pantau Diskusi</a>
      <a href="laporan_dosen.php" class="nav-underline hover:text-blue-400 font-semibold transition-colors duration-300">Laporan</a>
      <a href="api/logout.php" class="nav-underline hover:text-red-400 font-semibold transition-colors duration-300">Logout</a>
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

  <!-- Main content -->
  <main class="flex flex-col items-center justify-center min-h-[70vh] pt-8 pb-0 animate-fadeInUp">
    <div class="w-full max-w-3xl mx-auto mt-6 mb-2">
      <div class="bg-white/90 rounded-3xl shadow-xl p-8 animate-fadeInCard relative z-10 border-2 border-blue-900/60" style="box-shadow: 0 8px 32px 0 rgba(30,58,138,0.10);">
        <h2 class="text-2xl font-bold text-blue-900 mb-1 text-center">Halo, <?= htmlspecialchars($_SESSION['nama']) ?>!</h2>
        <p class="text-center text-blue-700 mb-4">Anda login sebagai <strong>Dosen</strong>.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
          <div class="bg-blue-50 rounded-xl shadow p-6 text-center group hover:scale-105 hover:shadow-2xl hover:bg-white transition-all duration-300 animate-fadeInCard border border-blue-200/60" onclick="window.location.href='pantau_diskusi.php'">
            <div class="text-4xl mb-2 transition-transform duration-300 group-hover:scale-110">📢</div>
            <div class="mb-1 text-blue-600 font-bold text-lg group-hover:text-blue-800 transition-colors duration-300">Pantau Diskusi</div>
            <div class="text-gray-700 group-hover:text-blue-900 transition-colors duration-300">Lihat dan pantau aktivitas diskusi mahasiswa secara real-time.</div>
          </div>
          <div class="bg-blue-50 rounded-xl shadow p-6 text-center group hover:scale-105 hover:shadow-2xl hover:bg-white transition-all duration-300 animate-fadeInCard border border-blue-200/60" style="animation-delay:0.1s;" onclick="window.location.href='laporan_dosen.php'">
            <div class="text-4xl mb-2 transition-transform duration-300 group-hover:scale-110">📋</div>
            <div class="mb-1 text-blue-600 font-bold text-lg group-hover:text-blue-800 transition-colors duration-300">Laporan Refleksi</div>
            <div class="text-gray-700 group-hover:text-blue-900 transition-colors duration-300">Akses laporan refleksi emosi mahasiswa dan analisis emosi.</div>
          </div>
          <div class="bg-blue-50 rounded-xl shadow p-6 text-center group hover:scale-105 hover:shadow-2xl hover:bg-white transition-all duration-300 animate-fadeInCard border border-blue-200/60" style="animation-delay:0.3s;" onclick="window.location.href='api/logout.php'">
            <div class="text-4xl mb-2 transition-transform duration-300 group-hover:scale-110">🔓</div>
            <div class="mb-1 text-blue-600 font-bold text-lg group-hover:text-blue-800 transition-colors duration-300">Logout</div>
            <div class="text-gray-700 group-hover:text-blue-900 transition-colors duration-300">Keluar dari aplikasi Demote.</div>
          </div>
        </div>
      </div>
      <!-- SVG Ilustrasi bawah -->
      <div class="w-full max-w-3xl mx-auto -mt-6 mb-8 z-0">
        <svg viewBox="0 0 600 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-20">
          <path d="M0 60 Q150 0 300 60 T600 60 V80 H0Z" fill="#a5b4fc" fill-opacity="0.25" />
          <path d="M0 70 Q150 20 300 70 T600 70 V80 H0Z" fill="#818cf8" fill-opacity="0.18" />
        </svg>
      </div>
    </div>
  </main>
</body>

</html>