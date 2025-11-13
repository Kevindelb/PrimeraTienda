<?php
// Mostrar todos los errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Incluir las clases necesarias
require_once 'CRUDproducto.php';
$productes = ProductoDAO::obtenerTodos();
session_start();

if (isset($_SESSION['tipo_usuario']) && $_SESSION['tipo_usuario'] === 'empleat') {
    $esEmpleado = true;
} else {
    $esEmpleado = false;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Productos</title>
    <link rel="stylesheet" href="style.css">
    <style>
/* Estilos para el menú */
.nav-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    gap: 10px;
}

.nav-links li {
    position: relative;
}

.nav-links li ul {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    list-style: none;
    padding: 5px 0;
    margin: 0;
    background: #2c3e50;
    border: 1px solid #ccc;
    min-width: 180px;
    z-index: 1000;
}

.nav-links li:hover > ul {
    display: block;
}

.nav-links li ul li {
    padding: 5px 15px;
}

.nav-links li ul li a {
    text-decoration: none;
    color: #ffffffff;
    display: block;
}

.nav-links li ul li a:hover {
    background-color: #34495e;
}
</style>
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
        <?php if ($esEmpleado): ?>
            <li>
                <a href="#">Gestionar ▼</a>
                <ul>
                    <li><a href="dashboardGestion.php">Gestionar Datos</a></li>
                    <li><a href="dashboardProductos.php">Gestionar Productos</a></li>
                    <li><a href="dashboardUsuarios.php">Gestionar Usuarios</a></li>
                </ul>
            </li>
        <?php endif; ?>
            <li><a href="cerrarSesion.php">Cerrar Sesión</a></li>
        <?php else: ?>
            <li><a href="formularioRegistro.php">Conócenos</a></li>
            <li><a href="inicio.php">Iniciar Sesión</a></li>
            <li><a href="formularioRegistro.php">Registro</a></li>
        <?php endif; ?>
</ul>

    </nav>
</header>

<body>
<div class="container">
    <h1> Nuestros Productos </h1>
    <div class="products-grid">
        <!-- Recorremos los productos y los mostramos con nombre de class de css -->
        <?php foreach ($productes as $p): ?>
        <div class="product-card">
            <div class="product-image" 
                 style="background-image: url('data:image/jpeg;base64,<?= base64_encode($p->foto) ?>');">
            </div>
            <div class="product-info">
                <div class="product-category">Unidades: <?= htmlspecialchars($p->n_unitats) ?></div>
                <h3 class="product-title"><?= htmlspecialchars($p->nom) ?></h3>
                <p class="product-description"><?= htmlspecialchars($p->descripcio) ?></p>
                <div class="product-footer">
                    <div class="product-price">
                        <span class="currency">€</span><?= htmlspecialchars($p->preu) ?>
                    </div>
                    <form method="post" action="cesta.php">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($p->id)?>">
                        <button type="submit" class="add-to-cart"   name="anadir">Añadir producto</button>
                    </form>
                    <!--<a href="formulariProducte.php?id=<?= $p->id ?>" class="add-to-cart">Editar</a>
                    <a href="eliminarProducte.php?id=<?= $p->id ?>" class="add-to-cart" style="background:red;">Eliminar</a> -->
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
