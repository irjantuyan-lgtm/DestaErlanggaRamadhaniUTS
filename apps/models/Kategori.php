<?php
require_once __DIR__ . '/../config/Database.php';

class Kategori {
    private $conn;

    public function __construct() {
        // Mengambil koneksi PDO dari file Database.php
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // READ: Tampil Semua Data Kategori
    public function getAll() {
        $query = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ: Tampil 1 Data Kategori Berdasarkan ID
    public function getById($id) {
        $query = "SELECT * FROM categories WHERE id_category = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // CREATE: Tambah Kategori Baru
    public function insert($nama_kategori) {
        $query = "INSERT INTO categories (nama_kategori) VALUES (:nama)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['nama' => $nama_kategori]);
    }

    // UPDATE: Ubah Data Kategori
    public function update($id, $nama_kategori) {
        $query = "UPDATE categories SET nama_kategori = :nama WHERE id_category = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            'nama' => $nama_kategori,
            'id' => $id
        ]);
    }

    // DELETE: Hapus Kategori
    public function delete($id) {
        $query = "DELETE FROM categories WHERE id_category = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}
?>