<?php
// tim.php hasil konversi dari tim.html
include 'session/proteksi.php';
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kelola Tim - Demote</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: linear-gradient(120deg, #4f8cff 0%, #2c3e50 100%);
            min-height: 100vh;
        }

        .navbar {
            background: rgba(44, 62, 80, 0.98);
            color: #fff;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 12px rgba(44, 62, 80, 0.08);
        }

        .navbar .brand {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1.2rem;
            font-weight: bold;
        }

        .navbar img {
            height: 38px;
            width: auto;
            vertical-align: middle;
            border-radius: 6px;
            background: #fff;
            box-shadow: 0 1px 4px rgba(44, 62, 80, 0.10);
        }

        .navbar a {
            color: #fff;
            text-decoration: none;
            margin-left: 1.2rem;
            font-weight: bold;
            transition: color 0.2s;
        }

        .navbar a:hover {
            color: #4f8cff;
        }

        .container {
            max-width: 900px;
            margin: 3rem auto;
            padding: 2rem;
        }

        .card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(44, 62, 80, 0.10);
            margin-bottom: 2rem;
        }

        h2 {
            color: #2c3e50;
        }

        ul {
            list-style: none;
            padding-left: 1rem;
        }

        li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
        }

        button {
            margin-top: 1rem;
            padding: 0.6em 1.2em;
            background: linear-gradient(90deg, #4f8cff 60%, #2c3e50 100%);
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
            transition: background 0.2s;
        }

        button:hover {
            background: linear-gradient(90deg, #2c3e50 0%, #4f8cff 100%);
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <div class="brand">
            <img src="img/demote_logos.png" alt="Logo Demote" onerror="this.src='https://placehold.co/60x38?text=Logo'">
            Demote - Kelola Tim
        </div>
        <div>
            <a href="dashboard_dosen.php">Dashboard</a>
            <a href="api/logout.php">Logout</a>
        </div>
    </nav>
    <div class="container">
        <h2>👥 Daftar Tim & Anggota</h2>
        <div id="daftarTim">
            <p>Memuat daftar tim...</p>
        </div>
    </div>
    <script>
        fetch('api/get_tim_anggota.php')
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.data.length > 0) {
                    let html = '';
                    data.data.forEach(tim => {
                        html += `<div class="card" style="margin-bottom:2rem;">
              <h3 style="color:#2c3e50;">${tim.nama_tim}</h3>
              <ul style="padding-left:1.2rem;">`;
                        if (tim.anggota.length > 0) {
                            tim.anggota.forEach(a => {
                                html += `<li>${a.nama} <span style="color:#888;font-size:0.95em;">(${a.role})</span></li>`;
                            });
                        } else {
                            html += `<li style="color:#b0b0b0;font-style:italic;">Belum ada anggota</li>`;
                        }
                        html += `</ul></div>`;
                    });
                    document.getElementById('daftarTim').innerHTML = html;
                } else {
                    document.getElementById('daftarTim').innerHTML = '<p>Tidak ada tim ditemukan.</p>';
                }
            });
    </script>
</body>

</html>