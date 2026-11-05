<?php
/** 
 * @var int $page 
 * @var int $total_pages 
 * @var array $data_mading
 */
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Mading - Universitas Hindu Negeri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8f9fa; display: flex; flex-direction: column; min-height: 100vh; }
        .navbar-brand { font-weight: 700; color: #4361ee !important; }
        .card-mading { transition: transform 0.2s, box-shadow 0.2s; border: none; border-radius: 12px; height: 100%; }
        .card-mading:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .poster-img { height: 200px; object-fit: cover; border-top-left-radius: 12px; border-top-right-radius: 12px; }
        .text-truncate-3 { display: -webkit-box; -webkit-line-clamp: 3; line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php?url=home"><i class="bi bi-display"></i> Digital Mading UHN</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                <!-- Logika Navbar Dinamis -->
                <?php if(isset($_SESSION['role'])): ?>
                    <li class="nav-item me-3">
                        <span class="text-muted">Halo, <strong><?= htmlspecialchars($_SESSION['nama_lengkap']) ?></strong></span>
                    </li>
                    <li class="nav-item d-flex gap-2">
                        <a class="btn btn-outline-primary btn-sm rounded-pill px-3" href="index.php?url=dashboard">Ke Dashboard Admin</a>
                        <a class="btn btn-outline-danger btn-sm rounded-pill px-3" href="index.php?url=user&action=logout" onclick="return confirm('Yakin ingin keluar?')">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm rounded-pill px-4 fw-bold" href="index.php?url=login" style="background-color: #4361ee;">Login Admin</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container my-5 flex-grow-1">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Papan Pengumuman Digital</h2>
        <p class="text-muted">Informasi terbaru seputar kegiatan, lomba, dan seminar di lingkungan kampus.</p>
    </div>

    <div class="row justify-content-center mb-5">
        <div class="col-md-8">
            <form method="GET" action="index.php" class="d-flex shadow-sm rounded">
                <input type="hidden" name="url" value="home">
                <input type="text" name="keyword" class="form-control form-control-lg border-0 bg-white" placeholder="Cari judul, kategori, atau penyelenggara..." value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>">
                <button type="submit" class="btn btn-primary btn-lg px-4 border-0" style="background-color: #4361ee;">Cari</button>
            </form>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php if(!empty($data_mading)): ?>
            <?php foreach ($data_mading as $row): ?>
            <div class="col">
                <div class="card card-mading shadow-sm">
                    <?php if(!empty($row['poster_path'])): ?>
                        <img src="uploads/<?= htmlspecialchars($row['poster_path']) ?>" class="card-img-top poster-img" alt="Poster Mading">
                    <?php else: ?>
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center poster-img">
                            <i class="bi bi-image fs-1"></i>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                       <div class="mb-2">
                             <span class="badge bg-primary rounded-pill"><?= htmlspecialchars($row['nama_kategori']) ?></span>
        
                                   <!-- Menampilkan label Tingkat Universitas atau Nama Fakultas -->
                                  <?php if(!empty($row['nama_fakultas'])): ?>
                                      <span class="badge bg-light text-dark border rounded-pill"><?= htmlspecialchars($row['nama_fakultas']) ?></span>
                          <?php else: ?>
                                  <span class="badge bg-light text-dark border rounded-pill">Tingkat Universitas</span>
                         <?php endif; ?>
                     </div>
                        <h5 class="card-title fw-bold mb-1"><?= htmlspecialchars($row['title']) ?></h5>
                        <p class="text-muted small mb-3"><i class="bi bi-building me-1"></i> <?= htmlspecialchars($row['nama_instansi']) ?></p>
                        
                        <p class="card-text text-muted text-truncate-3" style="font-size: 14px;">
                            <?= htmlspecialchars($row['deskripsi']) ?>
                        </p>
                    </div>
                    
                    <div class="card-footer bg-white border-top-0 pb-3 pt-0 d-flex justify-content-between align-items-center">
                        <?php 
                          // Cek apakah tanggal hari ini masih lebih kecil atau sama dengan tanggal expired
                             $is_active = (strtotime(date('Y-m-d')) <= strtotime($row['date_expired']));
                             $text_color = $is_active ? 'text-success' : 'text-danger';
                             $icon = $is_active ? 'bi-calendar-check' : 'bi-calendar-x';
                             $label_tgl = $is_active ? 'S.d' : 'Berakhir';
                            ?>
                        <small class="<?= $text_color ?> fw-medium"><i class="bi <?= $icon ?> me-1"></i> <?= $label_tgl ?> <?= date('d M Y', strtotime($row['date_expired'])) ?></small>
                        <small class="text-muted"><i class="bi bi-eye"></i> <?= isset($row['views']) ? $row['views'] : 0 ?>x</small>
                    </div>

                    <!-- Tombol Detail yang Baru (Dipindah jadi satu baris bawah penuh biar lebih rapi) -->
                    <div class="card-footer bg-light border-top-0 text-center">
                        <a href="index.php?url=home&action=detail&id=<?= $row['id_announcement'] ?>" class="btn btn-sm btn-primary w-100 rounded-pill">
                            Baca Detail Lengkap
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <h5 class="text-muted fw-bold mt-3">Belum ada pengumuman.</h5>
            </div>
        <?php endif; ?>
    </div>

   <?php if(isset($total_pages) && $total_pages > 1): ?>
    <nav class="mt-5">
        <ul class="pagination justify-content-center">
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <?php 
                    // Pisahkan logikanya di sini agar VS Code tidak bingung
                    $aktif = ($page == $i) ? 'active' : '';
                    $keyword = htmlspecialchars($_GET['keyword'] ?? '');
                ?>
                <li class="page-item <?= $aktif ?>">
                    <a class="page-link" href="index.php?url=home&page=<?= $i ?>&keyword=<?= $keyword ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
    <?php endif; ?>
</main>

<footer class="bg-white border-top text-center py-4 mt-auto">
    <div class="container text-muted small">
        <span class="fw-bold text-dark">Digital Mading UHN</span> © 2026. Dikembangkan untuk UTS Pengembangan Web.
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>