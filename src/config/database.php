<?php

class Database {
    private $host = 'localhost';
    private $port = '3306';
    private $db_name = 'proyectotienda';
    private $username = 'root';
    private $password = 'root';
    private $conn;
    
    public function getConnection(){
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            echo "Error de conexion: " . $e->getMessage();
        }
        return $this->conn;
    }
}

?>