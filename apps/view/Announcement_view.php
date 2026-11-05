<?php
/** 
 * @var int $page 
 * @var int $total_pages 
 * @var array $data_mading
 */
?>

<?php include 'templates/header.php'; ?>
<?php include 'templates/sidebar.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold m-0">Kelola Pengumuman</h2>
    <a href="index.php?url=announcement&action=form_tambah" class="btn btn-success">+ Tambah Pengumuman</a>
</div>

<div class="card p-4">
    <form method="POST" action="index.php?url=announcement" class="d-flex gap-2 mb-4 w-50">
        <input type="text" name="keyword" class="form-control" placeholder="Cari judul..." value="<?= htmlspecialchars($_POST['keyword'] ?? $_GET['keyword'] ?? '') ?>">
        <button type="submit" class="btn btn-dark">Cari</button>
    </form>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Poster</th> <!-- Kolom Baru Untuk Gambar -->
                    <th>Judul</th>
                    <th>Kategori</th>
                    <th>Instansi</th>
                    <th>Expired</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data_mading)): ?>
                    <?php foreach ($data_mading as $row): ?>
                    <tr>
                        <!-- Menampilkan Thumbnail Gambar -->
                        <!-- Menampilkan Thumbnail Gambar yang Bisa Diklik -->
                        <td>
                            <?php if(!empty($row['poster_path'])): ?>
                                <a href="uploads/<?= htmlspecialchars($row['poster_path']) ?>" target="_blank" title="Klik untuk lihat poster penuh">
                                    <img src="uploads/<?= htmlspecialchars($row['poster_path']) ?>" alt="Poster" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                                </a>
                            <?php else: ?>
                                <div style="width: 70px; height: 70px; background: #e9ecef; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #6c757d;">
                                    <i class="bi bi-image fs-3"></i>
                                </div>
                            <?php endif; ?>
                        </td>
                        
                        <td class="fw-bold"><?= htmlspecialchars($row['title']) ?></td>
                        <td><span class="badge bg-secondary"><?= htmlspecialchars($row['nama_kategori']) ?></span></td>
                        <td><?= htmlspecialchars($row['nama_instansi']) ?></td>
                       <td>
                         <?php 
                          // Logika pengecekan tanggal
                            $is_active = (strtotime(date('Y-m-d')) <= strtotime($row['date_expired']));
                            $text_color = $is_active ? 'text-success' : 'text-danger';
                            $badge_color = $is_active ? 'bg-success' : 'bg-danger';
                             $status_text = $is_active ? 'Aktif' : 'Berakhir';
                         ?>
    
                         <!-- Menampilkan Tanggal dengan warna -->
                         <span class="<?= $text_color ?> fw-bold">
                        <?= date('d M Y', strtotime($row['date_expired'])) ?>
                         </span>

                         <br>
    
                         <!-- Menambahkan Badge Status kecil di bawah tanggal biar makin keren -->
                         <span class="badge <?= $badge_color ?> rounded-pill mt-1" style="font-size: 0.7rem;">
                            <?= $status_text ?>
                        </span>
                    </td>
                        <td>
                            <a href="index.php?url=announcement&action=edit&id=<?= $row['id_announcement'] ?>" class="btn btn-sm btn-primary">Edit</a>
                            <a href="index.php?url=announcement&action=hapus&id=<?= $row['id_announcement'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Data tidak ditemukan.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Paginasi -->
    <?php if(isset($total_pages) && $total_pages > 1): ?>
        <nav class="mt-3">
            <ul class="pagination">
                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= ($page == $i) ? 'active' : '' ?>">
                        <a class="page-link" href="index.php?url=announcement&page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>
<?php include 'templates/footer.php'; ?>