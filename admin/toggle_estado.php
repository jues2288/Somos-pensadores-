<?php
include "../conexion.php";
$id = $_GET['id'];

$estado = $conn->query("SELECT estado FROM usuarios WHERE id=$id")->fetch_assoc()['estado'];
$nuevoEstado = ($estado == "activo") ? "inactivo" : "activo";

$conn->query("UPDATE usuarios SET estado='$nuevoEstado' WHERE id=$id");

header("Location: panel.php?seccion=gestion&msg=estado_actualizado");
exit;
