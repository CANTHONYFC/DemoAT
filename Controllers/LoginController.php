<?php
session_start();
include '../config/DatabaseConexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $password =hash('sha256', $_POST['password']);
    
    try {
        // Crear una instancia de la clase Database
        $database = new Database();
        $conn = $database->getConnection();
        
        // Definir el nombre del stored procedure
        $nombreSP = 'validate_user';
        // Definir los parámetros del stored procedure
        $parametros = array($usuario, $password);
        // Ejecutar el stored procedure
        $resultado = $database->ejecutarSP($nombreSP, $parametros);
        $row = $resultado->fetch(PDO::FETCH_ASSOC);
        // Verificar si se encontró un usuario
        if ($row) {
            // Asignar el ID del usuario a la sesión
            $_SESSION['id_usuario'] = $row['id_users'];
            $_SESSION['id_person'] = $row['id_person'];
            $_SESSION['dni'] = $row['dni'];
            $_SESSION['phone'] = $row['phone'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['last_name'] = $row['last_name'];
            $_SESSION['type_person'] = $row['type_person'];
            echo json_encode(array("success" => true, "redirect" => "transfer.php"));
            exit();
        } else {
            echo json_encode(array("success" => false, "message" => "Usuario o contraseña incorrectos."));
            
        }
    } catch (PDOException $e) {
        echo json_encode(array("success" => false, "message" => "Error: " . $e->getMessage()));
       
    }
}
?>