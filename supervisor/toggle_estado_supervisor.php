<?php
include "../conexion.php";

$id = $_GET['id'];
$res = $conn->query("SELECT estado FROM usuarios WHERE id=$id");
if ($res->num_rows > 0) {
    $estado = $res->fetch_assoc()['estado'];
    $nuevoEstado = ($estado == "activo") ? "inactivo" : "activo";
    $conn->query("UPDATE usuarios SET estado='$nuevoEstado' WHERE id=$id");
    echo "exito";
} else {
    echo "error";
}
?>
