
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'connexioBD.inc.php';

session_start();

if (isset($_POST['usuario']) && isset($_POST['contrasenya'])) {

    $usuario = $_POST['usuario'];
    $contrasenya = $_POST['contrasenya'];


    $db = new baseDatoscon();
    $conn = $db->conectar();

    $sql = "SELECT u.id, u.mail, u.nom,u.contrasenya, t.id AS id_tipus, t.nom_tipus
            FROM usuaris u
            JOIN rel_tipus_usuaris r ON u.id = r.id_usuari
            JOIN tipus_usuaris t ON r.id_tipus = t.id
            WHERE u.mail = :mail ";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':mail', $usuario, PDO::PARAM_STR);
    $stmt->execute();
    

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && password_verify($contrasenya, $user['contrasenya'])) {
        $_SESSION['usuario'] = $user['mail'];
        $_SESSION['nombre'] = $user['nom'];
        $_SESSION['tipo_usuario'] = $user['nom_tipus']; 
        $_SESSION['id_tipus'] = $user['id_tipus'];
        $_SESSION['id_usuario'] = $user['id']; 
        $_SESSION['autenticado'] = true;

        header("Location: index.php");
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
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
    <h1>Iniciar Sesion</h1>
    
    <?php if (isset($error)): ?>
        <p>Error: <?php echo $error ,$contrasenya; ?></p>
    <?php endif; ?>
    
    
    
    <form class="form-login" method="POST">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required>
        <br><br>
        
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="contrasenya" required>
        <br><br>
        
        <button type="submit" class="boton-ingresar" >Ingresar</button>
        
    </form>
    <div>
        <a href="formularioRegistro.php" ><button class="boton-registrar">Registrarse</button></a> 
    </div>
</body>
</html>


