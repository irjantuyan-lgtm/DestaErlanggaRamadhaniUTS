<?php
require_once __DIR__ . '/../models/Kategori.php';

class Kategori_Controllers {
    private $model;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Superadmin') {
            echo "<script>alert('Akses Ditolak! Menu ini khusus Superadmin.'); window.location.href='index.php?url=dashboard';</script>";
            exit;
        }
        $this->model = new Kategori();
    }

    public function index() {
        $data_kategori = $this->model->getAll();
        require_once __DIR__ . '/../view/Kategori_view.php';
    }

    public function tambah() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama_kategori'])) {
            $this->model->insert(trim($_POST['nama_kategori']));
            header("Location: index.php?url=kategori");
            exit;
        }
    }

    // FUNGSI BARU: Menampilkan Form Edit
    public function edit() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data_kategori = $this->model->getById($id);
            require_once __DIR__ . '/../view/Kategori_edit_view.php';
        }
    }

    // FUNGSI BARU: Memproses Update Data
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama_kategori'])) {
            $id = $_POST['id_category'];
            $nama = trim($_POST['nama_kategori']);
            $this->model->update($id, $nama);
            header("Location: index.php?url=kategori");
            exit;
        }
    }

    public function hapus() {
        if (isset($_GET['id'])) {
            $this->model->delete($_GET['id']);
        }
        header("Location: index.php?url=kategori");
        exit;
    }
}
?>