<?php require_once('../app/views/inc/header.php')?>

<div class="card">
    <div class="card-header">
        <h5 class="title">Actualizar Contraseña</h5>
        <a class="text-info" href="<?php echo ROUTE_URL?>/users"><i class="fas fa-step-backward"></i> Regresar</a>
    </div>
    <div class="card-body">
        <!-- Formulario nuevo usuario -->
        <form action="<?php echo ROUTE_URL?>/users/change_password/<?php echo $parameters['user']->id_user ?>" method="post"
            id="">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="first_name">Nombre</label>
                            <input type="text" class="form-control" name="first_name" id="first_name"
                                placeholder="Ingrese el nombre" value="<?php echo $parameters['user']->name ?>" disabled>
                        </div>
                     </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="last_name">Apellido</label>
                            <input type="text" class="form-control" name="last_name" id="last_name"
                                placeholder="Ingrese el apellido" value="<?php echo $parameters['user']->last_name ?>" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="birthdate">Fecha de nacimiento</label>
                            <input type="text" class="form-control" name="birthdate" id="birthdate"
                                placeholder="Ingrese fecha de nacimiento"
                                value="<?php echo date('Y-m-d', strtotime($parameters['user']->birthdate))?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="Sex">Sexo</label>
                            <input type="text" class="form-control" name="gender" id="gender"
                                value="<?php echo $var = ($parameters['user']->gender == 1)? 'Hombre' : 'Mujer'?>" disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label for="Type">Tipo de Usuario</label>
                          <input type="text" class="form-control" name="gender" id="gender"
                              value="<?php echo $var = ($parameters['user']->user_type == 1)? 'Usuario' : 'Administrador'?>" disabled>
                      </div>
                  </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="email" class="form-control" name="email" id="email"
                                placeholder="Ingrese un correo" value="<?php echo $parameters['user']->email ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" class="form-control" name="password" id="password"
                                placeholder="Ingrese la contraseña">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="password2">Contraseña</label>
                            <input type="password" class="form-control" name="password2" id="password2"
                                placeholder="Repetir contraseña">
                        </div>
                    </div>
                </div>
            </div>
            <input type="submit" class="btn btn-info" name="guardar" value="Guardar">

                 <!-- llamar las validaciones js -->
                 <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger errors" style="display:none" id="errores"></div>
                        </div>
                    </div>

                </div>

        </form>
    </div>
    <!-- Formulario nuevo usuario -->
</div>


<?php require_once('../app/views/inc/footer.php');
//Alertas
if ($parameters['alert'] == 'saved'){
    echo
    "<script>
        Swal.fire({
        title: 'Datos guardados',
        text: 'Contraseña modificada con exito',
        type: 'success',
        confirmButtonText: 'Aceptar'
      })
    </script>";
}
?>
