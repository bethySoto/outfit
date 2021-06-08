<?php

class Users
{
    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    public function getUsuario($usuario)
    {
        $this->db->query("SELECT * FROM usuarios WHERE usuario = :user");
        $this->db->bind(':user', $usuario);
        return $this->db->register();
    }

    public function getUsuarios($idUsuario)
    {
        $this->db->query("SELECT U.idusuario, U.usuario, P.fotoPerfil, P.nombreCompleto, L.lastAccess FROM usuarios U
        INNER JOIN login L ON L.idUser = U.idusuario
        INNER JOIN perfil P ON P.idUsuario = U.idusuario 
        WHERE U.idusuario NOT LIKE :buscar");
        $this->db->bind(':buscar', $idUsuario);
        return $this->db->registers();
    }

    public function getPerfil($idUsuario)
    {
        $this->db->query("SELECT * FROM perfil WHERE idUsuario = :id");
        $this->db->bind(':id', $idUsuario);
        return $this->db->register();
    }

    public function verificarContrasena($datosUsuario, $contrasena)
    {
        if (password_verify($contrasena, $datosUsuario->contrasena)) {
            return true;
        } else {
            return false;
        }
    }

    public function insertLastAccess($idusuario)
    {
        $this->db->query("SELECT * FROM login WHERE idUser = :user");
        $this->db->bind(':user', $idusuario);

        if ($this->db->count()) {//ya existe
            $this->db->query('UPDATE login SET lastAccess = :lastAccess WHERE idUser = :idUsuario');
            $this->db->bind(':lastAccess', date("Y-m-d H:i:s"));
            $this->db->bind(':idUsuario', $idusuario);
        } else {//no existe
            $this->db->query('INSERT INTO login (idUser, lastAccess) VALUES (:idUsuario, :lastAccess)');
            $this->db->bind(':idUsuario', $idusuario);
            $this->db->bind(':lastAccess', date("Y-m-d H:i:s"));
        }

        $this->db->execute();
    }

    public function verificarUsuario($datosUsuario)
    {
        $this->db->query("SELECT usuario FROM usuarios WHERE usuario = :user");
        $this->db->bind(':user', $datosUsuario['usuario']);
        if ($this->db->count()) {
            return false;
        } else {
            return true;
        }
    }

    public function register($datosUsuario)
    {
        $this->db->query('INSERT INTO usuarios (idPrivilegio, correo, usuario, contrasena) VALUES (:privilegio, :email, :usuario, :password)');
        $this->db->bind(':privilegio', $datosUsuario['privilegio']);
        $this->db->bind(':email', $datosUsuario['email']);
        $this->db->bind(':usuario', $datosUsuario['usuario']);
        $this->db->bind(':password', $datosUsuario['password']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function insertarPerfil($datos)
    {
        $this->db->query("INSERT INTO perfil (idUsuario, fotoPerfil, nombreCompleto) VALUES (:id, :rutaFoto, :nombre) ");
        $this->db->bind(':id', $datos['idUsuario']);
        $this->db->bind(':rutaFoto', $datos['ruta']);
        $this->db->bind(':nombre', $datos['nombre']);
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function buscar($busqueda, $idUser)
    {
        $this->db->query("SELECT U.idusuario, U.usuario, P.fotoPerfil, P.nombreCompleto FROM usuarios U
        INNER JOIN perfil P ON P.idUsuario = U.idusuario
        WHERE U.usuario LIKE :buscar AND U.idusuario != :idUser");
        $this->db->bind(':buscar', $busqueda);
        $this->db->bind(':idUser', $idUser);
        return $this->db->registers();
    }

  
    public function peticiones($idUsuario)
    {
        $this->db->query("SELECT * FROM solicitudamistad WHERE deIdUser = :idUsuario OR paraIdUser = :idUsuario");
        $this->db->bind(':idUsuario', $idUsuario);
        return $this->db->registers();
    }
}
