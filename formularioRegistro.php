<!DOCTYPE html>
<html>
<head>
    <title>Registro</title>
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
    <h1>Registro</h1>
    
    <?php if (isset($error)): ?>
        <p>Error: <?php echo $error; ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="success">
            <?php echo htmlspecialchars($success); ?>
        </div>
    <?php endif; ?>
    
    <form class="form-login" method="POST" action="register.php">
        <label>Usuario:</label>
        <input type="text" name="usuario" required>
        <br><br>
        
        <label>Mail:</label>
        <input type="email" name="mail" required>
        <br><br>

        <label>Contraseña:</label>
        <input type="password" name="contrasenya" required>
        <br><br>


        <label>Nombre:</label>
        <input type="text" name="nombre" required>
        <br><br>


        <label>Apellido:</label>
        <input type="text" name="apellido" required>
        <br><br>


        <label>Telefono:</label>
        <input type="number" name="telefono" required>
        <br><br>


        <label>Fecha de nacimiento:</label>
        <input type="date" name="nacimiento" required>
        <br><br>


        <label>DNI:</label>
        <input type="text" name="dni" required>
        <br><br>
        
        <button type="submit" class="boton-registrar">Enviar</button>
    </form>
</body>
</html>