<?php
include "../conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $Telefono = $_POST['Telefono'] ?? '';

    // Agregamos semestre = 1 al registro
    $sql = "INSERT INTO usuarios (nombre, email, password, Telefono, perfil, estado, semestre)
            VALUES (?, ?, ?, ?, 'alumno', 'activo', 1)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $email, $password, $Telefono);

    echo $stmt->execute() ? "exito" : "error";
    $stmt->close();
}
?>
