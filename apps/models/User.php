<?php
require_once __DIR__ . '/../config/Database.php';

class User {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // FUNGSI LOGIN (HYBRID: Mendukung MD5 lama dan Bcrypt baru)
    public function login($username, $password) {
        // 1. Cari user berdasarkan username saja terlebih dahulu
        $query = "SELECT * FROM users WHERE username = :username LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['username' => $username]);
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // 2a. Cek password dengan keamanan modern (Bcrypt) untuk akun baru
            if (password_verify($password, $user['password'])) {
                return $user;
            }
            // 2b. Cek password dengan MD5 (Fallback) untuk menyelamatkan akun Superadmin lama
            if (md5($password) === $user['password']) {
                return $user;
            }
        }
        
        return false; // Login gagal
    }

    // READ: Tampil Semua User beserta nama instansinya
    public function getAll() {
        $query = "SELECT u.id_user, u.username, u.nama_lengkap, u.role, i.nama_instansi 
                  FROM users u
                  LEFT JOIN instansi i ON u.id_instansi = i.id_instansi";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // CREATE: Tambah User Baru
    public function insert($data) {
        $query = "INSERT INTO users (username, password, nama_lengkap, role, id_instansi) 
                  VALUES (:username, :password, :nama_lengkap, :role, :id_instansi)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            'username' => $data['username'],
            // FIX: md5() dihapus di sini karena Controller sudah melakukan password_hash()
            'password' => $data['password'], 
            'nama_lengkap' => $data['nama_lengkap'],
            'role' => $data['role'],
            'id_instansi' => $data['id_instansi']
        ]);
    }

    public function delete($id) {
        $query = "DELETE FROM users WHERE id_user = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}
?>