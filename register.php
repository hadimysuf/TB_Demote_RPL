<?php
session_start();
if (isset($_SESSION['user_id'])) {
    // Sudah login, redirect ke dashboard
    if ($_SESSION['role'] === 'mahasiswa') {
        header('Location: dashboard_mhs.php');
        exit;
    } else if ($_SESSION['role'] === 'dosen') {
        header('Location: dashboard_dosen.php');
        exit;
    }
}
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'api/koneksi.php';
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    if (!$nama || !$email || !$password || !$role) {
        $error = 'Semua field harus diisi.';
    } else {
        $stmt = $koneksi->prepare('SELECT id FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $error = 'Email sudah terdaftar.';
        } else {
            $stmt->close();
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $koneksi->prepare('INSERT INTO users (nama, email, password, role) VALUES (?, ?, ?, ?)');
            $stmt->bind_param('ssss', $nama, $email, $hashed_password, $role);
            if ($stmt->execute()) {
                $success = 'Registrasi berhasil. Silakan login.';
                header('refresh:1.5;url=login.php');
            } else {
                $error = 'Gagal registrasi.';
            }
        }
        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Akun - Demote</title>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://unpkg.com/@tailwindcss/typography"></script>
  <style>
    .animate-fadeInUp { animation: fadeInUp 1.2s cubic-bezier(0.23, 1, 0.32, 1); }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
    .hover\:scale-105:hover { transform: scale(1.05); transition: transform 0.3s cubic-bezier(0.23, 1, 0.32, 1); }
    .animate-pulse-slow { animation: pulse 2.5s infinite; }
    @keyframes pulse { 0%, 100% { box-shadow: 0 0 0 0 rgba(59,130,246,0.4); } 50% { box-shadow: 0 0 0 16px rgba(59,130,246,0.1); } }
    .glass-navbar { background: rgba(30, 58, 138, 0.85); box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); border-bottom: 1.5px solid rgba(59,130,246,0.10); }
    .floating-shape { position: absolute; z-index: 0; opacity: 0.18; pointer-events: none; animation: floatShape 7s ease-in-out infinite alternate; }
    @keyframes floatShape { from { transform: translateY(0) scale(1); } to { transform: translateY(-30px) scale(1.08); } }
    .animate-fadeInCard { animation: fadeInCard 1.2s cubic-bezier(0.23, 1, 0.32, 1); }
    @keyframes fadeInCard { from { opacity: 0; transform: scale(0.96) translateY(30px); } to { opacity: 1; transform: scale(1) translateY(0); } }
    .hover\:shadow-xl:hover { box-shadow: 0 8px 32px 0 rgba(59,130,246,0.18); transition: box-shadow 0.3s cubic-bezier(0.23, 1, 0.32, 1); }
    .nav-underline { position: relative; overflow: hidden; }
    .nav-underline::after { content: ''; position: absolute; left: 0; right: 0; bottom: -2px; height: 2px; background: linear-gradient(90deg, #4f8cff 0%, #2c3e50 100%); width: 0; transition: width 0.3s cubic-bezier(0.23, 1, 0.32, 1); }
    .nav-underline:hover::after { width: 100%; }
    .register-error { color: #e74c3c; text-align: center; margin-bottom: 1rem; display: none; }
    .register-success { color: #27ae60; text-align: center; margin-bottom: 1rem; display: none; }
  </style>
</head>
<body class="relative min-h-screen flex flex-col bg-gradient-to-br from-blue-400 to-blue-900">
  <!-- Navbar -->
  <nav class="flex items-center justify-between glass-navbar text-white px-6 py-4 shadow-lg relative animate-fadeInUp z-20">
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
      <svg width="60" height="60"><circle cx="30" cy="30" r="28" fill="#4f8cff"/></svg>
    </div>
    <div class="floating-shape" style="top:10px;right:8vw;animation-delay:2s;">
      <svg width="36" height="36"><rect x="0" y="0" width="36" height="36" rx="12" fill="#2c3e50"/></svg>
    </div>
  </nav>
  <!-- Background belajaronline.jpg -->
  <div class="absolute inset-0 w-full h-full z-0">
    <img src="img/belajaronline.jpg" alt="Belajar Online" class="w-full h-full object-cover object-center opacity-60 blur-[2px] scale-105" style="filter: grayscale(10%) brightness(0.85);">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-400/80 to-blue-900/90"></div>
  </div>
  <!-- Register Section -->
  <main class="flex-1 flex items-center justify-center relative z-10">
    <div class="w-full max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 bg-white/80 rounded-2xl shadow-2xl p-8 md:p-12 animate-fadeInUp backdrop-blur-md">
      <!-- Form Register -->
      <div class="flex flex-col justify-center">
        <h2 class="text-2xl font-bold text-blue-900 mb-4 text-center">Register Akun Demote</h2>
        <?php if ($error): ?>
          <div class="register-error" style="display:block;"> <?= htmlspecialchars($error) ?> </div>
        <?php endif; ?>
        <?php if ($success): ?>
          <div class="register-success" style="display:block;"> <?= htmlspecialchars($success) ?> </div>
        <?php endif; ?>
        <form method="post" autocomplete="on" class="space-y-3">
          <label for="nama" class="font-semibold text-blue-900">Nama</label>
          <input type="text" id="nama" name="nama" required autocomplete="name" class="w-full px-4 py-2 rounded-md border border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 bg-blue-50 text-blue-900 transition">

          <label for="email" class="font-semibold text-blue-900">Email</label>
          <input type="email" id="email" name="email" required autocomplete="username" class="w-full px-4 py-2 rounded-md border border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 bg-blue-50 text-blue-900 transition">

          <label for="password" class="font-semibold text-blue-900">Password</label>
          <input type="password" id="password" name="password" required autocomplete="new-password" class="w-full px-4 py-2 rounded-md border border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 bg-blue-50 text-blue-900 transition">

          <label for="role" class="font-semibold text-blue-900">Role</label>
          <select id="role" name="role" required class="w-full px-4 py-2 rounded-md border border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 bg-blue-50 text-blue-900 transition">
            <option value="">-- Pilih Role --</option>
            <option value="mahasiswa">Mahasiswa</option>
            <option value="dosen">Dosen</option>
          </select>

          <button type="submit" class="w-full py-2 mt-2 bg-gradient-to-r from-blue-500 to-blue-900 text-white font-bold rounded-md shadow-lg hover:from-blue-700 hover:to-blue-500 transition animate-pulse-slow">Daftar</button>
        </form>
        <div class="login-link mt-4 text-center text-blue-900">
          Sudah punya akun? <a href="login.php" class="font-bold text-blue-600 hover:text-blue-900 nav-underline">Login</a>
        </div>
      </div>
      <!-- Samping Form: Interaktif -->
      <div class="flex flex-col items-center justify-center text-center gap-6 animate-fadeInCard">
        <img src="img/demote_logos.png" alt="Logo Demote" class="w-20 h-20 mb-2 bg-white rounded-xl shadow-lg animate-fadeInUp" onerror="this.src='https://placehold.co/90x90?text=Logo'">
        <h3 class="text-xl font-bold text-blue-800">Gabung Komunitas Kolaboratif!</h3>
        <p class="text-blue-900/80">Bergabunglah dengan Demote untuk pengalaman diskusi, refleksi, dan monitoring emosi yang modern, aman, dan terintegrasi. Pilih peranmu, isi data, dan mulai perjalanan barumu!</p>
        <svg class="mx-auto opacity-25 animate-pulse" width="120" height="60" viewBox="0 0 120 60" fill="none" xmlns="http://www.w3.org/2000/svg">
          <ellipse cx="60" cy="50" rx="40" ry="6" fill="#4f8cff" opacity="0.18"/>
          <circle cx="30" cy="30" r="14" fill="#eaf1fb" stroke="#4f8cff" stroke-width="2"/>
          <circle cx="90" cy="25" r="12" fill="#eaf1fb" stroke="#2c3e50" stroke-width="2"/>
          <rect x="45" y="15" width="30" height="18" rx="6" fill="#fff" stroke="#4f8cff" stroke-width="1.5"/>
          <rect x="52" y="22" width="16" height="4" rx="2" fill="#eaf1fb"/>
        </svg>
      </div>
    </div>
  </main>
</body>
</html>
