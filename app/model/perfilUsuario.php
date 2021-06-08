<?php
class perfilUsuario
{
    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    public function editarFoto($datos)
    {
        $this->db->query("UPDATE perfil SET fotoPerfil = :ruta where idUsuario = :iduser ");
        $this->db->bind(':ruta', $datos['ruta']);
        $this->db->bind(':iduser', $datos['idUsuario']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
