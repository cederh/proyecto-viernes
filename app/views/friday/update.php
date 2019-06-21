<?php require_once('../app/views/inc/header.php')?>
<div class="card">
    <div class="card-header">
        <h5 class="title">Perfil del paciente</h5>
        <a class="text-info" href="<?php echo ROUTE_URL?>/friday"><i class="fas fa-step-backward"></i>
            Regresar</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <p>Palabras claves</p>
                    </div>
                    <div class="col-md-6 text-right">
                        <button style="top: -20px;margin-bottom: -20px;margin-top: 0px;"
                            class="btn btn-info btn-fab btn-icon btn-round btn-sm" data-toggle="modal"
                            data-target="#new_keyword">
                            <!-- <i class="fas fa-comment"></i> -->
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <hr>
                <?php foreach ($parameters['keywords'] as $key => $keyword):?>
                <div class="row">
                    <div class="col-md-6">
                        <p><?php echo $keyword['keyword']?></p>
                    </div>
                    <div class="col-md-6 text-right">
                        <button style="top: -20px;margin-bottom: -20px;margin-top: 0px;"
                            class="btn btn-danger btn-fab btn-icon btn-round btn-sm" data-toggle="modal"
                            data-target="#del_<?php echo $keyword['id']?>">
                            <!-- <i class="fas fa-comment"></i> -->
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <hr>
                <?php endforeach;?>
            </div>
            <div class="col-md-6">
                <p>Respuesta</p>
                <hr>
                <p class="text-justify"><?php echo $parameters['entry'][0]->answer?></p>
                <br>
                <button class="btn btn-default" data-toggle="modal" data-target="#edit_answer"><i class="fas fa-edit"></i> Modificar</button>
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="col-md-12">
                Información de registro
                <hr>
                <p>Entrada registrada por <b><?php echo $parameters['entry'][0]->user_insert?></b> fecha de registro
                    <b><?php echo date_format(new DateTime($parameters['entry'][0]->insert_date), 'd-m-Y H:i:s')?></b>
                </p>
                <?php if ($parameters['entry'][0]->insert_date != $parameters['entry'][0]->update_date ):?>
                <p>Entrada registrada por <b><?php echo $parameters['entry'][0]->user_update?></b> fecha de registro
                    <b><?php echo date_format(new DateTime($parameters['entry'][0]->update_date), 'd-m-Y H:i:s')?></b>
                </p>
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="card-footer">

    </div>
</div>

<style>
.modal-user {
    position: absolute;
    /* top: -130px; */
    right: 100px;
    bottom: 0;
    left: 0;
    z-index: 10040;
    overflow: auto;
    overflow-y: auto;
}
</style>

<!-- Modal -->
<div class="modal fade modal-user" id="new_keyword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-comment"></i><i
                        class="fas fa-plus fa-xs"></i> Agregar palabra clave</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Formulario nuevo usuario -->
            <form action="<?php echo ROUTE_URL?>/friday/update/<?php echo $parameters['id']?>" method="post"
                id="form-usuario">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="keyword">Palabra clave</label>
                                <input type="text" class="form-control" name="keyword" id="keyword"
                                    placeholder="Ingrese una palabra clave" required>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-info" name="save_keyword" value="Guardar">
                </div>
            </form>
            <!-- Formulario nuevo usuario -->
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade modal-user" id="edit_answer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-comment"></i><i
                        class="fas fa-plus fa-xs"></i> Modificar respuesta </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Formulario nuevo usuario -->
            <form action="<?php echo ROUTE_URL?>/friday/update/<?php echo $parameters['id']?>" method="post"
                id="form-usuario">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="answer">Respuesta</label>
                                <textarea name="answer" id="answer" rows="4" class="form-control" required><?php echo $parameters['entry'][0]->answer ?></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <input type="submit" class="btn btn-info" name="save_answer" value="Guardar">
                </div>
            </form>
            <!-- Formulario nuevo usuario -->
        </div>
    </div>
</div>

<?php foreach ($parameters['keywords'] as $key => $keyword):?>
<!-- Modal -->
<div class="modal fade modal-user" id="del_<?php echo $keyword['id']?>" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-comment"></i><i
                        class="fas fa-minus fa-xs"></i> Eliminar palabra clave</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h3>¿Desea eliminar esta palabra clave?</h3>
                <h4>"<?php echo $keyword['keyword']?>"</h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <a href="<?php echo ROUTE_URL?>/friday/delete_keyword/<?php echo $keyword['id']?>/<?php echo $parameters['id']?>"
                    class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>
<?php endforeach;?>

<!-- Modals para eliminar palabras -->
<?php require_once('../app/views/inc/footer.php');
// Alertas
if ($parameters['alert'] == 'saved') {
    echo
    "<script>
        Swal.fire({
        title: 'Datos guardados',
        text: 'Nueva palabra añadida a esta entrada',
        type: 'success',
        confirmButtonText: 'Aceptar'
      })
    </script>";
}else if ($parameters['alert'] == 'delete') {
    echo
    "<script>
        Swal.fire({
        title: 'Datos eliminados',
        text: 'Se elimino la palabra calve',
        type: 'success',
        confirmButtonText: 'Aceptar'
      })
    </script>";
}else if ($parameters['alert'] == 'saved_answer') {
    echo
    "<script>
        Swal.fire({
        title: 'Datos guardados',
        text: 'Se actualizo la respuesta',
        type: 'success',
        confirmButtonText: 'Aceptar'
      })
    </script>";
}
?>
