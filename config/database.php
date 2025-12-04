<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "sistem_absensi";
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        // Pertama, coba koneksi tanpa memilih database
        $this->connection = new mysqli($this->host, $this->username, $this->password);
        
        if ($this->connection->connect_error) {
            $this->showError("Koneksi ke MySQL gagal: " . $this->connection->connect_error);
            return;
        }
        
        // Buat database jika belum ada
        $this->createDatabase();
        
        // Pilih database
        $this->connection->select_db($this->database);
        
        // Buat tabel jika belum ada
        $this->createTable();
        
        // Set charset
        $this->connection->set_charset("utf8");
    }

    private function createDatabase() {
        $sql = "CREATE DATABASE IF NOT EXISTS " . $this->database;
        if (!$this->connection->query($sql)) {
            $this->showError("Gagal membuat database: " . $this->connection->error);
        }
    }

    private function createTable() {
        // Pastikan database dipilih
        $this->connection->select_db($this->database);
        
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
        
        if (!$this->connection->query($sql)) {
            $this->showError("Gagal membuat tabel: " . $this->connection->error);
        }
        
        // Tambah data contoh jika tabel kosong
        $this->addSampleData();
    }

    private function addSampleData() {
        $check = $this->connection->query("SELECT COUNT(*) as count FROM absensi");
        $row = $check->fetch_assoc();
        
        if ($row['count'] == 0) {
            $sql = "INSERT INTO absensi (nim, nama_mahasiswa, mata_kuliah, kelas, tanggal, waktu, status, catatan) VALUES
                ('202401001', 'Ahmad Fauzi', 'Pemrograman Web', 'TI-A', CURDATE(), '08:30:00', 'hadir', 'Tepat waktu'),
                ('202401002', 'Budi Santoso', 'Basis Data', 'TI-B', CURDATE(), '08:45:00', 'izin', 'Ijin sakit')";
            
            $this->connection->query($sql);
        }
    }

    private function showError($message) {
        echo "<div style='
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            background: #f8d7da;
            color: #721c24;
            padding: 20px;
            border-bottom: 3px solid #f5c6cb;
            z-index: 1000;
            font-family: Arial, sans-serif;
        '>
            <h3>⚠️ Database Error</h3>
            <p>{$message}</p>
            <p>Silakan: 
                1. Pastikan MySQL berjalan di XAMPP/Laragon<br>
                2. Atau jalankan <a href='setup.php' style='color:#dc3545; font-weight:bold;'>setup.php</a> terlebih dahulu
            </p>
        </div>";
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        if ($this->connection) {
            $this->connection->close();
        }
    }
}
?>