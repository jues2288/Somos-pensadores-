<?php
include "../verificar_sesion.php";
verificarRol("alumno");

if (!isset($_SESSION['email'])) {
    die("Error: No se ha encontrado el email del alumno en la sesión.");
}

include "../conexion.php";

$email = $_SESSION['email'];

$sql = "SELECT m.nombre AS materia, m.semestre_id AS semestre, n.calificacion
        FROM materias m
        INNER JOIN notas n ON m.id = n.id_materia
        INNER JOIN usuarios u ON n.id_usuario = u.id
        WHERE u.email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<section class="materias-section">
    <h2 class="titulo-seccion">📚 Materias inscritas este semestre</h2>

    <div class="tabla-container">
        <table class="tabla-materias">
            <thead>
                <tr>
                    <th>Materia</th>
                    <th>Semestre</th>
                    <th>Calificación</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($resultado->num_rows > 0): ?>
                    <?php while($row = $resultado->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['materia']); ?></td>
                            <td><?php echo htmlspecialchars($row['semestre']); ?></td>
                            <td class="<?php echo ($row['calificacion'] < 3) ? 'mala' : 'buena'; ?>">
                                <?php echo htmlspecialchars($row['calificacion']); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3" class="sin-materias">No tienes materias inscritas actualmente.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<style>
.materias-section {
    background: #ffffff;
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    animation: fadeIn 0.5s ease-in-out;
}

.titulo-seccion {
    font-size: 1.6rem;
    color: #2e7d32;
    margin-bottom: 20px;
    text-align: center;
    font-weight: 600;
}

.tabla-container {
    overflow-x: auto;
    border-radius: 12px;
}

.tabla-materias {
    width: 100%;
    border-collapse: collapse;
    font-size: 1rem;
    background: #f9fafb;
    border-radius: 12px;
    overflow: hidden;
}

.tabla-materias thead {
    background: #4CAF50;
    color: white;
}

.tabla-materias th, 
.tabla-materias td {
    padding: 14px 16px;
    text-align: center;
}

.tabla-materias tr {
    border-bottom: 1px solid #e0e0e0;
    transition: background 0.2s;
}

.tabla-materias tr:hover {
    background: #e8f5e9;
}

.tabla-materias td.buena {
    color: #2e7d32;
    font-weight: 600;
}

.tabla-materias td.mala {
    color: #d32f2f;
    font-weight: 600;
}

.sin-materias {
    text-align: center;
    color: #666;
    font-style: italic;
    padding: 20px;
}

/* Animación */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
