<?php
require_once __DIR__ . '/../models/Announcement.php';
require_once __DIR__ . '/../models/Kategori.php';
require_once __DIR__ . '/../models/Instansi.php';

class Announcement_Controllers {
    private $pengumumanModel;
    private $kategoriModel;
    private $instansiModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        if (!isset($_SESSION['role']) || $_SESSION['role'] === 'Mahasiswa') {
            header("Location: index.php?url=login");
            exit;
        }
        $this->pengumumanModel = new Announcement();
        $this->kategoriModel = new Kategori();
        $this->instansiModel = new Instansi();
    }

    public function index() {
        $keyword = isset($_POST['keyword']) ? trim($_POST['keyword']) : (isset($_GET['keyword']) ? trim($_GET['keyword']) : '');
        $limit = 10;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $id_instansi_admin = ($_SESSION['role'] == 'Superadmin') ? null : $_SESSION['id_instansi'];

        $data_mading = $this->pengumumanModel->getPaginatedData($keyword, $limit, $offset, $id_instansi_admin);
        $total_rows = $this->pengumumanModel->getTotalRows($keyword, $id_instansi_admin);
        $total_pages = ceil($total_rows / $limit);

        require_once __DIR__ . '/../view/Announcement_view.php';
    }

    public function form_tambah() {
        $data_kategori = $this->kategoriModel->getAll();
        $data_instansi = $this->instansiModel->getAll();
        require_once __DIR__ . '/../view/Announcement_tambah_view.php';
    }

    public function simpan() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nama_file_poster = ""; 

            if (isset($_FILES['poster_path']) && $_FILES['poster_path']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['poster_path']['tmp_name'];
                $fileName = $_FILES['poster_path']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png'];

                if (in_array($fileExtension, $allowed)) {
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                    $uploadDir = __DIR__ . '/../../uploads/';
                    if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }
                    
                    if(move_uploaded_file($fileTmpPath, $uploadDir . $newFileName)) {
                        $nama_file_poster = $newFileName; 
                    } else {
                        echo "<script>alert('Gagal upload gambar!'); window.history.back();</script>"; exit;
                    }
                }
            }

            $id_instansi_fix = ($_SESSION['role'] == 'Superadmin') ? $_POST['id_instansi'] : $_SESSION['id_instansi'];

            $data = [
                'id_instansi' => $id_instansi_fix,
                'id_user' => $_SESSION['id_user'], 
                'id_category' => $_POST['id_category'],
                'title' => $_POST['title'],
                'deskripsi' => $_POST['deskripsi'],
                'poster_path' => $nama_file_poster, 
                'date_expired' => $_POST['date_expired']
            ];

            $this->pengumumanModel->insert($data);
            header("Location: index.php?url=announcement");
            exit;
        }
    }

    public function edit() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $data_pengumuman = $this->pengumumanModel->getById($id);
            
            if ($_SESSION['role'] != 'Superadmin' && $data_pengumuman['id_instansi'] != $_SESSION['id_instansi']) {
                echo "<script>alert('Akses Ditolak!'); window.location.href='index.php?url=announcement';</script>";
                exit;
            }

            $data_kategori = $this->kategoriModel->getAll();
            $data_instansi = $this->instansiModel->getAll();
            require_once __DIR__ . '/../view/Announcement_edit_view.php';
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id_announcement'];
            $nama_file_poster = $_POST['poster_lama']; 
            
            if (isset($_FILES['poster_path']) && $_FILES['poster_path']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['poster_path']['tmp_name'];
                $fileName = $_FILES['poster_path']['name'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                
                if (in_array($fileExtension, ['jpg', 'jpeg', 'png'])) {
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                    $uploadDir = __DIR__ . '/../../uploads/';
                    if (!is_dir($uploadDir)) { mkdir($uploadDir, 0777, true); }
                    if(move_uploaded_file($fileTmpPath, $uploadDir . $newFileName)) {
                        $nama_file_poster = $newFileName;
                    }
                }
            }

            $id_instansi_fix = ($_SESSION['role'] == 'Superadmin') ? $_POST['id_instansi'] : $_SESSION['id_instansi'];

            $data = [
                'id_instansi' => $id_instansi_fix,
                'id_category' => $_POST['id_category'],
                'title' => $_POST['title'],
                'deskripsi' => $_POST['deskripsi'],
                'poster_path' => $nama_file_poster,
                'date_expired' => $_POST['date_expired']
            ];

            $this->pengumumanModel->update($id, $data);
            header("Location: index.php?url=announcement");
            exit;
        }
    }

    public function hapus() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            if ($_SESSION['role'] != 'Superadmin') {
                $data_pengumuman = $this->pengumumanModel->getById($id);
                if ($data_pengumuman['id_instansi'] != $_SESSION['id_instansi']) {
                    echo "<script>alert('Akses Ditolak!'); window.location.href='index.php?url=announcement';</script>";
                    exit;
                }
            }
            $this->pengumumanModel->delete($id);
        }
        header("Location: index.php?url=announcement");
        exit;
    }
}
?>