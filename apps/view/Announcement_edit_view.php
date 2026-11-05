<?php
/** 
 * @var array $data_pengumuman 
 * @var array $data_kategori 
 * @var array $data_instansi 
 */
?>
<?php include 'templates/header.php'; ?>
<?php include 'templates/sidebar.php'; ?>

<h2 class="fw-bold mb-4">Ubah Data Pengumuman</h2>
<div class="card p-4" style="max-width: 800px;">
    <!-- Perhatikan action diarahkan ke 'update' -->
    <form method="POST" action="index.php?url=announcement&action=update" enctype="multipart/form-data">
        
        <!-- HIDDEN INPUT: ID Pengumuman & Nama File Gambar Lama -->
        <input type="hidden" name="id_announcement" value="<?= $data_pengumuman['id_announcement'] ?>">
        <input type="hidden" name="poster_lama" value="<?= htmlspecialchars($data_pengumuman['poster_path']) ?>">

        <div class="mb-3">
            <label class="form-label fw-bold">Judul Pengumuman</label>
            <!-- Value diisi dengan data dari database -->
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($data_pengumuman['title']) ?>" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Kategori</label>
                <select name="id_category" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <?php foreach ($data_kategori as $k): ?>
                        <option value="<?= $k['id_category'] ?>" <?= ($k['id_category'] == $data_pengumuman['id_category']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($k['nama_kategori']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <?php if($_SESSION['role'] == 'Superadmin'): ?>
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Instansi Penyelenggara</label>
                <select name="id_instansi" class="form-select" required>
                    <option value="">-- Pilih --</option>
                    <?php foreach ($data_instansi as $i): ?>
                        <option value="<?= $i['id_instansi'] ?>" <?= ($i['id_instansi'] == $data_pengumuman['id_instansi']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($i['nama_instansi']) ?> (Tingkat <?= htmlspecialchars($i['kategori_tingkat']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <?php endif; ?>
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Deskripsi Acara</label>
            <textarea name="deskripsi" class="form-control" rows="5" required><?= htmlspecialchars($data_pengumuman['deskripsi']) ?></textarea>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label fw-bold">Upload Poster Baru (Kosongkan jika tidak diganti)</label>
                <!-- Atribut 'required' DIHAPUS karena user boleh tidak mengganti gambar -->
                <input type="file" name="poster_path" class="form-control" accept="image/*">
                <small class="text-muted mt-1 d-block">
                    Gambar saat ini: 
                    <?php if(!empty($data_pengumuman['poster_path'])): ?>
                        <a href="uploads/<?= htmlspecialchars($data_pengumuman['poster_path']) ?>" target="_blank">Lihat Gambar</a>
                    <?php else: ?>
                        Tidak ada gambar
                    <?php endif; ?>
                </small>
            </div>
            <div class="col-md-6 mb-3">
            <label class="form-label fw-bold">Tanggal Berakhir (Expired)</label>
            <!-- Tambahkan min="< ?= date('Y-m-d') ?>" di sebelah atribut value -->
            <input type="date" name="date_expired" class="form-control" value="<?= htmlspecialchars($data_pengumuman['date_expired']) ?>" min="<?= date('Y-m-d') ?>" required>
        </div>
        </div>

        <button type="submit" class="btn btn-primary px-4 mt-3">Simpan Perubahan</button>
        <a href="index.php?url=announcement" class="btn btn-light px-4 mt-3 ms-2">Batal</a>
    </form>
</div>

<?php include 'templates/footer.php'; ?>