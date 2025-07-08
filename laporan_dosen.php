<?php
// laporan_dosen.php hasil konversi dari laporan_dosen.html
include 'session/proteksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Dosen - Demote</title>
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

        .badge-emosi {
            display: inline-block;
            padding: 0.2em 0.7em;
            border-radius: 1em;
            font-size: 0.95em;
            font-weight: 600;
        }

        .badge-positif {
            background: #2ecc71;
            color: white;
        }

        .badge-negatif {
            background: #e74c3c;
            color: white;
        }

        .badge-netral {
            background: #f1c40f;
            color: #222;
        }
    </style>
    <!-- jsPDF CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <nav class="flex items-center justify-between glass-navbar text-white px-6 py-4 shadow-lg relative animate-fadeInUp">
        <div class="flex items-center gap-3 font-bold text-lg">
            <img src="img/demote_logos.png" alt="Logo Demote" class="h-10 w-auto rounded-md bg-white shadow transition-transform duration-300 hover:scale-110" onerror="this.src='https://placehold.co/60x38?text=Logo'">
            <span class="tracking-wide">Demote</span>
            <span class="ml-2 text-base font-normal text-blue-200/90 hidden sm:inline">| Laporan Dosen</span>
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
    <div class="w-full max-w-5xl mx-auto mt-8 mb-8">
        <div class="flex justify-end mb-4">
            <button class="bg-gradient-to-r from-blue-500 to-blue-900 text-white font-bold rounded-lg px-6 py-3 shadow-lg hover:from-blue-700 hover:to-blue-500 transition" onclick="exportPDF('laporanFull', 'Laporan_Dosen.pdf')">Export PDF</button>
        </div>
        <div class="bg-white/90 rounded-3xl shadow-xl p-8 animate-fadeInCard relative z-10 border-2 border-blue-900/60" id="laporanFull">
            <h2 class="text-2xl font-bold text-blue-900 mb-1 text-center">📊 Laporan Aktivitas Diskusi & Refleksi</h2>
            <div class="section mt-8" id="laporanDiskusi">
                <h3 class="text-lg font-bold text-blue-800 mb-2">Rekap Aktivitas Diskusi</h3>
                <input type="text" id="searchDiskusi" placeholder="Cari nama tim / kode room..." class="w-full max-w-xs px-4 py-2 rounded-lg border-2 border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition mb-4 bg-white/80 text-blue-900 font-semibold" />
                <div id="tabelDiskusiWrap">
                    <p>Memuat data diskusi...</p>
                </div>
                <div class="max-w-xl mx-auto mt-8">
                    <canvas id="chartEmosi"></canvas>
                </div>
            </div>
            <div class="section mt-12" id="laporanRefleksi">
                <h3 class="text-lg font-bold text-blue-800 mb-2">Rekap Refleksi Emosi Mahasiswa</h3>
                <input type="text" id="searchRefleksi" placeholder="Cari nama / isi refleksi..." class="w-full max-w-xs px-4 py-2 rounded-lg border-2 border-blue-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 outline-none transition mb-4 bg-white/80 text-blue-900 font-semibold" />
                <div id="tabelRefleksiWrap">
                    <p>Memuat data refleksi...</p>
                </div>
                <div class="max-w-xl mx-auto mt-8">
                    <canvas id="chartEmosiRefleksi"></canvas>
                </div>
                <div id="tabelRincianRefleksi" class="mt-8 max-w-3xl mx-auto"></div>
            </div>
        </div>
    </div>
    <script>
        // Data cache
        let diskusiData = [];
        let refleksiData = [];

        // Render tabel diskusi
        function renderDiskusiTable(data) {
            if (!data.length) {
                document.getElementById('tabelDiskusiWrap').innerHTML = '<p>Tidak ada data diskusi.</p>';
                return;
            }
            let html = `<div class="overflow-x-auto">
        <table class="min-w-full border-separate border-spacing-y-2">
          <thead>
            <tr class="bg-blue-100/80">
              <th class="px-4 py-2 rounded-l-xl text-blue-900 font-bold text-left">Nama Tim</th>
              <th class="px-4 py-2 text-blue-900 font-bold text-left">Kode Room</th>
              <th class="px-4 py-2 text-blue-900 font-bold text-left">Jumlah Anggota</th>
              <th class="px-4 py-2 text-blue-900 font-bold text-left">Jumlah Chat</th>
              <th class="px-4 py-2 text-blue-900 font-bold text-left">Chat Positif</th>
              <th class="px-4 py-2 text-blue-900 font-bold text-left">Chat Negatif</th>
              <th class="px-4 py-2 rounded-r-xl text-blue-900 font-bold text-left">Chat Netral</th>
            </tr>
          </thead>
          <tbody>`;
            data.forEach(row => {
                html += `<tr class="bg-white/80 hover:bg-blue-50 transition rounded-xl shadow group">
          <td class="px-4 py-2 font-semibold text-blue-800 group-hover:text-blue-900 rounded-l-xl">${row.nama_tim}</td>
          <td class="px-4 py-2 font-mono text-blue-700 group-hover:text-blue-900">${row.kode_room}</td>
          <td class="px-4 py-2">${row.jumlah_anggota}</td>
          <td class="px-4 py-2">${row.jumlah_chat}</td>
          <td class="px-4 py-2"><span class="badge-emosi badge-positif">${row.chat_positif ?? 0}</span></td>
          <td class="px-4 py-2"><span class="badge-emosi badge-negatif">${row.chat_negatif ?? 0}</span></td>
          <td class="px-4 py-2 rounded-r-xl"><span class="badge-emosi badge-netral">${row.chat_netral ?? 0}</span></td>
        </tr>`;
            });
            html += `</tbody></table></div>`;
            document.getElementById('tabelDiskusiWrap').innerHTML = html;
        }

        // Render tabel refleksi
        function renderRefleksiTable(data) {
            if (!data.length) {
                document.getElementById('tabelRefleksiWrap').innerHTML = '<p>Tidak ada data refleksi.</p>';
                return;
            }
            let html = `<div class="overflow-x-auto">
        <table class="min-w-full border-separate border-spacing-y-2">
          <thead>
            <tr class="bg-blue-100/80">
              <th class="px-4 py-2 rounded-l-xl text-blue-900 font-bold text-left">Waktu</th>
              <th class="px-4 py-2 text-blue-900 font-bold text-left">Nama Mahasiswa</th>
              <th class="px-4 py-2 text-blue-900 font-bold text-left">Refleksi</th>
              <th class="px-4 py-2 rounded-r-xl text-blue-900 font-bold text-left">Label Emosi</th>
            </tr>
          </thead>
          <tbody>`;
            data.forEach(row => {
                let badge = '';
                if (row.label_emosi === 'positif') badge = '<span class="badge-emosi badge-positif">Positif</span>';
                else if (row.label_emosi === 'negatif') badge = '<span class="badge-emosi badge-negatif">Negatif</span>';
                else badge = '<span class="badge-emosi badge-netral">Netral</span>';
                html += `<tr class="bg-white/80 hover:bg-blue-50 transition rounded-xl shadow group">
          <td class="px-4 py-2 font-mono text-blue-700 group-hover:text-blue-900 rounded-l-xl whitespace-nowrap">${row.timestamp}</td>
          <td class="px-4 py-2 font-semibold text-blue-800 group-hover:text-blue-900">${row.nama}</td>
          <td class="px-4 py-2 text-blue-900">${row.isi_perasaan}</td>
          <td class="px-4 py-2 rounded-r-xl">${badge}</td>
        </tr>`;
            });
            html += `</tbody></table></div>`;
            document.getElementById('tabelRefleksiWrap').innerHTML = html;
        }

        // Chart.js: render chart emosi chat diskusi
        let chartEmosi;

        function renderChartEmosiDiskusi(data) {
            let total = {
                positif: 0,
                negatif: 0,
                netral: 0
            };
            data.forEach(row => {
                total.positif += parseInt(row.chat_positif) || 0;
                total.negatif += parseInt(row.chat_negatif) || 0;
                total.netral += parseInt(row.chat_netral) || 0;
            });
            const ctx = document.getElementById('chartEmosi').getContext('2d');
            if (chartEmosi) chartEmosi.destroy();
            chartEmosi = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Positif', 'Negatif', 'Netral'],
                    datasets: [{
                        data: [total.positif, total.negatif, total.netral],
                        backgroundColor: ['#4caf50', '#e74c3c', '#f1c40f'],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Statistik Emosi Chat Diskusi'
                        }
                    }
                }
            });
        }

        // Chart.js: render chart emosi refleksi mahasiswa
        let chartEmosiRefleksi;

        function renderChartEmosiRefleksi(data) {
            let total = {
                positif: 0,
                negatif: 0,
                netral: 0
            };
            data.forEach(row => {
                if (row.label_emosi === 'positif') total.positif++;
                else if (row.label_emosi === 'negatif') total.negatif++;
                else total.netral++;
            });
            const ctx = document.getElementById('chartEmosiRefleksi').getContext('2d');
            if (chartEmosiRefleksi) chartEmosiRefleksi.destroy();
            chartEmosiRefleksi = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Positif', 'Negatif', 'Netral'],
                    datasets: [{
                        data: [total.positif, total.negatif, total.netral],
                        backgroundColor: ['#4caf50', '#e74c3c', '#f1c40f'],
                        borderWidth: 1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                            position: 'bottom'
                        },
                        title: {
                            display: true,
                            text: 'Statistik Emosi Refleksi Mahasiswa'
                        }
                    }
                }
            });
        }

        // Render tabel rincian refleksi per tim
        function renderTabelRincianRefleksi(data) {
            if (!data.length) {
                document.getElementById('tabelRincianRefleksi').innerHTML = '<p>Tidak ada data refleksi.</p>';
                return;
            }
            let count = {};
            data.forEach(row => {
                let key = row.label_emosi;
                if (!count[key]) count[key] = 0;
                count[key]++;
            });
            let html = `<div class="overflow-x-auto mt-6">
        <div class="bg-white/90 rounded-2xl shadow p-6 border border-blue-200/60 max-w-md mx-auto">
          <h4 class="text-center text-blue-900 font-bold mb-4">Rincian Emosi Refleksi</h4>
          <table class="min-w-full border-separate border-spacing-y-2">
            <thead>
              <tr class="bg-blue-100/80">
                <th class="px-4 py-2 rounded-l-xl text-blue-900 font-bold text-left">Label Emosi</th>
                <th class="px-4 py-2 rounded-r-xl text-blue-900 font-bold text-left">Jumlah</th>
              </tr>
            </thead>
            <tbody>`;
            ['positif', 'negatif', 'netral'].forEach(label => {
                let badge = '';
                if (label === 'positif') badge = '<span class="badge-emosi badge-positif">Positif</span>';
                else if (label === 'negatif') badge = '<span class="badge-emosi badge-negatif">Negatif</span>';
                else badge = '<span class="badge-emosi badge-netral">Netral</span>';
                html += `<tr class="bg-white/80 hover:bg-blue-50 transition rounded-xl shadow group">
          <td class="px-4 py-2 font-semibold">${badge}</td>
          <td class="px-4 py-2 rounded-r-xl">${count[label]||0}</td>
        </tr>`;
            });
            html += `</tbody></table></div></div>`;
            document.getElementById('tabelRincianRefleksi').innerHTML = html;
        }

        // Render tabel rincian emosi per tim
        function renderTabelRincianEmosi(data) {
            if (!data.length) {
                document.getElementById('tabelRincianEmosi').innerHTML = '<p>Tidak ada data tim.</p>';
                return;
            }
            let html = '<h4 style="margin-bottom:1rem;">Rincian Emosi per Tim</h4>';
            html += '<table style="width:100%;border-collapse:collapse;">';
            html += '<thead><tr style="background:#f0f0f0;"><th>Nama Tim</th><th>Kode Room</th><th>Jumlah Anggota</th><th>Positif</th><th>Negatif</th><th>Netral</th></tr></thead><tbody>';
            data.forEach(row => {
                html += `<tr><td>${row.nama_tim}</td><td>${row.kode_room}</td><td>${row.jumlah_anggota}</td><td>${row.chat_positif ?? 0}</td><td>${row.chat_negatif ?? 0}</td><td>${row.chat_netral ?? 0}</td></tr>`;
            });
            html += '</tbody></table>';
            document.getElementById('tabelRincianEmosi').innerHTML = html;
        }

        // Fetch data diskusi dan render chart emosi chat + tabel rincian
        fetch('api/rekap_diskusi.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.data.length > 0) {
                    diskusiData = data.data;
                    renderDiskusiTable(diskusiData);
                    renderChartEmosiDiskusi(diskusiData);
                    renderTabelRincianEmosi(diskusiData);
                } else {
                    renderDiskusiTable([]);
                    renderChartEmosiDiskusi([]);
                    renderTabelRincianEmosi([]);
                }
            });

        // Fetch data refleksi (feedback) mahasiswa yang sudah difilter backend
        fetch('api/rekap_refleksi.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.data.length > 0) {
                    refleksiData = data.data;
                    renderRefleksiTable(refleksiData);
                    renderChartEmosiRefleksi(refleksiData);
                    renderTabelRincianRefleksi(refleksiData);
                } else {
                    renderRefleksiTable([]);
                    renderChartEmosiRefleksi([]);
                    renderTabelRincianRefleksi([]);
                }
            });

        // Pencarian diskusi
        document.getElementById('searchDiskusi').addEventListener('input', function() {
            const q = this.value.toLowerCase();
            const filtered = diskusiData.filter(row =>
                row.nama_tim.toLowerCase().includes(q) || row.kode_room.toLowerCase().includes(q)
            );
            renderDiskusiTable(filtered);
        });

        // Pencarian refleksi
        document.getElementById('searchRefleksi').addEventListener('input', function() {
            const q = this.value.toLowerCase();
            const filtered = refleksiData.filter(row =>
                row.nama.toLowerCase().includes(q) || row.isi_perasaan.toLowerCase().includes(q)
            );
            renderRefleksiTable(filtered);
        });
        // Export PDF function
        function exportPDF(sectionId, filename) {
            const section = document.getElementById(sectionId);
            html2canvas(section, {
                scale: 2
            }).then(canvas => {
                const imgData = canvas.toDataURL('image/png');
                const pdf = new window.jspdf.jsPDF('p', 'mm', 'a4');
                const pageWidth = pdf.internal.pageSize.getWidth();
                const pageHeight = pdf.internal.pageSize.getHeight();
                const imgProps = pdf.getImageProperties(imgData);
                let pdfWidth = pageWidth - 20;
                let pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
                let position = 10;
                if (pdfHeight > pageHeight - 20) {
                    // Multi-page
                    while (pdfHeight > 0) {
                        pdf.addImage(imgData, 'PNG', 10, position, pdfWidth, Math.min(pdfHeight, pageHeight - 20));
                        pdfHeight -= (pageHeight - 20);
                        if (pdfHeight > 0) pdf.addPage();
                        position = 0;
                    }
                } else {
                    pdf.addImage(imgData, 'PNG', 10, 10, pdfWidth, pdfHeight);
                }
                pdf.save(filename);
            });
        }
    </script>
</body>

</html>