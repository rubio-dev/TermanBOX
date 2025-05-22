<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados del Test de Terman</title>
    <link rel="stylesheet" href="../../assets/css/test.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="test-container">
        <h2>¡Test finalizado!</h2>
        <p>
            Gracias por completar todas las series.<br>
        </p>
        <button class="submit-btn" onclick="window.location.href='../../index.php'">Volver al inicio</button>
    </div>
    <script>
    // Mostrar SweetAlert al llegar aquí
    Swal.fire({
        icon: 'info',
        title: '¡Test finalizado!',
        text: 'Aquí aparecerán tus resultados.',
        confirmButtonColor: '#37517e'
    });
    </script>
</body>
</html>
