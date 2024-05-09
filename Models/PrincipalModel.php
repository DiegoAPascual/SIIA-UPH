<?php
class PrincipalModel extends Query{
    public function __construct()
    {
        parent::__construct();
    }

    public function getUsuario($correo)
    {
       return $this->select("SELECT * FROM usuarios WHERE correo = '$correo' AND estado = 1");
    }

    public function updateToken($token, $correo)
    {
       $sql = "UPDATE usuarios SET token = ? WHERE correo = ?";
       return $this->save($sql, [$token, $correo]);
    }

    public function getToken($token)
    {
       return $this->select("SELECT * FROM usuarios WHERE token = '$token' AND estado = 1");
    }

    public function changePassword($clave, $token)
    {
       $sql = "UPDATE usuarios SET clave = ?, token = ? WHERE token = ?";
       return $this->save($sql, [$clave, null, $token]);
    }

    public function getVerificar($item, $nombre, $id)
    {
        if ($id > 0) {
            $sql = "SELECT id FROM usuarios WHERE $item  = '$nombre' AND id != $id AND estado = 1";
        } else {
            $sql = "SELECT id FROM usuarios WHERE $item  = '$nombre' AND estado = 1";
        }
        return $this->select($sql);
    }

    public function registrar($nombre, $apellido, $correo, $telefono, $direccion, $clave, $rol)
    {
        $sql = "INSERT INTO usuarios (nombre, apellido, correo, telefono, direccion, clave, rol) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $datos = array($nombre, $apellido, $correo, $telefono, $direccion, $clave, $rol);
        return $this->insertar($sql, $datos);
    }
}
?>