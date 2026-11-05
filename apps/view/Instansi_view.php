<?php
/** 
 * @var array $data_fakultas
 * @var array $data_instansi
 */
?>
<?php include 'templates/header.php'; ?>
<?php include 'templates/sidebar.php'; ?>

<h2 class="fw-bold mb-4">Master Data Instansi (BEM/UKM)</h2>

<!-- Form Tambah Instansi -->
<div class="card p-4 mb-4 bg-light border-0">
    <h5 class="fw-bold mb-3">Tambah Instansi Baru</h5>
    <form method="POST" action="index.php?url=instansi&action=tambah" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-bold">Nama Instansi</label>
            <input type="text" name="nama_instansi" class="form-control" placeholder="Contoh: BEM Fakultas..." required>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-bold">Tingkat</label>
            <select name="kategori_tingkat" class="form-select" required>
                <option value="Universitas">Tingkat Universitas</option>
                <option value="Fakultas">Tingkat Fakultas</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-bold">Pilih Fakultas (Opsional)</label>
            <select name="id_fakultas" class="form-select">
                <option value="">-- Kosongkan jika tingkat Univ --</option>
                <?php foreach ($data_fakultas as $f): ?>
                    <option value="<?= $f['id_fakultas'] ?>"><?= htmlspecialchars($f['nama_fakultas']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">+ Simpan</button>
        </div>
    </form>
</div>

<!-- Tabel Data Instansi -->
<div class="card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Instansi</th>
                    <th>Tingkatan</th>
                    <th>Fakultas Terkait</th>
                    <th width="120" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data_instansi)): ?>
                    <?php $no = 1; foreach ($data_instansi as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($row['nama_instansi']) ?></td>
                        <td>
                            <?php if($row['kategori_tingkat'] == 'Universitas'): ?>
                                <span class="badge bg-primary">Universitas</span>
                            <?php else: ?>
                                <span class="badge bg-warning text-dark">Fakultas</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-muted"><?= htmlspecialchars($row['nama_fakultas'] ? $row['nama_fakultas'] : 'Semua Fakultas / Umum') ?></td>
                        <td class="text-center">
                            <div class="d-flex justify-content-center gap-2">
                                <!-- Tombol Ubah (Ikon Saja) -->
                                <a href="index.php?url=instansi&action=edit&id=<?= $row['id_instansi'] ?>" class="btn btn-sm btn-warning text-white" title="Edit Data">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <!-- Tombol Hapus (Ikon Saja) -->
                                <a href="index.php?url=instansi&action=hapus&id=<?= $row['id_instansi'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus instansi ini?')" title="Hapus Data">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center py-4 text-muted">Belum ada data instansi.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'templates/footer.php'; ?>