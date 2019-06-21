<?php require_once('../app/views/inc/header.php')?>

<div class="card">
    <div class="card-header">
        <h5 class="title">Actualizar Paciente</h5>
        <a class="text-info" href="<?php echo ROUTE_URL?>/patient"><i class="fas fa-step-backward"></i>
            Regresar</a>
    </div>
    <div class="card-body">
        <form action="<?php echo ROUTE_URL?>/patient/update/<?php echo $parameters['patient']->id_patient ?>" method="post">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" aria-describedby="emailHelp"
                            placeholder="Ingrese nombre" value="<?php echo $parameters['patient']->name?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="last_name">Apellido</label>
                        <input type="text" class="form-control" id="last_name" name="last_name"
                            aria-describedby="emailHelp" placeholder="Ingrese nombre" value="<?php echo $parameters['patient']->last_name?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="birthdate">Fecha de nacimiento</label>
                        <input type="text" class="form-control" id="birthdate" name="birthdate"
                            aria-describedby="emailHelp" placeholder="Ingrese fecha de nacimiento" value="<?php echo date_format(new DateTime($parameters['patient']->birthdate), 'Y-m-d')?>" >
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="">Sexo</label>
                    <div class="form-group form-inline">
                        <label class="form-check-label" style="margin-right: 20px">
                            <input class="form-check-input" type="radio" name="gender" id="gender" value="1"
                                accept="text/html" <?php echo $var = ($parameters['patient']->gender == 1)?'checked':'' ?>>
                            Hombre
                            <span class="form-check-sign"></span>
                        </label>
                        <label class="form-check-label">
                            <input class="form-check-input" type="radio" name="gender" id="gender" value="2"
                                accept="text/html" <?php echo $var = ($parameters['patient']->gender == 2)?'checked':'' ?>>
                            Mujer
                            <span class="form-check-sign"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="email">Correo electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
                            placeholder="Ingrese correo"  value="<?php echo $parameters['patient']->email?>">
                    </div>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-info">Guardar</button>

        </form>
    </div>
    <div class="card-footer">

    </div>
</div>
<?php require_once('../app/views/inc/footer.php');
//Alertas
if ($parameters['alert'] == 'saved') {
    echo
    "<script>
        Swal.fire({
        title: 'Datos guardados',
        text: 'Datos actualizados exitosamente',
        type: 'success',
        confirmButtonText: 'Aceptar'
      })
    </script>";
}
?>
