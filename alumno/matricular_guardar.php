<?php
include "../conexion.php";
session_start();

$alumno_id = $_SESSION['id'];
$materia_id = $_POST['materia_id'];

// Buscar semestre de la materia
$materia = $conn->query("SELECT semestre_id FROM materias WHERE id=$materia_id")->fetch_assoc();
$semestre_id = $materia['semestre_id'];

$conn->query("INSERT INTO inscripciones (alumno_id, materia_id, semestre_id, estado) VALUES ($alumno_id, $materia_id, $semestre_id, 'cursando')");
echo "<script>alert('✅ Materia matriculada correctamente'); window.location.href='panel.php';</script>";
