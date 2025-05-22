<?php
session_start();
require_once __DIR__ . '/../../config/db.php'; // Clase de conexión

// Conexión PDO
$db = new Database();
$conn = $db->connect();

$archivos_series = [
    1 => 'serie1_informacion.json',
    2 => 'serie2_juicio.json',
    3 => 'serie3_vocabulario.json',
    4 => 'serie4_sintesis.json',
    5 => 'serie5_concentracion.json',
    6 => 'serie6_analisis.json',
    7 => 'serie7_abstraccion.json',
    8 => 'serie8_planeacion.json',
    9 => 'serie9_organizacion.json',
    10 => 'serie10_atencion.json'
];

// PASO 1: Registro usuario (si no hay sesión)
if (!isset($_SESSION['usuario_id'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
        $nombre = trim($_POST['nombre']);
        $edad = intval($_POST['edad']);
        $ciudad = trim($_POST['ciudad']);
        $departamento = trim($_POST['departamento']);

        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, edad, ciudad, departamento) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nombre, $edad, $ciudad, $departamento]);
        $usuario_id = $conn->lastInsertId();
        $_SESSION['usuario_id'] = $usuario_id;
        $_SESSION['nombre'] = $nombre;
        $_SESSION['edad'] = $edad;
        $_SESSION['ciudad'] = $ciudad;
        $_SESSION['departamento'] = $departamento;

        // Crear intento
        $stmt2 = $conn->prepare("INSERT INTO intentos (usuario_id) VALUES (?)");
        $stmt2->execute([$usuario_id]);
        $_SESSION['intento_id'] = $conn->lastInsertId();

        header("Location: test.php?serie=1");
        exit;
    }
    // Mostrar formulario de registro
    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Registro - Test de Terman</title>
        <link rel="stylesheet" href="../../assets/css/test.css">
    </head>
    <body>
    <div class="test-container">
        <h2>Registro antes de iniciar el test</h2>
        <form method="post" autocomplete="off" class="registro-form">
            <div class="input-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" required>
            </div>
            <div class="input-group">
                <label for="edad">Edad:</label>
                <input type="number" name="edad" id="edad" min="4" max="99" required>
            </div>
            <div class="input-group">
                <label for="ciudad">Ciudad:</label>
                <input type="text" name="ciudad" id="ciudad" required>
            </div>
            <div class="input-group">
                <label for="departamento">Departamento:</label>
                <input type="text" name="departamento" id="departamento" required>
            </div>
            <button type="submit" class="submit-btn">Comenzar test</button>
        </form>
    </div>
    </body>
    </html>
    <?php
    exit;
}

// PASO 2: Presentar serie actual y guardar respuestas
$serie = isset($_GET['serie']) ? intval($_GET['serie']) : 1;
$json_path = "../../data/" . (isset($archivos_series[$serie]) ? $archivos_series[$serie] : $archivos_series[1]);
$json = file_get_contents($json_path);
$data = json_decode($json, true);

$tiempo = isset($data['tiempo']) ? intval($data['tiempo']) : 120;
$nombre_serie = $data['nombre'];
$instruccion = $data['instruccion'];
$preguntas = $data['preguntas'];
$siguiente_serie = $serie + 1;
$hay_siguiente = isset($archivos_series[$siguiente_serie]);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['q1'])) {
    $usuario_id = $_SESSION['usuario_id'];
    $intento_id = $_SESSION['intento_id'];
    $aciertos_serie = 0;

    foreach ($preguntas as $i => $pregunta) {
        $num_preg = $i + 1;
        $resp_usuario = isset($_POST['q'.$num_preg]) ? $_POST['q'.$num_preg] : '';
        $resp_correcta = $pregunta['respuesta_correcta'];
        $es_correcta = ($resp_usuario === $resp_correcta) ? 1 : 0;
        if ($es_correcta) $aciertos_serie++;

        $stmt = $conn->prepare("INSERT INTO respuestas (intento_id, serie, pregunta, respuesta_usuario, respuesta_correcta, es_correcta)
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$intento_id, $serie, $num_preg, $resp_usuario, $resp_correcta, $es_correcta]);
    }

    // Si es la última serie, calcula el puntaje total y redirige a resultados
    if (!$hay_siguiente) {
        $sql = "SELECT SUM(es_correcta) as total FROM respuestas WHERE intento_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$intento_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $puntaje_total = $row ? intval($row['total']) : 0;

        $conn->prepare("UPDATE intentos SET puntaje_total = ? WHERE id = ?")
            ->execute([$puntaje_total, $intento_id]);
        header("Location: results.php");
        exit;
    } else {
        header("Location: test.php?serie=$siguiente_serie");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Test de Terman - <?= htmlspecialchars($nombre_serie) ?></title>
    <link rel="stylesheet" href="../../assets/css/test.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="test-container">
        <div class="timer" id="timer"><?= gmdate("i:s", $tiempo) ?></div>
        <h2><?= htmlspecialchars($nombre_serie) ?></h2>
        <p class="instruccion"><?= htmlspecialchars($instruccion) ?></p>
        <form id="test-form" method="post" autocomplete="off">
            <?php foreach ($preguntas as $i => $p): ?>
                <div class="question">
                    <p><?= ($i+1) . ". " . htmlspecialchars($p['texto']) ?></p>
                    <?php foreach ($p['opciones'] as $j => $opcion): ?>
                        <label>
                            <input type="radio" name="q<?= $i+1 ?>" value="<?= chr(97+$j) ?>"> <?= htmlspecialchars($opcion) ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            <button type="submit" class="submit-btn">Enviar respuestas</button>
        </form>
    </div>
    <script>
    let duration = <?= $tiempo ?>;
    let display = document.getElementById('timer');
    let form = document.getElementById('test-form');
    let enviado = false;

    function allAnswered() {
        let totalQuestions = form.querySelectorAll('.question').length;
        let answered = form.querySelectorAll('input[type="radio"]:checked').length;
        return answered === totalQuestions;
    }

    function finishTest() {
        if (!enviado) {
            enviado = true;
            Swal.fire({
                icon: 'success',
                title: '¡Serie finalizada!',
                text: 'Tus respuestas han sido enviadas.',
                confirmButtonColor: '#37517e'
            }).then(() => {
                form.submit();
            });
        }
    }

    function startTimer() {
        let timer = duration, minutes, seconds;
        let interval = setInterval(function () {
            minutes = parseInt(timer / 60, 10);
            seconds = parseInt(timer % 60, 10);
            minutes = minutes < 10 ? "0" + minutes : minutes;
            seconds = seconds < 10 ? "0" + seconds : seconds;
            display.textContent = minutes + ":" + seconds;
            if (--timer < 0) {
                clearInterval(interval);
                display.textContent = "¡Tiempo!";
                if (allAnswered()) {
                    finishTest();
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: '¡Tiempo agotado!',
                        text: 'No respondiste todas las preguntas.',
                        confirmButtonColor: '#37517e'
                    }).then(() => {
                        form.submit();
                    });
                }
            }
        }, 1000);
    }

    window.onload = function () {
        if (display) startTimer();

        form.addEventListener('submit', function(e){
            e.preventDefault();
            if (allAnswered()) {
                finishTest();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: '¡Faltan respuestas!',
                    text: 'Por favor, responde todas las preguntas antes de continuar.',
                    confirmButtonColor: '#37517e'
                });
                enviado = false;
            }
        });
    };
    </script>
</body>
</html>
