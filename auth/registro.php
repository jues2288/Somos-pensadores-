<?php
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Universidad</title>
    <link rel="stylesheet" href="../css/login/login.css">
</head>
<body>
    <div class="login-container">
        <h2>Registro de Visitantes</h2>

        <?php if (!empty($_SESSION['error'])) { ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php } ?>

        <form method="POST" action="../usuarios/guardar_registro.php">
            <label>Nombre completo:</label>
            <input type="text" name="nombre" required>

            <label>Correo electrónico:</label>
            <input type="email" name="email" required>

            <label>Contraseña:</label>
            <input type="password" name="password" required>

            <button type="submit">Registrarse</button>
        </form>

        <p style="margin-top:15px;">¿Ya tienes cuenta? 
            <a href="login.php">Inicia sesión</a>
        </p>
    </div>
</body>
</html>
