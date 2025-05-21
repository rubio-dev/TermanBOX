<?php
// test.php
$serie = isset($_GET['serie']) ? intval($_GET['serie']) : 1;

$archivos_series = [
    1 => 'serie1_informacion.json',
    2 => 'serie2_juicio.json',
    // Agrega aquí las demás series cuando las tengas
];
$json_path = "../../data/" . (isset($archivos_series[$serie]) ? $archivos_series[$serie] : $archivos_series[1]);
$json = file_get_contents($json_path);
$data = json_decode($json, true);

$tiempo = isset($data['tiempo']) ? intval($data['tiempo']) : 120;
$nombre_serie = $data['nombre'];
$instruccion = $data['instruccion'];
$preguntas = $data['preguntas'];

// Siguiente serie
$siguiente_serie = $serie + 1;
$hay_siguiente = isset($archivos_series[$siguiente_serie]);
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
        <form id="test-form" autocomplete="off">
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
    let siguienteSerie = <?= $hay_siguiente ? $siguiente_serie : 0 ?>;

    function finishTest() {
        if (!enviado) {
            enviado = true;
            Swal.fire({
                icon: 'success',
                title: '¡Serie finalizada!',
                text: 'Tus respuestas han sido enviadas.',
                confirmButtonColor: '#37517e'
            }).then(() => {
                if (siguienteSerie > 0) {
                    window.location.href = "test.php?serie=" + siguienteSerie;
                } else {
                    window.location.href = "results.php"; // ruta para la página de resultados
                }
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
                finishTest();
            }
        }, 1000);
    }

    window.onload = function () {
        if (display) startTimer();

        form.addEventListener('submit', function(e){
            e.preventDefault();
            finishTest();
        });
    };
    </script>
</body>
</html>
