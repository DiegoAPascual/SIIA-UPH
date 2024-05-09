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
    <link href="<?php echo BASE_URL . 'Assets/plugins/perfectscroll/perfect-scrollbar.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/pace/pace.css'; ?>" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <!-- Theme Styles -->
    <link href="<?php echo BASE_URL . 'Assets/css/main.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/plugins/DataTables/datatables.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/css/custom.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/css/select2.min.css'; ?>" rel="stylesheet">
    <link href="<?php echo BASE_URL . 'Assets/css/select2-bootstrap-5-theme.rtl.min.css'; ?>" rel="stylesheet">


    <link rel="icon" href="<?php echo BASE_URL . 'Assets/images/ic_launcher.png'; ?>">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
    <div class="app align-content-stretch d-flex flex-wrap">
        <div class="app-sidebar">
            <div class="logo">
                <div class="sidebar-user-switcher user-activity-online">
                    <a href="#">
                        <img src="<?php echo BASE_URL . 'Assets/images/6073873.png'; ?>" alt="Foto de perfil">
                        <span class="activity-indicator"></span>
                        <span class="user-info-text"><?php echo $_SESSION['nombre']; ?><br><span class="user-state-info"><?php echo $_SESSION['correo']; ?></span></span>
                    </a>
                </div>
            </div>
            <div class="app-menu">
                <ul class="accordion-menu">
                    <li class="sidebar-title">
                        Menú
                    </li>
                    <li class="<?php echo ($data['menu'] == 'admin') ? 'active-page' : ''; ?>">
                        <a href="<?php echo BASE_URL . 'admin'; ?>" class="<?php echo ($data['menu'] == 'admin') ? 'active' : ''; ?>"><i class="material-icons-two-tone">home</i>Inicio</a>
                    </li>
                    <li class="<?php echo ($data['menu'] == 'categorias') ? 'active-page' : ''; ?>">
                        <a href="<?php echo BASE_URL . 'categorias'; ?>" class="<?php echo ($data['menu'] == 'categorias') ? 'active' : ''; ?>"><i class="material-icons-two-tone">category</i>Categorías</a>
                    </li>
                    <li class="<?php echo ($data['menu'] == 'share') ? 'active-page' : ''; ?>">
                        <a href="<?php echo BASE_URL . 'compartidos'; ?>" class="<?php echo ($data['menu'] == 'share') ? 'active' : ''; ?>"><i class="material-icons-two-tone">notifications</i>Notificaciones <span class="badge rounded-pill badge-danger float-end"><?php echo $data['shares']['total']; ?></span></a>
                    </li>
                    <li class="<?php echo ($data['menu'] == 'recursos') ? 'active-page' : ''; ?>">
                        <a href="<?php echo BASE_URL . 'recursos'; ?>" class="<?php echo ($data['menu'] == 'recursos') ? 'active' : ''; ?>"><i class="material-icons-two-tone">cloud_queue</i>Recursos</a>
                    </li>
                    <li class="<?php echo ($data['menu'] == 'acercade') ? 'active-page' : ''; ?>">
                        <a href="<?php echo BASE_URL . 'acercade'; ?>" class="<?php echo ($data['menu'] == 'acercade') ? 'active' : ''; ?>"><i class="material-icons-two-tone">info</i>Acerca de</a>
                    </li>
                    <br><br><br><br>
                    <li class="<?php echo ($data['menu'] == 'config') ? 'active-page' : ''; ?>">
                        <a href="<?php echo BASE_URL . 'usuarios/profile'; ?>" class="<?php echo ($data['menu'] == 'config') ? 'active' : ''; ?>"><i class="material-icons-two-tone">settings</i>Configuraciones</a>
                    </li>
                    <li>
                        <a href="<?php echo BASE_URL . 'usuarios/cerrar_sesion'; ?>"><i class="material-icons-two-tone">power_settings_new</i>Cerrar sesión</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="app-container">
            <div class="search">
                <form>
                    <input class="form-control" id="inputBuscar" type="text" placeholder="Buscar..." aria-label="Search">
                    <div id="container-result"></div>
                </form>
                <a href="#" class="toggle-search"><i class="material-icons">close</i></a>
            </div>
            <div class="app-header">
                <nav class="navbar navbar-light navbar-expand-lg">
                    <div class="container-fluid">
                        <div class="navbar-nav" id="navbarNav">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link hide-sidebar-toggle-button" href="#"><i class="material-icons">first_page</i></a>
                                </li>

                            </ul>

                        </div>
                        <div class="d-flex">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link toggle-search" href="#"><i class="material-icons">search</i></a>
                                </li>
                                <li class="nav-item hidden-on-mobile">
                                    <a class="nav-link language-dropdown-toggle" href="#" id="languageDropDown" data-bs-toggle="dropdown"><img src="<?php echo BASE_URL . 'Assets/images/ic_launcher.png'; ?>" alt=""></a>
                                    <ul class="dropdown-menu dropdown-menu-end language-dropdown" aria-labelledby="languageDropDown">
                                        <li><a class="dropdown-item" href="<?php echo BASE_URL . 'usuarios/profile'; ?>"><img src="<?php echo BASE_URL . 'Assets/images/6073873.png'; ?>"></i>Perfil</a></li>
                                        <li><a class="dropdown-item" href="<?php echo BASE_URL . 'usuarios/cerrar_sesion'; ?>"><img src="<?php echo BASE_URL . 'Assets/images/cerrar-sesion.png'; ?>">Cerrar sesión</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="app-content">
                <div class="content-wrapper">