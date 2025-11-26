<?php
include "../verificar_sesion.php";
verificarRol("profesor");
include "../conexion.php";

// Obtener todas las materias
$materias = $conn->query("SELECT * FROM materias");
?>

<section class="container">
    <h2>👨‍🏫 Alumnos Matriculados</h2>

    <form method="GET">
        <label>Selecciona una materia:</label>
        <select name="materia_id" required>
            <option value="">Seleccione...</option>
            <?php while ($m = $materias->fetch_assoc()): ?>
                <option value="<?= $m['id'] ?>"><?= $m['nombre'] ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Ver</button>
    </form>

    <?php if (isset($_GET['materia_id'])): ?>
        <h3 style="margin-top:20px;">Alumnos inscritos en la materia</h3>

        <?php
        $materia_id = $_GET['materia_id'];
        $sql = "SELECT u.nombre, u.email 
                FROM inscripciones i
                INNER JOIN usuarios u ON i.alumno_id = u.id
                WHERE i.materia_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $materia_id);
        $stmt->execute();
        $result = $stmt->get_result();
        ?>

        <table class="tabla">
            <tr><th>Nombre</th><th>Email</th></tr>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['nombre'] ?></td>
                    <td><?= $row['email'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>
</section>

<style>
.container { width:600px;margin:auto;background:#fff;padding:25px;border-radius:12px;margin-top:30px; }
select,input,button { padding:10px;border-radius:8px;margin-top:10px;border:1px solid #ccc; }
button { background:#2980b9;color:#fff;font-weight:bold;cursor:pointer; }
.tabla { width:100%;border-collapse:collapse;margin-top:20px; }
.tabla th { background:#3498db;color:white;padding:10px; }
.tabla td { padding:10px;border-bottom:1px solid #ddd; }
</style>
