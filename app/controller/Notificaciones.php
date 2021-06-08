<?php
class Notificaciones extends Controller{
    public function __construct()
    {
        $this->notificar = $this->model('notificacion');
        $this->publicaciones = $this->model('publicar');
        $this->usuario = $this->model('Users');
    }

    public function index(){
        if(isset($_SESSION['logueado'])){
            $datosUsuario = $this->usuario->getUsuario($_SESSION['usuario']);
            $datosPerfil = $this->usuario->getPerfil($datosUsuario->idusuario);
            $misNotificaciones = $this->publicaciones->getNotificaciones($_SESSION['logueado']);
            $notificaciones = $this ->notificar->obtenerNotificaciones($_SESSION['logueado']);

            $datos = [
                'perfil' => $datosPerfil,
                'usuario' => $datosUsuario,
                'misNotificaciones' => $misNotificaciones,
                'notificaciones' => $notificaciones
            ];

            $this->view('pages/notificaciones/notificaciones', $datos);
        }else{
            redirect('/home');
        }
    }

    public function eliminar($id){
        if(isset($_SESSION['logueado'])){
            if($this->notificar->eliminarNotificacion($id)){
                redirect('/notificaciones');

            }else{
                redirect('/notificaciones');
            }
        }else{
            redirect('/home');
        }

    }
}