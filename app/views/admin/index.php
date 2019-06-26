<?php require_once "../app/views/inc/header.php"?>
<div class="row">
    <div class="col-md-4">
        <div class="card card-chart">
            <div class="card-header">
                <h3 class="card-title">Numero de pacientes </h3>
            </div>
            <div class="card-body text-center">
                <h2><i class="fas fa-file-medical text-info"></i> <?php echo $parameters['patients'] ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-chart">
            <div class="card-header">
                <h3 class="card-title">Numero de respuestas</h3>
            </div>
            <div class="card-body text-center">
                <h2><i class="fas fa-comment text-info"></i> <?php echo $parameters['answers'] ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card card-chart">
            <div class="card-header">
                <h3 class="card-title">Tests </h3>
            </div>
            <div class="card-body text-center">
                <h2><i class="fas fa-file-alt text-info"></i> 4</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <a href="<?php echo ROUTE_URL?>" class="btn btn-primary btn-block"><i class="fas fa-comments"></i> Acceder al chat</a>
    </div>
</div>
<?php require_once "../app/views/inc/footer.php"?>