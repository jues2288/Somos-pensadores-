<?php
session_start();
if ($_SESSION['perfil'] != "supervisor") {
    header("Location: ../auth/login.php");
    exit;
}

include "../conexion.php";

$totalAlumnos = $conn->query("SELECT COUNT(*) AS total FROM usuarios WHERE perfil='alumno'")->fetch_assoc()['total'];
$totalCursos  = $conn->query("SELECT COUNT(*) AS total FROM cursos")->fetch_assoc()['total'];

$totalReportes = 0;
if ($conn->query("SHOW TABLES LIKE 'reportes'")->num_rows > 0) {
    $totalReportes = $conn->query("SELECT COUNT(*) AS total FROM reportes")->fetch_assoc()['total'];
}

$alumnos = $conn->query("SELECT id, nombre, email, Telefono, estado FROM usuarios WHERE perfil='alumno'");
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
        .msg { margin-top:10px; font-weight:bold; text-align:center; }
        .form { background:#fff; padding:20px; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); max-width:400px; }
        .form input { width:100%; padding:10px; margin-top:10px; border:1px solid #ccc; border-radius:6px; }
        .form button { margin-top:15px; width:100%; padding:10px; border:none; border-radius:6px; background:#2ecc71; color:#fff; font-size:16px; cursor:pointer; }
        .form button:hover { background:#27ae60; }
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
            <form id="formCrearAlumno" class="form">
                <input type="text" name="nombre" placeholder="Nombre completo" required>
                <input type="email" name="email" placeholder="Correo" required>
                <input type="password" name="password" placeholder="Contraseña" required>
                <input type="text" name="Telefono" placeholder="Teléfono (opcional)">
                <button type="submit">Guardar Alumno</button>
                <p id="msg" class="msg"></p>
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
                        <th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Estado</th><th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tablaAlumnos">
                    <?php while($row = $alumnos->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['Telefono']; ?></td>
                            <td><?php echo ucfirst($row['estado']); ?></td>
                            <td>
                                <?php if ($row['estado'] == "activo"): ?>
                                    <button class="btn btn-inact" onclick="cambiarEstado(<?php echo $row['id']; ?>)">🔒 Inactivar</button>
                                <?php else: ?>
                                    <button class="btn btn-act" onclick="cambiarEstado(<?php echo $row['id']; ?>)">🔓 Activar</button>
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


document.getElementById("formCrearAlumno").addEventListener("submit", async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const msg = document.getElementById("msg");

    try {
        const res = await fetch("crear_estudiante.php", { method: "POST", body: formData });
        const data = await res.text();

        msg.textContent = data.includes("exito") ? "✅ Alumno creado correctamente" : "❌ Error al crear alumno";
        msg.style.color = data.includes("exito") ? "green" : "red";
        e.target.reset();
    } catch (error) {
        msg.textContent = "⚠️ Error de conexión";
        msg.style.color = "red";
    }
});


async function cambiarEstado(id) {
    const res = await fetch(`toggle_estado_supervisor.php?id=${id}`);
    const data = await res.text();

    if (data.includes("exito")) {
        const fila = document.querySelector(`#tablaAlumnos tr td:first-child:contains(${id})`);
        location.reload(); 
    } else {
        alert("Error al cambiar el estado del alumno");
    }
}
</script>
</body>
</html>
