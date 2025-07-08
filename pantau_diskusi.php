<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pantau Diskusi - Demote</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
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

        .bubble-chat {
            background: #eaf1fb;
            border-radius: 1.2rem;
            padding: 0.7rem 1.2rem;
            margin-bottom: 1.1rem;
            box-shadow: 0 2px 8px 0 rgba(59, 130, 246, 0.08);
            border: 1.5px solid #4f8cff22;
            transition: box-shadow 0.3s, border 0.3s;
        }

        .bubble-chat .komentar-nama {
            color: #2563eb;
            font-weight: bold;
        }

        .bubble-chat .komentar-tgl {
            color: #64748b;
            font-size: 0.92em;
            margin-left: 0.5rem;
        }

        .bubble-chat .komentar-isi {
            margin-top: 0.2rem;
            color: #22223b;
        }

        .bubble-chat:hover {
            box-shadow: 0 8px 32px 0 rgba(59, 130, 246, 0.18);
            border: 1.5px solid #2563eb;
        }
    </style>
</head>

<body>
    <nav class="flex items-center justify-between glass-navbar text-white px-6 py-4 shadow-lg relative animate-fadeInUp">
        <div class="flex items-center gap-3 font-bold text-lg">
            <img src="img/demote_logos.png" alt="Logo Demote" class="h-10 w-auto rounded-md bg-white shadow transition-transform duration-300 hover:scale-110" onerror="this.src='https://placehold.co/60x38?text=Logo'">
            <span class="tracking-wide">Demote</span>
            <span class="ml-2 text-base font-normal text-blue-200/90 hidden sm:inline">| Pantau Diskusi</span>
        </div>
        <div class="flex gap-4">
            <a href="dashboard_dosen.php" class="nav-underline hover:text-blue-400 font-semibold transition-colors duration-300">Dashboard</a>
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
    <div class="fixed inset-0 -z-10">
        <div class="floating-shape bg-blue-400 w-60 h-60 top-10 left-10"></div>
        <div class="floating-shape bg-purple-300 w-40 h-40 bottom-20 right-20"></div>
    </div>
    <main class="flex flex-col items-center justify-center min-h-[70vh] pt-8 pb-0 animate-fadeInUp">
        <div class="w-full max-w-3xl mx-auto mt-6 mb-2">
            <div class="bg-white/90 rounded-3xl shadow-xl p-8 animate-fadeInCard relative z-10 border-2 border-blue-900/60">
                <h2 class="text-2xl font-bold text-blue-900 mb-1 text-center flex items-center justify-center gap-2">👀 Pantau Diskusi</h2>
                <div class="flex flex-col md:flex-row gap-6 mb-8">
                    <form id="formJoinRoom" class="flex-1 max-w-md mx-auto bg-blue-50/60 rounded-xl p-6 shadow border border-blue-200/60 animate-fadeInCard flex flex-col h-full justify-between">
                        <div>
                            <label for="kode_room_join" class="block font-semibold text-blue-900 mb-1">Masukkan Kode Room untuk Join Diskusi</label>
                            <input type="text" id="kode_room_join" placeholder="Contoh: S9LX5B" required class="w-full px-4 py-3 rounded-lg border-2 border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition mb-2 bg-white/80 text-blue-900 font-semibold" />
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-900 text-white font-bold rounded-lg px-6 py-3 shadow-lg hover:from-blue-700 hover:to-blue-500 transition mt-2">Join Room</button>
                    </form>
                    <form id="formBuatRoom" class="flex-1 max-w-md mx-auto bg-blue-50/60 rounded-xl p-6 shadow border border-blue-200/60 animate-fadeInCard flex flex-col h-full justify-between">
                        <div>
                            <label for="nama_tim_buat" class="block font-semibold text-blue-900 mb-1">Buat Room<br>Diskusi Baru</label>
                            <input type="text" id="nama_tim_buat" placeholder="Nama Tim/Room" required class="w-full px-4 py-3 rounded-lg border-2 border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition mb-2 bg-white/80 text-blue-900 font-semibold" />
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-500 to-blue-900 text-white font-bold rounded-lg px-6 py-3 shadow-lg hover:from-blue-700 hover:to-blue-500 transition mt-2">Buat Room</button>
                    </form>
                </div>
                <div id="daftarDiskusi" class="animate-fadeInCard mt-4">
                    <p>Memuat daftar room/tim diskusi...</p>
                </div>
                <div id="riwayatDiskusi" style="display:none;">
                    <h3 class="text-lg font-bold text-blue-800 mb-2 mt-6">Riwayat Percakapan</h3>
                    <div class="riwayat-box bg-blue-50/60 rounded-xl p-4 shadow-inner border border-blue-200/60 min-h-[120px] max-h-[350px] overflow-y-auto" id="riwayatBox">
                        <p>Silakan pilih room/tim untuk melihat riwayat diskusi.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        // Join Room Handler
        document.getElementById('formJoinRoom').addEventListener('submit', function(e) {
            e.preventDefault();
            const kode = document.getElementById('kode_room_join').value.trim();
            if (!kode) {
                alert('Silakan masukkan kode room!');
                return;
            }
            fetch('api/cek_room.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        kode_room: kode
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        alert('Berhasil join ke room: ' + data.data.nama_tim);
                        // Reload daftar diskusi agar room baru muncul
                        window.location.reload();
                    } else {
                        alert('Gagal join room: ' + data.message);
                    }
                })
                .catch(async (err) => {
                    // Coba ambil pesan error dari response jika ada
                    let errorMsg = 'Terjadi kesalahan saat menghubungi server.';
                    if (err && err instanceof Response) {
                        try {
                            const data = await err.json();
                            if (data && data.message) errorMsg = data.message;
                        } catch {}
                    }
                    alert(errorMsg + (err && err.message ? ('\nDetail: ' + err.message) : ''));
                });
        });
        // Ambil daftar diskusi/tim
        fetch('api/get_dashboard.php?role=dosen')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.data.length > 0) {
                    let html = `<div class="overflow-x-auto">
            <table class="min-w-full border-separate border-spacing-y-2">
              <thead>
                <tr class="bg-blue-100/80">
                  <th class="px-4 py-2 rounded-l-xl text-blue-900 font-bold text-left">Nama Tim</th>
                  <th class="px-4 py-2 text-blue-900 font-bold text-left">Kode Room</th>
                  <th class="px-4 py-2 rounded-r-xl text-blue-900 font-bold text-left">Aksi</th>
                </tr>
              </thead>
              <tbody>`;
                    data.data.forEach(item => {
                        html += `<tr class="bg-white/80 hover:bg-blue-50 transition rounded-xl shadow group">
              <td class="px-4 py-2 font-semibold text-blue-800 group-hover:text-blue-900 rounded-l-xl">${item.nama_tim}</td>
              <td class="px-4 py-2 font-mono text-blue-700 group-hover:text-blue-900">${item.kode_room}</td>
              <td class="px-4 py-2 rounded-r-xl flex gap-2">
                <button class="bg-gradient-to-r from-blue-500 to-blue-900 text-white font-bold rounded-lg px-4 py-2 shadow hover:from-blue-700 hover:to-blue-500 transition" onclick="lihatRiwayat('${item.diskusi_id}', '${item.nama_tim.replace(/'/g, '\'')}')">Lihat Riwayat</button>
                <button class="bg-white border border-blue-500 text-blue-700 font-bold rounded-lg px-3 py-2 shadow hover:bg-blue-50 transition flex items-center gap-1" title="Lihat Anggota Tim" onclick="lihatAnggotaTim('${item.kode_room}', '${item.nama_tim.replace(/'/g, '\'')}')">
                  <svg xmlns='http://www.w3.org/2000/svg' class='inline w-5 h-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4a4 4 0 11-8 0 4 4 0 018 0z' /></svg>
                  <span class="hidden md:inline">Anggota</span>
                </button>
              </td>
            </tr>`;
                    });
                    html += `</tbody></table></div>`;
                    document.getElementById('daftarDiskusi').innerHTML = html;
                } else {
                    document.getElementById('daftarDiskusi').innerHTML = '<p>Tidak ada data diskusi ditemukan.</p>';
                }
            });
        // Handler Buat Room (khusus dosen, hanya membuat, tidak join)
        document.getElementById('formBuatRoom').addEventListener('submit', function(e) {
            e.preventDefault();
            const nama = document.getElementById('nama_tim_buat').value.trim();
            if (!nama) {
                alert('Silakan masukkan nama tim/room!');
                return;
            }
            fetch('api/buat_room.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        nama_tim: nama
                    })
                })
                .then(async res => {
                    let data;
                    try {
                        data = await res.json();
                    } catch (e) {
                        // Jika response bukan JSON, tampilkan response text
                        const text = await res.text();
                        alert('Gagal membuat room.\nStatus: ' + res.status + '\nResponse: ' + text);
                        return;
                    }
                    if (data.status === 'success') {
                        alert('Room berhasil dibuat! Kode Room: ' + (data.data?.kode_room || data.kode_room));
                        window.location.reload();
                    } else {
                        alert('Gagal membuat room: ' + (data.message || JSON.stringify(data)));
                    }
                })
                .catch((err) => {
                    alert('Terjadi kesalahan saat menghubungi server.\nDetail: ' + (err && err.message ? err.message : err));
                });
        });

        // Fungsi lihat riwayat
        function lihatRiwayat(diskusi_id, nama_tim) {
            document.getElementById('riwayatDiskusi').style.display = 'block';
            document.getElementById('riwayatBox').innerHTML = '<p>Memuat riwayat diskusi...</p>';
            fetch('api/get_komentar.php?diskusi_id=' + encodeURIComponent(diskusi_id))
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success' && data.data.length > 0) {
                        let html = '';
                        data.data.forEach(k => {
                            // Gunakan k.nama_user dan k.timestamp jika ada, fallback jika tidak
                            const nama = k.nama_user || k.nama || 'Tidak diketahui';
                            const tgl = k.timestamp || k.tanggal || '-';
                            html += `<div class="bubble-chat">
                <span class="komentar-nama">${nama}</span>
                <span class="komentar-tgl"> &bull; ${tgl}</span>
                <div class="komentar-isi">${k.isi}</div>
              </div>`;
                        });
                        document.getElementById('riwayatBox').innerHTML = html;
                    } else {
                        document.getElementById('riwayatBox').innerHTML = '<p>Belum ada percakapan pada diskusi ini.</p>';
                    }
                })
                .catch(() => {
                    document.getElementById('riwayatBox').innerHTML = '<p>Gagal memuat riwayat diskusi.</p>';
                });
        }
        // Modal Anggota Tim
        function lihatAnggotaTim(kode_room, nama_tim) {
            // Modal HTML
            let modal = document.getElementById('modalAnggotaTim');
            if (!modal) {
                modal = document.createElement('div');
                modal.id = 'modalAnggotaTim';
                modal.className = 'fixed inset-0 z-50 flex items-center justify-center bg-black/40';
                modal.innerHTML = `
          <div class="bg-white rounded-2xl shadow-2xl max-w-lg w-full p-7 relative animate-fadeInUp">
            <button onclick="document.getElementById('modalAnggotaTim').remove()" class="absolute top-3 right-3 text-blue-900 hover:text-red-500 text-2xl font-bold">&times;</button>
            <h3 class="text-xl font-bold text-blue-900 mb-4 flex items-center gap-2"><svg xmlns='http://www.w3.org/2000/svg' class='inline w-6 h-6' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m9-4a4 4 0 11-8 0 4 4 0 018 0z' /></svg> Anggota yang Join <span class="text-base font-normal text-blue-700 ml-2">(${nama_tim})</span></h3>
            <div id="anggotaTimList" class="space-y-2 min-h-[80px]">Memuat data anggota...</div>
          </div>
        `;
                document.body.appendChild(modal);
            }
            // Fetch seluruh tim dan filter berdasarkan nama_tim
            fetch('api/get_tim_anggota.php')
                .then(res => res.json())
                .then(data => {
                    let html = '';
                    if (data.status === 'success' && data.data.length > 0) {
                        // Temukan tim yang sesuai nama_tim
                        const tim = data.data.find(t => t.nama_tim === nama_tim);
                        if (tim && tim.anggota && tim.anggota.length > 0) {
                            tim.anggota.forEach(a => {
                                html += `<div class=\"flex items-center gap-3 bg-green-50 rounded-lg px-4 py-2 shadow\">
                  <span class=\"font-semibold text-green-900\">${a.nama}</span>
                </div>`;
                            });
                        } else {
                            html = '<div class=\"text-center text-gray-500\">Belum ada yang join.</div>';
                        }
                    } else {
                        html = '<div class=\"text-center text-gray-500\">Belum ada yang join.</div>';
                    }
                    document.getElementById('anggotaTimList').innerHTML = html;
                })
                .catch(() => {
                    document.getElementById('anggotaTimList').innerHTML = '<div class=\"text-center text-red-500\">Gagal memuat data anggota.</div>';
                });
        }
    </script>
</body>

</html>