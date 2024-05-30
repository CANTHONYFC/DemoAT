<?php
class Encriptador {
    // Método para encriptar una cadena utilizando SHA-256
    public static function encriptarSHA($cadena) {
        $hash = hash('sha256', $cadena);
        return $hash;
    }
}

// Ejemplo de uso
$contraseña = "993430563";
$contraseñaEncriptada = Encriptador::encriptarSHA($contraseña);
echo "Contraseña encriptada: " . $contraseñaEncriptada;
?>