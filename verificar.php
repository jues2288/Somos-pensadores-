<?php
session_start();
include "conexion.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($usuario = $result->fetch_assoc()) {
        
        if (strtolower(trim($usuario['estado'])) !== "activo") {
            $_SESSION['error'] = "⚠️ Usuario inactivo, contacte al administrador.";
            header("Location: auth/login.php");
            exit;
        }

        
        if (password_verify($password, $usuario['password'])) {
            $_SESSION['usuario'] = $usuario['nombre'];
            $_SESSION['perfil'] = $usuario['perfil'];

            switch ($usuario['perfil']) {
                case "administrador":
                    header("Location: admin/panel.php");
                    break;
                case "supervisor":
                    header("Location: supervisor/panel.php");
                    break;
                case "profesor":
                    header("Location: profesor/panel.php");
                    break;
                case "alumno":
                    header("Location: alumno/panel.php");
                    break;
                default:
                    $_SESSION['error'] = "Perfil no reconocido.";
                    header("Location: auth/login.php");
            }
            exit;
        } else {
            $_SESSION['error'] = "❌ Contraseña incorrecta";
            header("Location: auth/login.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "❌ Usuario no encontrado";
        header("Location: auth/login.php");
        exit;
    }
}
