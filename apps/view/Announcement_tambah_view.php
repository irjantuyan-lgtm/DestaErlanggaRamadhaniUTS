<?php
/** 
 * @var array $data_kategori 
 * @var array $data_instansi 
 */
?>

<?php include 'templates/header.php'; ?>
<?php include 'templates/sidebar.php'; ?>

<h2 class="fw-bold mb-4">Buat Pengumuman Baru</h2>
<div class="card p-4" style="max-width: 800px;">
    <form method="POST" action="index.php?url=announcement&action=simpan" enctype="multipart/form-data">
        
        <div class="mb-3">
            <label class="form-label fw-bold">Judul Pengumuman</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Kategori</label>
                <select name="id_category" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <?php foreach ($data_kategori as $k): ?>
                        <option value="<?= $k['id_category'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if($_SESSION['role'] == 'Superadmin'): ?>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Instansi Penyelenggara</label>
                <select name="id_instansi" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <?php foreach ($data_instansi as $i): ?>
                        <option value="<?= $i['id_instansi'] ?>">
                            <?= htmlspecialchars($i['nama_instansi']) ?> (Tingkat <?= htmlspecialchars($i['kategori_tingkat']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Deskripsi Acara</label>
            <textarea name="deskripsi" class="form-control" rows="5" required></textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Upload Poster (JPG/PNG)</label>
                <input type="file" name="poster_path" class="form-control" accept="image/*" required>
            </div>
            <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Tanggal Berakhir (Expired)</label>
            <!-- Tambahkan min="< ?= date('Y-m-d') ?>" -->
            <input type="date" name="date_expired" class="form-control" min="<?= date('Y-m-d') ?>" required>
        </div>
        </div>

        <button type="submit" class="btn btn-primary px-4 mt-3">Simpan & Publikasikan</button>
        <a href="index.php?url=announcement" class="btn btn-light px-4 mt-3 ms-2">Batal</a>
    </form>
</div>
<?php include 'templates/footer.php'; ?>