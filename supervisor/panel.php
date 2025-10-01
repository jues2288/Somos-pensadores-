<?php
session_start();
if ($_SESSION['perfil'] != "supervisor") {
    header("Location: ../auth/login.php");
    exit;
}


$conn = new mysqli("localhost", "root", "", "escuela_app");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}


$totalAlumnos = $conn->query("SELECT COUNT(*) AS total FROM usuarios WHERE perfil='alumno'")->fetch_assoc()['total'];
$totalCursos  = $conn->query("SELECT COUNT(*) AS total FROM cursos")->fetch_assoc()['total'];
$totalReportes = 0;
if ($conn->query("SHOW TABLES LIKE 'reportes'")->num_rows > 0) {
    $totalReportes = $conn->query("SELECT COUNT(*) AS total FROM reportes")->fetch_assoc()['total'];
}


$alumnos = $conn->query("SELECT id, nombre, email, estado FROM usuarios WHERE perfil='alumno'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Supervisor</title>
    <link rel="stylesheet" href="../css/panel/dashboard.css">
    <style>
        .hidden { display: none; }
        .table { width:100%; border-collapse: collapse; margin-top:20px; }
        .table th, .table td { border:1px solid #ddd; padding:10px; text-align:center; }
        .table th { background:#f4f4f4; }
        .btn { padding:6px 10px; margin:2px; border:none; border-radius:5px; cursor:pointer; }
        .btn-edit { background:#3498db; color:#fff; }
        .btn-del { background:#e74c3c; color:#fff; }
        .btn-act { background:#2ecc71; color:#fff; }
        .btn-inact { background:#f39c12; color:#fff; }
    </style>
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <div class="profile">
            <img src="https://via.placeholder.com/80" alt="Usuario">
            <h3><?php echo $_SESSION['usuario']; ?></h3>
            <p>Supervisor</p>
        </div>
        <nav>
            <ul>
                <li><a href="#" onclick="mostrar('dashboard')">🏠 Dashboard</a></li>
                <li><a href="#" onclick="mostrar('crear')">👨‍🎓 Crear Alumno</a></li>
                <li><a href="#" onclick="mostrar('reportes')">📊 Reportes de Cursos</a></li>
                <li><a href="#" onclick="mostrar('alumnos')">📋 Ver Alumnos</a></li>
                <li><a href="../auth/logout.php" class="logout">🚪 Salir</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">
        <header>
            <h1>Panel del Supervisor</h1>
            <p>Bienvenido, <?php echo $_SESSION['usuario']; ?> 👋</p>
        </header>

        
        <section id="dashboard" class="stats">
            <div class="card">👨‍🎓 <h2><?php echo $totalAlumnos; ?></h2><p>Alumnos</p></div>
            <div class="card">📚 <h2><?php echo $totalCursos; ?></h2><p>Cursos Activos</p></div>
            <div class="card">📊 <h2><?php echo $totalReportes; ?></h2><p>Reportes</p></div>
        </section>

        
        <section id="crear" class="hidden">
            <h2>👨‍🎓 Crear Alumno</h2>
            <form action="crear_estudiante.php" method="POST">
                <input type="text" name="nombre" placeholder="Nombre completo" required><br><br>
                <input type="email" name="email" placeholder="Correo" required><br><br>
                <input type="password" name="password" placeholder="Contraseña" required><br><br>
                <button type="submit" class="btn btn-act">Crear Alumno</button>
            </form>
        </section>

        
        <section id="reportes" class="hidden">
            <h2>📊 Reportes de Cursos</h2>
            <p>Aquí podrás ver estadísticas detalladas de los cursos.</p>
        </section>

        
        <section id="alumnos" class="hidden">
            <h2>📋 Lista de Alumnos</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th><th>Nombre</th><th>Email</th><th>Estado</th><th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $alumnos->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo ucfirst($row['estado']); ?></td>
                            <td>
                                <button class="btn btn-edit">✏️ Editar</button>
                                <button class="btn btn-del">🗑️ Eliminar</button>
                                <?php if ($row['estado'] == "activo"): ?>
                                    <button class="btn btn-inact">🔒 Inactivar</button>
                                <?php else: ?>
                                    <button class="btn btn-act">🔓 Activar</button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>
</div>

<script>
function mostrar(id) {
    document.querySelectorAll('main section').forEach(sec => sec.classList.add('hidden'));
    document.getElementById(id).classList.remove('hidden');
}
</script>
</body>
</html>
