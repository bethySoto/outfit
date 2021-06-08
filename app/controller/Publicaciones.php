<?php


class Publicaciones extends Controller{
    public function __construct()
    {
        $this->publicar = $this->model('publicar');
    }

    public function publicar($idUsuario){

        if (isset($_FILES['imagen'])) {
            $carpeta = "C:/xampp/htdocs/velvet/public/img/imagenesPublicaciones/";
            opendir($carpeta);
            $rutaImagen = 'img/imagenesPublicaciones/' . $_FILES['imagen']['name'];
            $ruta = $carpeta . $_FILES['imagen']['name'];
            copy($_FILES['imagen']['tmp_name'], $ruta);
        } else {
            $rutaImagen = "";
        }

        $datos = [
            'iduser' => trim($idUsuario),
            'contenido' => trim($_POST['contenido']),
            'foto' => $rutaImagen
        ];

        if($this->publicar->publicar($datos)){
            redirect("/home");
        }else{
            echo "error al cargar imagen publicaciones";
        }
    }

    public function eliminar($idpublicacion){
        $publicacion = $this->publicar->getPublicacion($idpublicacion);


        if($this->publicar->eliminarPublicacion($publicacion)){
            unlink('C:/xampp/htdocs/velvet/public/'.$publicacion->fotoPublicacion);
            redirect('home');
        }else{

        }
    }

    public function megusta($idpublicacion, $idUsuario, $idUsuarioPropietario){
        $datos = [
            'idpublicacion' => $idpublicacion,
            'idusuario' => $idUsuario,
            'idUsuarioPropietario' => $idUsuarioPropietario
        ];

        $datosPublicacion = $this->publicar->getPublicacion($idpublicacion);

        if($this->publicar->rowLikes($datos)){
            if($this->publicar->eliminarLike($datos)){
                $this->publicar->deleteLikeCount($datosPublicacion);
            }
            redirect('/home');
        }else{
            if($this->publicar->agregarLike($datos)){
                $this->publicar->addLikeCount($datosPublicacion);
                $this->publicar->addNotificacionLike($datos);
            }
            redirect('/home');
        }
    }

    public function comentar(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $datos = [
                'iduserPropietario' => trim($_POST['iduserPropietario']),
                'iduser' => trim($_POST['idusuario']),
                'idpublicacion' => trim($_POST['idpublicacion']),
                'comentario' => trim($_POST['comentarioText']),
            ];

            if($this->publicar->publicarComentario($datos)){
                $this->publicar->addNotificacionComenario($datos);
                redirect('/home');
            }else{
                redirect('/home');
            }

        }else{
            redirect('/home');
        }
    }

    public function eliminarComentario($id){
        if($this->publicar->eliminarComentarioUsuario($id)){
            redirect("/home");
        }else{
            redirect("/home");
        }

    }
}
