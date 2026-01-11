<?php

class Database {
    private $host = 'localhost';
    private $db_name = 'helpdesk_db';
    private $username = 'root'; // User default XAMPP
    private $password = '';     // Parola default XAMPP e goală
    public $conn;
    /**
     * @return PDO|null
     */

    public function connect() {
        $this->conn = null;

        try {
            // Încercăm conectarea folosind PDO (PHP Data Objects)
            // PDO este standardul de securitate, previne SQL Injection
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
                $this->username,
                $this->password
            );
            
            // Setăm modul de erori să fie "Exception" ca să vedem clar dacă crapă ceva
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $e) {
            echo "Eroare la conectare: " . $e->getMessage();
        }

        return $this->conn;
    }
}