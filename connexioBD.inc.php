<?php
require_once 'CRUDproducto.php';

class baseDatoscon{

    private $servername = "localhost";
    private $dbname = "BDVdA";
    private $username = "kevin";
    private $password = "nuevacontraseña";
    private $conn;
  
public function conectar(){
    $this->conn = null;

    try{
        $this->conn = new PDO("mysql:host=".$this->servername, $this->username, $this->password);

        $this->conn = new PDO("mysql:host=".$this->servername.";dbname=".$this->dbname, $this->username, $this->password);

        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Conectado satisfactoriamente";
    }
    catch(PDOException $e){
        echo "Error en la conexion: " . $e->getMessage();
    }
    return $this->conn;
}


}


?>