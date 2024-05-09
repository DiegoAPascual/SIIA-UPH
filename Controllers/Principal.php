<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//Load Composer's autoloader
require 'vendor/autoload.php';

class Principal extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }
    public function index()
    {
        $data['title'] = 'Inicio de sesión';
        $this->views->getView('principal', 'index', $data);
    }

    ### Login ###
    public function validar()
    {
        $correo = $_POST['correo'];
        $clave = $_POST['clave'];
        $data = $this->model->getUsuario($correo);
        if (!empty($data)) {
            if (password_verify($clave, $data['clave'])) {
                $_SESSION['id'] = $data['id'];
                $_SESSION['correo'] = $data['correo'];
                $_SESSION['nombre'] = $data['nombre'];
                $res = array('tipo' => 'success', 'mensaje' => 'BIENVENIDO AL SISTEMA INTEGRAL DE INFORMACIÓN ACADÉMICA');
            } else {
                $res = array('tipo' => 'warning', 'mensaje' => 'CONTRASEÑA INCORRECTA');
            }
        } else {
            $res = array('tipo' => 'warning', 'mensaje' => 'EL CORREO NO EXISTE');
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die;
    }

    ##Resetear clave
    public function enviarCorreo($correo)
    {
        $consulta = $this->model->getUsuario($correo);
        if (!empty($consulta)) {
            //Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);

            try {
                $token = md5(date('YmdHis'));
                $this->model->updateToken($token, $correo);
                //Server settings
                $mail->SMTPDebug = 0;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = '20191173@uthh.edu.mx';                     //SMTP username
                $mail->Password   = 'mczi ackz gwha nkqc';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('diegopascual2019@gmail.com', 'SIIA-UPH');
                $mail->addAddress($correo);

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Restablecer clave SIIA-UPH';
                $mail->Body    = '¿Has pedido restablecer tu contraseña?, si no has sido tu omite este mensaje. <br><a href="' . BASE_URL . 'principal/reset/' . $token . '">¡Click aquí para cambiar!.</a>';

                $mail->send();
                $res = array('tipo' => 'success', 'mensaje' => 'El enlace para restablecer tu contraseña ha sido enviado a tu correo.');
            } catch (Exception $e) {
                $res = array('tipo' => 'success', 'mensaje' => $mail->ErrorInfo);
            }
        } else {
            $res = array('tipo' => 'warning', 'mensaje' => 'El correo ingresado no existe.');
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }

    public function reset($token)
    {
        $data['title'] = 'Restablecer contraseña';
        $data['usuario'] = $this->model->getToken($token);
        if ($data['usuario']['token'] == $token) {
            $this->views->getView('principal', 'reset', $data);
        } else {
            header('Location: ' . BASE_URL . 'errors');
        }
    }

    public function changePassword()
    {
        $nueva = $_POST['clave_nueva'];
        $confirmar = $_POST['clave_confirmar'];
        $token = $_POST['token'];
        if (empty($nueva) || empty($confirmar) || empty($token)) {
            $res = array('tipo' => 'warning', 'mensaje' => 'Todos los campos son requeridos.');
        } else {
            if ($nueva != $confirmar) {
                $res = array('tipo' => 'warning', 'mensaje' => 'Las contraseñas no coindiden.');
            } else {
                $result = $this->model->getToken($token);
                if ($token == $result['token']) {
                    $hash = password_hash($nueva, PASSWORD_DEFAULT);
                    $data = $this->model->changePassword($hash, $token);
                    if ($data == 1) {
                        $res = array('tipo' => 'success', 'mensaje' => 'Contraseña restablecida.');
                    } else {
                        $res = array('tipo' => 'error', 'mensaje' => 'Error al restablecer la contraseña.');
                    }
                }
            }
        }
        echo json_encode($res, JSON_UNESCAPED_UNICODE);
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

        if (empty($nombre) || empty($apellido) || empty($correo) || empty($telefono) || empty($direccion) || empty($clave) || empty($rol)) {
            $res = array('tipo' => 'warning', 'mensaje' => 'Todos los campos son requeridos');
        } else {
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
        }

        echo json_encode($res, JSON_UNESCAPED_UNICODE);
        die();
    }
}
