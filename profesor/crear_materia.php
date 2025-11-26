<?php
include "../verificar_sesion.php";
verificarRol("profesor");
include "../conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $semestre_id = $_POST['semestre_id'];

    $sql = "INSERT INTO materias (nombre, semestre_id) VALUES (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $nombre, $semestre_id);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Materia creada correctamente'); window.location='panel_profesor.php';</script>";
    } else {
        echo "<script>alert('❌ Error al crear materia');</script>";
    }
}
?>

<section class="container">
    <h2>➕ Crear Nueva Materia</h2>

    <form method="POST">
        <label>Nombre de la materia:</label>
        <input type="text" name="nombre" required>

        <label>Semestre:</label>
        <select name="semestre_id" required>
            <option value="">Seleccione...</option>
            <option value="1">Semestre 1</option>
            <option value="2">Semestre 2</option>
            <option value="3">Semestre 3</option>
            <option value="4">Semestre 4</option>
        </select>

        <button type="submit">Crear Materia</button>
    </form>
</section>

<style>
.container { width:400px;margin:auto;background:#fff;padding:25px;border-radius:12px;margin-top:30px; }
label { font-weight:bold;display:block;margin-top:10px; }
input,select { width:100%;padding:10px;border:1px solid #ccc;border-radius:8px;margin-top:5px; }
button { margin-top:15px;padding:12px;background:#27ae60;border:none;color:#fff;border-radius:8px;width:100%;font-weight:bold; }
button:hover{ background:#1e8449; }
</style>
