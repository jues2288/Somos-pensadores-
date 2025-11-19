<?php
session_start();
include "../conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Limpiar y validar datos
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $password_raw = trim($_POST['password']);

    if (empty($nombre) || empty($email) || empty($password_raw)) {
        $_SESSION['error'] = "⚠️ Todos los campos son obligatorios.";
        header("Location: ../auth/registro.php");
        exit;
    }

    // Encriptar contraseña
    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    // Verificar si ya existe el usuario
    $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $_SESSION['error'] = "⚠️ Ya existe un usuario con ese correo.";
        $check->close();
        $conn->close();
        header("Location: ../auth/registro.php");
        exit;
    }
    $check->close();

    // Insertar nuevo visitante
    $sql = $conn->prepare("INSERT INTO usuarios (nombre, email, password, perfil, estado) VALUES (?, ?, ?, 'visitante', 'activo')");
    $sql->bind_param("sss", $nombre, $email, $password);

    if ($sql->execute()) {
        // Crear sesión y redirigir
        $_SESSION['usuario'] = $nombre;
        $_SESSION['perfil'] = 'visitante';
        $_SESSION['email'] = $email;

        $sql->close();
        $conn->close();

        header("Location: informacion.php");
        exit;
    } else {
        $_SESSION['error'] = "❌ Error al registrar el usuario. Intenta nuevamente.";
        $sql->close();
        $conn->close();
        header("Location: ../auth/registro.php");
        exit;
    }
}
?>
