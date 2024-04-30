<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<section class = "sectionPrincipal">
    <div class=" col-md-12 text-center" style=" margin-top: 20px;">
        <h4> <?php echo esc($tituloCuerpo)?></h4>
    </div>

    <div class = "container" style=" margin-top: 40px;">
        <form class="row g-5 p-5 " id="formulario" method="post" action="/usuario/validar" >
        <?= csrf_field() ?>

            <div class="col-md-4 m-5">
                <label for="email" class="form-label"><b>Email</b></label>
                <input type="email" class="form-control" id="email" name = "correo" value = "" required>
            </div>

            <div class="col-md-4 m-5">
                <label for="clave" class="form-label"><b>Password</b></label>
                <input type="password" id="clave" name="clave"  class="form-control" 
                    pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&+=!])(?!.*\s).{8,}$"required>
            </div>         

            <div class="col-12 m-5">
                <button type="submit" class="btn btn-success" id="enviar" name = "enviar" style = "width: 100px">Iniciar</button>
            </div>

        </form>

        <div id="liveAlertPlaceholder"></div>      

        <?php
           /*  if (isset($errors)){
                ?>
            <div class="alert alert-primary d-flex align-items-center alert-dismissible" role="alert" 
            style = "margin-top: 20px; margin-bottom: 5px;" type = "hidedeng">
                <?php include "../static/imagenes/redes/exclamation-triangle.svg" ?>                
                <div>
                    <H6><b><?php echo $errors; ?></H6></b>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div> 
            <?php
            }*/
        ?>
    </div>
</section>
