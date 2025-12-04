<?php
// Test koneksi database
echo "<h2>🛠️ Test Koneksi Database</h2>";

// Cek MySQL
echo "<h3>1. Testing MySQL Connection:</h3>";
$conn = @new mysqli("localhost", "root", "");
if ($conn->connect_error) {
    echo "❌ MySQL Error: " . $conn->connect_error . "<br>";
    echo "🔧 Solusi: Pastikan XAMPP/Laragon MySQL berjalan!";
} else {
    echo "✅ MySQL Connected Successfully!<br>";
    
    // Cek database
    $result = $conn->query("SHOW DATABASES LIKE 'sistem_absensi'");
    if ($result->num_rows > 0) {
        echo "✅ Database 'sistem_absensi' ditemukan<br>";
    } else {
        echo "❌ Database 'sistem_absensi' tidak ditemukan<br>";
        echo "💡 Jalankan <a href='setup.php'>setup.php</a> untuk membuat database";
    }
    
    $conn->close();
}

// Cek file structure
echo "<h3>2. Checking File Structure:</h3>";
$files = [
    'index.php',
    'config/database.php',
    'classes/Absensi.php',
    'style.css'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✅ {$file} exists<br>";
    } else {
        echo "❌ {$file} missing<br>";
    }
}

echo "<hr>";
echo "<a href='setup.php' style='padding:10px 20px; background:#007bff; color:white; text-decoration:none;'>🔧 Run Setup</a> ";
echo "<a href='index.php' style='padding:10px 20px; background:#28a745; color:white; text-decoration:none;'>🚀 Open System</a>";
?>