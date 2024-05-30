<?php
// db.php

class Database {
    private $host = "localhost";
    private $port = "3306"; // Puerto predeterminado de MySQL
    private $db_name = "demoAT";
    private $username = "root";
    private $password = ""; // Cambia esto si tu contraseña no está vacía
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            
            $this->conn = new PDO("mysql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Establecer el modo de error a excepción
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
    public function ejecutarSP($nombreSP, $parametros) {
        try {
            $parametroString = implode(',', array_fill(0, count($parametros), '?'));
            $query = "CALL $nombreSP($parametroString)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute($parametros);
            return $stmt;
        } catch (PDOException $exception) {
            echo "Error al ejecutar el stored procedure: " . $exception->getMessage();
        }
    }
}
?>