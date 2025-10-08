<?php
session_start();
if ($_SESSION['perfil'] != "administrador") {
    header("Location: ../auth/login.php");
    exit;
}
include "../conexion.php";

$totalUsuarios = $conn->query("SELECT COUNT(*) AS total FROM usuarios")->fetch_assoc()['total'];
$totalCursos   = $conn->query("SELECT COUNT(*) AS total FROM cursos")->fetch_assoc()['total'];
$totalProfes   = $conn->query("SELECT COUNT(*) AS total FROM usuarios WHERE perfil='profesor'")->fetch_assoc()['total'];
$totalSuper    = $conn->query("SELECT COUNT(*) AS total FROM usuarios WHERE perfil='supervisor'")->fetch_assoc()['total'];
$totalAlumnos  = $conn->query("SELECT COUNT(*) AS total FROM usuarios WHERE perfil='alumno'")->fetch_assoc()['total'];

$usuarios = $conn->query("SELECT * FROM usuarios ORDER BY id DESC");

$seccion = $_GET['seccion'] ?? "dashboard";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../css/panel/dashboard.css">
    <style>
        body, html { margin:0; padding:0; height:100%; width:100%; font-family:Arial, sans-serif; }
        .dashboard { display:flex; height:100vh; width:100vw; }
        .main-content { flex:1; padding:20px; overflow-y:auto; background:#f5f6fa; }
        .section { display:none; }
        .active { display:block; }
        .stats { display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:20px; margin-bottom:20px; }
        .card { background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 8px rgba(0,0,0,0.1); text-align:center; }
        .charts { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:30px; }
        .chart { background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 8px rgba(0,0,0,0.1); }
        .user-management { background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 8px rgba(0,0,0,0.1); }
        table { width:100%; border-collapse:collapse; margin-top:15px; }
        table th, table td { border:1px solid #ddd; padding:8px; text-align:center; }
        table th { background:#f5f5f5; }
        .btn { padding:5px 10px; border-radius:6px; text-decoration:none; font-size:14px; margin:2px; display:inline-block; }
        .btn-edit { background:#4CAF50; color:#fff; }
        .btn-delete { background:#f44336; color:#fff; }
        .btn-toggle { background:#2196F3; color:#fff; }
        .form-crear { background:#fff; padding:20px; border-radius:12px; box-shadow:0 4px 8px rgba(0,0,0,0.1); margin-top:20px; max-width:500px; }
        .form-crear label { display:block; margin-top:10px; font-weight:bold; }
        .form-crear input, .form-crear select { width:100%; padding:8px; margin-top:5px; border:1px solid #ccc; border-radius:6px; }
        .form-crear button { margin-top:15px; padding:10px; width:100%; border:none; background:#4CAF50; color:white; border-radius:6px; font-size:16px; cursor:pointer; }
        .form-crear button:hover { background:#45a049; }
        .msg { margin-top:15px; font-weight:bold; text-align:center; }
    </style>
</head>
<body>
<div class="dashboard">
    
    <aside class="sidebar">
        <div class="profile">
            <img src="https://via.placeholder.com/80" alt="Usuario">
            <h3><?php echo $_SESSION['usuario']; ?></h3>
            <p>Administrador</p>
            <small><?php echo $_SESSION['email'] ?? ''; ?></small>
        </div>
        <nav>
            <ul>
                <li><a href="#" onclick="showSection('dashboard')">📊 Dashboard</a></li>
                <li><a href="#" onclick="showSection('gestion')">👥 Gestión Usuarios</a></li>
                <li><a href="#" onclick="showSection('crear')">➕ Crear Usuario</a></li>
                <li><a href="../auth/logout.php" class="logout">🚪 Salir</a></li>
            </ul>
        </nav>
    </aside>

    <main class="main-content">

     
        <section id="dashboard" class="section <?php echo ($seccion=='dashboard')?'active':''; ?>">
            <header><h1>📊 Dashboard Admin</h1></header>
            <section class="stats">
                <div class="card">👥 <h2><?php echo $totalUsuarios; ?></h2><p>Usuarios</p></div>
                <div class="card">📚 <h2><?php echo $totalCursos; ?></h2><p>Cursos</p></div>
                <div class="card">🧑‍🏫 <h2><?php echo $totalProfes; ?></h2><p>Profesores</p></div>
                <div class="card">🧑‍💼 <h2><?php echo $totalSuper; ?></h2><p>Supervisores</p></div>
                <div class="card">🎓 <h2><?php echo $totalAlumnos; ?></h2><p>Alumnos</p></div>
            </section>
            <section class="charts">
                <div class="chart">
                    <h3>Usuarios y Cursos</h3>
                    <canvas id="chartUsuarios"></canvas>
                </div>
                <div class="chart">
                    <h3>Distribución de Roles</h3>
                    <canvas id="chartRoles"></canvas>
                </div>
            </section>
        </section>

        
        <section id="gestion" class="section <?php echo ($seccion=='gestion')?'active':''; ?>">
            <div class="user-management">
                <h2>👥 Gestión de Usuarios</h2>
                <table>
                    <tr>
                        <th>ID</th><th>Nombre</th><th>Telefono</th><th>Email</th><th>Perfil</th><th>Estado</th><th>Acciones</th>
                    </tr>
                    <?php while($u = $usuarios->fetch_assoc()){ ?>
                    <tr>
                        <td><?php echo $u['id']; ?></td>
                        <td><?php echo $u['nombre']; ?></td>
                        <td><?php echo $u['Telefono']; ?></td>
                        <td><?php echo $u['email']; ?></td>
                        <td><?php echo ucfirst($u['perfil']); ?></td>
                        <td><?php echo ucfirst($u['estado']); ?></td>
                        <td>
                            <a href="editar_usuario.php?id=<?php echo $u['id']; ?>" class="btn btn-edit">✏ Editar</a>
                            <a href="eliminar_usuario.php?id=<?php echo $u['id']; ?>" class="btn btn-delete" onclick="return confirm('¿Eliminar este usuario?')">🗑 Eliminar</a>
                            <a href="toggle_estado.php?id=<?php echo $u['id']; ?>&seccion=gestion" class="btn btn-toggle">
                                <?php echo ($u['estado'] == "activo") ? "🔒 Inactivar" : "✅ Activar"; ?>
                            </a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </section>

        <section id="crear" class="section <?php echo ($seccion=='crear')?'active':''; ?>">
            <div class="form-crear">
                <h2>➕ Crear Nuevo Usuario</h2>
                <form id="formCrearUsuario">
                    <label>Nombre:</label>
                    <input type="text" name="nombre" required>
                    
                    <label>Email:</label>
                    <input type="email" name="email" required>
                    
                    <label>Contraseña:</label>
                    <input type="password" name="password" required>

                    <label>Teléfono:</label>
                    <input type="text" name="Telefono" required>

                    <label>Rol:</label>
                    <select name="perfil" required>
                        <option value="administrador">Administrador</option>
                        <option value="supervisor">Supervisor</option>
                        <option value="profesor">Profesor</option>
                        <option value="alumno">Alumno</option>
                    </select>

                    <button type="submit">Guardar Usuario</button>
                </form>
                <p class="msg" id="msg"></p>
            </div>
        </section>

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
    document.getElementById(sectionId).classList.add('active');
    history.replaceState(null, "", "?seccion=" + sectionId);
}


new Chart(document.getElementById('chartUsuarios'), {
    type: 'bar',
    data: {
        labels: ['Usuarios', 'Cursos'],
        datasets: [{
            label: 'Cantidad',
            data: [<?php echo $totalUsuarios; ?>, <?php echo $totalCursos; ?>],
            backgroundColor: ['#4CAF50', '#2196F3']
        }]
    }
});

new Chart(document.getElementById('chartRoles'), {
    type: 'doughnut',
    data: {
        labels: ['Profesores', 'Supervisores', 'Alumnos'],
        datasets: [{
            data: [<?php echo $totalProfes; ?>, <?php echo $totalSuper; ?>, <?php echo $totalAlumnos; ?>],
            backgroundColor: ['#FF9800', '#9C27B0', '#03A9F4']
        }]
    }
});


document.getElementById("formCrearUsuario").addEventListener("submit", async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const msg = document.getElementById("msg");

    try {
        const res = await fetch("crear_usuario.php", { method: "POST", body: formData });
        const data = await res.text();

        msg.textContent = data.includes("exito") ? "✅ Usuario creado correctamente" : "❌ Error al crear usuario";
        msg.style.color = data.includes("exito") ? "green" : "red";

        e.target.reset();
    } catch (error) {
        msg.textContent = "⚠️ Error al conectar con el servidor";
        msg.style.color = "red";
    }
});
</script>
</body>
</html>
