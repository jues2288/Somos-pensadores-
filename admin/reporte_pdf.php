<?php
require "../conexion.php";
require "../libs/fpdf/fpdf.php";

date_default_timezone_set("America/Bogota");

// =============================
// CONSULTAS
// =============================
$usuarios = $conn->query("SELECT * FROM usuarios ORDER BY id ASC");
$materias = $conn->query("SELECT * FROM materias ORDER BY id ASC");

$totalUsuarios = $conn->query("SELECT COUNT(*) AS total FROM usuarios")->fetch_assoc()['total'];
$totalProfes   = $conn->query("SELECT COUNT(*) AS total FROM usuarios WHERE perfil='profesor'")->fetch_assoc()['total'];
$totalSuper    = $conn->query("SELECT COUNT(*) AS total FROM usuarios WHERE perfil='supervisor'")->fetch_assoc()['total'];
$totalAlumnos  = $conn->query("SELECT COUNT(*) AS total FROM usuarios WHERE perfil='alumno'")->fetch_assoc()['total'];
$totalMaterias = $conn->query("SELECT COUNT(*) AS total FROM materias")->fetch_assoc()['total'];

// =============================
// PDF
// =============================
$pdf = new FPDF("P", "mm", "A4");
$pdf->AddPage();

// SIEMPRE USAR ARIAL
$pdf->SetFont("Arial", "B", 16);
$pdf->Cell(0, 10, utf8_decode("REPORTE GENERAL DEL SISTEMA"), 0, 1, "C");
$pdf->Ln(5);

$pdf->SetFont("Arial", "", 12);
$pdf->Cell(0, 8, "Fecha del reporte: " . date("d/m/Y H:i A"), 0, 1);
$pdf->Ln(5);

// =============================
// RESUMEN GENERAL
// =============================
$pdf->SetFont("Arial", "B", 14);
$pdf->Cell(0, 8, "RESUMEN GENERAL", 0, 1);

$pdf->SetFont("Arial", "", 12);
$pdf->Cell(0, 8, "Total Usuarios: $totalUsuarios", 0, 1);
$pdf->Cell(0, 8, "Profesores: $totalProfes", 0, 1);
$pdf->Cell(0, 8, "Supervisores: $totalSuper", 0, 1);
$pdf->Cell(0, 8, "Alumnos: $totalAlumnos", 0, 1);
$pdf->Cell(0, 8, "Total Materias: $totalMaterias", 0, 1);

$pdf->Ln(10);

// =============================
// TABLA DE USUARIOS
// =============================
$pdf->SetFont("Arial", "B", 14);
$pdf->Cell(0, 8, "LISTA COMPLETA DE USUARIOS", 0, 1);
$pdf->SetFont("Arial", "B", 10);

// Encabezado
$pdf->Cell(10, 8, "ID", 1);
$pdf->Cell(40, 8, "Nombre", 1);
$pdf->Cell(40, 8, "Email", 1);
$pdf->Cell(25, 8, "Telefono", 1);
$pdf->Cell(30, 8, "Perfil", 1);
$pdf->Cell(25, 8, "Estado", 1);
$pdf->Ln();

// Datos
$pdf->SetFont("Arial", "", 10);

while ($u = $usuarios->fetch_assoc()) {
    $pdf->Cell(10, 8, $u['id'], 1);
    $pdf->Cell(40, 8, utf8_decode($u['nombre']), 1);
    $pdf->Cell(40, 8, $u['email'], 1);
    $pdf->Cell(25, 8, $u['Telefono'], 1);
    $pdf->Cell(30, 8, utf8_decode(ucfirst($u['perfil'])), 1);
    $pdf->Cell(25, 8, utf8_decode(ucfirst($u['estado'])), 1);
    $pdf->Ln();
}

$pdf->Ln(10);

// =============================
// TABLA DE MATERIAS
// =============================
$pdf->SetFont("Arial", "B", 14);
$pdf->Cell(0, 8, "LISTA DE MATERIAS", 0, 1);

$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(20, 8, "ID", 1);
$pdf->Cell(90, 8, "Materia", 1);
$pdf->Cell(40, 8, "Semestre", 1);
$pdf->Ln();

$pdf->SetFont("Arial", "", 10);

while ($m = $materias->fetch_assoc()) {
    $pdf->Cell(20, 8, $m['id'], 1);
    $pdf->Cell(90, 8, utf8_decode($m['nombre']), 1);
    $pdf->Cell(40, 8, $m['semestre_id'], 1);
    $pdf->Ln();
}

// Salida
$pdf->Output();
?>
