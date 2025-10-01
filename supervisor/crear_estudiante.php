<?php
session_start();
if ($_SESSION['perfil'] != "supervisor") {
    header("Location: ../auth/login.php");
    exit;
}
include "../conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $perfil = "alumno"; 

    $sql = "INSERT INTO usuarios (nombre, email, password, perfil) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $email, $password, $perfil);

    if ($stmt->execute()) {
        $msg = "Alumno creado con éxito";
    } else {
        $msg = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Alumno</title>
    <link rel="stylesheet" href="../css/supervisor/crear_alumno.css">
</head>
<body>
    <div class="form-container">
        <h2>Registrar Alumno</h2>
        <?php if (!empty($msg)): ?>
            <p class="msg <?php echo (strpos($msg, 'éxito') !== false) ? 'success' : 'error'; ?>">
                <?php echo $msg; ?>
            </p>
        <?php endif; ?>
        <form method="POST">
            <label>Nombre:</label>
            <input type="text" name="nombre" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Contraseña:</label>
            <input type="password" name="password" required>

            <button type="submit">Crear Alumno</button>
        </form>
    </div>
</body>
</html>
