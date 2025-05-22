<?php
require_once __DIR__ . '/../../config/db.php';

$db = new Database();
$conn = $db->connect();

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

$sql = "
SELECT 
    u.id AS usuario_id, u.nombre, i.puntaje_total, i.fecha, i.id AS intento_id
FROM usuarios u
LEFT JOIN intentos i ON i.usuario_id = u.id
ORDER BY i.fecha DESC
";
$stmt = $conn->query($sql);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Función para obtener desglose por serie:
function getSeriesResumenArray($conn, $intento_id) {
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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Todos los resultados - TermanBOX</title>
    <link rel="stylesheet" href="../../assets/css/results.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>
<body>
    <div class="test-container">
        <h2>Resultados de todos los usuarios</h2>
        <table class="tabla-admin" id="tablaResultados">
            <tr>
                <th>Nombre</th>
                <th>Puntaje Total</th>
                <th>Fecha</th>
                <th>Reporte</th>
            </tr>
            <?php foreach($usuarios as $user): 
                $series = [];
                if ($user['intento_id']) {
                    $series = getSeriesResumenArray($conn, $user['intento_id']);
                }
                ?>
                <tr class="user-head">
                    <td><?= htmlspecialchars($user['nombre']) ?></td>
                    <td class="puntaje"><?= intval($user['puntaje_total']) ?></td>
                    <td><?= htmlspecialchars($user['fecha']) ?></td>
                    <td>
                        <button class="btn-imprimir" 
                            onclick="imprimirReporteDetallado(this)"
                            data-nombre="<?= htmlspecialchars($user['nombre']) ?>"
                            data-puntaje="<?= intval($user['puntaje_total']) ?>"
                            data-fecha="<?= htmlspecialchars($user['fecha']) ?>"
                            data-series='<?= json_encode($series) ?>'
                        >Imprimir Reporte</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <button class="submit-btn" onclick="window.location.href='../../index.php'">Volver al inicio</button>
    </div>
    <script>
    const nombresSeries = [
        "Información", "Juicio", "Vocabulario", "Síntesis", "Concentración",
        "Análisis", "Abstracción", "Planeación", "Organización", "Atención"
    ];

    function imprimirReporteDetallado(btn) 
    {
    const nombre = btn.getAttribute('data-nombre');
    const puntaje = btn.getAttribute('data-puntaje');
    const fecha = btn.getAttribute('data-fecha');
    const series = JSON.parse(btn.getAttribute('data-series'));

    const nombresSeries = [
        "Información", "Juicio", "Vocabulario", "Síntesis", "Concentración",
        "Análisis", "Abstracción", "Planeación", "Organización", "Atención"
    ];

    const doc = new window.jspdf.jsPDF({orientation: "portrait", unit: "mm", format: "a4"});
    
    // FONDO degradado pastel (truco con rectángulos)
    doc.setFillColor(163, 191, 250); // #a3bffa
    doc.rect(0, 0, 210, 80, 'F');
    doc.setFillColor(255, 214, 174); // #ffd6ae
    doc.rect(0, 80, 210, 217, 'F');

    // TÍTULO grande
    doc.setTextColor(55, 81, 126); // #37517e
    doc.setFont("helvetica", "bold");
    doc.setFontSize(22);
    doc.text("Reporte de Resultados", 105, 28, {align: "center"});

    // Subtítulo
    doc.setFontSize(13);
    doc.setFont("helvetica", "normal");
    doc.setTextColor(96, 114, 160); // #6072a0
    doc.text("Evaluación automatizada TermanBOX", 105, 38, {align: "center"});

    // DATOS de usuario
    doc.setTextColor(55, 81, 126);
    doc.setFontSize(14);
    doc.setFont("helvetica", "bold");
    doc.text("Nombre:", 25, 55);
    doc.text("Puntaje Total:", 25, 64);
    doc.text("Fecha:", 25, 73);

    doc.setFont("helvetica", "normal");
    doc.setFontSize(13);
    doc.text(nombre, 70, 55);
    doc.setFont("helvetica", "bold");
    doc.setFontSize(16);
    doc.setTextColor(37, 99, 235); // #2563eb
    doc.text(String(puntaje), 70, 64);

    doc.setFont("helvetica", "normal");
    doc.setFontSize(13);
    doc.setTextColor(55, 81, 126);
    doc.text(fecha, 70, 73);

    // Línea decorativa
    doc.setDrawColor(163, 191, 250); // #a3bffa
    doc.setLineWidth(1.1);
    doc.line(25, 82, 185, 82);

    // DESGLOSE por módulos
    doc.setFont("helvetica", "bold");
    doc.setFontSize(14.5);
    doc.text("Desglose por módulo:", 25, 94);

    // Tabla de series
    let y = 104;
    for (let i = 0; i < 10; i++) {
        const serie = series[i+1] || {aciertos:0, total:0};
        doc.setFont("helvetica", "normal");
        doc.setFontSize(13.5);
        doc.setTextColor(37, 81, 126);
        doc.text(`${nombresSeries[i]}`, 33, y);

        // Puntaje destacado
        doc.setFont("helvetica", "bold");
        doc.setFontSize(13.5);
        doc.setTextColor(37, 99, 235); // #2563eb
        doc.text(`${serie.aciertos} / ${serie.total}`, 160, y, {align: "right"});
        y += 10;
    }

    // Pie de página bonito
    doc.setFontSize(11.5);
    doc.setFont("helvetica", "italic");
    doc.setTextColor(170, 170, 170);
    doc.text("TermanBOX - Reporte generado automáticamente", 105, 282, {align: "center"});
    doc.setTextColor(255, 182, 98);
    doc.text("Gracias por confiar en la tecnología educativa", 105, 289, {align: "center"});

    // ¡Logo? Puedes agregarlo aquí con doc.addImage si quieres.
    // doc.addImage("logo_base64.png", "PNG", x, y, w, h);

    doc.save("Reporte-TermanBOX-" + nombre.replace(/[^a-zA-Z0-9]/g, "") + ".pdf");
    }
    </script>
</body>
</html>
