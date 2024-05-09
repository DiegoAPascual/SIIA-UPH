<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title><?php echo $data['title']; ?></title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/bootstrap/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/bootstrap/css/bootstrap.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/pace/pace.css'; ?>" rel="stylesheet">


    <!-- Theme Styles -->
    <link href="<?php echo BASE_URL . 'Assets/css/main.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/css/custom.css'; ?>" rel="stylesheet">

    <link rel="icon" href="<?php echo BASE_URL . 'Assets/images/ic_launcher.png'; ?>">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="app app-auth-sign-in align-content-stretch d-flex flex-wrap justify-content-end">
        <div class="app-auth-background">
        </div>
        <div class="app-auth-container">
            <div class="logo">
                <a href="#"><?php echo $data['title']; ?></a>
            </div>
            <p class="auth-description">¿No tienes una cuenta? <a href="#" id="registrar">Registrate aquí</a></p>

            <form id="formulario" autocomplete="off">
                <div class="auth-credentials m-b-xxl">
                    <label for="correo" class="form-label">Correo Electrónico <span class="text-danger">*</span></label>
                    <input type="email" class="form-control m-b-md" id="correo" name="correo" aria-describedby="correo" placeholder="correo@gmail.com">

                    <label for="clave" class="form-label">Contraseña <span class="text-danger">*</span></label>
                    <input type="password" class="form-control" id="clave" name="clave" aria-describedby="clave" placeholder="Ingrese su contraseña">
                </div>

                <div class="auth-submit">
                    <button type="submit" class="btn btn-primary">Acceder</button>
                    <a href="#" class="auth-forgot-password float-end" id="reset">¿Olvidaste tu contraseña?</a>
                </div>
            </form>

        </div>
    </div>

    <div id="modalResetPassword" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Olvidaste tu contraseña</h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputReset">Correo</label>
                        <input id="inputReset" class="form-control" type="text" name="inputReset" placeholder="Ingrese su correo eletrónico">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="button" id="btnProcesar">Procesar</button>
                </div>
            </div>
        </div>
    </div>

    <div id="modalRegistroUsuarios" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="registro-modal-title"></h5>
                    <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form id="registro-form" autocomplete="off">
                    <input type="hidden" id="id_usuario" name="id_usuario">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="nombre">Nombre</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="material-icons">
                                            list
                                        </i>
                                    </span>
                                    <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Nombre" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="apellido">Apellido</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="material-icons">
                                            list
                                        </i>
                                    </span>
                                    <input class="form-control" type="text" id="apellido" name="apellido" placeholder="Apellido" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="correo">Correo</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="material-icons">
                                            email
                                        </i>
                                    </span>
                                    <input class="form-control" type="email" id="correo" name="correo" placeholder="Correo" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="telefono">Telefono</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="material-icons">
                                            phone
                                        </i>
                                    </span>
                                    <input class="form-control" type="number" id="telefono" name="telefono" placeholder="Telefono" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="direccion">Dirección</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="material-icons">
                                            location_on
                                        </i>
                                    </span>
                                    <input class="form-control" type="text" id="direccion" name="direccion" placeholder="Dirección" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="clave">Clave</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="material-icons">
                                            key
                                        </i>
                                    </span>
                                    <input class="form-control" type="password" id="clave" name="clave" placeholder="Contraseña" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="rol">Rol</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="material-icons">
                                            account_circle
                                        </i>
                                    </span>
                                    <select name="rol" id="rol" class="form-control" required>
                                        <option value="2">USUARIO</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-primary" type="submit"><i class="material-icons">save</i>Registrar</button>
                        <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal"><i class="material-icons">cancel</i>Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Javascripts -->
    <script src="<?php echo BASE_URL . 'Assets/plugins/jquery/jquery-3.5.1.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'Assets/plugins/bootstrap/js/bootstrap.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'Assets/plugins/perfectscroll/perfect-scrollbar.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'Assets/plugins/pace/pace.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'Assets/js/main.min.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'Assets/js/sweetalert2@11.js'; ?>"></script>
    <script src="<?php echo BASE_URL . 'Assets/js/alertas.js'; ?>"></script>
    <script>
        const base_url = '<?php echo BASE_URL; ?>';
    </script>
    <script src="<?php echo BASE_URL . 'Assets/js/pages/login.js'; ?>"></script>
</body>

</html>