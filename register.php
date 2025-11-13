
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'connexioBD.inc.php';
$db = new baseDatoscon();
$conn = $db->conectar();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    if (isset($_POST['usuario']) && isset($_POST['contrasenya'])&& isset($_POST['mail'])&& isset($_POST['nombre'])&& isset($_POST['apellido'])&& isset($_POST['telefono'])&& isset($_POST['nacimiento'])&& isset($_POST['dni'])) {
        
        try{
            //coger los datos del form
            $usuario = $_POST['usuario'];
            //encriptamos la contraseña con password_hashs
            $contrasenya = password_hash($_POST['contrasenya'], PASSWORD_BCRYPT);

            $mail = $_POST['mail'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $telefono = $_POST['telefono'];
            $nacimiento = $_POST['nacimiento'];
            $dni = $_POST['dni'];
            
            $stmtCheck = $conn->prepare("SELECT id FROM usuaris WHERE mail = :mail");
            $stmtCheck->bindParam(':mail', $mail);
            $stmtCheck->execute();
            
            if ($stmtCheck->rowCount() > 0) {
                $error = "Este correo electrónico ya está registrado";
            } else {
                // Insertar los datos en la base de datos
                $stmt = $conn->prepare("INSERT INTO usuaris (mail, contrasenya, nom, cognoms, telefon, foto, data_naixement, dni, id_lloc) 
                                       VALUES (:mail, :contrasenya, :nom, :cognoms, :telefon, ' ', :data_naixement, :dni, '4')");
                $stmt->bindParam(':mail', $mail);
                $stmt->bindParam(':contrasenya', $contrasenya);
                $stmt->bindParam(':nom', $nombre);
                $stmt->bindParam(':cognoms', $apellido);
                $stmt->bindParam(':telefon', $telefono);
                $stmt->bindParam(':data_naixement', $nacimiento);
                $stmt->bindParam(':dni', $dni);
                $stmt->execute();
            
            
            //obtener el id del registro
            $idUsuario = $conn->lastInsertId();

            //insertar el tipo de usuario (1) para usuario normal en la table rel_tipus_usuarios 
            $stmt2 = $conn->prepare("INSERT INTO rel_tipus_usuaris (id_usuari, id_tipus) VALUES (:id_usuari, 1)");
            $stmt2->bindParam(':id_usuari', $idUsuario, PDO::PARAM_INT);
            $stmt2->execute();    
                   
            $exito = "Felicidades ". $nombre . " estas registrado con exito";

        }

    }catch(PDOException $e){
            $error = "Error en la base de datos : " . $e->getMessage();
        }
    }
}
?>

<?php if (isset($error)): ?>
    <h1>Error: <?php echo htmlspecialchars($error); ?></h1>
<?php endif; ?>

<?php if (isset($exito)): ?>
    <h1 style="text-align:center;"><?php echo htmlspecialchars($exito); ?></h1>
<?php endif; ?>

<a href="inicio.php"><button id="VolveralIncio" class="boton-registrar">Volver al inicio</button></a>
<link rel="stylesheet" href="style.css">