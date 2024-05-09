<?php
class Recursos extends Controller
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
        ### Eliminar archivos de forma permanente
        $fecha = date('Y-m-d H:i:s');
        $eliminar = $this->model->getConsulta();
        $ruta = 'Assets/archivos/';
        for ($i = 0; $i < count($eliminar); $i++) {
            if ($eliminar[$i]['fecha_eliminacion'] < $fecha) {
                $accion = $this->model->eliminarRegistro($eliminar[$i]['id']);
                if ($accion == 1) {
                    if (file_exists($ruta . $eliminar[$i]['id_carpeta'] . '/' . $eliminar[$i]['nombre'])) {
                        unlink($ruta . $eliminar[$i]['id_carpeta'] . '/' . $eliminar[$i]['nombre']);
                    }
                }
            }
        }
    }
    public function index()
    {
        $data['title'] = 'Centro de recursos';
        $data['script'] = 'files.js';
        $data['active'] = 'recent';
        $data['menu'] = 'recursos';
        $carpetas = $this->model->getCarpetas($this->id_usuario);
        $data['archivos'] = $this->model->getArchivosRecientes($this->id_usuario);
        for ($i = 0; $i < count($carpetas); $i++) {
            $carpetas[$i]['color'] = substr(md5($carpetas[$i]['id']), 0, 6);
            $carpetas[$i]['fecha'] = time_ago(strtotime($carpetas[$i]['fecha_create']));
        }
        $data['carpetas'] = $carpetas;
        $data['shares'] = $this->model->verificarEstado($this->correo);
        $this->views->getView('recursos', 'recursos', $data);
    }

    public function crearcarpeta()
    {
        $nombre = $_POST['nombre'];
        if (empty($nombre)) {
            $res = array('tipo' => 'warning', 'mensaje' => 'El nombre para la carpeta nueva es requerido');
        } else {
            //Comprobar si existe nombre de la carpeta
            $verificarNom = $this->model->getVerificar('nombre', $nombre, $this->id_usuario, 0);
            if (empty($verificarNom)) {
                $data = $this->model->crearcarpeta($nombre, $this->id_usuario);
                if ($data > 0) {
                    $res = array('tipo' => 'success', 'mensaje' => 'Carpeta creada');
                } else {
                    $res = array('tipo' => 'error', 'mensaje' => 'Error al crear carpeta');
                }
            } else {
                $res = array('tipo' => 'warning', 'mensaje' => 'La carpeta ya existe');
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function subirarchivo()
    {
        $id_carpeta = (empty($_POST['id_carpeta'])) ? 1 : $_POST['id_carpeta'];
        $archivos = $_FILES['file'];
        $destino = 'Assets/archivos';
        if (!file_exists($destino)) {
            mkdir($destino);
        }
        $carpeta = $destino . '/' . $id_carpeta;
        if (!file_exists($carpeta)) {
            mkdir($carpeta);
        }
        for ($i = 0; $i < count($archivos['name']); $i++) {
            $name = $archivos['name'][$i];
            $tmp = $archivos['tmp_name'][$i];
            $tipo = $archivos['type'][$i];
            $data = $this->model->subirarchivo($name, $tipo, $id_carpeta, $this->id_usuario);

            if ($data > 0) {
                move_uploaded_file($tmp, $carpeta . '/' . $name);
                $respuesta = $data;
            } else {
                $respuesta = 0;
            }
        }
        if ($respuesta > 0) {
            $res = array('tipo' => 'success', 'mensaje' => 'Archivos subidos correctamente.');
        } else {
            $res = array('tipo' => 'error', 'mensaje' => 'Error al subir los archivos.');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function ver($id_carpeta)
    {
        $data['title'] = 'Listado de archivos';
        $data['active'] = 'detail';
        $data['archivos'] = $this->model->getArchivos($id_carpeta, $this->id_usuario);
        $data['menu'] = 'recursos';
        $data['carpeta'] = $this->model->getCarpeta($id_carpeta);
        $data['shares'] = $this->model->verificarEstado($this->correo);
        $this->views->getView('recursos', 'archivos', $data);
    }

    public function verdetalle($id_carpeta)
    {
        $data['title'] = 'Archivos compartidos';
        $data['id_carpeta'] = $id_carpeta;
        $data['script'] = 'details.js';
        $data['carpeta'] = $this->model->getCarpeta($id_carpeta);
        if (empty($data['carpeta'])) {
            echo 'Pagina no encontrada';
            exit;
        }
        $data['menu'] = 'recursos';
        $data['shares'] = $this->model->verificarEstado($this->correo);
        $this->views->getView('recursos', 'detalle', $data);
    }

    public function listardetalle($id_carpeta)
    {
        $data = $this->model->getArchivosCompartidos($id_carpeta);
        for ($i = 0; $i < count($data); $i++) {
            if ($data[$i]['estado'] == 0) {
                $data[$i]['estado'] = '<span class="badge bg-warning">Se eliminará el ' . $data[$i]['fecha_eliminacion'] . '</span>';
                $data[$i]['acciones'] = '';
            } else {
                $data[$i]['estado'] = '<span class="badge bg-success">Compartido</span>';
                $data[$i]['acciones'] = '<button class="btn btn-danger btn-sm" onclick="eliminarDetalle(' . $data[$i]['id'] . ')">Eliminar</button>';
            }
        }

        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        die();
    }
}
