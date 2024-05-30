<?php

include_once dirname(__DIR__) . '/config/DatabaseConexion.php';
class ClientController {
    private $database;
    public function __construct() {
        $database = new Database();
        $database->getConnection();
        $this->database=$database;
    }

    public function listClient() {
        // Definir el nombre del stored procedure
        $nombreSP = 'list_client';
        // Definir los parámetros del stored procedure
        $parametros = array();
        // Ejecutar el stored procedure
        $resultado = $this->database->ejecutarSP($nombreSP, $parametros);
        $users = $resultado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("success" => true, "data" => $users));
    }
}

// Ruta para manejar la solicitud AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'listClient') {
    $controller = new ClientController();
    $controller->listClient();
}
?>