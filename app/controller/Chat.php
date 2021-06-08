<?php
class chat extends Controller
{
    public function __construct()
    {
        $this->chat = $this->model('chats');
        $this->notificar = $this->model('notificacion');
        $this->publicaciones = $this->model('publicar');
        $this->usuario = $this->model('Users');
        $this->solicitudes = $this->model('solicitudesAmistad');
    }

    public function index()
    {
        if (isset($_SESSION['logueado'])) {
            $datosUsuario = $this->usuario->getUsuario($_SESSION['usuario']);
            $datosPerfil = $this->usuario->getPerfil($datosUsuario->idusuario);
            $misNotificaciones = $this->publicaciones->getNotificaciones($_SESSION['logueado']);
            $notificaciones = $this->notificar->obtenerNotificaciones($_SESSION['logueado']);
            $listaUsuarios = $this->solicitudes->getAmigos($_SESSION['logueado']);

            $datos = [
                'perfil' => $datosPerfil,
                'usuario' => $datosUsuario,
                'misNotificaciones' => $misNotificaciones,
                'notificaciones' => $notificaciones,
                'listaUsuarios' => $listaUsuarios
            ];

            $this->view('pages/chat/chat', $datos);
        } else {
            redirect('/home');
        }
    }

    public function listUsers(){
        $idUser = $_POST['userId'];
        $listaUsuarios = $this->usuario->getUsuarios($idUser);
        
        echo json_encode($listaUsuarios);
    }

    public function userChatHistory()
    {
        if (isset($_SESSION['logueado'])) {
            $toIdUser = $_POST['to_user_id'];
            $fromIdUser = $_POST['from_user_id'];
            $dataChat = $this->chat->fetch_user_chat_history($fromIdUser, $toIdUser);
            
            echo $dataChat;
        } else {
            redirect('/home');
        }
    }

    public function insertChat(){
        if (isset($_SESSION['logueado'])) {
            $toIdUser = $_POST['to_user_id'];
            $fromIdUser = $_POST['from_user_id'];
            $message = $_POST['chat_message'];
            
            if($this->chat->insertChat($toIdUser, $fromIdUser, $message)){
                echo $this->chat->fetch_user_chat_history($fromIdUser, $toIdUser);
            }

        } else {
            redirect('/home');
        }
    }

    public function LastAccessUser(){
        $idUser = $_POST['userId'];
        $this->usuario->insertLastAccess($idUser);
    }
}
