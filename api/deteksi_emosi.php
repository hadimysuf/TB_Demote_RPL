<?php
header('Content-Type: application/json');

// Ganti dengan API key Gemini Anda
define('GEMINI_API_KEY', 'AIzaSyC5B-K28ugCZcEvK4Rzt-RdoecXuJav1k8');

function detect_emotion($text)
{
    // Daftar kata kunci emosi positif dan negatif (bisa dikembangkan)
    $positif = [
        'bahagia',
        'senang',
        'gembira',
        'bangga',
        'bersyukur',
        'tenang',
        'puas',
        'semangat',
        'tertarik',
        'terinspirasi',
        'percaya diri',
        'cinta',
        'peduli',
        'terharu',
        'takjub',
        'optimis',
        'antusias',
        'aman',
        'dihargai',
        'diterima',
        'berdaya',
        'bersemangat',
        'berharap',
        'lega',
        'sukses',
        'nyaman',
        'beruntung',
        'terkoneksi',
        'penuh harapan',
        'termotivasi',
        'alhamdulillah',
        'syukur',
        'lega',
        'terpuaskan',
        'terhibur',
        'terinspirasi',
        'berbahagia',
        'merasa dihargai',
        'merasa diterima',
        'merasa berdaya',
        'merasa bersemangat',
        'merasa lega'
    ];
    $negatif = [
        'sedih',
        'kecewa',
        'frustrasi',
        'putus asa',
        'malu',
        'takut',
        'khawatir',
        'cemas',
        'gelisah',
        'marah',
        'kesal',
        'jengkel',
        'iri',
        'cemburu',
        'tertekan',
        'lelah',
        'bosan',
        'bingung',
        'ragu',
        'terluka',
        'merasa gagal',
        'tidak berdaya',
        'minder',
        'terasing',
        'sakit hati',
        'malas',
        'panik',
        'terhina',
        'tersinggung',
        'terintimidasi',
        'terbebani',
        'terabaikan',
        'merasa bersalah',
        'merasa ditolak',
        'merasa tidak cukup',
        'pusing',
        'ga tau',
        'ga jelas',
        'ga paham',
        'ga ngerti'
    ];
    $text_lc = strtolower($text);
    // Normalisasi spasi agar pencocokan frasa seperti 'ga tau', 'ga ngerti' lebih akurat
    $text_lc = preg_replace('/\s+/', ' ', $text_lc);
    foreach ($positif as $kata) {
        $kata_norm = preg_replace('/\s+/', ' ', strtolower($kata));
        if (strpos($text_lc, $kata_norm) !== false) return 'positif';
    }
    foreach ($negatif as $kata) {
        $kata_norm = preg_replace('/\s+/', ' ', strtolower($kata));
        if (strpos($text_lc, $kata_norm) !== false) return 'negatif';
    }
    // fallback ke model Gemini jika tidak ditemukan kata kunci
    $url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=' . GEMINI_API_KEY;
    $prompt = [
        [
            'role' => 'user',
            'parts' => [
                [
                    'text' => "Klasifikasikan emosi dari teks berikut sebagai 'positif', 'negatif', atau 'netral'. Jawab hanya dengan salah satu label tersebut, tanpa penjelasan.\n\nContoh:\nTeks: Saya merasa senang sekali hari ini.\nLabel: positif\nTeks: Aku sedih dan kecewa dengan hasil diskusi.\nLabel: negatif\nTeks: Diskusinya biasa saja.\nLabel: netral\nTeks: Saya marah karena tidak didengarkan.\nLabel: negatif\nTeks: Saya puas dengan hasilnya.\nLabel: positif\n\nKata-kata seperti sedih, kecewa, marah, takut, cemas, khawatir, putus asa, frustasi, galau, dan sejenisnya harus diberi label 'negatif'.\n\nTeks: $text\nLabel:"
                ]
            ]
        ]
    ];
    $data = [
        'contents' => $prompt
    ];
    $options = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
            'timeout' => 15
        ]
    ];
    $context  = stream_context_create($options);
    $result = @file_get_contents($url, false, $context);
    if ($result === FALSE) {
        return null;
    }
    $response = json_decode($result, true);
    if (isset($response['candidates'][0]['content']['parts'][0]['text'])) {
        $label = strtolower(trim($response['candidates'][0]['content']['parts'][0]['text']));
        if (in_array($label, ['positif', 'negatif', 'netral'])) {
            return $label;
        }
    }
    return null;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $text = isset($input['teks']) ? $input['teks'] : '';
    if (!$text) {
        echo json_encode(['success' => false, 'error' => 'Teks tidak ditemukan']);
        exit;
    }
    $label = detect_emotion($text);
    if ($label) {
        echo json_encode(['success' => true, 'label' => $label]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Gagal mendeteksi emosi']);
    }
    exit;
}

echo json_encode(['success' => false, 'error' => 'Metode tidak didukung']);
