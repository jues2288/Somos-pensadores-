<?php
include "../conexion.php";
$id = $_GET['id'];

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
?>
<h2>Editar Usuario</h2>
<form method="POST">
    <input type="text" name="nombre" value="<?php echo $usuario['nombre']; ?>" required>
    <input type="email" name="email" value="<?php echo $usuario['email']; ?>" required>
    <select name="perfil">
        <option value="administrador" <?php if($usuario['perfil']=="administrador") echo "selected"; ?>>Administrador</option>
        <option value="supervisor" <?php if($usuario['perfil']=="supervisor") echo "selected"; ?>>Supervisor</option>
        <option value="profesor" <?php if($usuario['perfil']=="profesor") echo "selected"; ?>>Profesor</option>
        <option value="alumno" <?php if($usuario['perfil']=="alumno") echo "selected"; ?>>Alumno</option>
    </select>
    <button type="submit">Guardar cambios</button>
</form>
