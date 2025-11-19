<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Universidad SomosPensadores - Bienvenido</title>
    <style>
        body {
            font-family: "Segoe UI", Roboto, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f7fa;
            color: #333;
        }

        /* ====== HEADER ====== */
        header {
            background-color: #002855;
            color: white;
            padding: 15px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        header h1 {
            font-size: 1.6em;
            margin: 0;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .cerrar-sesion {
            background-color: #d63031;
            color: white;
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: 500;
            transition: background 0.3s ease;
        }

        .cerrar-sesion:hover {
            background-color: #b82526;
        }

        /* ====== HERO SECTION ====== */
        .hero {
            background: url('https://images.unsplash.com/photo-1523580846011-d3a5bc25702b?auto=format&fit=crop&w=1400&q=80') center/cover no-repeat;
            color: white;
            text-align: center;
            padding: 100px 30px;
            position: relative;
        }

        .hero::after {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 40, 85, 0.7);
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
            margin: 0 auto;
        }

        .hero h2 {
            font-size: 2.5em;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .hero p {
            font-size: 1.2em;
            line-height: 1.6;
        }

        /* ====== MAIN CONTENT ====== */
        main {
            max-width: 1100px;
            margin: 50px auto;
            padding: 0 30px;
        }

        section {
            background: white;
            margin-bottom: 40px;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        section h3 {
            color: #002855;
            font-size: 1.5em;
            margin-bottom: 15px;
            border-bottom: 3px solid #007bff;
            display: inline-block;
            padding-bottom: 5px;
        }

        section p {
            line-height: 1.7;
            color: #555;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background-color: #f8f9fb;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #e0e0e0;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h4 {
            color: #007bff;
            margin-bottom: 10px;
        }

        footer {
            background-color: #002855;
            color: white;
            text-align: center;
            padding: 30px;
            margin-top: 60px;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

    <header>
        <h1>🎓 Universidad SomosPensadores</h1>
        <a href="../auth/login.php" class="cerrar-sesion">Cerrar sesión</a>
    </header>

    <section class="hero">
        <div class="hero-content">
            <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?> 👋</h2>
            <p>Explora la excelencia académica, la innovación y el compromiso social de una institución que forma líderes con pensamiento crítico.</p>
        </div>
    </section>

    <main>

        <section>
            <h3>Sobre Nosotros</h3>
            <p>
                La <strong>Universidad SomosPensadores</strong> es una institución líder en educación superior dedicada a inspirar el aprendizaje,
                la investigación y la transformación social. Nuestra misión es desarrollar profesionales íntegros, creativos y comprometidos con el progreso de la sociedad.
            </p>
            <p>
                Fundada en 1998, SomosPensadores ha consolidado su prestigio nacional e internacional gracias a sus programas académicos acreditados,
                su infraestructura moderna y su comunidad universitaria diversa y activa.
            </p>
        </section>

        <section>
            <h3>Facultades y Programas</h3>
            <div class="grid">
                <div class="card">
                    <h4>📘 Facultad de Humanidades</h4>
                    <p>Programas de Psicología, Filosofía, Comunicación Social y Educación. Fomentamos el pensamiento crítico y la comprensión humana.</p>
                </div>
                <div class="card">
                    <h4>💻 Facultad de Ingeniería</h4>
                    <p>Ingeniería en Sistemas, Electrónica, Industrial y Ambiental. Innovación, tecnología y sostenibilidad en acción.</p>
                </div>
                <div class="card">
                    <h4>💼 Facultad de Ciencias Económicas</h4>
                    <p>Economía, Administración de Empresas, Contaduría y Finanzas. Preparando líderes empresariales del futuro.</p>
                </div>
                <div class="card">
                    <h4>🌿 Facultad de Ciencias Naturales</h4>
                    <p>Biología, Química, Física y Matemáticas. Investigación científica para un mundo mejor.</p>
                </div>
            </div>
        </section>

        <section>
            <h3>Infraestructura y Servicios</h3>
            <p>
                Contamos con modernos laboratorios, bibliotecas digitales, zonas verdes, áreas deportivas, cafeterías y residencias universitarias.
                Nuestros estudiantes disfrutan de una experiencia educativa completa, cómoda y segura.
            </p>
            <div class="grid">
                <div class="card"><h4>📚 Biblioteca Central</h4><p>Más de 150,000 títulos físicos y digitales disponibles las 24 horas.</p></div>
                <div class="card"><h4>🏋️ Gimnasio Universitario</h4><p>Equipado para promover la salud y el bienestar estudiantil.</p></div>
                <div class="card"><h4>🌎 Intercambios Internacionales</h4><p>Convenios con más de 40 universidades alrededor del mundo.</p></div>
                <div class="card"><h4>🎨 Vida Cultural</h4><p>Eventos, exposiciones y talleres artísticos abiertos a toda la comunidad.</p></div>
            </div>
        </section>

        <section>
            <h3>Contacto e Información</h3>
            <p>
                📍 Dirección: Carrera 45 # 10-50, Bogotá, Colombia <br>
                ☎️ Teléfono: (601) 555-1234 <br>
                📧 Correo institucional: contacto@somospensadores.edu.co <br>
                🌐 Sitio web: <a href="#" style="color:#007bff; text-decoration:none;">www.somospensadores.edu.co</a>
            </p>
        </section>

    </main>

    <footer>
        © 2025 Universidad SomosPensadores — Todos los derechos reservados.  
        <br>Inspirando mentes, transformando el futuro.
    </footer>

</body>
</html>
