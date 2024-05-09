<?php
class Categorias extends Controller
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
        $data['title'] = 'Categorías';
        $data['menu'] = 'categorias';
        $data['shares'] = $this->model->verificarEstado($this->correo);
        $this->views->getView('categorias', 'categorias', $data);
    }  
}