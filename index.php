<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. TANGKAP PARAMETER URL
// Default URL diubah menjadi 'home' agar publik langsung melihat mading
$url = isset($_GET['url']) ? $_GET['url'] : 'home'; 
$action = isset($_GET['action']) ? $_GET['action'] : 'index'; 

$controller = null;

// 2. ROUTING
switch ($url) {
    case 'home':
        require_once 'apps/controllers/Home_Controllers.php';
        $controller = new Home_Controllers();
        break;

    case 'login':
        require_once 'apps/controllers/User_Controllers.php';
        $controller = new User_Controllers();
        if ($action == 'index') { $action = 'login_page'; }
        break;

    case 'dashboard':
        require_once 'apps/controllers/Dashboard_Controllers.php';
        $controller = new Dashboard_Controllers();
        break;

    case 'announcement':
        require_once 'apps/controllers/Announcement_Controllers.php';
        $controller = new Announcement_Controllers();
        break;

    case 'kategori':
        require_once 'apps/controllers/Kategori_Controllers.php';
        $controller = new Kategori_Controllers();
        break;

    case 'fakultas':
        require_once 'apps/controllers/Fakultas_Controllers.php';
        $controller = new Fakultas_Controllers();
        break;

    case 'instansi':
        require_once 'apps/controllers/Instansi_Controllers.php';
        $controller = new Instansi_Controllers();
        break;

    case 'user':
        require_once 'apps/controllers/User_Controllers.php';
        $controller = new User_Controllers();
        break;

    default:
        echo "<div style='text-align:center; padding: 50px; font-family: sans-serif;'>";
        echo "<h1>404 - Halaman Tidak Ditemukan!</h1>";
        echo "<p>URL <b>$url</b> tidak terdaftar.</p>";
        echo "<a href='index.php'>Kembali ke Halaman Awal</a>";
        echo "</div>";
        exit;
}

// 3. JALANKAN FITUR
if ($controller !== null) {
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        echo "<div style='text-align:center; padding: 50px; font-family: sans-serif;'>";
        echo "<h1>Error 500</h1>";
        echo "<p>Fungsi/Aksi <b>$action</b> belum dibuat.</p>";
        echo "<a href='index.php'>Kembali ke Halaman Awal</a>";
        echo "</div>";
    }
}
?>