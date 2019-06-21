<?php require_once "../app/views/inc/header.php"?>
<div class="card">
    <div class="card-header">
        <h5 class="title">Viernes</h5>
    </div>
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-8">
                <b>Administración de inteligencia artificial</b>
            </div>
            <div class="col-md-4">
                <a href="<?php echo ROUTE_URL?>/friday/add" style="margin-top: -12px;" class="btn btn-info">Nueva entrada <i class="fas fa-comments" style="margin-left: 5px;"></i><i class="fas fa-plus fa-xs"></i></a>
            </div>
        </div>
        <hr>
        <br/>
        <br>
        <table class="table" id="entrys">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th width="40%">Respuestas</th>
                    <th>Palabras claves</th>
                    <th>Usuario que enseñó</th>
                    <th class="text-right">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($parameters['answers'] as $key => $answer):?>
                <tr>
                    <td><?php echo $answer['id_answer']?></td>
                    <td class="text-justify"><?php echo $answer['answer']?></td>
                    <td class="text-justify"><?php echo $answer['keywords']?></td>
                    <td class="text-justify"><?php echo $answer['user']?></td>
                    <td class="td-actions text-right">
                        <a href="<?php echo ROUTE_URL?>/friday/update/<?php echo $answer['id_answer']?>" rel="tooltip" class="btn btn-success btn-sm btn-icon">
                            <i class="tim-icons icon-settings"></i>
                        </a>
                    </td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>
<?php require_once "../app/views/inc/footer.php";
if ($parameters['alert'] == 'saved') {
    echo
    "<script>
        Swal.fire({
        title: 'Datos guardados',
        text: 'Nueva entrada guardada',
        type: 'success',
        confirmButtonText: 'Aceptar'
      })
    </script>";
}
?>
<script>
$(document).ready(function() {
    $('#entrys').DataTable({
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
