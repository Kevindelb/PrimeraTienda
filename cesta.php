<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'producto.php';
require_once 'CRUDproducto.php';


session_start();
if (!isset($_SESSION['cesta'])) {
    $_SESSION['cesta'] = [];
}

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $_SESSION['cesta'][] = $id;
}

if (isset($_POST['eliminar'])) {
    $key = $_POST['eliminar'];
    unset($_SESSION['cesta'][$key]);
    // Reindexar el array para evitar saltos de índice
    $_SESSION['cesta'] = array_values($_SESSION['cesta']);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="style.css">
    </head>
    <header>
    <nav>
        <a href="/up6/index.php" class="logo">
            <div class="logo-img">🛒</div>
            <span>Tienda Vall d'Alba</span>
        </a>

        <!-- Menu de navegacion si hay usuario o si no hay  -->
        <ul class="nav-links">
            <?php if (isset($_SESSION['usuario'])): ?>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="cesta.php">Cesta</a></li>
                <li><a href="cerrarSesion.php">Cerrar Sesión</a></li>
            <?php else: ?>
                <li><a href="formularioRegistro.php">Conócenos</a></li>
                <li><a href="inicio.php">Iniciar Sesion</a></li>
                <li><a href="formularioRegistro.php">Registro</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>

<body>
<div class="container">
    <h1> Nuestros Productos </h1>
    <div class="cesta-lista">
        <!-- Recorremos los productos y los mostramos con nombre de class de css -->
        <?php foreach ($_SESSION['cesta'] as $key => $prodId): ?>
        <?php $productoUnico= ProductoDAO::obtenerPorId($prodId);?>
        <div class="cesta-item">
            <img class="cesta-img" src="imagenes/<?= htmlspecialchars($productoUnico->foto) ?>" alt="<?= htmlspecialchars($productoUnico->nom) ?>">
             <div class="cesta-info">
                 <div class="cesta-nombre"><?= htmlspecialchars($productoUnico->nom) ?></div>
                <div class="cesta-unidades">Unidades: <?= htmlspecialchars($productoUnico->n_unitats) ?></div>
                <div class="cesta-desc"><?= htmlspecialchars($productoUnico->descripcio) ?></div>
                 <div class="cesta-precio">€<?= htmlspecialchars($productoUnico->preu) ?></div>
            </div>
            <div>
            <form method="post" style="margin-left:20px;">
                <input type="hidden" name="eliminar" value="<?= $key ?>">
                <button type="submit" class="borrarBtn">Eliminar</button>
            </form>
            </div>
                
        </div>
        <?php endforeach; ?>
        <div> 
            <a href="/up6/index.php"><button id="seguircomprandoBtn">Seguir comprando </button>
        </div>
    </div>
</div>
</body>
</html>