<?php
session_start();
if ($_SESSION['perfil'] != "alumno") {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Alumno</title>
    <link rel="stylesheet" href="../css/panel/dashboard.css">
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="profile">
            <img src="https://via.placeholder.com/80" alt="Usuario">
            <h3><?php echo $_SESSION['usuario']; ?></h3>
            <p>Alumno</p>
        </div>
        <nav>
            <ul>
                <li><a href="panel.php">🏠 Dashboard</a></li>
                <li><a href="#">📖 Mis Cursos</a></li>
                <li><a href="#">📊 Progreso</a></li>
                <li><a href="../auth/logout.php" class="logout">🚪 Salir</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <header>
            <h1>Panel del Alumno</h1>
            <p>Bienvenido, <?php echo $_SESSION['usuario']; ?> 👋</p>
        </header>

        <section class="stats">
            <div class="card">📖 <h2>3</h2><p>Cursos Inscritos</p></div>
            <div class="card">⭐ <h2>85%</h2><p>Progreso</p></div>
            <div class="card">🏆 <h2>2</h2><p>Certificados</p></div>
        </section>
    </main>
</div>
</body>
</html>
