<!-- Sidebar Navigation -->
        <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse">
            <div class="position-sticky">
                <div class="text-center mb-4 px-3">
                    <h5 class="text-white fw-bold"><i class="bi bi-display"></i> Mading UHN</h5>
                    <small class="text-warning">Halo, <?= htmlspecialchars($_SESSION['nama_lengkap'] ?? 'Pengguna', ENT_QUOTES, 'UTF-8') ?></small><br>
                    <span class="badge bg-primary mt-1"><?= htmlspecialchars($_SESSION['role']) ?></span>
                </div>

                <a href="index.php?url=dashboard"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
                <a href="index.php?url=announcement"><i class="bi bi-megaphone me-2"></i> Pengumuman</a>
                
                <!-- Menu Master Data (HANYA SUPERADMIN) -->
                <?php if($_SESSION['role'] == 'Superadmin'): ?>
                    <div class="sidebar-heading">Master Data</div>
                    <a href="index.php?url=kategori"><i class="bi bi-tags me-2"></i> Kategori</a>
                    <a href="index.php?url=fakultas"><i class="bi bi-building me-2"></i> Fakultas</a>
                    <a href="index.php?url=instansi"><i class="bi bi-diagram-3 me-2"></i> Instansi</a>
                    <a href="index.php?url=user"><i class="bi bi-people me-2"></i> Data User</a>
                <?php endif; ?>

                <hr class="text-secondary mx-3">
                <a href="index.php?url=user&action=logout" onclick="return confirm('Yakin ingin keluar?')" class="text-danger"><i class="bi bi-box-arrow-right me-2"></i> Logout</a>
            </div>
        </nav>
        
        <!-- Main Content Area -->
        <main class="col-md-9 ms-sm-auto col-lg-10 main-content">