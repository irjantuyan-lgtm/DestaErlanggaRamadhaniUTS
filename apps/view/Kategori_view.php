<?php
/** 
 * @var array $data_kategori 
 */
?>
<?php include 'templates/header.php'; ?>
<?php include 'templates/sidebar.php'; ?>

<h2 class="fw-bold mb-4">Master Data Kategori</h2>

<!-- Form Tambah Kategori -->
<div class="card p-4 mb-4 bg-light border-0">
    <h5 class="fw-bold mb-3">Tambah Kategori Baru</h5>
    <form method="POST" action="index.php?url=kategori&action=tambah" class="d-flex align-items-end gap-3 flex-wrap">
        <div class="flex-grow-1" style="min-width: 250px;">
            <label class="form-label fw-bold">Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Lomba, Seminar, Beasiswa..." required>
        </div>
        <button type="submit" class="btn btn-primary px-4">+ Simpan Kategori</button>
    </form>
</div>

<!-- Tabel Data Kategori -->
<div class="card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Kategori</th>
                    <th width="120" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data_kategori)): ?>
                    <?php $no = 1; foreach ($data_kategori as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($row['nama_kategori']) ?></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Tombol Ubah (Ikon Saja) -->
                                <a href="index.php?url=kategori&action=edit&id=<?= $row['id_category'] ?>" class="btn btn-sm btn-warning text-white" title="Edit Data">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
            
                                <!-- Tombol Hapus (Ikon Saja) -->
                                <a href="index.php?url=kategori&action=hapus&id=<?= $row['id_category'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')" title="Hapus Data">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" class="text-center py-4 text-muted">Belum ada data kategori.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'templates/footer.php'; ?>