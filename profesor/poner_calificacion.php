<?php
include "../verificar_sesion.php";
verificarRol("profesor");
include "../conexion.php";

$materias = $conn->query("SELECT * FROM materias");

// Si envían la nota
if (isset($_POST['guardar_nota'])) {
    $alumno_id = $_POST['alumno_id'];
    $materia_id = $_POST['materia_id'];
    $nota = $_POST['nota'];

    // Verificar si ya existe una calificación
    $sql_ver = "SELECT * FROM calificaciones WHERE alumno_id = ? AND materia_id = ?";
    $stmt_ver = $conn->prepare($sql_ver);
    $stmt_ver->bind_param("ii", $alumno_id, $materia_id);
    $stmt_ver->execute();
    $existe = $stmt_ver->get_result()->fetch_assoc();

    if ($existe) {
        // Actualizar
        $sql_up = "UPDATE calificaciones SET nota=? WHERE alumno_id=? AND materia_id=?";
        $stmt_up = $conn->prepare($sql_up);
        $stmt_up->bind_param("dii", $nota, $alumno_id, $materia_id);
        $stmt_up->execute();

        echo "<script>alert('✅ Nota actualizada correctamente'); window.location='panel_profesor.php';</script>";
    } else {
        // Insertar
        $sql = "INSERT INTO calificaciones (alumno_id, materia_id, nota) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iid", $alumno_id, $materia_id, $nota);
        $stmt->execute();

        echo "<script>alert('✅ Nota registrada correctamente'); window.location='panel_profesor.php';</script>";
    }
}
?>

<section class="container">
    <h2>📝 Registrar Calificación</h2>

    <form method="POST">
        <label>Materia:</label>
        <select name="materia_id" required>
            <option value="">Seleccione...</option>
            <?php while ($m = $materias->fetch_assoc()): ?>
                <option value="<?= $m['id'] ?>" 
                    <?= ($_POST['materia_id'] ?? '') == $m['id'] ? 'selected' : '' ?>>
                    <?= $m['nombre'] ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit" name="buscar_alumnos" style="background:#2980b9;">Buscar alumnos</button>
    </form>

    <?php if (isset($_POST['buscar_alumnos']) && !empty($_POST['materia_id'])): ?>
        <?php
        $materia_id = $_POST['materia_id'];

        $alumnos = $conn->query("
            SELECT u.id, u.nombre 
            FROM inscripciones i
            INNER JOIN usuarios u ON u.id = i.alumno_id
            WHERE i.materia_id = $materia_id
        ");
        ?>
        <form method="POST" style="margin-top:20px;">
            <input type="hidden" name="materia_id" value="<?= $materia_id ?>">

            <label>Alumno:</label>
            <select name="alumno_id" required>
                <?php while ($a = $alumnos->fetch_assoc()): ?>
                    <option value="<?= $a['id'] ?>"><?= $a['nombre'] ?></option>
                <?php endwhile; ?>
            </select>

            <label>Calificación:</label>
            <input type="number" name="nota" min="0" max="5" step="0.1" required>

            <button type="submit" name="guardar_nota">Guardar Calificación</button>
        </form>
    <?php endif; ?>
</section>

<style>
.container { width:500px;margin:auto;background:#fff;padding:25px;border-radius:12px;margin-top:30px; }
select,input,button { width:100%;padding:10px;border-radius:8px;margin-top:10px;border:1px solid #ccc; }
button { color:#fff;font-weight:bold;cursor:pointer;margin-top:20px; }
</style>
