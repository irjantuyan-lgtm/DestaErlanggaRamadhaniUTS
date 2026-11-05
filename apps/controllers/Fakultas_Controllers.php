<?php
require_once __DIR__ . '/../models/Fakultas.php';

class Fakultas_Controllers {
    private $model;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Superadmin') {
            echo "<script>alert('Akses Ditolak! Menu ini khusus Superadmin.'); window.location.href='index.php?url=dashboard';</script>";
            exit;
        }
        $this->model = new Fakultas();
    }

    public function index() {
        $data_fakultas = $this->model->getAll();
        require_once __DIR__ . '/../view/Fakultas_view.php';
    }

    public function tambah() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama_fakultas'])) {
            $this->model->insert(trim($_POST['nama_fakultas']));
            header("Location: index.php?url=fakultas");
            exit;
        }
    }

    // FUNGSI BARU: Menampilkan Form Edit
    public function edit() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data_fakultas = $this->model->getById($id);
            require_once __DIR__ . '/../view/Fakultas_edit_view.php';
        }
    }

    // FUNGSI BARU: Memproses Update Data
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['nama_fakultas'])) {
            $id = $_POST['id_fakultas'];
            $nama = trim($_POST['nama_fakultas']);
            $this->model->update($id, $nama);
            header("Location: index.php?url=fakultas");
            exit;
        }
    }

    public function hapus() {
        if (isset($_GET['id'])) {
            $this->model->delete($_GET['id']);
        }
        header("Location: index.php?url=fakultas");
        exit;
    }
}
?>