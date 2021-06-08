<?php
class solicitudesAmistad
{
    private $db;

    public function __construct()
    {
        $this->db = new Base;
    }

    public function sendPeticion($deIdUser, $paraIdUser)
    {
        $this->db->query("INSERT INTO solicitudamistad (paraIdUser, deIdUser, estado) VALUES (:paraUser, :deUser, 'enviada')");
        $this->db->bind(':paraUser', $paraIdUser);
        $this->db->bind(':deUser', $deIdUser);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getSolicitudesPendientes($deIdUser)
    {
        $this->db->query("SELECT S.idSolicitud, S.timestamp, U.idusuario, U.usuario, P.fotoPerfil, P.nombreCompleto FROM solicitudamistad S
        INNER JOIN usuarios U ON U.idusuario = S.deIdUser
        INNER JOIN perfil P ON P.idUsuario = U.idusuario
        WHERE S.paraIdUser = :idUsuario AND S.estado = 'enviada'");
        $this->db->bind(':idUsuario', $deIdUser);
        return $this->db->registers();
    }

    public function aceptarSolicitud($idSolicitud)
    {
        $this->db->query("UPDATE solicitudamistad SET estado = 'aceptada' WHERE idSolicitud = :idSolicitud");
        $this->db->bind(':idSolicitud', $idSolicitud);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function eliminarSolicitud($idSolicitud)
    {
        $this->db->query("DELETE FROM solicitudamistad WHERE idSolicitud = :idSolicitud");
        $this->db->bind(':idSolicitud', $idSolicitud);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getAmigos($idUser)
    {
        $this->db->query("SELECT S.idSolicitud, S.timestamp, U.idusuario, U.usuario, P.fotoPerfil, P.nombreCompleto FROM solicitudamistad S
        INNER JOIN usuarios U ON U.idusuario = S.deIdUser
        INNER JOIN perfil P ON P.idUsuario = U.idusuario
        WHERE (S.paraIdUser = :idUsuario AND S.estado = 'aceptada') OR (S.deIdUser = :idUsuario AND S.estado = 'aceptada')");
        $this->db->bind(':idUsuario', $idUser);
        return $this->db->registers();
    }

    
}