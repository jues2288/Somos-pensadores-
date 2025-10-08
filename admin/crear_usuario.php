<?php
include "../conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $Telefono = $_POST['Telefono'];
    $direccion = $_POST['direccion'] ?? '';
    $perfil = $_POST['perfil'];

    $sql = "INSERT INTO usuarios (nombre, email, password, Telefono, direccion, perfil, estado)
            VALUES (?, ?, ?, ?, ?, ?, 'activo')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $nombre, $email, $password, $Telefono, $direccion, $perfil);

    echo $stmt->execute() ? "exito" : "error";
    $stmt->close();
}
?>
