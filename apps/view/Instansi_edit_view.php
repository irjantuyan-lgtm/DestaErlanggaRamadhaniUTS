<?php
/** 
 * @var array $data_fakultas
 * @var array $data_instansi
 */
?>
<?php include 'templates/header.php'; ?>
<?php include 'templates/sidebar.php'; ?>

<div class="container-fluid px-4 mt-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: #2c3e50;">Edit Instansi / UKM</h2>
        <a href="index.php?url=instansi" class="btn btn-secondary rounded-pill px-4">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4" style="max-width: 600px;">
        <div class="card-body p-4">
            <form action="index.php?url=instansi&action=update" method="POST">
                <!-- Input hidden untuk menyimpan ID -->
                <input type="hidden" name="id_instansi" value="<?= htmlspecialchars($data_instansi['id_instansi']) ?>">

                <div class="mb-3">
                    <label for="nama_instansi" class="form-label fw-bold">Nama Instansi / UKM</label>
                    <input type="text" class="form-control bg-light" id="nama_instansi" name="nama_instansi" value="<?= htmlspecialchars($data_instansi['nama_instansi']) ?>" required>
                </div>

                <div class="mb-3">
                    <label for="kategori_tingkat" class="form-label fw-bold">Tingkat Instansi</label>
                    <select class="form-select bg-light" id="edit_kategori_tingkat" name="kategori_tingkat" required onchange="toggleEditFakultas()">
                        <option value="Universitas" <?= ($data_instansi['kategori_tingkat'] == 'Universitas') ? 'selected' : '' ?>>Tingkat Universitas</option>
                        <option value="Fakultas" <?= ($data_instansi['kategori_tingkat'] == 'Fakultas') ? 'selected' : '' ?>>Tingkat Fakultas</option>
                    </select>
                </div>

                <!-- Kolom Pilihan Fakultas (Tersembunyi jika Universitas, Muncul jika Fakultas) -->
                <div class="mb-4" id="edit_kolom_fakultas" style="<?= ($data_instansi['kategori_tingkat'] == 'Universitas') ? 'display: none;' : '' ?>">
                    <label for="id_fakultas" class="form-label fw-bold">Pilih Fakultas</label>
                    <select class="form-select bg-light" id="id_fakultas" name="id_fakultas">
                        <option value="">-- Pilih Fakultas --</option>
                        <?php foreach($data_fakultas as $fak): ?>
                            <option value="<?= $fak['id_fakultas'] ?>" <?= ($data_instansi['id_fakultas'] == $fak['id_fakultas']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($fak['nama_fakultas']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
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

<script>
// Fungsi JavaScript untuk menampilkan/menyembunyikan pilihan fakultas pada form edit
function toggleEditFakultas() {
    var tingkat = document.getElementById("edit_kategori_tingkat").value;
    var kolomFakultas = document.getElementById("edit_kolom_fakultas");
    
    if (tingkat === "Fakultas") {
        kolomFakultas.style.display = "block";
        document.getElementById("id_fakultas").setAttribute("required", "required");
    } else {
        kolomFakultas.style.display = "none";
        document.getElementById("id_fakultas").removeAttribute("required");
        document.getElementById("id_fakultas").value = ""; 
    }
}
</script>

<?php include 'templates/footer.php'; ?>