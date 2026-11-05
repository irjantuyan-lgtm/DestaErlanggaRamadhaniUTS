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
    <title><?= htmlspecialchars($data_mading['title']) ?> - Detail Mading</title>
    <!-- Pastikan link CSS Bootstrap Anda sesuai -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <!-- Tombol Kembali -->
                <a href="index.php?url=home" class="btn btn-outline-secondary mb-3">
                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                </a>

                <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
                    
                    <!-- Area Menampilkan Poster Full Size -->
                    <?php if(!empty($data_mading['poster_path'])): ?>
                        <div class="bg-dark text-center">
                            <img src="uploads/<?= htmlspecialchars($data_mading['poster_path']) ?>" class="img-fluid" alt="Poster Pengumuman" style="max-height: 600px; object-fit: contain;">
                        </div>
                    <?php else: ?>
                        <div class="bg-secondary text-white text-center py-5">
                            <i class="bi bi-image" style="font-size: 5rem;"></i>
                            <p>Tidak ada poster</p>
                        </div>
                    <?php endif; ?>

                    <div class="card-body p-4 p-md-5">
                        
                        <!-- Kategori dan Jumlah Views -->
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary px-3 py-2 fs-6">
                                <?= htmlspecialchars($data_mading['nama_kategori']) ?>
                            </span>
                            <span class="text-muted fw-bold">
                                <i class="bi bi-eye-fill text-primary"></i> <?= $data_mading['views'] ?> Tayangan
                            </span>
                        </div>
                        
                        <!-- Judul Mading -->
                        <h1 class="fw-bold mb-4" style="color: #2c3e50;">
                            <?= htmlspecialchars($data_mading['title']) ?>
                        </h1>
                        
                        <!-- Informasi Penyelenggara & Tanggal -->
                        <div class="row bg-light rounded-3 p-3 mb-4 border">
                           <div class="col-sm-6 mb-2 mb-sm-0">
                             <small class="text-muted d-block">Penyelenggara:</small>
                                 <strong class="fs-6"><i class="bi bi-building"></i> <?= htmlspecialchars($data_mading['nama_instansi']) ?></strong>
        
                              <!-- Tambahan Label Universitas/Fakultas di Detail -->
                             <span class="badge bg-secondary ms-1" style="font-size: 0.7em; vertical-align: middle;">
                                   <?= !empty($data_mading['nama_fakultas']) ? htmlspecialchars($data_mading['nama_fakultas']) : 'Universitas' ?>
                          </span>
                        </div>
                            <div class="col-sm-6">
                          <?php 
                         $is_active_detail = (strtotime(date('Y-m-d')) <= strtotime($data_mading['date_expired']));
                            $detail_color = $is_active_detail ? 'text-success' : 'text-danger';
                             $detail_icon = $is_active_detail ? 'bi-calendar-check' : 'bi-calendar-x';
                                 $detail_label = $is_active_detail ? 'Berlaku Sampai:' : 'Sudah Berakhir:';
                             ?>
                        <small class="text-muted d-block"><?= $detail_label ?></small>
                             <strong class="fs-6 <?= $detail_color ?>"><i class="bi <?= $detail_icon ?>"></i> <?= date('d F Y', strtotime($data_mading['date_expired'])) ?></strong>
                            </div>
                        </div>

                        <!-- Deskripsi (Jika ada kolom deskripsi di DB) -->
                        <div class="mb-4">
                            <h5 class="fw-bold">Deskripsi Pengumuman:</h5>
                            <p class="text-secondary" style="line-height: 1.8;">
                                <?= nl2br(htmlspecialchars($data_mading['deskripsi'] ?? 'Tidak ada deskripsi tambahan.')) ?>
                            </p>
                        </div>

                        <!-- Tombol Buka Gambar di Tab Baru -->
                        <?php if(!empty($data_mading['poster_path'])): ?>
                            <a href="uploads/<?= htmlspecialchars($data_mading['poster_path']) ?>" target="_blank" class="btn btn-primary w-100 py-2 fw-bold">
                                <i class="bi bi-arrows-fullscreen"></i> Lihat Gambar Ukuran Penuh
                            </a>
                        <?php endif; ?>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>