<?php
session_start();
if ($_SESSION['perfil'] != "profesor") {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Profesor</title>
    <link rel="stylesheet" href="../css/panel/dashboard.css">
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="profile">
            <img src="https://via.placeholder.com/80" alt="Usuario">
            <h3><?php echo $_SESSION['usuario']; ?></h3>
            <p>Profesor</p>
        </div>
        <nav>
            <ul>
                <li><a href="panel.php">🏠 Dashboard</a></li>
                <li><a href="#">📚 Mis Clases</a></li>
                <li><a href="#">📝 Evaluaciones</a></li>
                <li><a href="../auth/logout.php" class="logout">🚪 Salir</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <header>
            <h1>Panel del Profesor</h1>
            <p>Bienvenido, <?php echo $_SESSION['usuario']; ?> 👋</p>
        </header>

        <section class="stats">
            <div class="card">📚 <h2>5</h2><p>Cursos</p></div>
            <div class="card">👨‍🎓 <h2>100</h2><p>Alumnos</p></div>
            <div class="card">📝 <h2>30</h2><p>Tareas Pendientes</p></div>
        </section>
    </main>
</div>
</body>
</html>
