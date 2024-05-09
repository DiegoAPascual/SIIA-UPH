<?php
class Usuarios extends Controller
{
    private $id_usuario, $correo;
    public function __construct()
    {
        parent::__construct();
        session_start();
        $this->id_usuario = $_SESSION['id'];
        $this->correo = $_SESSION['correo'];
        if (empty($_SESSION['id'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
    }

    public function index()
    {
        $data['title'] = 'Gestión de usuarios';
        $data['script'] = 'usuarios.js';
        $data['menu'] = 'usuarios';
        $data['shares'] = $this->model->verificarEstado($this->correo);
        $this->views->getView('usuarios', 'index', $data);
    }

    public function listar()
    {
        $data = $this->model->getUsuarios();
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['id'] == 1) {
                $data[$i]['acciones'] = 'SUPER ADMIN';
            } else {
                $data[$i]['acciones'] = '<div>
                <a href="#" class="btn btn-info btn-sm" onclick="editar(' . $data[$i]['id'] . ')">Editar</a>
                <a href="#" class="btn btn-danger btn-sm" onclick="eliminar(' . $data[$i]['id'] . ')">Eliminar</a>
            </div>';
            }
            $data[$i]['nombres'] = $data[$i]['nombre'] . ' ' . $data[$i]['apellido'];
        }
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function guardar()
    {
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $correo = $_POST['correo'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];
        $clave = $_POST['clave'];
        $rol = $_POST['rol'];
        $id_usuario = $_POST['id_usuario'];
        if (empty($nombre) || empty($apellido) ||  empty($correo) ||  empty($telefono) ||  empty($direccion) ||  empty($clave) || empty($rol)) {
            $res = array('tipo' => 'warning', 'mensaje' => 'Todos los campos son requeridos');
        } else {
            if ($id_usuario == '') {
                //Comprobar si existe correo
                $verificarCorreo = $this->model->getVerificar('correo', $correo, 0);
                if (empty($verificarCorreo)) {
                    $verificarTel = $this->model->getVerificar('telefono', $telefono, 0);
                    if (empty($verificarTel)) {
                        $hash = password_hash($clave, PASSWORD_DEFAULT);
                        $data = $this->model->registrar($nombre, $apellido, $correo, $telefono, $direccion, $hash, $rol);
                        if ($data > 0) {
                            $res = array('tipo' => 'success', 'mensaje' => 'Usuario registrado correctamente');
                        } else {
                            $res = array('tipo' => 'error', 'mensaje' => 'Error al registrar');
                        }
                    } else {
                        $res = array('tipo' => 'warning', 'mensaje' => 'El telefono ya existe');
                    }
                } else {
                    $res = array('tipo' => 'warning', 'mensaje' => 'El correo ya existe');
                }
            } else {
                //Comprobar si existe correo
                $verificarCorreo = $this->model->getVerificar('correo', $correo, $id_usuario);

                if (empty($verificarCorreo)) {
                    $verificarTel = $this->model->getVerificar('telefono', $telefono, $id_usuario);
                    if (empty($verificarTel)) {
                        $hash = password_hash($clave, PASSWORD_DEFAULT);
                        $data = $this->model->modificar($nombre, $apellido, $correo, $telefono, $direccion, $rol, $id_usuario);
                        if ($data == 1) {
                            $res = array('tipo' => 'success', 'mensaje' => 'Usuario modificado');
                        } else {
                            $res = array('tipo' => 'error', 'mensaje' => 'Error al modificar');
                        }
                    } else {
                        $res = array('tipo' => 'warning', 'mensaje' => 'El telefono ya existe');
                    }
                } else {
                    $res = array('tipo' => 'warning', 'mensaje' => 'El correo ya existe');
                }
            }
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function delete($id)
    {
        $data = $this->model->delete($id);
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'Usuario dado de baja');
        } else {
            $res = array('tipo' => 'warning', 'mensaje' => 'Error al eliminar');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function editar($id)
    {
        $data = $this->model->getUsuario($id);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function profile()
    {
        $data['title'] = 'Perfil del usuario';
        $data['script'] = 'profile.js';
        $data['menu'] = 'config';
        $data['usuario'] = $this->model->getUsuario($this->id_usuario);
        $data['shares'] = $this->model->verificarEstado($this->correo);
        $this->views->getView('usuarios', 'perfil', $data);
    }

    public function changePassword()
    {
        $actual = $_POST['clave_actual'];
        $nueva = $_POST['clave_nueva'];
        $confirmar = $_POST['clave_confirmar'];
        if (empty($actual) || empty($nueva) || empty($confirmar)) {
            $res = array('tipo' => 'warning', 'mensaje' => 'Todos los campos son requeridos.');
        } else {
            if ($nueva != $confirmar) {
                $res = array('tipo' => 'warning', 'mensaje' => 'Las contraseñas no coindiden.');
            } else {
                $consulta = $this->model->getUsuario($this->id_usuario);
                if (password_verify($actual, $consulta['clave'])) {
                    $hash = password_hash($nueva, PASSWORD_DEFAULT);
                    $data = $this->model->changePassword($hash, $this->id_usuario);
                    if ($data == 1) {
                        $res = array('tipo' => 'success', 'mensaje' => 'Contraseña modificada.');
                    } else {
                        $res = array('tipo' => 'error', 'mensaje' => 'Error al modificar.');
                    }
                } else {
                    $res = array('tipo' => 'warning', 'mensaje' => 'Contraseña actual incorrecta');
                }
            }
            echo json_encode($res, JSON_UNESCAPED_UNICODE);
            die();
        }
    }

    public function changeProfile()
    {
        $correo = $_POST['correo'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $telefono = $_POST['telefono'];
        $direccion = $_POST['direccion'];

        // Verificar si se ha subido una nueva foto de perfil
        if (!empty($_FILES['perfil']['name'])) {
            $perfil = $_FILES['perfil'];

            // Obtener información sobre el archivo
            $perfilNombre = $perfil['name'];
            $perfilTmpName = $perfil['tmp_name'];

            // Directorio donde se almacenarán las fotos de perfil
            $directorioPerfil = 'Assets/images/Profile/';

            // Mover la foto de perfil al directorio
            if (move_uploaded_file($perfilTmpName, $directorioPerfil . $perfilNombre)) {
                // La foto se ha cargado correctamente, actualiza la ruta en la base de datos
                $rutaPerfil = $directorioPerfil . $perfilNombre;

                $nombreArchivoPerfil = basename($rutaPerfil);

                // Llama al método para actualizar la ruta de la foto de perfil en la base de datos
                $this->model->actualizarPerfil($this->id_usuario, $rutaPerfil, $nombreArchivoPerfil);
            } else {
                // Error al cargar la foto de perfil
                $res = array('tipo' => 'error', 'mensaje' => 'Error al cargar la foto de perfil.');
                echo json_encode($res, JSON_UNESCAPED_UNICODE);
                die();
            }
        } else {
            // No se ha subido una nueva foto de perfil, mantener la misma ruta
            $usuario = $this->model->getUsuario($this->id_usuario);
            $rutaPerfil = $usuario['perfil'];
        }

        // Modificar los datos del usuario
        $data = $this->model->modificar($nombre, $apellido, $correo, $telefono, $direccion, $rutaPerfil, $this->id_usuario);

        // Verificar si se modificaron los datos correctamente
        if ($data == 1) {
            $res = array('tipo' => 'success', 'mensaje' => 'Datos modificados correctamente.');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al modificar tus datos.');
        }

        // Devolver la respuesta como JSON
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function cerrar_sesion()
    {
        session_destroy();
        header('Location: ' . BASE_URL);
    }
}
