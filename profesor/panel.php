<?php
include "../verificar_sesion.php";
verificarRol("profesor");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel del Profesor</title>

<style>
    body {
        margin: 0;
        font-family: "Poppins", sans-serif;
        background-color: #f4f6f9;
        color: #333;
    }

    .main-container {
        padding: 40px;
        max-width: 1000px;
        margin: auto;
    }

    .welcome-box {
        background: #3498db;
        padding: 25px;
        color: white;
        border-radius: 14px;
        margin-bottom: 30px;
        text-align: center;
    }

    .welcome-box h1 {
        font-size: 1.8rem;
        margin: 0;
        font-weight: 600;
    }

    .cards {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 30px;
    }

    .card {
        background: white;
        width: 280px;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        text-align: center;
        transition: .3s;
    }

    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }

    .card h3 {
        font-size: 1.3rem;
        margin-bottom: 15px;
        color: #2c3e50;
    }

    .btn {
        display: inline-block;
        padding: 12px 20px;
        background: #3498db;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-size: 16px;
        font-weight: bold;
        transition: 0.3s;
    }

    .btn:hover {
        background: #2980b9;
    }

    /* Botón cerrar sesión */
    .logout-btn {
        display: block;
        width: 200px;
        margin: 40px auto 0 auto;
        padding: 12px 20px;
        background: #e74c3c;
        color: white;
        text-align: center;
        border-radius: 8px;
        font-size: 16px;
        font-weight: bold;
        text-decoration: none;
        transition: 0.3s;
    }

    .logout-btn:hover {
        background: #c0392b;
    }
</style>
</head>

<body>

<div class="main-container">

    <div class="welcome-box">
        <h1>👨‍🏫 Panel del Profesor</h1>
        <p>Gestiona tus materias, alumnos y calificaciones desde un solo lugar.</p>
    </div>

    <div class="cards">
        <div class="card">
            <h3>➕ Crear Materia</h3>
            <a href="crear_materia.php" class="btn">Ir</a>
        </div>

        <div class="card">
            <h3>👨‍🏫 Alumnos Matriculados</h3>
            <a href="alumnos_matriculados.php" class="btn">Ver</a>
        </div>

        <div class="card">
            <h3>📝 Poner Calificaciones</h3>
            <a href="poner_calificacion.php" class="btn">Calificar</a>
        </div>
    </div>

    <!-- 🔴 Botón Cerrar Sesión agregado -->
    <a href="../auth/logout.php" class="logout-btn">⛔ Cerrar sesión</a>

</div>

</body>
</html>
