<?php
require_once __DIR__ . '/../models/Announcement.php';

class Home_Controllers {
    private $model;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        $this->model = new Announcement();
    }

    // TAMPILAN HALAMAN DEPAN (LIST PENGUMUMAN)
    public function index() {
        // PERBAIKAN 1: Menangkap parameter 'keyword', bukan 'search'
        $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 9; // Tampilkan 9 pengumuman per halaman
        
        // PERBAIKAN 2: Memperbaiki syntax penghitungan offset
        $offset = ($page - 1) * $limit;

        // Ambil data mading (id_instansi_admin = null karena ini halaman publik)
        $data_mading = $this->model->getPaginatedData($keyword, $limit, $offset, null);
        $total_data = $this->model->getTotalRows($keyword, null);
        $total_pages = ceil($total_data / $limit);

        // Arahkan ke file view halaman home
        require_once __DIR__ . '/../view/Home_view.php';
    }

    // FUNGSI BARU: TAMPILAN DETAIL MADING & TAMBAH VIEW
    public function detail() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            // 1. Tambah jumlah tayangan (+1) di database
            $this->model->incrementViews($id); 
            
            // 2. Ambil data mading tersebut beserta relasinya (kategori & instansi)
            $data_mading = $this->model->getById($id); 
            
            // 3. Tampilkan halaman detail jika datanya ada
            if ($data_mading) {
                require_once __DIR__ . '/../view/Detail_mading_view.php';
            } else {
                echo "<script>alert('Pengumuman tidak ditemukan atau sudah dihapus!'); window.location.href='index.php?url=home';</script>";
            }
        } else {
            // Jika tidak ada ID di URL, kembalikan ke beranda
            header("Location: index.php?url=home");
            exit;
        }
    }
}
?>