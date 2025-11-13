<?php
session_start();
require_once 'connexioBD.inc.php';
require_once 'CRUDproducto.php';

// si el usuario no es igual a empleado denegar acceso
if (!isset($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'empleat') {
    die("⛔ Acceso denegado. Solo empleados pueden entrar aquí.");
}


$db = new baseDatoscon();
$conn = $db->conectar();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


//  Eliminar usuario
if (isset($_GET['eliminar'])) {
    $idEliminar = intval($_GET['eliminar']);

    //  Primero borrar relaciones de rel tipus
    $stmt = $conn->prepare("DELETE FROM rel_tipus_usuaris WHERE id_usuari = ?");
    $stmt->execute([$idEliminar]);

    //  Luego borramos el usuario de tabla usuaris
    $stmt = $conn->prepare("DELETE FROM producte WHERE id = ?");
    $stmt->execute([$idEliminar]);

    header("Location: dashboardGestion.php");
    exit;
}


// Cambiar tipo de usuario 1 pa cliente 2 pa empleado
if (isset($_POST['cambiar_tipo'])) {
    $idUsuario = intval($_POST['id_usuario']);
    $nuevoTipo = intval($_POST['nuevo_tipo']);

    // Actualizar en tabla rel_tipus_usuaris
    $stmt = $conn->prepare("UPDATE rel_tipus_usuaris SET id_tipus = ? WHERE id_usuari = ?");
    $stmt->execute([$nuevoTipo, $idUsuario]);
    header("Location: dashboardGestion.php");
    exit;
}


$sql = "SELECT 
            u.id, 
            u.mail, 
            u.nom, 
            u.cognoms, 
            t.nom_tipus
        FROM usuaris u
        LEFT JOIN rel_tipus_usuaris r ON u.id = r.id_usuari
        LEFT JOIN tipus_usuaris t ON r.id_tipus = t.id
        ORDER BY u.id ASC";


$stmt = $conn->query($sql);
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="style.css">
    <style>
          table { width: 80%; margin: 20px auto; border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
    th { background-color: #f4f4f4; }
    .btn { padding: 6px 12px; border-radius: 6px; text-decoration: none; }
    .btn-delete { background: red; color: white; }
    .btn-edit { background: #007bff; color: white; }



    </style>
</head>
<body>

<h1 style="text-align:center;">Gestión de Usuarios</h1>
<p style="text-align:center;"><a href="index.php">Volver al inicio</a></p>

<table>
    <tr>
        <th>ID</th>
        <th>Correo</th>
        <th>Nombre</th>
        <th>Tipo de usuario</th>
        <th>Acciones</th>
    </tr>

    <?php foreach ($usuarios as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['id']) ?></td>
            <td><?= htmlspecialchars($u['mail']) ?></td>
            <td><?= htmlspecialchars($u['nom'] . ' ' . $u['cognoms']) ?></td>
            <td><?= htmlspecialchars($u['nom_tipus']) ?></td>
            <td>
                <!-- Cambiar tipo -->
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id_usuario" value="<?= $u['id'] ?>">
                    <select name="nuevo_tipo">
                         <?php
                    if ($u['nom_tipus'] == 'client') {
                        echo '<option value="1" selected>Cliente</option>';
                        echo '<option value="2">Empleado</option>';
                    } else {
                        echo '<option value="1">Cliente</option>';
                        echo '<option value="2" selected>Empleado</option>';
                    }
                    ?>
                    </select>
                    <button type="submit" name="cambiar_tipo" class="btn btn-edit">Guardar</button>
                </form>

                <!-- Eliminar -->
                <a href="?eliminar=<?= $u['id'] ?>" class="btn btn-delete" >Eliminar</a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
