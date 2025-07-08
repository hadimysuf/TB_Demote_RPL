<?php
// room.php hasil konversi dari room.html
include 'session/proteksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Room Diskusi - DEMOTE</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .fadeInUp {
            animation: fadeInUp 0.8s;
        }

        .fadeInCard {
            animation: fadeInCard 1s;
        }

        .glass-navbar {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(12px);
            box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.07);
        }

        .floating-shape {
            position: absolute;
            border-radius: 9999px;
            opacity: 0.25;
            filter: blur(2px);
            z-index: 0;
            animation: float 6s ease-in-out infinite alternate;
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

        @keyframes fadeInCard {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes float {
            from {
                transform: translateY(0px);
            }

            to {
                transform: translateY(-30px);
            }
        }
    </style>
</head>

<body>

    <!-- Floating shapes background -->
    <div class="fixed inset-0 -z-10">
        <div class="floating-shape bg-blue-400 w-60 h-60 top-10 left-10"></div>
        <div class="floating-shape bg-purple-300 w-40 h-40 bottom-20 right-20"></div>
        <div class="floating-shape bg-cyan-300 w-32 h-32 top-1/2 left-1/2"></div>
    </div>

    <!-- Navbar glassmorphism -->
    <nav class="flex items-center justify-between glass-navbar text-white px-6 py-4 shadow-lg relative animate-fadeInUp z-20" style="background:rgba(30,58,138,0.85);box-shadow:0 8px 32px 0 rgba(31,38,135,0.15);backdrop-filter:blur(8px);border-bottom:1.5px solid rgba(59,130,246,0.10);">
        <div class="flex items-center gap-3 font-bold text-lg">
            <img src="img/demote_logos.png" alt="Logo Demote" class="h-10 w-auto rounded-md bg-white shadow transition-transform duration-300 hover:scale-110" onerror="this.src='https://placehold.co/60x38?text=Logo'">
            <span class="tracking-wide">Demote</span>
        </div>
        <div class="flex gap-4">
            <a href="#" onclick="sessionStorage.clear();location.href='index.html'" class="nav-underline hover:text-red-400 font-semibold transition-colors duration-300">Logout</a>
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
    <main class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-blue-100 via-blue-200 to-blue-300 pt-8 pb-0 fadeInUp">
        <div class="w-full max-w-2xl mx-auto mt-6 mb-2">
            <div class="bg-white/90 rounded-3xl shadow-xl p-6 fadeInCard relative z-10 border-2 border-blue-900/60" style="box-shadow: 0 8px 32px 0 rgba(30,58,138,0.10);">
                <h2 class="text-2xl font-bold text-blue-900 mb-1 text-center">Room Diskusi</h2>
                <p id="room-info" class="text-center text-blue-700 mb-4">Memuat informasi room...</p>
                <div id="chat-box" class="h-72 overflow-y-auto rounded-xl border-2 border-blue-900/30 bg-white/80 p-4 mb-4 shadow-inner transition-all"></div>
                <form class="flex gap-2" onsubmit="event.preventDefault(); kirimPesan();">
                    <input type="text" id="inputPesan" placeholder="Ketik pesan Anda..." class="flex-1 px-4 py-2 rounded-lg border-2 border-blue-900/30 focus:ring-2 focus:ring-blue-800 outline-none transition" autocomplete="off" />
                    <button type="submit" class="px-5 py-2 rounded-lg bg-blue-800 text-white font-semibold shadow hover:bg-blue-900 active:scale-95 transition disabled:opacity-50" id="btnKirim">Kirim</button>
                </form>
                <div class="flex justify-end mt-3">
                    <button onclick="akhiriDiskusi()" class="px-5 py-2 rounded-lg bg-red-500 text-white font-semibold shadow hover:bg-red-600 active:scale-95 transition">Akhiri Diskusi</button>
                </div>
            </div>
        </div>
        <!-- SVG Ilustrasi bawah -->
        <div class="w-full max-w-2xl mx-auto -mt-6 mb-8 z-0">
            <svg viewBox="0 0 600 80" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-20">
                <path d="M0 60 Q150 0 300 60 T600 60 V80 H0Z" fill="#a5b4fc" fill-opacity="0.25" />
                <path d="M0 70 Q150 20 300 70 T600 70 V80 H0Z" fill="#818cf8" fill-opacity="0.18" />
            </svg>
        </div>
    </main>

    <script>
        let diskusiId = sessionStorage.getItem("diskusi_id");
        const userId = sessionStorage.getItem("user_id");
        const role = sessionStorage.getItem("role") || "mahasiswa";
        const roomNama = sessionStorage.getItem("room_nama");
        const roomKode = sessionStorage.getItem("room_kode");

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("room-info").textContent =
                roomNama ? `Tim: ${roomNama} | Kode Room: ${roomKode}` : "Informasi room tidak ditemukan.";
            const btnKirim = document.getElementById('btnKirim');
            btnKirim.disabled = !diskusiId;
        });

        function enableKirimJikaSiap() {
            if (sessionStorage.getItem("diskusi_id")) {
                btnKirim.disabled = false;
            }
        }

        // Sinkronisasi sessionStorage dengan session PHP
        if (!userId) {
            fetch("api/cek_session.php")
                .then(res => res.json())
                .then(data => {
                    if (data.status === "active") {
                        sessionStorage.setItem("user_id", data.user_id);
                        sessionStorage.setItem("role", data.role);
                        sessionStorage.setItem("nama", data.nama);
                        // Reload agar variabel JS terisi ulang
                        location.reload();
                    } else {
                        alert("Session login tidak ditemukan. Silakan login ulang.");
                        window.location.href = "index.html";
                    }
                });
        }

        // Cek userId di awal, jika null redirect ke login
        if (!userId) {
            alert("Session login tidak ditemukan. Silakan login ulang.");
            window.location.href = "index.html";
        }

        // ⛔ Jika role mahasiswa dan belum ada diskusi_id, ambil dari room_diskusi
        if (!diskusiId && role === "mahasiswa" && roomKode) {
            fetch("api/cek_room.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        kode_room: roomKode
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        diskusiId = data.data.diskusi_id;
                        sessionStorage.setItem("diskusi_id", diskusiId);
                        enableKirimJikaSiap();
                        // Paksa reload agar diskusiId terupdate di seluruh script
                        location.reload();
                    } else {
                        alert("Gagal mendapatkan data diskusi dari room.");
                    }
                });
        }

        // ✅ Jika dosen, buat diskusi jika belum ada
        if (!diskusiId && role === "dosen") {
            fetch("api/buat_diskusi.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        judul: `Diskusi dari Room: ${roomNama}`
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        diskusiId = data.diskusi_id;
                        sessionStorage.setItem("diskusi_id", diskusiId);
                        enableKirimJikaSiap();
                        // Paksa reload agar diskusiId terupdate di seluruh script
                        location.reload();
                    } else {
                        alert("Gagal membuat diskusi: " + data.message);
                    }
                });
        }

        // Deteksi emosi menggunakan heuristik lokal (tanpa API Gemini)
        function deteksiEmosi(teks) {
            // Contoh heuristik sederhana: jika ada kata negatif/kata positif
            const positif = ["senang", "bahagia", "gembira", "semangat", "hebat", "bagus", "mantap"];
            const negatif = ["sedih", "marah", "kesal", "kecewa", "buruk", "jelek", "parah"];
            const teksLower = teks.toLowerCase();
            for (const kata of positif) {
                if (teksLower.includes(kata)) return "positif";
            }
            for (const kata of negatif) {
                if (teksLower.includes(kata)) return "negatif";
            }
            return "netral";
        }

        async function kirimPesan() {
            // Ambil ulang userId dan diskusiId dari sessionStorage (antisipasi reload)
            const isi = document.getElementById("inputPesan").value.trim();
            const userIdNow = sessionStorage.getItem("user_id");
            const diskusiIdNow = sessionStorage.getItem("diskusi_id");
            if (!isi || !userIdNow || !diskusiIdNow) {
                alert("Gagal mengirim komentar: Data tidak lengkap: diskusi_id, user_id, atau isi kosong.\nuserId=" + userIdNow + ", diskusiId=" + diskusiIdNow);
                return;
            }

            // Deteksi emosi via backend Gemini
            const label = await deteksiEmosi(isi);

            fetch("api/simpan_komentar.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        diskusi_id: parseInt(diskusiIdNow),
                        user_id: parseInt(userIdNow),
                        isi: isi,
                        label: label
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        document.getElementById("inputPesan").value = "";
                        // Setelah kirim, reload chat agar semua pesan tampil (termasuk dari user lain)
                        loadChat();
                    } else {
                        alert("Gagal mengirim komentar: " + data.message);
                    }
                });
        }

        function akhiriDiskusi() {
            if (confirm("Yakin ingin mengakhiri diskusi?")) {
                if (role === "mahasiswa") {
                    window.location.href = "form_emosi.php";
                } else {
                    sessionStorage.removeItem("diskusi_id");
                    window.location.href = "dashboard_dosen.php";
                }
            }
        }

        function loadChat() {
            if (!diskusiId) return;
            fetch("api/get_komentar.php?diskusi_id=" + encodeURIComponent(diskusiId))
                .then(res => res.json())
                .then(data => {
                    if (data.status === "success") {
                        const chatBox = document.getElementById("chat-box");
                        chatBox.innerHTML = "";
                        data.data.forEach(row => {
                            // Pilih warna bubble dan alignment berdasarkan user (mahasiswa/dosen/self)
                            const isSelf = row.user_id == userId;
                            const isDosen = row.role === 'dosen';
                            const bubbleColor = isSelf ? 'bg-blue-500 text-white' : (isDosen ? 'bg-purple-400 text-white' : 'bg-gray-100 text-blue-900');
                            const align = isSelf ? 'justify-end' : 'justify-start';
                            const nameFont = isDosen ? 'font-bold text-purple-700' : 'font-semibold text-blue-700';
                            const emosiBadge = row.label_emosi === 'positif' ?
                                '<span class="ml-2 px-2 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-700">😊 Positif</span>' :
                                (row.label_emosi === 'negatif' ?
                                    '<span class="ml-2 px-2 py-0.5 rounded-full text-xs font-semibold bg-red-100 text-red-700">😟 Negatif</span>' :
                                    '<span class="ml-2 px-2 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">😐 Netral</span>');
                            const bubble = document.createElement('div');
                            bubble.className = `flex ${align} mb-2`;
                            bubble.innerHTML = `
            <div class="max-w-[80%] px-4 py-2 rounded-2xl shadow-md ${bubbleColor} fadeInCard">
              <div class="flex items-center gap-2 mb-1">
                <span class="${nameFont}">${row.nama_user}</span>
                ${emosiBadge}
              </div>
              <div class="text-sm">${row.isi}</div>
            </div>
          `;
                            chatBox.appendChild(bubble);
                        });
                        chatBox.scrollTop = chatBox.scrollHeight;
                    }
                });
        }

        document.addEventListener("DOMContentLoaded", function() {
            loadChat();
            setInterval(loadChat, 4000); // update chat tiap 4 detik
        });
    </script>
</body>

</html>