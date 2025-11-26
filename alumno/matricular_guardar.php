<?php
include "../conexion.php";
session_start();

// Verificar sesión
if (!isset($_SESSION['email'])) {
    die("Error: No se encontró el email del alumno en la sesión.");
}

$email = $_SESSION['email'];

// Obtener ID real del alumno y su semestre
$sql = "SELECT id, semestre FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$alumno = $result->fetch_assoc();

if (!$alumno) {
    die("Error: No se encontró el alumno en la base de datos.");
}

$alumno_id = $alumno['id'];
$semestre_actual = $alumno['semestre']; // 👈 aquí cambia el nombre

// Recibir la materia seleccionada
$materia_id = $_POST['materia_id'] ?? null;

if (!$materia_id) {
    die("Error: No se seleccionó ninguna materia.");
}

// Buscar semestre de la materia
$sql_materia = "SELECT semestre_id FROM materias WHERE id = ?";
$stmt_materia = $conn->prepare($sql_materia);
$stmt_materia->bind_param("i", $materia_id);
$stmt_materia->execute();
$materia = $stmt_materia->get_result()->fetch_assoc();

if (!$materia) {
    die("Error: La materia seleccionada no existe.");
}

$semestre_materia = $materia['semestre_id'];

// 🚫 RESTRICCIÓN: NO PERMITIR MATRICULAR SEMESTRES SUPERIORES
if ($semestre_materia > $semestre_actual) {
    echo "<script>
            alert('❌ No puedes matricular materias de semestres superiores.');
            window.location.href='panel.php';
          </script>";
    exit;
}

// Insertar inscripción
$sql_insert = "INSERT INTO inscripciones (alumno_id, materia_id, semestre_id, estado) 
               VALUES (?, ?, ?, 'cursando')";
$stmt_insert = $conn->prepare($sql_insert);
$stmt_insert->bind_param("iii", $alumno_id, $materia_id, $semestre_materia);

if ($stmt_insert->execute()) {
    echo "<script>
            alert('✅ Materia matriculada correctamente');
            window.location.href='panel.php';
         </script>";
} else {
    echo "Error al matricular: " . $stmt_insert->error;
}
?>
