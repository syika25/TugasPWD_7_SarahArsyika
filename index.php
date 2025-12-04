<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi Mahasiswa</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <header>
            <h1><i class="fas fa-clipboard-check"></i> Sistem Absensi Mahasiswa</h1>
            <p class="subtitle">Universitas Teknologi Informatika - Sistem Informasi</p>
        </header>

        <?php
        require_once 'classes/Absensi.php';
        $absensi = new Absensi();
        $dataAbsensi = $absensi->getAllAbsensi();
        $statistik = $absensi->getStatistik();
        ?>

        <!-- Statistik -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon" style="background-color: #4CAF50;">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $statistik['total'] ?? 0; ?></h3>
                    <p>Total Data</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background-color: #2196F3;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $statistik['hadir'] ?? 0; ?></h3>
                    <p>Hadir</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background-color: #FF9800;">
                    <i class="fas fa-file-medical"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $statistik['sakit'] ?? 0; ?></h3>
                    <p>Sakit</p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon" style="background-color: #F44336;">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h3><?php echo $statistik['alfa'] ?? 0; ?></h3>
                    <p>Alfa</p>
                </div>
            </div>
        </div>

        <!-- Form Tambah Data -->
        <div class="form-container">
            <h2><i class="fas fa-plus-circle"></i> Tambah Data Absensi</h2>
            <form method="POST" action="" class="absensi-form">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="nim"><i class="fas fa-id-card"></i> NIM</label>
                        <input type="text" id="nim" name="nim" required placeholder="Contoh: 202401001">
                    </div>
                    
                    <div class="form-group">
                        <label for="nama"><i class="fas fa-user"></i> Nama Mahasiswa</label>
                        <input type="text" id="nama" name="nama" required placeholder="Nama lengkap">
                    </div>
                    
                    <div class="form-group">
                        <label for="matkul"><i class="fas fa-book"></i> Mata Kuliah</label>
                        <select id="matkul" name="matkul" required>
                            <option value="">Pilih Mata Kuliah</option>
                            <option value="Pemrograman Web">Pemrograman Web</option>
                            <option value="Basis Data">Basis Data</option>
                            <option value="Struktur Data">Struktur Data</option>
                            <option value="Jaringan Komputer">Jaringan Komputer</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="kelas"><i class="fas fa-chalkboard"></i> Kelas</label>
                        <select id="kelas" name="kelas" required>
                            <option value="">Pilih Kelas</option>
                            <option value="TI-A">TI-A</option>
                            <option value="TI-B">TI-B</option>
                            <option value="SI-A">SI-A</option>
                            <option value="SI-B">SI-B</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="tanggal"><i class="fas fa-calendar-alt"></i> Tanggal</label>
                        <input type="date" id="tanggal" name="tanggal" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="waktu"><i class="fas fa-clock"></i> Waktu</label>
                        <input type="time" id="waktu" name="waktu" value="08:30">
                    </div>
                    
                    <div class="form-group">
                        <label for="status"><i class="fas fa-clipboard-list"></i> Status</label>
                        <select id="status" name="status" required>
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alfa">Alfa</option>
                        </select>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="catatan"><i class="fas fa-sticky-note"></i> Catatan</label>
                        <textarea id="catatan" name="catatan" rows="3" placeholder="Keterangan tambahan..."></textarea>
                    </div>
                </div>
                
                <button type="submit" name="submit" class="submit-btn">
                    <i class="fas fa-save"></i> Simpan Data
                </button>
            </form>

            <?php
            if (isset($_POST['submit'])) {
                $data = [
                    'nim' => $absensi->cleanInput($_POST['nim']),
                    'nama' => $absensi->cleanInput($_POST['nama']),
                    'matkul' => $absensi->cleanInput($_POST['matkul']),
                    'kelas' => $absensi->cleanInput($_POST['kelas']),
                    'tanggal' => $absensi->cleanInput($_POST['tanggal']),
                    'waktu' => $absensi->cleanInput($_POST['waktu']),
                    'status' => $absensi->cleanInput($_POST['status']),
                    'catatan' => $absensi->cleanInput($_POST['catatan'])
                ];
                
                if ($absensi->addAbsensi($data)) {
                    echo '<div class="success-message">Data absensi berhasil disimpan!</div>';
                    // Refresh halaman
                    echo '<script>setTimeout(function(){ window.location.href = window.location.href; }, 1500);</script>';
                } else {
                    echo '<div class="error-message">Gagal menyimpan data. Silakan coba lagi.</div>';
                }
            }
            ?>
        </div>

        <!-- Tabel Data Absensi -->
        <div class="table-container">
            <h2><i class="fas fa-list-alt"></i> Data Absensi Mahasiswa</h2>
            
            <?php if (empty($dataAbsensi)): ?>
                <div class="no-data">
                    <i class="fas fa-database"></i>
                    <p>Tidak ada data absensi</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="absensi-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIM</th>
                                <th>Nama Mahasiswa</th>
                                <th>Mata Kuliah</th>
                                <th>Kelas</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($dataAbsensi as $data): ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($data['nim']); ?></td>
                                    <td><?php echo htmlspecialchars($data['nama_mahasiswa']); ?></td>
                                    <td><?php echo htmlspecialchars($data['mata_kuliah']); ?></td>
                                    <td><span class="kelas-badge"><?php echo htmlspecialchars($data['kelas']); ?></span></td>
                                    <td><?php echo date('d/m/Y', strtotime($data['tanggal'])); ?></td>
                                    <td><?php echo $data['waktu'] ? date('H:i', strtotime($data['waktu'])) : '-'; ?></td>
                                    <td>
                                        <?php 
                                        $statusClass = '';
                                        switch($data['status']) {
                                            case 'hadir': $statusClass = 'status-hadir'; break;
                                            case 'izin': $statusClass = 'status-izin'; break;
                                            case 'sakit': $statusClass = 'status-sakit'; break;
                                            case 'alfa': $statusClass = 'status-alfa'; break;
                                        }
                                        ?>
                                        <span class="status-badge <?php echo $statusClass; ?>">
                                            <?php echo ucfirst($data['status']); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($data['catatan'] ?: '-'); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>

        <footer>
            <p>Sistem Absensi Mahasiswa &copy; <?php echo date('Y'); ?> - Dibuat dengan <i class="fas fa-heart"></i></p>
            <p class="tech-info">PHP OOP | MySQL | HTML5 | CSS3</p>
        </footer>
    </div>

    <script>
        // Animasi untuk form
        document.addEventListener('DOMContentLoaded', function() {
            const formGroups = document.querySelectorAll('.form-group');
            formGroups.forEach((group, index) => {
                group.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
</body>
</html>