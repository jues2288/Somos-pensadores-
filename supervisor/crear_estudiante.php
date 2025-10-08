<?php
include "../conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $Telefono = $_POST['Telefono'] ?? '';

    $sql = "INSERT INTO usuarios (nombre, email, password, Telefono, perfil, estado)
            VALUES (?, ?, ?, ?, 'alumno', 'activo')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $email, $password, $Telefono);

    echo $stmt->execute() ? "exito" : "error";
    $stmt->close();
}
?>
