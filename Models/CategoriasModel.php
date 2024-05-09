<?php
class CategoriasModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }
    
    ### Ver total de archivos compartidos en notificaciones
    public function verificarEstado($correo)
    {
        $sql = "SELECT COUNT(id) AS total FROM detalle_archivos WHERE correo = '$correo' AND estado = 1";
        return $this->select($sql);
    }   
}
?>