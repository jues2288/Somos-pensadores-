<?php
include "../conexion.php";

$id = $_GET['id'] ?? null;
if (!$id) {
    die("Error: No se proporcionó un ID válido.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $email  = $_POST['email'];
    $perfil = $_POST['perfil'];

    $sql = "UPDATE usuarios SET nombre=?, email=?, perfil=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $nombre, $email, $perfil, $id);
    $stmt->execute();

    header("Location: panel.php?msg=editado");
    exit;
}

$usuario = $conn->query("SELECT * FROM usuarios WHERE id=$id")->fetch_assoc();
if (!$usuario) {
    die("Error: Usuario no encontrado.");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario - SomosPensadores</title>
    <link rel="stylesheet" href="../css/admin/editar_usuario.css">
</head>
<body>

<div class="form-container">
    <h2>✏️ Editar Usuario</h2>

    <form method="POST">
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>

        <label>Perfil:</label>
        <select name="perfil" required>
            <option value="administrador" <?php if($usuario['perfil']=="administrador") echo "selected"; ?>>Administrador</option>
            <option value="supervisor" <?php if($usuario['perfil']=="supervisor") echo "selected"; ?>>Supervisor</option>
            <option value="profesor" <?php if($usuario['perfil']=="profesor") echo "selected"; ?>>Profesor</option>
            <option value="alumno" <?php if($usuario['perfil']=="alumno") echo "selected"; ?>>Alumno</option>
            <option value="visitante" <?php if($usuario['perfil']=="visitante") echo "selected"; ?>>Visitante</option>
        </select>

        <button type="submit">Guardar cambios</button>
        <a href="panel.php" class="btn-volver">← Volver al Panel</a>
    </form>
</div>

</body>
</html>
