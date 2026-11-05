<?php
require_once __DIR__ . '/../config/Database.php';

class Fakultas {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // READ
    public function getAll() {
        $query = "SELECT * FROM fakultas";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM fakultas WHERE id_fakultas = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // CREATE
    public function insert($nama_fakultas) {
        $query = "INSERT INTO fakultas (nama_fakultas) VALUES (:nama)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['nama' => $nama_fakultas]);
    }

    // UPDATE
    public function update($id, $nama_fakultas) {
        $query = "UPDATE fakultas SET nama_fakultas = :nama WHERE id_fakultas = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['nama' => $nama_fakultas, 'id' => $id]);
    }

    // DELETE
    public function delete($id) {
        $query = "DELETE FROM fakultas WHERE id_fakultas = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}
?>