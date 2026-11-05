<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Instansi.php';

class User_Controllers {
    private $model;
    private $instansiModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        $this->model = new User();
        $this->instansiModel = new Instansi();
    }

    // --- FITUR LOGIN (Semua Role) ---
    public function login_page() {
        if (isset($_SESSION['role'])) {
            if ($_SESSION['role'] == 'Mahasiswa') {
                header("Location: index.php?url=home");
            } else {
                header("Location: index.php?url=dashboard");
            }
            exit;
        }
        require_once __DIR__ . '/../view/Login_view.php';
    }

    public function proses_login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            // Pengecekan login masih mengandalkan fungsi di model User.php
            $user = $this->model->login($username, $password);

            if ($user) {
                $_SESSION['id_user'] = $user['id_user'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['id_instansi'] = $user['id_instansi'];

                if ($user['role'] == 'Superadmin' || $user['role'] == 'Admin') {
                    header("Location: index.php?url=dashboard");
                } else {
                    header("Location: index.php?url=home"); 
                }
                exit;
            } else {
                echo "<script>alert('Username atau Password salah!'); window.location.href='index.php?url=login';</script>";
                exit;
            }
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?url=login");
        exit;
    }

    // --- FITUR MANAJEMEN USER (Khusus Superadmin) ---
    private function cekSuperadmin() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Superadmin') {
            echo "<script>alert('Akses Ditolak! Menu ini khusus Superadmin.'); window.location.href='index.php?url=dashboard';</script>";
            exit;
        }
    }

    public function index() {
        $this->cekSuperadmin();
        $data_users = $this->model->getAll();
        $data_instansi = $this->instansiModel->getAll(); 
        require_once __DIR__ . '/../view/User_view.php';
    }

    public function tambah() {
        $this->cekSuperadmin();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_instansi = (!empty($_POST['id_instansi']) && $_POST['role'] == 'Admin') ? $_POST['id_instansi'] : null;

            $data = [
                'username' => trim($_POST['username']),
                // FIX: Menambahkan enkripsi standar Bcrypt modern di sini
                'password' => password_hash(trim($_POST['password']), PASSWORD_DEFAULT),
                'nama_lengkap' => trim($_POST['nama_lengkap']),
                'role' => $_POST['role'],
                'id_instansi' => $id_instansi
            ];

            $this->model->insert($data);
            header("Location: index.php?url=user");
            exit;
        }
    }

    public function hapus() {
        $this->cekSuperadmin();
        if (isset($_GET['id'])) {
            $this->model->delete($_GET['id']);
        }
        header("Location: index.php?url=user");
        exit;
    }
}
?>