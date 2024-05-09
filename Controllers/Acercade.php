<?php
class Acercade extends Controller
{
    private $id_usuario, $correo;
    public function __construct() {
        parent::__construct();
        session_start();
        $this->id_usuario = $_SESSION['id'];
        $this->correo = $_SESSION['correo'];
        ##Validar sesion
        if (empty($_SESSION['id'])) {
            header('Location: ' . BASE_URL);
            exit;
        }
    }
    
    public function index()
    {
        $data['title'] = 'Acerca de';
        $data['menu'] = 'acercade';
        $data['shares'] = $this->model->verificarEstado($this->correo);
        $this->views->getView('acercade', 'acercade', $data);
    }  
}