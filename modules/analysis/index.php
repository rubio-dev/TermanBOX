<?php
require_once __DIR__ . '/../../config/db.php';
$db = new Database();
$conn = $db->connect();

// Total de tests aplicados (intentos)
$stmt = $conn->query("SELECT COUNT(*) FROM intentos");
$total_tests = $stmt->fetchColumn();

// Promedio de puntaje total (intentos)
$stmt = $conn->query("SELECT AVG(puntaje_total) FROM intentos");
$promedio = round($stmt->fetchColumn(), 2);

// Últimos 3 resultados con nombre de usuario
$stmt = $conn->query("
    SELECT 
        usuarios.nombre, 
        intentos.fecha, 
        intentos.puntaje_total
    FROM intentos
    JOIN usuarios ON intentos.usuario_id = usuarios.id
    ORDER BY intentos.fecha DESC
    LIMIT 3
");
$ultimos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Análisis - TermanBOX</title>
    <link rel="stylesheet" href="../../assets/css/indexAnalysis.css">
</head>
<body>
    <div class="container">
        <h1>Análisis</h1>
        <p>Resumen general del Test Terman-Merrill aplicado.</p>

        <!-- Tarjetas resumen -->
        <div style="display: flex; gap: 14px; width: 100%; margin-bottom: 1.3rem;">
            <div style="background: var(--azul-pastel); border-radius: 14px; padding: 1.1rem; flex:1; text-align: center;">
                <span style="font-size: 1.1rem; font-weight: 700;">Total</span><br>
                <span style="font-size: 2.1rem; font-weight: 800;"><?php echo $total_tests; ?></span>
            </div>
            <div style="background: var(--naranja-pastel); border-radius: 14px; padding: 1.1rem; flex:1; text-align: center;">
                <span style="font-size: 1.1rem; font-weight: 700;">Promedio</span><br>
                <span style="font-size: 2.1rem; font-weight: 800;"><?php echo $promedio; ?></span>
            </div>
        </div>

        <!-- Últimos resultados -->
        <div style="width: 100%; margin-bottom: 1.2rem;">
            <table style="width: 100%; border-collapse: collapse; background: var(--gris-suave); border-radius: 12px; overflow: hidden;">
                <thead>
                    <tr style="background: var(--azul-marino-pastel); color: white;">
                        <th style="padding: 8px; font-weight: 700;">Usuario</th>
                        <th style="padding: 8px; font-weight: 700;">Fecha</th>
                        <th style="padding: 8px; font-weight: 700;">Puntaje</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($ultimos as $row): ?>
                    <tr>
                        <td style="padding: 8px;"><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td style="padding: 8px;"><?php echo date("d/m/Y H:i", strtotime($row['fecha'])); ?></td>
                        <td style="padding: 8px; font-weight: 700;"><?php echo $row['puntaje_total']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <button onclick="location.href='../../test.php'">Aplicar nuevo test</button>
        <button onclick="location.href='../results/index.php'">Ver todos los resultados</button>
        <div class="footer">TermanBOX - Análisis</div>
    </div>
</body>
</html>
