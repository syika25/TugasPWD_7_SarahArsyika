<?php
echo "<h2>🔧 Setup Database Sistem Absensi</h2>";
echo "<div style='padding:20px; background:#e3f2fd; border-radius:10px;'>";

$host = "localhost";
$username = "root";
$password = "";

// Koneksi ke MySQL
$conn = new mysqli($host, $username, $password);

if ($conn->connect_error) {
    die("<div style='color:red;'>❌ Koneksi gagal: " . $conn->connect_error . "</div>");
}

echo "✅ Terhubung ke MySQL server<br>";

// 1. Buat database
$sql = "CREATE DATABASE IF NOT EXISTS sistem_absensi";
if ($conn->query($sql) === TRUE) {
    echo "✅ Database 'sistem_absensi' berhasil dibuat<br>";
} else {
    echo "❌ Error membuat database: " . $conn->error . "<br>";
}

// 2. Pilih database
$conn->select_db("sistem_absensi");

// 3. Buat tabel
$sql = "CREATE TABLE IF NOT EXISTS absensi (
    id_absensi INT PRIMARY KEY AUTO_INCREMENT,
    nim VARCHAR(15) NOT NULL,
    nama_mahasiswa VARCHAR(100) NOT NULL,
    mata_kuliah VARCHAR(50),
    kelas VARCHAR(10),
    tanggal DATE NOT NULL,
    waktu TIME,
    status ENUM('hadir', 'izin', 'sakit', 'alfa') DEFAULT 'hadir',
    catatan TEXT
)";

if ($conn->query($sql) === TRUE) {
    echo "✅ Tabel 'absensi' berhasil dibuat<br>";
} else {
    echo "❌ Error membuat tabel: " . $conn->error . "<br>";
}

// 4. Cek dan tambah data jika kosong
$result = $conn->query("SELECT COUNT(*) as count FROM absensi");
$row = $result->fetch_assoc();

if ($row['count'] == 0) {
    $sql = "INSERT INTO absensi (nim, nama_mahasiswa, mata_kuliah, kelas, tanggal, waktu, status, catatan) VALUES
        ('202401001', 'Ahmad Fauzi', 'Pemrograman Web', 'TI-A', '2024-03-20', '08:30:00', 'hadir', 'Tepat waktu'),
        ('202401002', 'Budi Santoso', 'Basis Data', 'TI-B', '2024-03-20', '08:45:00', 'izin', 'Ijin sakit'),
        ('202401003', 'Citra Dewi', 'Pemrograman Web', 'TI-A', '2024-03-20', '09:00:00', 'hadir', ''),
        ('202401004', 'Diana Putri', 'Basis Data', 'TI-B', '2024-03-20', NULL, 'alfa', 'Tidak hadir tanpa keterangan'),
        ('202401005', 'Eko Prasetyo', 'Pemrograman Web', 'TI-A', '2024-03-20', '08:35:00', 'sakit', 'Demam')";
    
    if ($conn->query($sql) === TRUE) {
        echo "✅ Data contoh berhasil dimasukkan (5 records)<br>";
    } else {
        echo "❌ Error memasukkan data: " . $conn->error . "<br>";
    }
} else {
    echo "⏩ Database sudah berisi " . $row['count'] . " data<br>";
}

// 5. Tampilkan data
echo "<h3>📊 Data dalam Database:</h3>";
$result = $conn->query("SELECT * FROM absensi");
if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='8' style='border-collapse:collapse; width:100%;'>";
    echo "<tr style='background:#2196F3; color:white;'>
            <th>ID</th><th>NIM</th><th>Nama</th><th>Mata Kuliah</th><th>Status</th>
          </tr>";
    while ($row = $result->fetch_assoc()) {
        $status_color = [
            'hadir' => '#4CAF50',
            'izin' => '#FF9800',
            'sakit' => '#FFC107',
            'alfa' => '#F44336'
        ];
        echo "<tr>";
        echo "<td>" . $row['id_absensi'] . "</td>";
        echo "<td>" . $row['nim'] . "</td>";
        echo "<td>" . $row['nama_mahasiswa'] . "</td>";
        echo "<td>" . $row['mata_kuliah'] . "</td>";
        echo "<td style='background:" . ($status_color[$row['status']] ?? '#ddd') . "; color:white; padding:5px 10px; border-radius:15px; text-align:center;'>" . ucfirst($row['status']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
}

$conn->close();

echo "</div>";
echo "<hr>";
echo "<h3>🎉 Setup selesai!</h3>";
echo "<a href='index.php' style='display:inline-block; padding:10px 20px; background:#4CAF50; color:white; text-decoration:none; border-radius:5px; margin:10px;'>🚀 Buka Sistem Absensi</a>";
echo "<br><br>";
echo "<small>Jika ada error, pastikan MySQL berjalan di XAMPP/Laragon.</small>";
?>