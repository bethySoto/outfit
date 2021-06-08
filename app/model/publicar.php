<?php
class publicar
{
    private $db;
    public function __construct()
    {
        $this->db = new Base;
    }

    public function publicar($datos)
    {
        $this->db->query("INSERT INTO publicaciones(idUserPublico, contenidoPublicacion, fotoPublicacion) VALUES (:iduser, :contenido, :foto)");
        $this->db->bind(':iduser', $datos['iduser']);
        $this->db->bind(':contenido', $datos['contenido']);
        $this->db->bind(':foto', $datos['foto']);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getPublicaciones(){
        $this->db->query("SELECT P.idpublicacion, P.contenidoPublicacion, P.fotoPublicacion, P.fechaPublicacion, P.num_likes, U.usuario, U.idusuario, Per.fotoPerfil FROM publicaciones P 
        INNER JOIN usuarios U ON U.idusuario = P.idUserPublico
        INNER JOIN perfil Per ON Per.idUsuario = P.idUserPublico ORDER BY P.fechaPublicacion DESC");
        return $this->db->registers();
    }

    public function getPublicacion($id){
        $this->db->query("SELECT * FROM publicaciones Where idpublicacion = :id");
        $this->db->bind(':id', $id);
        return $this->db->register();
    }

    public function publicacionesRecientes(){
        $this->db->query("SELECT * FROM publicaciones order by fechaPublicacion desc limit 10");
        return $this->db->registers();
    }
    
    public function eliminarPublicacion($publicacion){
        $this->db->query("DELETE FROM likes WHERE idPublicacion = :id");
        $this->db->bind(':id', $publicacion->idpublicacion);
        if($this->db->execute()){
            $this->db->query("DELETE FROM publicaciones WHERE idpublicacion = :id");
            $this->db->bind(':id', $publicacion->idpublicacion);
            if($this->db->execute()){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function rowLikes($datos){
        $this->db->query("SELECT * FROM likes Where idPublicacion = :publicacion AND idUser = :iduser");
        $this->db->bind(':publicacion', $datos['idpublicacion']);
        $this->db->bind(':iduser', $datos['idusuario']);

        $this->db->execute();
        return $this->db->count();
    }

    public function agregarLike($datos){
        $this->db->query("INSERT INTO likes(idPublicacion, idUser) VALUES (:publicacion, :iduser)");
        $this->db->bind(':publicacion', $datos['idpublicacion']);
        $this->db->bind(':iduser', $datos['idusuario']);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }

    public function eliminarLike($datos){
        $this->db->query("DELETE FROM likes WHERE idPublicacion = :publicacion AND idUser = :iduser");
        $this->db->bind(':publicacion', $datos['idpublicacion']);
        $this->db->bind(':iduser', $datos['idusuario']);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }

    }

    public function addLikeCount($datos)
    {
        $this->db->query("UPDATE publicaciones SET num_likes = :countLike WHERE idPublicacion = :publicacion");
        $this->db->bind(':countLike', ($datos->num_likes+1));
        $this->db->bind(':publicacion', $datos->idpublicacion);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
        
    }

    public function deleteLikeCount($datos)
    {
        $this->db->query("UPDATE publicaciones SET num_likes = :countLike WHERE idPublicacion = :publicacion");
        $this->db->bind(':countLike', ($datos->num_likes-1));
        $this->db->bind(':publicacion', $datos->idpublicacion);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function misLikes($user){
        $this->db->query("SELECT * FROM likes L
        INNER JOIN publicaciones P ON P.idpublicacion  = L.idPublicacion
        Where idUser = :id");
        $this->db->bind(':id', $user);

        $this->db->execute();
        return $this->db->registers();
    }

    public function publicarComentario($datos){
        $this->db->query("INSERT INTO comentarios (idPublicacion, idUser, contenidoComentario) VALUES (:idpublic, :iduser, :comentario)");
        $this->db->bind(':idpublic', $datos['idpublicacion']);
        $this->db->bind(':iduser', $datos['iduser']);
        $this->db->bind(':comentario', $datos['comentario']);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getComentarios(){
        $this->db->query("SELECT * FROM comentarios");
        return $this->db->registers();
    }

    public function getInformacionComentarios(){
        $this->db->query("SELECT C.idcomentario, C.iduser, C.idPublicacion, C.contenidoComentario, C.fechaComentario, P.fotoPerfil, U.usuario FROM comentarios C
        INNER JOIN perfil P ON P.idUsuario = C.idUser
        INNER JOIN usuarios U ON U.idusuario = C.idUser");
        return $this->db->registers();
    }

    public function eliminarComentarioUsuario($id){
        $this->db->query('DELETE FROM comentarios WHERE idcomentario = :id');
        $this->db->bind(':id', $id);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function addNotificacionLike($datos){
        $this->db->query("INSERT INTO notificaciones (idUsuario, usuarioAccion, tipoNotificaion) VALUES (:idusuario, :usuarioAccion, :tipo)");
        $this->db->bind(':idusuario', $datos['idUsuarioPropietario']);
        $this->db->bind(':usuarioAccion', $datos['idusuario']);
        $this->db->bind(':tipo', 1);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function addNotificacionComenario($datos){
        $this->db->query("INSERT INTO notificaciones (idUsuario, usuarioAccion, tipoNotificaion) VALUES (:idusuario, :usuarioAccion, :tipo)");
        $this->db->bind(':idusuario', $datos['iduserPropietario']);
        $this->db->bind(':usuarioAccion', $datos['iduser']);
        $this->db->bind(':tipo', 2);

        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getNotificaciones($id){
        $this->db->query("SELECT idnotificacion  FROM notificaciones WHERE idUsuario = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();
        return $this->db->count();
    }

    public function getMisPublicaciones($id){
        $this->db->query("SELECT P.idpublicacion, P.contenidoPublicacion, P.fotoPublicacion, P.fechaPublicacion, P.num_likes, U.usuario, U.idusuario, Per.fotoPerfil FROM publicaciones P 
        INNER JOIN usuarios U ON U.idusuario = P.idUserPublico
        INNER JOIN perfil Per ON Per.idUsuario = P.idUserPublico
        WHERE U.idusuario = :id
        ORDER BY P.fechaPublicacion DESC");
        $this->db->bind(':id', $id);
        return $this->db->registers();
    }
}
