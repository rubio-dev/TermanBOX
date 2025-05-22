<?php
session_start();

// Guarda los IDs antes de limpiar la sesión
$usuario_id = $_SESSION['usuario_id'] ?? null;
$intento_id = $_SESSION['intento_id'] ?? null;

// Limpia la sesión para siguiente usuario
session_unset();
session_destroy();

require_once __DIR__ . '/../../config/db.php';

$db = new Database();
$conn = $db->connect();

if (!$usuario_id || !$intento_id) {
    echo "<h2 style='margin-top:3rem;text-align:center;color:#37517e'>No hay resultados para mostrar.</h2>";
    echo "<div style='text-align:center;'><a href='../../index.php'><button style='margin-top:2rem;padding:0.9em 2em;background:#a3bffa;border:none;border-radius:13px;color:#37517e;font-size:1.1rem;font-weight:600;cursor:pointer;'>Ir al inicio</button></a></div>";
    exit;
}

// Buscar datos del usuario e intento reciente
$stmt = $conn->prepare("
    SELECT i.id AS intento_id, u.nombre, u.edad, u.ciudad, u.departamento, i.puntaje_total, i.fecha
    FROM intentos i
    JOIN usuarios u ON u.id = i.usuario_id
    WHERE i.id = ?
    LIMIT 1
");
$stmt->execute([$intento_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "<h2 style='margin-top:3rem;text-align:center;color:#37517e'>No hay resultados para mostrar.</h2>";
    echo "<div style='text-align:center;'><a href='../../index.php'><button style='margin-top:2rem;padding:0.9em 2em;background:#a3bffa;border:none;border-radius:13px;color:#37517e;font-size:1.1rem;font-weight:600;cursor:pointer;'>Ir al inicio</button></a></div>";
    exit;
}

// Obtener desglose por serie:
function getSeriesResumen($conn, $intento_id) {
    $stmt = $conn->prepare("
        SELECT serie, SUM(es_correcta) as aciertos, COUNT(*) as total
        FROM respuestas
        WHERE intento_id = ?
        GROUP BY serie
        ORDER BY serie ASC
    ");
    $stmt->execute([$intento_id]);
    $data = [];
    while($r = $stmt->fetch(PDO::FETCH_ASSOC)){
        $data[intval($r['serie'])] = [
            'aciertos' => intval($r['aciertos']),
            'total' => intval($r['total'])
        ];
    }
    return $data;
}

$series = getSeriesResumen($conn, $user['intento_id']);

$nombres_series = [
    1 => "Información",
    2 => "Juicio",
    3 => "Vocabulario",
    4 => "Síntesis",
    5 => "Concentración",
    6 => "Análisis",
    7 => "Abstracción",
    8 => "Planeación",
    9 => "Organización",
    10 => "Atención"
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados finales - TermanBOX</title>
    <link rel="stylesheet" href="../../assets/css/results.css">
</head>
<body>
    <div class="test-container">
        <h2>Resultados finales del test</h2>
        <div class="user-data" style="margin-bottom:2rem;background:#f3f4f8;border-radius:13px;padding:1.2em 1.6em;max-width:380px;margin-left:auto;margin-right:auto;">
            <b>Nombre:</b> <?= htmlspecialchars($user['nombre']) ?><br>
            <b>Edad:</b> <?= htmlspecialchars($user['edad']) ?><br>
            <b>Ciudad:</b> <?= htmlspecialchars($user['ciudad']) ?><br>
            <b>Departamento:</b> <?= htmlspecialchars($user['departamento']) ?><br>
            <b>Fecha:</b> <?= htmlspecialchars($user['fecha']) ?>
        </div>
        <div class="total-puntaje" style="font-size:1.22em;margin-bottom:1.4em;color:#2563eb;">
            Puntaje total: <b><?= intval($user['puntaje_total']) ?></b>
        </div>
        <table class="tabla-admin" style="max-width:500px;margin:auto;">
            <tr>
                <th>Módulo</th>
                <th>Correctas</th>
                <th>Total</th>
                <th>%</th>
            </tr>
            <?php for($s=1;$s<=10;$s++): 
                $d = isset($series[$s]) ? $series[$s] : ['aciertos'=>0, 'total'=>0];
                $percent = ($d['total'] > 0) ? round(($d['aciertos']/$d['total'])*100, 1) : 0;
            ?>
            <tr>
                <td><?= htmlspecialchars($nombres_series[$s]) ?></td>
                <td><?= $d['aciertos'] ?></td>
                <td><?= $d['total'] ?></td>
                <td><?= $percent ?>%</td>
            </tr>
            <?php endfor; ?>
        </table>
        <button class="submit-btn" onclick="window.location.href='../../index.php'">Terminar</button>
    </div>
</body>
</html>
