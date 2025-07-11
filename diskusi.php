<?php
// diskusi.php hasil konversi dari diskusi.html
include 'session/proteksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Diskusi - Demote</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/@tailwindcss/typography"></script>
    <style>
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

        .hover\:scale-105:hover {
            transform: scale(1.05);
            transition: transform 0.3s cubic-bezier(0.23, 1, 0.32, 1);
        }

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

        .hover\:shadow-xl:hover {
            box-shadow: 0 8px 32px 0 rgba(59, 130, 246, 0.18);
            transition: box-shadow 0.3s cubic-bezier(0.23, 1, 0.32, 1);
        }

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

        .animate-slideIn {
            animation: slideIn 1.2s cubic-bezier(0.23, 1, 0.32, 1);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(60px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>
</head>

<body class="min-h-screen flex flex-col bg-gradient-to-br from-blue-400 to-blue-900 relative">
    <!-- Navbar -->
    <nav class="flex items-center justify-between glass-navbar text-white px-6 py-4 shadow-lg relative animate-fadeInUp z-20">
        <div class="flex items-center gap-3 font-bold text-lg">
            <img src="img/demote_logos.png" alt="Logo Demote" class="h-10 w-auto rounded-md bg-white shadow transition-transform duration-300 hover:scale-110" onerror="this.src='https://placehold.co/60x38?text=Logo'">
            <span class="tracking-wide">Demote</span>
        </div>
        <div class="flex gap-4">
            <a href="dashboard_mhs.php" class="nav-underline hover:text-blue-400 font-semibold transition-colors duration-300">Dashboard</a>
            <a href="api/logout.php" class="nav-underline hover:text-blue-400 font-semibold transition-colors duration-300">Logout</a>
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
    <!-- Floating shapes background -->
    <div class="floating-shape" style="bottom:10vh;left:5vw;animation-delay:1.5s;">
        <svg width="80" height="80">
            <circle cx="40" cy="40" r="38" fill="#4f8cff" />
        </svg>
    </div>
    <div class="floating-shape" style="bottom:5vh;right:8vw;animation-delay:2.5s;">
        <svg width="48" height="48">
            <rect x="0" y="0" width="48" height="48" rx="16" fill="#2c3e50" />
        </svg>
    </div>
    <!-- Main Content -->
    <main class="flex-1 flex flex-col items-center justify-center px-4 py-10 relative z-10">
        <div class="w-full max-w-xl bg-white/90 rounded-2xl shadow-2xl p-8 md:p-12 animate-slideIn backdrop-blur-md flex flex-col items-center gap-6 border-2 border-blue-900/60" style="box-shadow: 0 8px 32px 0 rgba(30,58,138,0.10);">
            <img src="img/demote_logos.png" alt="Logo Demote" class="w-16 h-16 bg-white rounded-xl shadow mb-2 animate-fadeInUp" onerror="this.src='https://placehold.co/90x90?text=Logo'">
            <h2 class="text-2xl md:text-3xl font-bold text-blue-900 text-center animate-fadeInUp">🗣️ Diskusi Kolaboratif</h2>
            <p class="text-blue-900/90 text-center animate-fadeInUp">Buat room baru untuk memulai diskusi kelompok atau gabung ke room yang sudah ada dengan kode room.</p>
            <!-- Form Buat Room Baru -->
            <form id="buatRoomForm" class="w-full space-y-3 animate-fadeInCard">
                <label for="nama_tim" class="font-semibold text-blue-900">Nama Tim Diskusi</label>
                <input type="text" id="nama_tim" placeholder="Contoh: Tim A1 / Evaluasi Bab 3" required class="w-full px-4 py-2 rounded-md border-2 border-blue-900/30 focus:border-blue-800 focus:ring-2 focus:ring-blue-800 bg-blue-50 text-blue-900 transition">
                <button type="submit" class="w-full py-2 mt-2 bg-blue-800 text-white font-bold rounded-md shadow-lg hover:bg-blue-900 transition animate-pulse-slow">Buat Room Baru</button>
            </form>
            <hr class="my-6 border-blue-200 w-full">
            <!-- Form Gabung ke Room -->
            <form id="gabungRoomForm" class="w-full space-y-3 animate-fadeInCard">
                <label for="kode_room" class="font-semibold text-blue-900">Kode Room</label>
                <input type="text" id="kode_room" placeholder="Masukkan kode room" required class="w-full px-4 py-2 rounded-md border-2 border-blue-900/30 focus:border-blue-800 focus:ring-2 focus:ring-blue-800 bg-blue-50 text-blue-900 transition">
                <button type="submit" class="w-full py-2 mt-2 bg-blue-800 text-white font-bold rounded-md shadow-lg hover:bg-blue-900 transition animate-pulse-slow">Gabung ke Room</button>
            </form>
            <!-- Ilustrasi SVG bawah -->
            <svg class="mx-auto mt-6 opacity-25 animate-pulse" width="180" height="80" viewBox="0 0 180 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                <ellipse cx="90" cy="70" rx="60" ry="8" fill="#1e3a8a" opacity="0.18" />
                <circle cx="40" cy="40" r="24" fill="#eaf1fb" stroke="#4f8cff" stroke-width="3" />
                <circle cx="140" cy="35" r="20" fill="#eaf1fb" stroke="#2c3e50" stroke-width="3" />
                <rect x="70" y="20" width="40" height="28" rx="10" fill="#fff" stroke="#4f8cff" stroke-width="2" />
                <rect x="80" y="32" width="20" height="6" rx="3" fill="#eaf1fb" />
            </svg>
        </div>
    </main>
    <footer class="text-center py-4 text-blue-100 text-sm mt-8 animate-fadeInUp">
        &copy; 2025 Demote - Diskusi Kolaboratif
    </footer>
    <script>
        // Buat Room Baru
        document.getElementById('buatRoomForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const namaTim = document.getElementById('nama_tim').value.trim();

            if (!namaTim) {
                alert("Silakan isi nama tim terlebih dahulu!");
                return;
            }

            fetch("api/buat_room.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        nama_tim: namaTim
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        alert("Room berhasil dibuat!\nKode: " + data.kode_room);

                        // Simpan ke sessionStorage
                        sessionStorage.setItem("room_id", data.room_id);
                        sessionStorage.setItem("room_kode", data.kode_room);
                        sessionStorage.setItem("room_nama", data.nama_tim);
                        sessionStorage.setItem("diskusi_id", data.diskusi_id);

                        // Tambahan: Simpan juga session login jika ada di sessionStorage
                        if (!sessionStorage.getItem("user_id")) {
                            fetch("api/cek_session.php")
                                .then(res => res.json())
                                .then(sess => {
                                    if (sess.status === "active") {
                                        sessionStorage.setItem("user_id", sess.user_id);
                                        sessionStorage.setItem("role", sess.role);
                                        sessionStorage.setItem("nama", sess.nama);
                                    }
                                    window.location.href = "room.php";
                                });
                        } else {
                            window.location.href = "room.php";
                        }
                    } else {
                        alert("Gagal membuat room: " + data.message);
                    }
                })
                .catch(err => {
                    console.error("Error:", err);
                    alert("Terjadi kesalahan saat menghubungi server.");
                });
        });

        // Gabung ke Room
        document.getElementById('gabungRoomForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const kodeRoom = document.getElementById('kode_room').value.trim();

            if (!kodeRoom) {
                alert("Silakan isi kode room terlebih dahulu!");
                return;
            }

            fetch("api/cek_room.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        kode_room: kodeRoom
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        // Simpan data ke sessionStorage
                        sessionStorage.setItem("room_id", data.data.id);
                        sessionStorage.setItem("room_kode", data.data.kode_room);
                        sessionStorage.setItem("room_nama", data.data.nama_tim);
                        sessionStorage.setItem("diskusi_id", data.data.diskusi_id);

                        // Tambahan: Simpan juga session login jika ada di sessionStorage
                        if (!sessionStorage.getItem("user_id")) {
                            fetch("api/cek_session.php")
                                .then(res => res.json())
                                .then(sess => {
                                    if (sess.status === "active") {
                                        sessionStorage.setItem("user_id", sess.user_id);
                                        sessionStorage.setItem("role", sess.role);
                                        sessionStorage.setItem("nama", sess.nama);
                                    }
                                    window.location.href = "room.php";
                                });
                        } else {
                            window.location.href = "room.php";
                        }
                    } else {
                        alert("Kode room tidak ditemukan: " + data.message);
                    }
                })
                .catch(err => {
                    console.error("Error:", err);
                    alert("Terjadi kesalahan saat menghubungi server.");
                });
        });
    </script>
</body>

</html>