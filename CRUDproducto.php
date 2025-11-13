<?php
require_once 'connexioBD.inc.php';
require_once 'producto.php';

class ProductoDAO {

    public static function obtenerTodos() {
        $db = new baseDatoscon();
        $conn = $db->conectar();


        $stmt = $conn->prepare("SELECT * FROM producte ORDER BY id DESC");
        $stmt->execute();
        $productos = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $productos[] = new Producto(
                $row['id'],
                $row['nom'],
                $row['n_unitats'],
                $row['preu'],
                $row['descripcio'],
                $row['foto'],
                $row['data_fabricacio'],
                $row['data_caducitat'],
                $row['codi_proveidor']
            );
        }
        return $productos;
    }

    public static function obtenerPorId($id) {
        $db = new baseDatoscon();
        $conn = $db->conectar();

        $stmt = $conn->prepare("SELECT * FROM producte WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return new Producto(
               $row['id'],
                $row['nom'],
                $row['n_unitats'],
                $row['preu'],
                $row['descripcio'],
                $row['foto'],
                $row['data_fabricacio'],
                $row['data_caducitat'],
                $row['codi_proveidor']
            );
        }
        return null;
    }

    public static function insertar(Producto $p) {
        $db = new baseDatoscon();
        $conn = $db->conectar();

        $stmt = $conn->prepare("INSERT INTO producte (nom, n_unitats, preu, descripcio, foto, data_fabricacio, data_caducitat, codi_proveidor)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$p->nom, $p->n_unitats, $p->preu, $p->descripcio, $p->foto, $p->data_fabricacio, $p->data_caducitat, $p->codi_proveidor]);
    }

    public static function actualizar(Producto $p) {
        $db = new baseDatoscon();
        $conn = $db->conectar();
        $stmt = $conn->prepare("UPDATE producte 
                                SET nom=?, n_unitats=?, preu=?, descripcio=?, foto=?, data_fabricacio=?, data_caducitat=?, codi_proveidor=? 
                                WHERE id=?");
        $stmt->execute([$p->nom, $p->n_unitats, $p->preu, $p->descripcio, $p->foto, $p->data_fabricacio, $p->data_caducitat, $p->codi_proveidor, $p->id]);
    }

    public static function eliminar($id) {
        $db = new baseDatoscon();
        $conn = $db->conectar();
        $stmt = $conn->prepare("DELETE FROM producte WHERE id = ?");
        $stmt->execute([$id]);
    }
}
?>
