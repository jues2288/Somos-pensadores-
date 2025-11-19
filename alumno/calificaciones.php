<?php
include "../verificar_sesion.php";
verificarRol("alumno");

if (!isset($_SESSION['email'])) {
    die("<h3 style='color:red;text-align:center;'>Error: No se ha encontrado el email del alumno en la sesión.</h3>");
}

include "../conexion.php";

$email = $_SESSION['email'];

// Buscar ID del alumno
$sql_id = "SELECT id FROM usuarios WHERE email = ?";
$stmt_id = $conn->prepare($sql_id);
$stmt_id->bind_param("s", $email);
$stmt_id->execute();
$result_id = $stmt_id->get_result();
$alumno = $result_id->fetch_assoc();

if (!$alumno) {
    die("<h3 style='color:red;text-align:center;'>Error: No se encontró el alumno en la base de datos.</h3>");
}

$alumno_id = $alumno['id'];

// Obtener calificaciones del alumno
$sql = "SELECT m.nombre AS materia, c.nota AS calificacion
        FROM calificaciones c
        INNER JOIN materias m ON c.materia_id = m.id
        WHERE c.alumno_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $alumno_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="contenido-principal">
    <h2 class="titulo-seccion">📊 Calificaciones</h2>

    <div class="tabla-container">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Calificación</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['materia']) ?></td>
                            <td><?= htmlspecialchars($row['calificacion']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="2" class="empty">No tienes calificaciones registradas aún.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<style>
    .contenido-principal {
        background: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        margin: 20px;
        text-align: center;
        width: calc(100% - 40px);
    }

    .titulo-seccion {
        font-family: "Poppins", sans-serif;
        color: #2c3e50;
        font-size: 24px;
        margin-bottom: 20px;
        font-weight: 600;
    }

    .tabla-container {
        overflow-x: auto;
    }

    .tabla {
        width: 100%;
        border-collapse: collapse;
        border-radius: 10px;
        overflow: hidden;
        font-family: "Poppins", sans-serif;
    }

    .tabla th {
        background-color: #3498db;
        color: white;
        padding: 15px;
        text-align: center;
        font-weight: bold;
    }

    .tabla td {
        padding: 14px;
        border-bottom: 1px solid #ddd;
        text-align: center;
        color: #333;
    }

    .tabla tr:nth-child(even) {
        background-color: #f5f8fc;
    }

    .tabla tr:hover {
        background-color: #eaf4ff;
        transition: background 0.3s;
    }

    .empty {
        text-align: center;
        padding: 20px;
        color: #888;
        font-style: italic;
    }
</style>
