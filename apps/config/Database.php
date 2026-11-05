<?php
class Database {
    private $host = "localhost";
    private $db_name = "digital_mading"; 
    private $username = "root";          
    private $password = "";              
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // Membuat koneksi PDO
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Koneksi Error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>