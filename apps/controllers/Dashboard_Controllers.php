<?php
// 1. Wajib menghubungkan Model Announcement agar $this->model bisa bekerja
require_once __DIR__ . '/../models/Announcement.php';

class Dashboard_Controllers {
    // Deklarasikan variabel model
    private $model;

    public function __construct() {
        // Pastikan session menyala untuk mengambil data login
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        
        // Inisialisasi model
        $this->model = new Announcement();
    }

    // 2. Gabungkan logika statistik langsung ke dalam index()
    public function index() {
        // Proteksi jika belum login
        if (!isset($_SESSION['role'])) {
            header("Location: index.php?url=login");
            exit;
        }

        // Cek apakah yang login adalah Admin Instansi (untuk filter data)
        $id_instansi = ($_SESSION['role'] == 'Admin') ? $_SESSION['id_instansi'] : null;

        // Ambil data statistik dari Model
        $total_mading = $this->model->countTotalMading($id_instansi);
        $total_views  = $this->model->countTotalViews($id_instansi);
        $mading_aktif = $this->model->countActiveMading($id_instansi);

        // Arahkan ke tampilan Dashboard
        require_once __DIR__ . '/../view/Dashboard_view.php';
    }
}
?>