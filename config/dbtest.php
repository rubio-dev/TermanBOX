<?php
$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = ''; // o tu contraseña real
$DB_NAME = 'termanbox';

$conn = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
echo "¡Conexión exitosa!";
?>
