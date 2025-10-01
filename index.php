<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Universidad</title>
    <link rel="stylesheet" href="../css/login/login.css">
</head>
<body>
    <div class="login-container">
        <h2>🎓 Iniciar Sesión</h2>
        <form action="verificar.php" method="POST">
            <label>Email:</label>
            <input type="email" name="email" required>
            
            <label>Contraseña:</label>
            <input type="password" name="password" required>
            
            <button type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>
