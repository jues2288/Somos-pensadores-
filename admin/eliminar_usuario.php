<?php
include "../conexion.php";
$id = $_GET['id'];

$conn->query("DELETE FROM usuarios WHERE id=$id");

header("Location: panel.php?msg=eliminado");
exit;
