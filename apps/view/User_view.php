<?php
/** 
 * @var array $data_users 
 * @var array $data_instansi 
 */
?>
<?php include 'templates/header.php'; ?>
<?php include 'templates/sidebar.php'; ?>

<h2 class="fw-bold mb-4">Manajemen Akses User</h2>

<!-- Form Tambah User -->
<div class="card p-4 mb-4 bg-light border-0">
    <h5 class="fw-bold mb-3">Buat Akun Admin Baru</h5>
    <form method="POST" action="index.php?url=user&action=tambah" class="row g-3 align-items-end">
        <div class="col-md-3">
            <label class="form-label fw-bold">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" required>
        </div>
        <div class="col-md-2">
            <label class="form-label fw-bold">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="col-md-2">
            <label class="form-label fw-bold">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="col-md-2">
            <label class="form-label fw-bold">Hak Akses</label>
            <select name="role" class="form-select" required>
                <option value="Admin">Admin Biasa</option>
                <option value="Superadmin">Superadmin</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-bold">Instansi (Khusus Admin)</label>
            <select name="id_instansi" class="form-select">
                <option value="">-- Kosongkan Jika Superadmin --</option>
                <?php foreach ($data_instansi as $i): ?>
                    <option value="<?= $i['id_instansi'] ?>">
                        <?= htmlspecialchars($i['nama_instansi']) ?> (Tingkat <?= htmlspecialchars($i['kategori_tingkat']) ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary px-4">+ Simpan User Baru</button>
        </div>
    </form>
</div>

<!-- Tabel Data User -->
<div class="card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Instansi Admin</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($data_users)): ?>
                    <?php $no = 1; foreach ($data_users as $row): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td class="fw-bold"><?= htmlspecialchars($row['nama_lengkap']) ?></td>
                        <td><?= htmlspecialchars($row['username']) ?></td>
                        <td>
                            <?php if($row['role'] == 'Superadmin'): ?>
                                <span class="badge bg-danger">Superadmin</span>
                            <?php else: ?>
                                <span class="badge bg-success">Admin</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-muted"><?= htmlspecialchars($row['nama_instansi'] ? $row['nama_instansi'] : '-') ?></td>
                        <td>
                            <a href="index.php?url=user&action=hapus&id=<?= $row['id_user'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus User ini secara permanen?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data user.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'templates/footer.php'; ?>