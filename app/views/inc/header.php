<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <title>
        Proyecto Viernes <?php echo $var = (isset($parameters['title']))? ' - '.$parameters['title'] : ''?>
    </title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo ROUTE_URL?>/fa/css/all.min.css">
    <!-- Nucleo Icons -->
    <link href="<?php echo ROUTE_URL?>/assets/css/nucleo-icons.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="<?php echo ROUTE_URL?>/assets/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="<?php echo ROUTE_URL?>/assets/demo/demo.css" rel="stylesheet" />
    <!-- Mis estilos css -->
    <link href="<?php echo ROUTE_URL?>/css/d_styles.css" rel="stylesheet" />

    <!-- <link rel="stylesheet" href="<?php echo ROUTE_URL?>/css/datatables.css"> -->
    <link href="<?php echo ROUTE_URL?>/assets/datatable/css/dataTables.bootstrap4.css" rel="stylesheet" />
    
</head>

<body class="white-content">
    <div class="wrapper">
        <div class="sidebar" data="blue">
            <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
    -->
            <div class="sidebar-wrapper">
                <div class="logo">
                    <a href="javascript:void(0)" class="simple-text logo-mini">
                        PV
                    </a>
                    <a href="javascript:void(0)" class="simple-text logo-normal">
                        ADMINISTRACIÓN
                    </a>
                </div>
                <ul class="nav">
                    <li class="<?php echo $var = ($parameters['menu'] == 'Admin')? 'active' : '' ?>">
                        <a href="<?php echo ROUTE_URL?>/admin">
                            <i class="fas fa-home"></i>
                            <p>Inicio</p>
                        </a>
                    </li>
                    <li class="<?php echo $var = ($parameters['menu'] == 'Pacientes')? 'active' : '' ?>">
                        <a href="<?php echo ROUTE_URL?>/patient">
                            <i class="fas fa-notes-medical"></i>
                            <p>PACIENTES</p>
                        </a>
                    </li>
                    <li class="<?php echo $var = ($parameters['menu'] == 'Viernes')? 'active' : '' ?>">
                        <a href="<?php echo ROUTE_URL?>/friday">
                            <i class="fas fa-atom"></i>
                            <p>Viernes</p>
                        </a>
                    </li>
                    <li class="<?php echo $var = ($parameters['menu'] == 'Usuarios')? 'active' : '' ?>">
                        <a href="<?php echo ROUTE_URL?>/users">
                            <i class="fas fa-users"></i>
                            <p>Usuarios</p>
                        </a>
                    </li>
                    <li class="<?php echo $var = ($parameters['menu'] == 'Bitacora')? 'active' : '' ?>">
                        <a href="<?php echo ROUTE_URL?>/binnacle">
                            <i class="fas fa-database"></i>
                            <p>Bitácora</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <!-- Navbar -->
            <nav class="navbar navbar-expand-lg navbar-absolute navbar-transparent">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle d-inline">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        <a class="navbar-brand" href="javascript:void(0)">Dashboard</a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navigation">
                        <ul class="navbar-nav ml-auto">
                            <li class="dropdown nav-item">
                                <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                                <i class="fas fa-user"></i> <b> <?php echo $_SESSION['user']->name?> </b>
                                </a>
                                <ul class="dropdown-menu dropdown-navbar">
                                    <li class="nav-link">
                                        <a href="javascript:void(0)" class="nav-item dropdown-item"><i class="fas fa-user-edit"></i> Perfil</a>
                                    </li>
                                    <li class="dropdown-divider"></li>
                                    <li class="nav-link">
                                        <a href="<?php echo ROUTE_URL?>/login/logout" class="nav-item dropdown-item"> <i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="separator d-lg-none"></li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="modal modal-search fade" id="searchModal" tabindex="-1" role="dialog"
                aria-labelledby="searchModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="SEARCH">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="tim-icons icon-simple-remove"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Navbar -->
            <div class="content">