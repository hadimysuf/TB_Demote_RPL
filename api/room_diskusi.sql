-- Tambahkan tabel room_diskusi
CREATE TABLE IF NOT EXISTS room_diskusi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_tim VARCHAR(100) NOT NULL,
    kode_room VARCHAR(20) NOT NULL UNIQUE,
    host_id INT NOT NULL,
    diskusi_id INT NOT NULL,
    FOREIGN KEY (host_id) REFERENCES users(id),
    FOREIGN KEY (diskusi_id) REFERENCES diskusi(id)
);

-- Tambahkan kolom judul dan pembuat_id ke tabel diskusi jika belum ada
ALTER TABLE diskusi ADD COLUMN IF NOT EXISTS judul VARCHAR(255) DEFAULT NULL;
ALTER TABLE diskusi ADD COLUMN IF NOT EXISTS pembuat_id INT DEFAULT NULL;
ALTER TABLE diskusi ADD CONSTRAINT fk_diskusi_pembuat FOREIGN KEY (pembuat_id) REFERENCES users(id);
