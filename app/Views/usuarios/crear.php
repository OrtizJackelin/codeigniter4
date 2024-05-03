
<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>
<section class = "sectionPrincipal">
          
    <div class="container w-75"  style = "margin-top: 40px;">

        <div class=" col-md-12 text-center" style=" margin-bottom: 40px">
            <h4> <?php echo esc($tituloCuerpo)?></h4>
        </div>

        <form class="row g-3 " name= "formulario" id="formulario" method="post" action="/usuario" enctype="multipart/form-data" >
        <?= csrf_field() ?>

            <div class="col-md-6">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name = "nombre" 
                value = "<?= set_value('nombre') ?>" pattern="[A-Za-z]{2,15}" required>
            </div>

            <div class="col-md-6">
                <label for="apellido" class="form-label">Apellido</label>
                <input type="text" class="form-control" id="apellido" name = "apellido" 
                value = "<?= set_value('apellido') ?>" pattern="[A-Za-z]{2,15}" required>
            </div>

            <div class="col-md-4">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name = "correo" 
                value = "<?= set_value('correo') ?>" >
            </div>

            <div class="col-md-4">
                <label for="clave" class="form-label">Password</label>
                <input type="password" id="clave" name="clave"  class="form-control" 
                    pattern="^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@#$%^&+=!])(?!.*\s).{8,}$" required>
            </div>

            <div class="col-md-4">
                <label for="repetirClave" class="form-label">Repetir Password</label>
                <input type="password" id="repetirClave" name="repetirClave"  class="form-control" 
                required>
            </div>

            <label>Seleccione Rol</label>
            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1"<?= set_value('es_activo_original', $es_activo_original) ?> name="rol[]">
                    <label class="form-check-label" for="flexCheckDefault1">
                        Validador
                    </label>
                </div>
            </div>

            <div class="col-6">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="2"<?= set_value('es_activo_original', $es_activo_original) ?> name="rol[]">
                    <label class="form-check-label" for="flexCheckDefault2">
                        Editor
                    </label>
                </div>
            </div>

            
            <div class="col-12 ">
                <button type="submit" class="btn btn-secondary" id="enviar" name = "enviar">ENVIAR</button>
            </div>
        </form><br>

        <label><h20>Nota:(Todos los campos son obligatorios, en roles debe seleccionar al menos uno)</h20></label>

        <div id="liveAlertPlaceholder"></div>      

        <?php
            /* if(!$valido){
                ?>
            <div class="alert alert-primary d-flex align-items-center alert-dismissible" role="alert" 
            style = "margin-top: 20px; margin-bottom: 5px;" type = "hidedeng">
                <?php include "../static/imagenes/redes/exclamation-triangle.svg" ?>                
                <div>
                    <H6><b><?php echo $mensaje ?></H6></b>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div> 
            <?php
            }*/
        ?>
    </div>
</section> 
