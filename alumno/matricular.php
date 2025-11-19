<?php
include "../verificar_sesion.php";
verificarRol("alumno");

if (!isset($_SESSION['email'])) {
    die("<h3>Error: No se ha encontrado el email del alumno en la sesión.</h3>");
}

include "../conexion.php";

$email = $_SESSION['email'];

// Obtener el ID del alumno
$sql_id = "SELECT id FROM usuarios WHERE email = ?";
$stmt_id = $conn->prepare($sql_id);
$stmt_id->bind_param("s", $email);
$stmt_id->execute();
$result_id = $stmt_id->get_result();
$alumno = $result_id->fetch_assoc();

if (!$alumno) {
    die("<h3>Error: No se encontró el alumno en la base de datos.</h3>");
}

$alumno_id = $alumno['id'];

// Verificar si tiene materias pendientes
$sql_pendiente = "SELECT COUNT(*) AS total FROM inscripciones WHERE alumno_id = ? AND estado = 'reprobado'";
$stmt_pendiente = $conn->prepare($sql_pendiente);
$stmt_pendiente->bind_param("i", $alumno_id);
$stmt_pendiente->execute();
$result_pendiente = $stmt_pendiente->get_result();
$pendiente = $result_pendiente->fetch_assoc()['total'];

if ($pendiente > 0) {
    echo "<section class='container'>
            <h3 style='color: red; text-align:center;'>⚠️ No puedes matricular materias nuevas hasta aprobar todas las pendientes.</h3>
          </section>";
    exit;
}

// Obtener lista de materias
$materias = $conn->query("SELECT * FROM materias");
?>

<section class="container">
    <h2>📝 Matricular Materias</h2>
    <form action="matricular_guardar.php" method="POST" style="margin-top: 15px;">
        <label style="font-weight:bold;">Selecciona una materia:</label><br>
        <select name="materia_id" required style="padding:10px; border-radius:8px; width:250px; border:1px solid #ccc;">
            <option value="">-- Selecciona una materia --</option>
            <?php while ($m = $materias->fetch_assoc()): ?>
                <option value="<?= htmlspecialchars($m['id']) ?>">
                    <?= htmlspecialchars($m['nombre']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>
        <button type="submit" style="
            padding:10px 20px;
            border:none;
            border-radius:8px;
            background:#1abc9c;
            color:white;
            font-weight:bold;
            cursor:pointer;
            transition:0.3s;
        ">Matricular</button>
    </form>
</section>
