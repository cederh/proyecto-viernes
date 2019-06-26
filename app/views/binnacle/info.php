<?php require_once "../app/views/inc/header.php"?>
<div class="card">
    <div class="card-header">
        <h5 class="title">Bitácora - información</h5>
        <a class="text-info" href="<?php echo ROUTE_URL?>/binnacle"><i class="fas fa-step-backward"></i> Regresar</a>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-info">
                    <div class="row">
                        <div class="col-md-4">
                            <b>Nombre de la tabla: </b> <?php echo $parameters['register']->table_name?>
                        </div>
                        <div class="col-md-4">
                            <b>Operación: </b> <?php echo $parameters['register']->operation?>
                        </div>
                        <div class="col-md-4">
                            <b>Fecha y hora: </b> <?php echo $parameters['register']->dt?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <?php if ($parameters['type'] == 'INSERT'):?>

        <table class="table">
            <thead>
                <tr>
                    <th>Columna</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parameters['new_data'] as $key => $data):?>
                <?php $temp_data = explode("=", $data)?>
                <tr>
                    <td><?php echo $temp_data[0]?></td>
                    <td><?php echo $temp_data[1]?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>

        <?php endif;?>

        <?php if ($parameters['type'] == 'DELETE'):?>

        <table class="table">
            <thead>
                <tr>
                    <th>Columna</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parameters['old_data'] as $key => $data):?>
                <?php $temp_data = explode("=", $data)?>
                <tr>
                    <td><?php echo $temp_data[0]?></td>
                    <td><?php echo $temp_data[1]?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>

        <?php endif;?>

        <?php if ($parameters['type'] == 'UPDATE'):?>
        <table class="table">
            <thead>
                <tr>
                    <th>Columna</th>
                    <th>Valor nuevo</th>
                    <th>Valor viejo</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($parameters['new_data'] as $key => $data):?>
            <?php $temp_new = explode("=", $data)?>
            <?php $temp_old = explode("=", $parameters['old_data'][$key])?>
            <tr class="<?php echo $var = ($temp_new[1] != $temp_old[1])? 'table-default' : ''?>">
                <td><?php echo $temp_new[0]?></td>
                <td><?php echo $temp_new[1]?></td>
                <td><?php echo $temp_old[1]?></td>
            </tr>
            <?php endforeach?>

            </tbody>
        </table>

        <?php if ($parameters['register']->table_name = 'TBL_USERS' && $parameters['register']->new_data == $parameters['register']->old_data):?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-success">
                            Se actualizo la contraseña del usuario
                        </div>
                    </div>
                </div>
            <?php endif;?>
        <?php endif;?>


    </div>
    <div class="card-footer">

    </div>
</div>
<?php require_once "../app/views/inc/footer.php"?>