<?php
class Ajustes extends Controller
{
    public function __construct()
    {
        $this->ajustes = $this->model('ajustesPerfil');
        $this->notificar = $this->model('notificacion');
        $this->publicaciones = $this->model('publicar');
        $this->usuario = $this->model('Users');
        $this->perfil = $this->model('perfilUsuario');
    }

    public function index()
    {
        if (isset($_SESSION['logueado'])) {
            $datosUsuario = $this->usuario->getUsuario($_SESSION['usuario']);
            $datosPerfil = $this->usuario->getPerfil($datosUsuario->idusuario);
            $misNotificaciones = $this->publicaciones->getNotificaciones($_SESSION['logueado']);
            $datosPublicaciones = $this->publicaciones->getPublicaciones();

            $datos = [
                'perfil' => $datosPerfil,
                'usuario' => $datosUsuario,
                'misNotificaciones' => $misNotificaciones,
                'datosPublicaciones' => $datosPublicaciones
            ];

            $this->view('pages/ajustes/ajustes', $datos);
        } else {
            redirect('/home');
        }
    }

    public function actualizarPerfil()
    {
        if (isset($_SESSION['logueado'])) {

            $datos = [
                'userId' => $_POST['userId'],
                'aliasUser' => $_POST['aliasUser'],
                'completeName' => $_POST['completeName'],
                'email' => str_replace("\"", "", $_POST['email'])
            ];

            $result = $this->ajustes->updateProfile($datos);
            if ($result) {
                $_SESSION['usuario'] =  $datos['aliasUser'];
            }
            echo $result;

        } else {
            redirect('/home');
        }
    }

    public function changePassword()
    {
        if (isset($_SESSION['logueado'])) {
            $datos = [
                'userId' => $_POST['userId'],
                'oldPass' => $_POST['oldPass'],
                'newPass' => password_hash($_POST['newPass'], PASSWORD_DEFAULT)
            ];

            $datosUsuario = $this->usuario->getUsuario($_SESSION['usuario']);

            if ($this->usuario->verificarContrasena($datosUsuario, $datos['oldPass'])) {
                echo $this->ajustes->updatePassword($datos);
            } else {
                echo "la contraseña antigua no conincide";
            }
        } else {
            redirect('/home');
        }
    }

    public function deleteUser(){
        if (isset($_SESSION['logueado'])) {

            echo $this->ajustes->deleteUser($_POST['userId']);

        } else {
            redirect('/home');
        }
    }
}
