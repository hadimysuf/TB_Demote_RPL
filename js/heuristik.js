function deteksiEmosi(teks) {
  teks = teks.toLowerCase();
  const positif = ['senang', 'puas', 'berhasil', 'bagus', 'baik'];
  const negatif = ['marah', 'kesal', 'buruk', 'gagal', 'bingung', 'pusing'];

  for (let kata of positif) if (teks.includes(kata)) return 'positif';
  for (let kata of negatif) if (teks.includes(kata)) return 'negatif';
  return 'netral';
}
