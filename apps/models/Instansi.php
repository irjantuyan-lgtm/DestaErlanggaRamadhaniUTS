<?php
require_once __DIR__ . '/../config/Database.php';

class Instansi {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // READ: Tampil Instansi lengkap dengan nama fakultasnya
    public function getAll() {
        $query = "SELECT i.*, f.nama_fakultas 
                  FROM instansi i
                  LEFT JOIN fakultas f ON i.id_fakultas = f.id_fakultas";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // READ: Berdasarkan ID
    public function getById($id) {
        $query = "SELECT * FROM instansi WHERE id_instansi = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // CREATE: Tambah Instansi
    public function insert($data) {
        $query = "INSERT INTO instansi (nama_instansi, kategori_tingkat, id_fakultas) 
                  VALUES (:nama, :kategori_tingkat, :id_fakultas)";
        $stmt = $this->conn->prepare($query);
        
        // Cek jika kategori tingkat Universitas, maka id_fakultas bisa NULL
        $id_fakultas = ($data['kategori_tingkat'] == 'Universitas') ? null : $data['id_fakultas'];

        return $stmt->execute([
            'nama' => $data['nama_instansi'],
            'kategori_tingkat' => $data['kategori_tingkat'],
            'id_fakultas' => $id_fakultas
        ]);
    }

    // DELETE
    public function delete($id) {
        $query = "DELETE FROM instansi WHERE id_instansi = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['id' => $id]);
    }

    // UPDATE: Ubah Data Instansi
    public function update($id, $data) {
        $query = "UPDATE instansi 
                  SET nama_instansi = :nama, kategori_tingkat = :kategori_tingkat, id_fakultas = :id_fakultas 
                  WHERE id_instansi = :id";
        $stmt = $this->conn->prepare($query);
        
        // Cek jika kategori tingkat Universitas, maka id_fakultas NULL
        $id_fakultas = ($data['kategori_tingkat'] == 'Universitas') ? null : $data['id_fakultas'];

        return $stmt->execute([
            'nama' => $data['nama_instansi'],
            'kategori_tingkat' => $data['kategori_tingkat'],
            'id_fakultas' => $id_fakultas,
            'id' => $id
        ]);
    }
}
?>