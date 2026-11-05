<?php include 'templates/header.php'; ?>
<?php include 'templates/sidebar.php'; ?>

<div class="container-fluid px-4 mt-3">
    <h2 class="fw-bold mb-4" style="color: #2c3e50;">Dashboard</h2>

    <!-- KARTU UCAPAN SELAMAT DATANG (Desain Bersih & Kalem) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4" style="background-color: #f8f9fa; border-left: 5px solid #4361ee !important;">
        <div class="card-body p-4">
            <h4 class="fw-bold text-dark mb-2">Selamat Datang, <?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Pengguna', ENT_QUOTES, 'UTF-8') ?>!</h4>
            <?php if($_SESSION['role'] == 'Superadmin'): ?>
                <p class="text-muted mb-0">Anda login sebagai <strong>Superadmin Pusat</strong>. Anda memiliki kendali penuh atas sistem.</p>
            <?php else: ?>
                <p class="text-muted mb-0">Anda login sebagai <strong>Admin <?= htmlspecialchars($nama_instansi_aktif ?? 'Instansi') ?></strong>. Silakan kelola mading instansi Anda.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- KARTU STATISTIK MADING (Desain Putih Bersih / Clean Minimalist) -->
    <div class="row g-4 mb-4">
        <!-- Kartu 1: Total Mading -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.85rem; letter-spacing: 0.5px;">Total Mading</p>
                            <h2 class="fw-bold mb-0" style="color: #2b2d42;"><?= $total_mading ?? 0 ?></h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 55px; height: 55px;">
                            <i class="bi bi-file-earmark-text fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu 2: Mading Aktif -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.85rem; letter-spacing: 0.5px;">Mading Aktif</p>
                            <h2 class="fw-bold mb-0" style="color: #2b2d42;"><?= $mading_aktif ?? 0 ?></h2>
                        </div>
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex justify-content-center align-items-center" style="width: 55px; height: 55px;">
                            <i class="bi bi-calendar-check fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu 3: Total Tayangan -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted text-uppercase fw-semibold mb-1" style="font-size: 0.85rem; letter-spacing: 0.5px;">Total Tayangan</p>
                            <h2 class="fw-bold mb-0" style="color: #2b2d42;"><?= $total_views ?? 0 ?></h2>
                        </div>
                        <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex justify-content-center align-items-center" style="width: 55px; height: 55px;">
                            <i class="bi bi-graph-up-arrow fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- AREA GRAFIK (Chart.js) -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h6 class="fw-bold" style="color: #2c3e50;"><i class="bi bi-bar-chart-line me-2 text-primary"></i>Statistik Aktivitas Mading</h6>
                </div>
                <div class="card-body p-4">
                    <!-- Kanvas tempat grafik akan digambar -->
                    <canvas id="madingChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tambahkan Library Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Inisialisasi Grafik
    const ctx = document.getElementById('madingChart').getContext('2d');
    const madingChart = new Chart(ctx, {
        type: 'bar', // Anda bisa menggantinya menjadi 'line' jika ingin grafik garis
        data: {
            // Label Bulan (Bisa dibuat dinamis dari PHP nanti)
            labels: ['Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov'],
            datasets: [
                {
                    label: 'Mading Diunggah',
                    // Data simulasi (contoh), dan ujungnya mengambil data asli aplikasi Anda
                    data: [1, 2, 1, 3, 2, <?= $total_mading ?? 0 ?>], 
                    backgroundColor: 'rgba(67, 97, 238, 0.8)', // Warna Biru Kalem
                    borderRadius: 6
                },
                {
                    label: 'Total Tayangan',
                    // Data simulasi (contoh), dan ujungnya mengambil data asli aplikasi Anda
                    data: [5, 12, 8, 20, 15, <?= $total_views ?? 0 ?>], 
                    backgroundColor: 'rgba(46, 196, 182, 0.8)', // Warna Tosca Kalem
                    borderRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        font: { family: "'Inter', sans-serif" }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [5, 5] } // Membuat garis grid putus-putus agar terlihat rapi
                },
                x: {
                    grid: { display: false } // Menghilangkan garis vertikal agar bersih
                }
            }
        }
    });
</script>

<?php include 'templates/footer.php'; ?>