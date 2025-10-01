<?php
session_start();
if ($_SESSION['perfil'] != "administrador") {
    header("Location: ../auth/login.php");
    exit;
}
include "../conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $perfil = $_POST['perfil'];

    $sql = "INSERT INTO usuarios (nombre, email, password, perfil) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $email, $password, $perfil);

    if ($stmt->execute()) {
        $msg = "✅ Usuario creado con éxito";
    } else {
        $msg = "❌ Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario - Admin</title>
    <link rel="stylesheet" href="../css/admin/crear_usuario.css">
</head>
<body>
    <div class="form-container">
        <h2>👨‍💻 Crear Usuario</h2>
        <?php if (!empty($msg)) echo "<p class='mensaje'>$msg</p>"; ?>

        <form method="POST">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" required>

            <label for="email">Correo electrónico:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>

            <label for="perfil">Perfil:</label>
            <select id="perfil" name="perfil" required>
                <option value="administrador">Administrador</option>
                <option value="supervisor">Supervisor</option>
                <option value="profesor">Profesor</option>
                <option value="alumno">Alumno</option>
            </select>

            <button type="submit">➕ Crear Usuario</button>
        </form>
    </div>
</body>
</html>
