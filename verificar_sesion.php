<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar que haya sesión activa
if (!isset($_SESSION['usuario']) || !isset($_SESSION['perfil'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Verificar rol específico (opcional)
function verificarRol($rol) {
    if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== $rol) {
        header("Location: ../auth/login.php");
        exit;
    }
}
?>
