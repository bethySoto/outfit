<?php
class Perfil extends Controller
{
    public function __construct()
    {
        $this->perfil = $this->model('perfilUsuario');
        $this->usuario = $this->model('Users');
        $this->publicaciones = $this->model('publicar');
    }

    public function index($user)
    {

        if (isset($_SESSION['logueado'])) {
            //Datos usuario logueado
            $datosUsuario = $this->usuario->getUsuario($_SESSION['usuario']);
            $datosPerfil = $this->usuario->getPerfil($_SESSION['logueado']);
            

            //Datos otros usuarios
            $datosOtrosUsuario = $this->usuario->getUsuario($user);
            $datosPublicaciones = $this->publicaciones->getMisPublicaciones($datosOtrosUsuario->idusuario);
            $datosOtrosPerfil = $this->usuario->getPerfil($datosOtrosUsuario->idusuario);
            
            $misNotificaciones = $this->publicaciones->getNotificaciones($_SESSION['logueado']);

            $informacionComentarios = $this->publicaciones->getInformacionComentarios();

            $datos = [
                'usuario' => $datosUsuario,
                'perfil' => $datosPerfil,
                'OtroUsuario' => $datosOtrosUsuario,
                'OtroPerfil' => $datosOtrosPerfil,
                'publicaciones' => $datosPublicaciones,
                'misNotificaciones' => $misNotificaciones,
                'comentarios' => $informacionComentarios

            ];
            $this->view('pages/perfil/perfil', $datos);
        }
    }

    public function cambiarImagen()
    {
        $carpeta = "C:/xampp/htdocs/velvet/public/img/imagenesPerfil/";
        opendir($carpeta);
        $rutaImagen = 'img/imagenesPerfil/' . $_FILES['imagen']['name'];
        $ruta = $carpeta . $_FILES['imagen']['name'];
        copy($_FILES['imagen']['tmp_name'], $ruta);

        $datos = [
            'idUsuario' => trim($_POST['id_user']),
            'nombre' => "",
            'ruta' => $rutaImagen
        ];

        $datosPerfil = $this->usuario->getPerfil($datos['idUsuario']);

        if ($datosPerfil) { //El usuario ya tiene foto de perfil
            if ($this->perfil->editarFoto($datos)) {
                unlink('C:/xampp/htdocs/velvet/public/' . $datosPerfil->fotoPerfil); //eliminamos la anterior
                redirect('/home');
            } else {
                echo 'Foto no editada';
            }
        } else { //El usuario no ha cargado ninguna foto de perfil
            if ($this->usuario->insertarPerfil($datos)) {
                echo "foto insertado";
                redirect('/home');
            } else {
                echo 'foto no insertada';
            }
        }
    }

    public function publicacionesRecientes(){
        if (isset($_SESSION['logueado'])) {
            $data = $this->publicaciones->publicacionesRecientes();
            echo json_encode($data);
            
        } else {
            redirect('/home');
        }
    }
}
