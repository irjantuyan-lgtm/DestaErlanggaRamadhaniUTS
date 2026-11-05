<?php
require_once __DIR__ . '/../models/Instansi.php';
require_once __DIR__ . '/../models/Fakultas.php';

class Instansi_Controllers {
    private $instansiModel;
    private $fakultasModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Superadmin') {
            echo "<script>alert('Akses Ditolak! Menu ini khusus Superadmin.'); window.location.href='index.php?url=dashboard';</script>";
            exit;
        }
        $this->instansiModel = new Instansi();
        $this->fakultasModel = new Fakultas();
    }

    public function index() {
        $data_instansi = $this->instansiModel->getAll();
        $data_fakultas = $this->fakultasModel->getAll(); 
        require_once __DIR__ . '/../view/Instansi_view.php';
    }

    public function tambah() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'nama_instansi' => trim($_POST['nama_instansi']),
                'kategori_tingkat' => $_POST['kategori_tingkat'],
                'id_fakultas' => !empty($_POST['id_fakultas']) ? $_POST['id_fakultas'] : null
            ];
            $this->instansiModel->insert($data);
            header("Location: index.php?url=instansi");
            exit;
        }
    }

    // FUNGSI BARU: Menampilkan Form Edit
    public function edit() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data_instansi = $this->instansiModel->getById($id);
            $data_fakultas = $this->fakultasModel->getAll(); // Dibutuhkan untuk dropdown pilihan fakultas
            require_once __DIR__ . '/../view/Instansi_edit_view.php';
        }
    }

    // FUNGSI BARU: Memproses Update Data
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id_instansi'];
            $data = [
                'nama_instansi' => trim($_POST['nama_instansi']),
                'kategori_tingkat' => $_POST['kategori_tingkat'],
                'id_fakultas' => !empty($_POST['id_fakultas']) ? $_POST['id_fakultas'] : null
            ];
            $this->instansiModel->update($id, $data);
            header("Location: index.php?url=instansi");
            exit;
        }
    }

    public function hapus() {
        if (isset($_GET['id'])) {
            $this->instansiModel->delete($_GET['id']);
        }
        header("Location: index.php?url=instansi");
        exit;
    }
}
?>