<?php
// archivo: backend/conexion.php

$host = 'localhost';
$db = 'eps'; // Nombre de la base de datos
$user = 'root'; // Usuario de MySQL
$pass = ''; // Contraseña de MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
