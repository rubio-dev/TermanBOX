<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>TermanBox - Test de Terman</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Enlace al CSS específico de index -->
    <link rel="stylesheet" href="assets/css/index.css">
</head>
<body>
    <div class="container">
        <h1>TermanBox</h1>
        <p>Bienvenido. ¿Qué deseas hacer?</p>
        <form action="modules/test/index.php" method="get">
            <button type="submit">Cuestionario</button>
        </form>
        <form action="modulos/resultados.php" method="get">
            <button type="submit">Resultados</button>
        </form>
        <form action="acerca.php" method="get">
            <button type="submit">Acerca de</button>
        </form>
    </div>
</body>
</html>
