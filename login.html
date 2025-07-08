<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Demote</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://unpkg.com/@tailwindcss/typography"></script>
  <style>
    .animate-fadeInUp { animation: fadeInUp 1.2s cubic-bezier(0.23, 1, 0.32, 1); }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
    .glass-navbar {
      background: rgba(30, 58, 138, 0.85);
      box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
      border-bottom: 1.5px solid rgba(59,130,246,0.10);
    }
    .nav-underline { position: relative; overflow: hidden; }
    .nav-underline::after {
      content: '';
      position: absolute;
      left: 0; right: 0; bottom: -2px;
      height: 2px;
      background: linear-gradient(90deg, #4f8cff 0%, #2c3e50 100%);
      width: 0;
      transition: width 0.3s cubic-bezier(0.23, 1, 0.32, 1);
    }
    .nav-underline:hover::after { width: 100%; }
    .floating-shape {
      position: absolute;
      z-index: 0;
      opacity: 0.18;
      pointer-events: none;
      animation: floatShape 7s ease-in-out infinite alternate;
    }
    @keyframes floatShape {
      from { transform: translateY(0) scale(1); }
      to { transform: translateY(-30px) scale(1.08); }
    }
    .animate-pulse-slow { animation: pulse 2.5s infinite; }
    @keyframes pulse {
      0%, 100% { box-shadow: 0 0 0 0 rgba(59,130,246,0.4); }
      50% { box-shadow: 0 0 0 16px rgba(59,130,246,0.1); }
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
      <a href="login.html" class="nav-underline hover:text-blue-400 font-semibold transition-colors duration-300">Login</a>
      <a href="register.html" class="nav-underline hover:text-blue-400 font-semibold transition-colors duration-300">Register</a>
    </div>
    <div class="floating-shape" style="top:-30px;left:10vw;">
      <svg width="60" height="60"><circle cx="30" cy="30" r="28" fill="#4f8cff"/></svg>
    </div>
    <div class="floating-shape" style="top:10px;right:8vw;animation-delay:2s;">
      <svg width="36" height="36"><rect x="0" y="0" width="36" height="36" rx="12" fill="#2c3e50"/></svg>
    </div>
  </nav>
  <div class="min-h-screen flex items-center justify-center py-12 px-4 relative overflow-hidden">
    <!-- Background belajaronline.jpg -->
    <div class="absolute inset-0 w-full h-full z-0">
      <img src="img/belajaronline.jpg" alt="Belajar Online" class="w-full h-full object-cover object-center opacity-70 blur-[2px] scale-105" style="filter: grayscale(10%) brightness(0.90);">
      <div class="absolute inset-0 bg-gradient-to-br from-blue-400/80 to-blue-900/90"></div>
    </div>
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 animate-fadeInUp relative z-10">
      <h2 class="text-2xl font-bold text-center text-blue-900 mb-6">Login ke Demote</h2>
      <div id="loginError" class="text-red-500 text-center mb-4 hidden"></div>
      <form id="loginForm" autocomplete="on" class="space-y-4">
        <input type="email" id="email" placeholder="Email" required autocomplete="username" class="w-full px-4 py-3 rounded-lg border border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
        <input type="password" id="password" placeholder="Password" required autocomplete="current-password" class="w-full px-4 py-3 rounded-lg border border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition">
        <button type="submit" class="w-full py-3 bg-gradient-to-r from-blue-500 to-blue-900 text-white font-bold rounded-lg shadow-lg hover:from-blue-700 hover:to-blue-500 transition animate-pulse-slow">Login</button>
      </form>
      <div class="text-center mt-4 text-gray-700">
        Belum punya akun? <a href="register.html" class="text-blue-600 font-bold nav-underline">Daftar di sini</a>
      </div>
    </div>
  </div>
  <script>
    document.getElementById("loginForm").addEventListener("submit", function(e) {
      e.preventDefault();
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;
      const errorDiv = document.getElementById("loginError");
      errorDiv.style.display = "none";
      errorDiv.textContent = "";

      fetch("api/login.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ email, password })
      })
      .then(res => res.json())
      .then(data => {
        if (data.status === "success") {
          sessionStorage.setItem("user_id", data.user_id);
          sessionStorage.setItem("role", data.role);
          sessionStorage.setItem("nama", data.nama);
          window.location.href = data.redirect;
        } else {
          errorDiv.textContent = "Login gagal: " + data.message;
          errorDiv.style.display = "block";
        }
      })
      .catch(err => {
        errorDiv.textContent = "Terjadi kesalahan: " + err;
        errorDiv.style.display = "block";
      });
    });
  </script>
</body>
</html>
