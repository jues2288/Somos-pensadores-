<?php
include "conexion.php";

// Obtener materias inscritas de un alumno
function obtenerMaterias($email) {
    global $conn;

    $sql = "SELECT m.nombre AS materia, m.semestre, n.calificacion
            FROM materias m
            INNER JOIN notas n ON m.id = n.id_materia
            INNER JOIN usuarios u ON n.id_usuario = u.id
            WHERE u.email = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result();
}
?>
