<?php
session_start();
include_once dirname(__DIR__) . '/config/DatabaseConexion.php';

class TransferController
{
    private $database;
    public function __construct()
    {

        $database = new Database();
        $database->getConnection();
        $this->database = $database;
    }

    public function listTransfer()
    {
        // Definir el nombre del stored procedure
        $nombreSP = 'list_transfer';
        // Definir los parámetros del stored procedure
        $parametros = array();
        // Ejecutar el stored procedure
        $resultado = $this->database->ejecutarSP($nombreSP, $parametros);
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("success" => true, "data" => $data));
    }
    public function listChannel()
    {
        // Definir el nombre del stored procedure
        $nombreSP = 'list_Channel';
        // Definir los parámetros del stored procedure
        $parametros = array();
        // Ejecutar el stored procedure
        $resultado = $this->database->ejecutarSP($nombreSP, $parametros);
        $canales = $resultado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("success" => true, "data" => $canales));
    }
    public function listAccountNumbers()
    {
        // Definir el nombre del stored procedure
        $nombreSP = 'list_account_numbers';
        // Definir los parámetros del stored procedure
        $parametros = array();
        // Ejecutar el stored procedure
        $resultado = $this->database->ejecutarSP($nombreSP, $parametros);
        $cuentas = $resultado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("success" => true, "data" => $cuentas));
    }
    public function guardarTransferencia()
    {
        $cliente = $_POST['selectCliente'];
        $canal = $_POST['selectChannel'];
        $cuenta = $_POST['selectAcountNumber'];
        $monto = $_POST['amount'];
        $voucher = $_FILES['voucher'];

        // Ruta donde se guardará el archivo
        $uploadDir = '../uploads/';
        $fileExtension = pathinfo($voucher['name'], PATHINFO_EXTENSION);

        // Generar un nombre único usando microtime
        $uniqueName = basename($voucher['name'], '.' . $fileExtension) . '_' . round(microtime(true) * 1000) . '.' . $fileExtension;
        $uploadFile = $uploadDir . $uniqueName;

        // Mueve el archivo a la carpeta de uploads
        if (move_uploaded_file($voucher['tmp_name'], $uploadFile)) {
            // Guardar los datos en la base de datos incluyendo la URL del archivo
            $voucherUrl = $uploadFile;
            $nombreSP = 'save_transferencia';
            // Aquí va tu lógica para insertar los datos en la base de datos
            // Supongamos que tienes una función saveTransferencia() para esto
            $id_usuario = null;
            $id_person = null;
            if (isset($_SESSION['id_usuario'])) {
                $id_usuario = $_SESSION['id_usuario'];
                $id_person = $_SESSION['id_person'];
                // Ahora puedes usar $userId según sea necesario en tu controlador
            }
            $parametros = array($cliente, $canal, $monto, $voucherUrl, $id_person, $id_usuario, $cuenta);
            // Ejecutar el stored procedure
            $resultado = $this->database->ejecutarSP($nombreSP, $parametros);

            echo json_encode(['status' => 'success', 'message' => 'Transferencia registrada correctamente']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error al cargar el archivo']);
        }
    }  
      public function actualizarTransferencia()
    {
        $p_id_transfer = $_POST['p_id_transfer'];
        $cliente = $_POST['selectCliente'];
        $canal = $_POST['selectChannel'];
        $cuenta = $_POST['selectAcountNumber'];
        $monto = $_POST['amount'];
        $voucher = $_FILES['voucher'];
        $voucherUrl=null;
        if (isset($_FILES['voucher']) && $_FILES['voucher']['error'] === UPLOAD_ERR_OK) {
        // Ruta donde se guardará el archivo
        $uploadDir = '../uploads/';
        $fileExtension = pathinfo($voucher['name'], PATHINFO_EXTENSION);

        // Generar un nombre único usando microtime
        $uniqueName = basename($voucher['name'], '.' . $fileExtension) . '_' . round(microtime(true) * 1000) . '.' . $fileExtension;
        $uploadFile = $uploadDir . $uniqueName;

        // Mueve el archivo a la carpeta de uploads
        if (move_uploaded_file($voucher['tmp_name'], $uploadFile)) {
            // Guardar los datos en la base de datos incluyendo la URL del archivo
            $voucherUrl = $uploadFile;
        } 
    } 

        $nombreSP = 'update_transfer';
        $id_usuario = null;
        $id_person = null;
        if (isset($_SESSION['id_usuario'])) {
            $id_usuario = $_SESSION['id_usuario'];
            $id_person = $_SESSION['id_person'];
            // Ahora puedes usar $userId según sea necesario en tu controlador
        }
        $parametros = array($p_id_transfer , $canal, $monto, $voucherUrl, $id_person, $id_usuario, $cuenta);
        // Ejecutar el stored procedure
        $resultado = $this->database->ejecutarSP($nombreSP, $parametros);

        echo json_encode(['status' => 'success', 'message' => 'Transferencia actualizada correctamente']);
    }
    public function getHistory()
    {
        $p_id_transfer = $_POST['p_id_transfer'];
        $nombreSP = 'get_history';
        $parametros = array($p_id_transfer);
        $resultado = $this->database->ejecutarSP($nombreSP, $parametros);
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("success" => true, "data" => $data));
    }
    public function getTransfer()
    {
        $p_id_transfer = $_POST['p_id_transfer'];
        $nombreSP = 'get_transfer';
        $parametros = array($p_id_transfer);
        $resultado = $this->database->ejecutarSP($nombreSP, $parametros);
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("success" => true, "data" => $data));
    } 
    public function listTransferUser()
    {
        $id_person = $_SESSION['id_person'];
        $name = $_SESSION['last_name'].' '.$_SESSION['name'] ;

        $nombreSP = 'list_transfer_user';
        $parametros = array($id_person);
        $resultado = $this->database->ejecutarSP($nombreSP, $parametros);
        $data = $resultado->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(array("success" => true,
         "data" => $data,
         "name" => $name,
        ));
    }
}

// Ruta para manejar la solicitud AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'listTransfer') {
    $controller = new TransferController();
    $controller->listTransfer();
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'listChannel') {
    $controller = new TransferController();
    $controller->listChannel();
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['action']) && $_GET['action'] === 'listAccountNumbers') {
    $controller = new TransferController();
    $controller->listAccountNumbers();
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'guardarTransferencia') {
    $controller = new TransferController();
    $controller->guardarTransferencia();
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'actualizarTransferencia') {
    $controller = new TransferController();
    $controller->actualizarTransferencia();
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'getHistory') {
    $controller = new TransferController();
    $controller->getHistory();
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'getTransfer') {
    $controller = new TransferController();
    $controller->getTransfer();
} else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_GET['action'] === 'listTransferUser') {
    $controller = new TransferController();
    $controller->listTransferUser();
}
