<?php
require_once 'config/database.php';

class Absensi {
    private $db;
    private $conn;

    public function __construct() {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    // Method untuk mengambil semua data absensi
    public function getAllAbsensi() {
        $query = "SELECT * FROM absensi ORDER BY tanggal DESC, waktu DESC";
        $result = $this->conn->query($query);
        
        $data = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;
    }

    // Method untuk mengambil data berdasarkan status
    public function getAbsensiByStatus($status) {
        $query = "SELECT * FROM absensi WHERE status = ? ORDER BY tanggal DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $status);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }

    // Method untuk menambah data absensi baru
    public function addAbsensi($data) {
        $query = "INSERT INTO absensi (nim, nama_mahasiswa, mata_kuliah, kelas, tanggal, waktu, status, catatan) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssss", 
            $data['nim'],
            $data['nama'],
            $data['matkul'],
            $data['kelas'],
            $data['tanggal'],
            $data['waktu'],
            $data['status'],
            $data['catatan']
        );
        
        return $stmt->execute();
    }

    // Method untuk mendapatkan statistik
    public function getStatistik() {
        $query = "SELECT 
                    COUNT(*) as total,
                    SUM(status = 'hadir') as hadir,
                    SUM(status = 'izin') as izin,
                    SUM(status = 'sakit') as sakit,
                    SUM(status = 'alfa') as alfa
                  FROM absensi";
        
        $result = $this->conn->query($query);
        return $result->fetch_assoc();
    }

    // Method untuk membersihkan input
    public function cleanInput($data) {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    public function __destruct() {
        $this->db->closeConnection();
    }
}
?>