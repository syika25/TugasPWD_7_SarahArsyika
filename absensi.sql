-- Buat database
CREATE DATABASE IF NOT EXISTS sistem_absensi;
USE sistem_absensi;

-- Tabel absensi
CREATE TABLE IF NOT EXISTS absensi (
    id_absensi INT PRIMARY KEY AUTO_INCREMENT,
    nim VARCHAR(15) NOT NULL,
    nama_mahasiswa VARCHAR(100) NOT NULL,
    mata_kuliah VARCHAR(50),
    kelas VARCHAR(10),
    tanggal DATE NOT NULL,
    waktu TIME NOT NULL,
    status ENUM('hadir', 'izin', 'sakit', 'alfa') DEFAULT 'hadir',
    catatan TEXT
);

-- Insert data contoh (Step 2)
INSERT INTO absensi (nim, nama_mahasiswa, mata_kuliah, kelas, tanggal, waktu, status, catatan) VALUES
('202401001', 'Ahmad Fauzi', 'Pemrograman Web', 'TI-A', '2024-03-20', '08:30:00', 'hadir', 'Tepat waktu'),
('202401002', 'Budi Santoso', 'Basis Data', 'TI-B', '2024-03-20', '08:45:00', 'izin', 'Ijin sakit'),
('202401003', 'Citra Dewi', 'Pemrograman Web', 'TI-A', '2024-03-20', '09:00:00', 'hadir', ''),
('202401004', 'Diana Putri', 'Basis Data', 'TI-B', '2024-03-20', NULL, 'alfa', 'Tidak hadir tanpa keterangan'),
('202401005', 'Eko Prasetyo', 'Pemrograman Web', 'TI-A', '2024-03-20', '08:35:00', 'sakit', 'Demam');