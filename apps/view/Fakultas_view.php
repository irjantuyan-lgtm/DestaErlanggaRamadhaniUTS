<?php
/** 
 * @var array $data_fakultas 
 */
?>
<?php include 'templates/header.php'; ?>
<?php include 'templates/sidebar.php'; ?>

<h2 class="fw-bold mb-4">Master Data Fakultas</h2>

<!-- Form Tambah Fakultas -->
<div class="card p-4 mb-4 bg-light border-0">
    <form method="POST" action="index.php?url=fakultas&action=tambah" class="d-flex align-items-end gap-3 flex-wrap">
        <div class="flex-grow-1" style="min-width: 250px;">
            <label class="form-label fw-bold">Tambah Fakultas Baru</label>
            <input type="text" name="nama_fakultas" class="form-control" placeholder="Contoh: Fakultas Sains dan Teknologi..." required>
        </div>
        <button type="submit" class="btn btn-primary px-4">+ Simpan Fakultas</button>
    </form>
</div>

<!-- Tabel Data Fakultas -->
<div class="card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Fakultas</th>
                    <th width="120" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data_fakultas)): ?>
                    <?php $no = 1; foreach ($data_fakultas as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($row['nama_fakultas']) ?></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Tombol Ubah (Ikon Saja) -->
                                <a href="index.php?url=fakultas&action=edit&id=<?= $row['id_fakultas'] ?>" class="btn btn-sm btn-warning text-white" title="Edit Data">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Tombol Hapus (Ikon Saja) -->
                                <a href="index.php?url=fakultas&action=hapus&id=<?= $row['id_fakultas'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus fakultas ini secara permanen?')" title="Hapus Data">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" class="text-center py-4 text-muted">Belum ada data fakultas.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'templates/footer.php'; ?>