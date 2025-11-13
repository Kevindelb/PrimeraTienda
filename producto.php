<?php
class Producto {
    public $id;
    public $nom;
    public $n_unitats;
    public $preu;
    public $descripcio;
    public $foto;
    public $data_fabricacio;
    public $data_caducitat;
    public $codi_proveidor;

    public function __construct($id, $nom, $n_unitats, $preu, $descripcio, $foto, $data_fabricacio, $data_caducitat, $codi_proveidor) {
        $this->id = $id;
        $this->nom = $nom;
        $this->n_unitats = $n_unitats;
        $this->preu = $preu;
        $this->descripcio = $descripcio;
        $this->foto = $foto;
        $this->data_fabricacio = $data_fabricacio;
        $this->data_caducitat = $data_caducitat;
        $this->codi_proveidor = $codi_proveidor;
    }
}
?>
