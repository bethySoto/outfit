<?php

class Home extends Controller
{
    public function __construct()
    {
        $this->usuario = $this->model("users");
        $this->publicaciones = $this->model('publicar');
    }

    public function index()
    {
        if (isset($_SESSION['logueado'])) {
            $datosUsuario = $this->usuario->getUsuario($_SESSION['usuario']);
            $datosPerfil = $this->usuario->getPerfil($_SESSION['logueado']);
            $datosPublicaciones = $this->publicaciones->getPublicaciones();
            $verificarLike = $this->publicaciones->misLikes($_SESSION['logueado']);

            //$comentarios = $this->publicaciones->getComentarios();
            $informacionComentarios = $this->publicaciones->getInformacionComentarios();
            $misNotificaciones = $this->publicaciones->getNotificaciones($_SESSION['logueado']);

            //$usersPublicaciones = $this->publicaciones->getPublicacionUsuario();

            //if($datosPerfil){//perfil completo
            $datosRed = [
                'usuario' => $datosUsuario,
                'perfil' => $datosPerfil,
                'publicaciones' => $datosPublicaciones,
                'misLikes' => $verificarLike,
                'comentarios' => $informacionComentarios,
                'misNotificaciones' => $misNotificaciones
            ];

            $this->view('pages/home', $datosRed);
            /*}else{
                //echo "el perfil no esta completo";
                $this->view('pages/perfil/completarPerfil', $_SESSION['logueado']);
            }*/
        } else {
            redirect('home/login');
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $datosLogin = [
                'usuario' => trim($_POST['usuario']),
                'password' => $_POST['password']
            ];

            $datosUsuario = $this->usuario->getUsuario($datosLogin['usuario']);

            if ($this->usuario->verificarContrasena($datosUsuario, $datosLogin['password'])) {
                $this->usuario->insertLastAccess($datosUsuario->idusuario);
                $_SESSION['logueado'] = $datosUsuario->idusuario;
                $_SESSION['usuario'] = $datosUsuario->usuario;
                redirect('home');
            } else {
                $_SESSION['errorLogin'] = "Los datos del usuario no son correctos.";
                redirect('/home');
            }
        } else {
            if (isset($_SESSION['logueado'])) {
                redirect('/home');
            } else {
                $this->view("pages/login-register/login");
            }
        }
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST['password'] != $_POST['confirmPassword']) {
                $_SESSION['usuarioError'] = "Las contraseñas no coinciden.";
                $this->view('pages/login-register/register');
            } else {
                $datosRegistro = [
                    'privilegio' => '2',
                    'email' => trim($_POST['email']),
                    'usuario' => trim($_POST['usuario']),
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT)
                ];

                if ($this->usuario->verificarUsuario($datosRegistro)) {
                    if ($this->usuario->register($datosRegistro)) {
                        $_SESSION['registerComplete'] = "Registro correcto, puede iniciar sesión.";
                        redirect('/home');
                    } else {
                    }
                } else {
                    $_SESSION['usuarioError'] = "El usuario no esta disponible, intenta con otro usuario.";
                    $this->view('pages/login-register/register');
                }
            }
        } else {
            if (isset($_SESSION['logueado'])) {
                redirect('/home');
            } else {
                $this->view("pages/login-register/register");
            }
        }
    }

    public function insertarRegistrosPerfil()
    {
        $carpeta = "C:/xampp/htdocs/velvet/public/img/imagenesPerfil/";
        opendir($carpeta);
        $rutaImagen = 'img/imagenesPerfil/' . $_FILES['imagen']['name'];
        $ruta = $carpeta . $_FILES['imagen']['name'];
        copy($_FILES['imagen']['tmp_name'], $ruta);

        $datos = [
            'idUsuario' => trim($_POST['id_user']),
            'nombre' => $_POST['nombre'],
            'ruta' => $rutaImagen
        ];

        if ($this->usuario->insertarPerfil($datos)) {
            redirect('/home');
        } else {
            echo 'EL PERFIL NO ESTA COMPLETO';
        }
    }

    public function logout()
    {
        session_start();
        $_SESSION = [];
        session_destroy();
        redirect('/home');
    }

    public function buscar()
    {
        if (isset($_SESSION['logueado'])) {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $busqueda = '%' . trim($_POST['buscar']) . '%';
                $datosBusqueda = $this->usuario->buscar($busqueda, $_SESSION['logueado']);
                $peticiones = $this->usuario->peticiones($_SESSION['logueado']);

                $datosUsuario = $this->usuario->getUsuario($_SESSION['usuario']);
                $datosPerfil = $this->usuario->getPerfil($_SESSION['logueado']);
                $misNotificaciones = $this->publicaciones->getNotificaciones($_SESSION['logueado']);
                //$misMensajes = $this->publicaciones->getMensajes($_SESSION['logueado']);

                if ($datosBusqueda) {
                    $datosRed = [
                        'usuario' => $datosUsuario,
                        'perfil' => $datosPerfil,
                        'misNotificaciones' => $misNotificaciones,
                        //'misMensajes' => $misMensajes,
                        'resultado' => $datosBusqueda,
                        'peticiones' =>$peticiones
                    ];

                    $this->view('pages/busqueda/buscar', $datosRed);
                } else {
                    redirect('/home');
                }
            }
        } else {
            redirect("/home");
        }
    }

}
