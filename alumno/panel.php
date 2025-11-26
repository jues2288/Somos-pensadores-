<?php
include "../verificar_sesion.php";
verificarRol("alumno");
include "../conexion.php";

$email = $_SESSION['email'];

// Obtener datos del alumno
$stmt = $conn->prepare("SELECT id, nombre FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$alumno = $stmt->get_result()->fetch_assoc();

$alumno_id = $alumno['id'];

// Contar materias inscritas
$total_materias = $conn->query("SELECT COUNT(*) AS total FROM inscripciones WHERE alumno_id = $alumno_id")->fetch_assoc()['total'];

// Calcular promedio
$promedio = $conn->query("SELECT AVG(nota) AS promedio FROM calificaciones WHERE alumno_id = $alumno_id")->fetch_assoc()['promedio'];

// Materias reprobadas
$reprobadas = $conn->query("SELECT COUNT(*) AS total FROM calificaciones WHERE alumno_id = $alumno_id AND nota < 3")->fetch_assoc()['total'];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Alumno</title>
    <link rel="stylesheet" href="../css/panel/dashboard.css">
    <style>
        /* estilos principales que ya usabas */
        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            background-color: #f4f6f9;
            color: #333;
        }

        .dashboard {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 240px;
            background-color: #2c3e50;
            color: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 30px;
        }

        .sidebar h2 {
            color: #1abc9c;
            margin-bottom: 30px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            width: 100%;
        }

        .sidebar ul li {
            width: 100%;
        }

        .sidebar ul li button,
        .sidebar ul li a {
            width: 100%;
            background: none;
            border: none;
            color: #ecf0f1;
            padding: 15px;
            text-align: left;
            cursor: pointer;
            font-size: 15px;
            transition: 0.3s;
        }

        .sidebar ul li button:hover,
        .sidebar ul li a:hover {
            background-color: #1abc9c;
        }

        .main-content {
            flex: 1;
            padding: 40px;
            overflow-y: auto;
        }

        .welcome {
            background: #3498db;
            color: white;
            padding: 25px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            flex: 1;
            min-width: 220px;
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .card h3 {
            margin-bottom: 10px;
            color: #2c3e50;
        }

        .card p {
            font-size: 24px;
            font-weight: bold;
            color: #3498db;
        }

        #contenido {
            animation: fadeIn 0.4s;
        }

        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
        }
    </style>
</head>
<body>

<div class="dashboard">
    <aside class="sidebar">
        <h2>Alumno</h2>
        <ul>
            <li><button onclick="cargarContenido('inicio')">🏠 Inicio</button></li>
            <li><button onclick="cargarContenido('materias')">📚 Materias</button></li>
            <li><button onclick="cargarContenido('matricular')">📝 Matricular</button></li>
            <li><button onclick="cargarContenido('calificaciones')">📊 Calificaciones</button></li>
            <li><a href="../auth/logout.php">🚪 Cerrar sesión</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <div id="contenido">
            <!-- Contenido inicial (Inicio) -->
            <div class="welcome">
                <h1>👋 ¡Bienvenido, <?php echo htmlspecialchars($alumno['nombre']); ?>!</h1>
                <p>Este es tu panel principal, donde puedes ver tu información académica actualizada.</p>
            </div>

            <div class="cards">
                <div class="card">
                    <h3>📚 Materias Inscritas</h3>
                    <p><?php echo $total_materias ?: 0; ?></p>
                </div>
                <div class="card">
                    <h3>⭐ Promedio General</h3>
                    <p><?php echo $promedio ? number_format($promedio, 2) : 'N/A'; ?></p>
                </div>
                <div class="card">
                    <h3>⚠️ Materias Reprobadas</h3>
                    <p style="color:red;"><?php echo $reprobadas ?: 0; ?></p>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
function cargarContenido(pagina) {
    let contenedor = document.getElementById("contenido");
    contenedor.innerHTML = "<p>Cargando...</p>";

    if (pagina === "inicio") {
        // Recargar el contenido inicial directamente sin fetch
        contenedor.innerHTML = `
            <div class='welcome'>
                <h1>👋 ¡Bienvenido, <?php echo htmlspecialchars($alumno['nombre']); ?>!</h1>
                <p>Este es tu panel principal, donde puedes ver tu información académica actualizada.</p>
            </div>
            <div class='cards'>
                <div class='card'>
                    <h3>📚 Materias Inscritas</h3>
                    <p><?php echo $total_materias ?: 0; ?></p>
                </div>
                <div class='card'>
                    <h3>⭐ Promedio General</h3>
                    <p><?php echo $promedio ? number_format($promedio, 2) : 'N/A'; ?></p>
                </div>
                <div class='card'>
                    <h3>⚠️ Materias Reprobadas</h3>
                    <p style='color:red;'><?php echo $reprobadas ?: 0; ?></p>
                </div>
            </div>
        `;
        return;
    }

    fetch(pagina + ".php")
        .then(res => {
            if (!res.ok) throw new Error("Error al cargar " + pagina);
            return res.text();
        })
        .then(html => {
            contenedor.innerHTML = html;
        })
        .catch(err => {
            contenedor.innerHTML = "<p style='color:red;'>❌ " + err.message + "</p>";
        });
}
</script>

</body>
</html>
