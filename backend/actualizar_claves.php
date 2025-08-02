<?php
require_once 'conexion.php';

function encriptarSiEsPlano($tabla, $pdo) {
    $query = "SELECT id, clave FROM $tabla";
    $stmt = $pdo->query($query);
    $usuarios = $stmt->fetchAll();

    foreach ($usuarios as $usuario) {
        $id = $usuario['id'];
        $clave = $usuario['clave'];

        // Si la clave ya está encriptada, la dejamos quieta
        if (password_get_info($clave)['algo']) {
            continue;
        }

        // Encriptar y actualizar
        $claveHash = password_hash($clave, PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE $tabla SET clave = :clave WHERE id = :id");
        $update->execute(['clave' => $claveHash, 'id' => $id]);
    }

    echo "✔ Claves actualizadas en la tabla $tabla<br>";
}

encriptarSiEsPlano('usuarios', $pdo);
encriptarSiEsPlano('invitados', $pdo);
encriptarSiEsPlano('funcionarios', $pdo);
