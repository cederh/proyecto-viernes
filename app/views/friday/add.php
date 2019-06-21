<?php require_once('../app/views/inc/header.php')?>
<div class="card">
    <div class="card-header">
        <h5 class="title">Agregar nueva entrada</h5>
        <a class="text-info" href="<?php echo ROUTE_URL?>/friday"><i class="fas fa-step-backward"></i>
            Regresar</a>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            Ingrese un posible mensaje que pueda enviar un paciente, posteriormente ingrese la respuesta que debería dar viernes.
        </div>
        <form action="<?php echo ROUTE_URL?>/friday/add" method="post" id="form-add_friday">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="message">Mensaje</label>
                        <textarea name="message" id="message" class="form-control" cols="30" rows="10" required></textarea>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="answer">Respuesta</label>
                        <textarea name="answer" id="answer" class="form-control" cols="30" rows="10" required></textarea>
                    </div>
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-info">Guardar</button>

             <!-- llama los errores de las validaciones de js -->
             <div class="row">
              <div class="col-md-12">
                <div class="alert alert-danger errores" id="errores" style="display:none">

                </div>
                </div>
                </div>

        </form>

    </div>
    <div class="card-footer">

    </div>
</div>
<?php require_once('../app/views/inc/footer.php')?>