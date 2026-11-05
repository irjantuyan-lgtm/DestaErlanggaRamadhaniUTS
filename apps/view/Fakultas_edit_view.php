<?php
/** 
 * @var array $data_fakultas 
 */
?>

<?php include 'templates/header.php'; ?>
<?php include 'templates/sidebar.php'; ?>

<div class="container-fluid px-4 mt-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: #2c3e50;">Edit Fakultas</h2>
        <a href="index.php?url=fakultas" class="btn btn-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4" style="max-width: 600px;">
        <div class="card-body p-4">
            <form action="index.php?url=fakultas&action=update" method="POST">
                <!-- Input hidden untuk menyimpan ID -->
                <input type="hidden" name="id_fakultas" value="<?= htmlspecialchars($data_fakultas['id_fakultas']) ?>">

                <div class="mb-4">
                    <label for="nama_fakultas" class="form-label fw-bold">Nama Fakultas</label>
                    <input type="text" class="form-control form-control-lg bg-light" id="nama_fakultas" name="nama_fakultas" value="<?= htmlspecialchars($data_fakultas['nama_fakultas']) ?>" required placeholder="Masukkan nama fakultas...">
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold">
                        <i class="bi bi-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>