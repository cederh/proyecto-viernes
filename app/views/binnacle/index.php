<?php require_once "../app/views/inc/header.php"?>
<div class="card">
    <div class="card-header">
        <h5 class="title">Bitácora</h5>
    </div>
    <div class="card-body">
        <table class="table" id="binnacle">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Operación</th>
                    <th>Nombre de la tabla</th>
                    <th>Fecha</th>
                    <th>Opciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($parameters['registers'] as $key => $register):?>
                <tr>
                    <td class="text-center">
                            <?php echo $register->id_binnacle?>
                    </td>
                    <td>
                            <?php echo $register->operation?>
                    </td>
                    <td>
                        <?php echo $register->table_name?>
                    </td>
                    <td>
                            <?php echo $register->dt?>
                    </td>
                    <td>
                        <a href="<?php echo ROUTE_URL?>/binnacle/info/<?php echo $register->id_binnacle?>" class="btn btn-sm btn-info">
                            Ver detalles
                            <i class="fas fa-file-alt"></i>
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
<?php require_once "../app/views/inc/footer.php"?>

<script>
$(document).ready(function() {
    $('#binnacle').DataTable({
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