<?php
class ajustespERFIL
{
    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }


    public function updateProfile($datos)
    {
        $this->db->query("SELECT usuario FROM usuarios WHERE usuario = :aliasUser AND idusuario NOT LIKE :idUser");
        $this->db->bind(':aliasUser', $datos['aliasUser']);
        $this->db->bind(':idUser', $datos['userId']);
        if ($this->db->count()) {
            return "el usuario ya existe";
        } else {
            $this->db->query("UPDATE usuarios SET correo = :correo, usuario = :aliasUser WHERE idusuario = :idUser");
            $this->db->bind(':correo', $datos['email']);
            $this->db->bind(':aliasUser', $datos['aliasUser']);
            $this->db->bind(':idUser', $datos['userId']);
            if ($this->db->execute()) {
                $this->db->query("UPDATE perfil SET nombreCompleto = :nombreCompleto where idUsuario = :iduser ");
                $this->db->bind(':nombreCompleto', $datos['completeName']);
                $this->db->bind(':iduser', $datos['userId']);
                if ($this->db->execute()) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
    }

    public function updatePassword($datos)
    {
        $this->db->query("UPDATE usuarios SET contrasena = :password WHERE idusuario = :idUser");
        $this->db->bind(':password', $datos['newPass']);
        $this->db->bind(':idUser', $datos['userId']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteUser($idUser)
    {
        $this->db->query("DELETE FROM perfil WHERE idUsuario = :idUser");
        $this->db->bind(':idUser', $idUser);
        if ($this->db->execute()) {
            $this->db->query("DELETE FROM usuarios WHERE idusuario = :idUser");
            $this->db->bind(':idUser', $idUser);
            if ($this->db->execute()) {
                session_start();
                $_SESSION = [];
                session_destroy();
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
