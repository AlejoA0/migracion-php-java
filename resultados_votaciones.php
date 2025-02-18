<?php
require_once 'config.php';
verificar_sesion();

// Obtener resultados de candidatos
$sql_candidatos = "SELECT c.id, c.nombre, c.cargo, COUNT(v.id) as votos
                   FROM candidatos c
                   LEFT JOIN votos_candidatos v ON c.id = v.candidato_id
                   GROUP BY c.id
                   ORDER BY votos DESC";
$result_candidatos = $conn->query($sql_candidatos);

// Obtener resultados de actividades recreativas
$sql_actividades = "SELECT a.id, a.nombre, COUNT(v.id) as votos
                    FROM actividades_recreativas a
                    LEFT JOIN votos_actividades v ON a.id = v.actividad_id
                    GROUP BY a.id
                    ORDER BY votos DESC";
$result_actividades = $conn->query($sql_actividades);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, 
    initial-scale=1.0">
    <title>Resultados de las Votaciones</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Resultados de las Votaciones</h2>

    <h3>Resultados de Candidatos</h3>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Cargo</th>
            <th>Votos</th>
        </tr>
        <?php while ($row = $result_candidatos->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                <td><?php echo htmlspecialchars($row['cargo']); ?></td>
                <td><?php echo $row['votos']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h3>Resultados de Actividades Recreativas</h3>
    <table border="1">
        <tr>
            <th>Nombre</th>
            <th>Votos</th>
        </tr>
        <?php while ($row = $result_actividades->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                <td><?php echo $row['votos']; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php if (es_administrador()): ?>
        <p><a href="admin_panel.php">Volver al Panel de Administrador</a></p>
    <?php else: ?>
        <p><a href="foro.php">Volver al Foro</a></p>
    <?php endif; ?>
</body>
</html>