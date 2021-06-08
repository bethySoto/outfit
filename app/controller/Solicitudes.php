<?php
class Solicitudes extends Controller
{
    public function __construct()
    {
        $this->solicitudes = $this->model('solicitudesAmistad');
        $this->publicaciones = $this->model('publicar');
        $this->usuario = $this->model('Users');
    }

    public function index()
    {
        if (isset($_SESSION['logueado'])) {
            $datosUsuario = $this->usuario->getUsuario($_SESSION['usuario']);
            $datosPerfil = $this->usuario->getPerfil($datosUsuario->idusuario);
            $misNotificaciones = $this->publicaciones->getNotificaciones($_SESSION['logueado']);
            $solicitudesPendientes = $this->solicitudes->getSolicitudesPendientes($_SESSION['logueado']);
            #$datosPublicaciones = $this->publicaciones->getPublicaciones();

            $datos = [
                'perfil' => $datosPerfil,
                'usuario' => $datosUsuario,
                'misNotificaciones' => $misNotificaciones,
                'solicitudesPendientes' =>$solicitudesPendientes
                #'datosPublicaciones' => $datosPublicaciones
            ];

            $this->view('pages/solicitudes/solicitudes', $datos);
        } else {
            redirect('/home');
        }
    }

    public function getAmigos(){
        if (isset($_SESSION['logueado'])) {
            $idUser = $_POST['idUser'];
            $data = $this->solicitudes->getAmigos($idUser);
            echo json_encode($data);
            
        } else {
            redirect('/home');
        }
    }

    public function followUser(){
        if (isset($_SESSION['logueado'])) {
            $deIdUser = $_POST['deIdUser'];
            $paraIdUser = $_POST['paraIdUser'];
            $dataSolicitud = $this->solicitudes->sendPeticion($deIdUser, $paraIdUser);
            echo $dataSolicitud;
            
        } else {
            redirect('/home');
        }
    }

    public function aceptarSolicitud(){
        if (isset($_SESSION['logueado'])) {
            $idSolicitud = $_POST['idSolicitud'];
            $result = $this->solicitudes->aceptarSolicitud($idSolicitud);
            echo $result;
            
        } else {
            redirect('/home');
        }
    }

    public function eliminarSolicitud(){
        if (isset($_SESSION['logueado'])) {
            $idSolicitud = $_POST['idSolicitud'];
            $result = $this->solicitudes->eliminarSolicitud($idSolicitud);
            echo $result;
            
        } else {
            redirect('/home');
        }
    }

    
}
