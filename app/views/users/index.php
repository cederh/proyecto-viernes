<?php require_once('../app/views/inc/header.php')?>
<style>
.modal-user {
    position: absolute;
    top: -130px;
    right: 100px;
    bottom: 0;
    left: 0;
    z-index: 10040;
    overflow: auto;
    overflow-y: auto;
}
</style>

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-md-6">
                <h5 class="title">Usuarios</h5>
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-info btn-fab btn-icon btn-round" data-toggle="modal" data-target="#new_user">
                    <i class="fas fa-user-plus"></i>
                </button>
                <button class="btn btn-danger btn-fab btn-icon btn-round" data-toggle="modal"
                    data-target="#disabled_user">
                    <i class="fas fa-user-lock"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <table class="table" id="users">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Sexo</th>
                    <th>Rol</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parameters['users'] as $key => $user):?>
                <tr>
                    <td class="text-center"><?php echo $user->id_user?></td>
                    <td><?php echo $user->name?></td>
                    <td><?php echo $user->age?></td>
                    <td><?php echo $var = ($user->gender == 1)?'Hombre':'Mujer'?></td>
                    <td><?php echo $var = ($user->user_type == 1)?'Usuario':'Administrador'?></td>
                    <td class="td-actions text-right">
                        <a href="<?php echo ROUTE_URL?>/users/update/<?php echo $user->id_user?>" rel="tooltip"
                            class="btn btn-info btn-sm btn-round btn-icon">
                            <i class="fas fa-user-edit"></i>
                        </a>
                        <a href="<?php echo ROUTE_URL?>/users/change_password/<?php echo $user->id_user?>" rel="tooltip"
                            class="btn btn-success btn-sm btn-round btn-icon">
                            <i class="fas fa-key"></i>
                        </a>
                        <a href="<?php echo ROUTE_URL?>/users/disable/<?php echo $user->id_user?>" rel="tooltip"
                            class="btn btn-danger btn-sm btn-round btn-icon">
                            <i class="fas fa-lock"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
    <div class="card-footer">

    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-user" id="new_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user-plus"></i> Nuevo usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Formulario nuevo usuario -->
            <form action="<?php echo ROUTE_URL?>/users/" method="post" id="form-usuario">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name">Nombre</label>
                                <input type="text" class="form-control" name="first_name" id="first_name"
                                    placeholder="Ingrese el nombre">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name">Apellido</label>
                                <input type="text" class="form-control" name="last_name" id="last_name"
                                    placeholder="Ingrese el apellido">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="birthdate">Fecha de nacimiento</label>
                                <input type="text" class="form-control" name="birthdate" id="birthdate"
                                    placeholder="YYYY-MM-DD">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="">Sexo</label>
                            <div class="form-group form-inline">
                                <label class="form-check-label" style="margin-right: 20px">
                                    <input class="form-check-input" type="radio" name="gender" id="gender" value="1">
                                    Hombre
                                    <span class="form-check-sign"></span>
                                </label>
                                <label class="form-check-label">
                                    <input class="form-check-input" type="radio" name="gender" id="gender" value="2">
                                    Mujer
                                    <span class="form-check-sign"></span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="user_type">Tipo de usuario</label>
                                <select class="form-control" name="user_type" id="user_type">
                                    <option value="1">Estándar</option>
                                    <option value="2">Administrador</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Correo</label>
                                <input type="email" class="form-control" name="email" id="email"
                                    placeholder="Ingrese un correo">
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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-danger errors" style="display:none" id="errores"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-info" name="guardar" value="Guardar">
                </div>
            </form>
            <!-- Formulario nuevo usuario -->
        </div>
    </div>
</div>

<!-- Usuarios desactivados -->
<div class="modal fade" id="disabled_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-user-lock"></i> Usuarios desactivados
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <table class="table" >
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Sexo</th>
                    <th>Rol</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parameters['disabled_users'] as $key => $user):?>
                <tr>
                    <td class="text-center"><?php echo $user->id_user?></td>
                    <td><?php echo $user->name?></td>
                    <td><?php echo $user->age?></td>
                    <td><?php echo $var = ($user->gender == 1)?'Hombre':'Mujer'?></td>
                    <td><?php echo $var = ($user->user_type == 1)?'Usuario':'Administrador'?></td>
                    <td class="td-actions text-right">
                        <a href="<?php echo ROUTE_URL?>/users/enable/<?php echo $user->id_user?>" rel="tooltip"
                            class="btn btn-info btn-sm btn-round btn-icon">
                            <i class="fas fa-unlock"></i>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>

        </div>
    </div>
</div>
<?php require_once('../app/views/inc/footer.php');

// Alertas
if ($parameters['alert'] == 'saved') {
    echo
    "<script>
        Swal.fire({
        title: 'Datos guardados',
        text: 'Nuevo usuario registrado exitosamente',
        type: 'success',
        confirmButtonText: 'Aceptar'
      })
    </script>";
} else if($parameters['alert'] == 'disabled'){
    echo
    "<script>
        Swal.fire({
        title: 'Usuario desactivado',
        text: 'Los cambios se efectuaran en el siguiente inicio de sesión',
        type: 'success',
        confirmButtonText: 'Aceptar'
      })
    </script>";
} else if($parameters['alert'] == 'enabled'){
    echo
    "<script>
        Swal.fire({
        title: 'Usuario activado',
        text: 'Ahora el usuario puede acceder al sistema nuevamente',
        type: 'success',
        confirmButtonText: 'Aceptar'
      })
    </script>";
}
?>

<script>
$(document).ready(function() {
    $('#users').DataTable({
        language: {
                    paginate: {
                        previous: "<i class='fas fa-angle-left'>",
                        next: "<i class='fas fa-angle-right'>"
                    },
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
    
                }
    });
} );
</script>
