<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="fa/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Chat</title>
</head>

<body>
    <div class="chat-container" id="chat-container">
        <div class="bot-name">
            <!-- <i class="fas fa-search"></i> -->
            <h4>Psicóloga Virtual</h4>
        </div>
        <div class="bot-info">
            <!-- Diseño de bot   -->
            <div class="picture">
                <img src="img/viernes.png" alt="">
            </div>
            <?php if ($parameters['login'] == 0):?>
            <div class="form-login">
                <h3>Iniciar sesión</h3>
                <form action="<?php echo ROUTE_URL?>/PatientPublic/login" method="post">
                    <div>
                        <input type="email" placeholder="Ingrese su correo" name="email" required>
                    </div>
                    <br>
                    <div>
                        <input type="password" placeholder="Ingrese su contraseña" name="password" required>
                    </div>
                    <br>
                    <div>
                        <button class="btn btn-primary">Iniciar sesión</button>
                        <br>
                        <br>
                        <a href="<?php echo ROUTE_URL?>/PatientPublic/new_acount/">¿No tienes cuenta? Crea una.</a>
                    </div>
                    <br>
                </form>
            </div>
            <?php endif;?>
            <?php if ($parameters['login'] == 1):?>
            <div class="patient-info">
                <h3>BIENVENIDO</h3>
                <b class="patient-name"><?php echo $_SESSION['patient']->name . ' ' . $_SESSION['patient']->last_name?></b>

                <div class="options">
                    <a href="<?php echo ROUTE_URL?>/PatientPublic"><i class="fas fa-id-card"></i> Ver perfil</a>
                    <a href="#"><i class="fas fa-file-alt"></i> Realizar test</a>
                    <br><br>
                    <a href="<?php echo ROUTE_URL?>/PatientPublic/logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                </div>
            </div>
            <?php endif;?>
            <?php if ($parameters['login'] == 2):?>
            <div class="patient-info">
                <h3>BIENVENIDO</h3>
                <b class="patient-name"><?php echo $_SESSION['user']->name?></b>

                <div class="options">
                    <a href="<?php echo ROUTE_URL?>/Admin"><i class="fas fa-home"></i> Dashboard</a>
                    <br><br>
                    <a href="<?php echo ROUTE_URL?>/PatientPublic/logout"><i class="fas fa-sign-out-alt"></i> Cerrar sesión</a>
                </div>
            </div>
            <?php endif;?>
        </div>
        <div class="chat-title">
            <span>Viernes</span>
            <i class="fas fa-bars"></i>
        </div>
        <div class="chat-message-list" id="chat-message-list">
        <?php if ($parameters['login'] == 1):?>
            <div class="message-row you-message">
                <div class="message-content">
                    <div class="message-text"> <a style="cursor:pointer" class="text-white" onclick="load_history()"><i class="fas fa-redo"></i> Cargar mensajes anteriores    </a> </div>
                    <div class="message-time">17:49</div>
                </div>
            </div>
            <?php endif;?>
            <?php echo $parameters['message'] ?>
        </div>
        <div class="chat-form">
            <input type="text" onkeypress="send_keyboard(event)" id="message-form" placeholder="Escribe un mensaje">
            <i class="fas fa-paper-plane" onclick="send()"></i>
        </div>
    </div>

    <!-- Archivos JS -->
    <script src="js/jquery.min.js"></script>
    <script src="js/utf8.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
