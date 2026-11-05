<?php
require_once __DIR__ . '/../config/Database.php';

class Announcement {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Tampil Data dengan Paginasi, Pencarian, dan Filter Hak Akses Instansi
    public function getPaginatedData($keyword = '', $limit = 10, $offset = 0, $id_instansi_admin = null) {
        $query = "SELECT a.*, u.nama_lengkap, c.nama_kategori, i.nama_instansi, f.nama_fakultas 
                  FROM announcements a
                  LEFT JOIN users u ON a.id_user = u.id_user
                  LEFT JOIN categories c ON a.id_category = c.id_category
                  LEFT JOIN instansi i ON a.id_instansi = i.id_instansi
                  LEFT JOIN fakultas f ON i.id_fakultas = f.id_fakultas
                  WHERE (a.title LIKE :keyword 
                      OR i.nama_instansi LIKE :keyword 
                      OR f.nama_fakultas LIKE :keyword)";
        
        // Filter khusus Admin Instansi
        if ($id_instansi_admin != null) {
            $query .= " AND a.id_instansi = :id_instansi_admin";
        }
                  
        $query .= " ORDER BY a.created_at DESC LIMIT :limit OFFSET :offset";
                  
        $stmt = $this->conn->prepare($query);
        $keyword = "%$keyword%";
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        
        if ($id_instansi_admin != null) {
            $stmt->bindParam(':id_instansi_admin', $id_instansi_admin, PDO::PARAM_INT);
        }
        
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Menghitung total data untuk Pagination
    public function getTotalRows($keyword = '', $id_instansi_admin = null) {
        $query = "SELECT COUNT(*) as total 
                  FROM announcements a
                  LEFT JOIN instansi i ON a.id_instansi = i.id_instansi
                  LEFT JOIN fakultas f ON i.id_fakultas = f.id_fakultas
                  WHERE (a.title LIKE :keyword 
                      OR i.nama_instansi LIKE :keyword 
                      OR f.nama_fakultas LIKE :keyword)";
                     
        if ($id_instansi_admin != null) {
            $query .= " AND a.id_instansi = :id_instansi_admin";
        }
                     
        $stmt = $this->conn->prepare($query);
        $keyword = "%$keyword%";
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        
        if ($id_instansi_admin != null) {
            $stmt->bindParam(':id_instansi_admin', $id_instansi_admin, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // AMBIL 1 DATA SPESIFIK (Duplikat sudah dihapus dan disatukan di sini)
    public function getById($id) {
        // Disamakan menggunakan tabel categories dan id_category sesuai standar database Anda
        $query = "SELECT a.*, c.nama_kategori, i.nama_instansi 
                  FROM announcements a 
                  LEFT JOIN categories c ON a.id_category = c.id_category 
                  LEFT JOIN instansi i ON a.id_instansi = i.id_instansi 
                  WHERE a.id_announcement = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($data) {
        $query = "INSERT INTO announcements (id_instansi, id_user, id_category, title, deskripsi, poster_path, date_expired) 
                  VALUES (:id_instansi, :id_user, :id_category, :title, :deskripsi, :poster_path, :date_expired)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            'id_instansi' => $data['id_instansi'],
            'id_user' => $data['id_user'],
            'id_category' => $data['id_category'],
            'title' => $data['title'],
            'deskripsi' => $data['deskripsi'],
            'poster_path' => $data['poster_path'],
            'date_expired' => $data['date_expired']
        ]);
    }

    public function update($id, $data) {
        $query = "UPDATE announcements SET 
                    id_instansi = :id_instansi, 
                    id_category = :id_category, 
                    title = :title, 
                    deskripsi = :deskripsi, 
                    poster_path = :poster_path, 
                    date_expired = :date_expired 
                  WHERE id_announcement = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            'id_instansi' => $data['id_instansi'],
            'id_category' => $data['id_category'],
            'title' => $data['title'],
            'deskripsi' => $data['deskripsi'],
            'poster_path' => $data['poster_path'],
            'date_expired' => $data['date_expired'],
            'id' => $id
        ]);
    }

    public function delete($id) {
        $query = "DELETE FROM announcements WHERE id_announcement = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['id' => $id]);
    }

    // Tambah jumlah view (+1 setiap kali detail dibuka)
    public function incrementViews($id) {
        $query = "UPDATE announcements SET views = views + 1 WHERE id_announcement = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $id]);
    }

    public function get($id) {
        $query = "SELECT a.*, c.nama_kategori, i.nama_instansi, f.nama_fakultas 
                  FROM announcements a 
                  LEFT JOIN categories c ON a.id_category = c.id_category 
                  LEFT JOIN instansi i ON a.id_instansi = i.id_instansi 
                  LEFT JOIN fakultas f ON i.id_fakultas = f.id_fakultas
                  WHERE a.id_announcement = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // --- FUNGSI STATISTIK UNTUK DASHBOARD ---

    // 1. Menghitung total mading (Bisa difilter per instansi)
    public function countTotalMading($id_instansi = null) {
        $query = "SELECT COUNT(*) as total FROM announcements";
        if ($id_instansi != null) {
            $query .= " WHERE id_instansi = :id_instansi";
        }
        $stmt = $this->conn->prepare($query);
        if ($id_instansi != null) {
            $stmt->execute(['id_instansi' => $id_instansi]);
        } else {
            $stmt->execute();
        }
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    // 2. Menghitung total tayangan/views
    public function countTotalViews($id_instansi = null) {
        $query = "SELECT SUM(views) as total_views FROM announcements";
        if ($id_instansi != null) {
            $query .= " WHERE id_instansi = :id_instansi";
        }
        $stmt = $this->conn->prepare($query);
        if ($id_instansi != null) {
            $stmt->execute(['id_instansi' => $id_instansi]);
        } else {
            $stmt->execute();
        }
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_views'] ?? 0; // Jika null, kembalikan 0
    }

    // 3. Menghitung mading yang masih aktif (belum expired)
    public function countActiveMading($id_instansi = null) {
        $query = "SELECT COUNT(*) as total FROM announcements WHERE date_expired >= CURRENT_DATE()";
        if ($id_instansi != null) {
            $query .= " AND id_instansi = :id_instansi";
        }
        $stmt = $this->conn->prepare($query);
        if ($id_instansi != null) {
            $stmt->execute(['id_instansi' => $id_instansi]);
        } else {
            $stmt->execute();
        }
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
?>