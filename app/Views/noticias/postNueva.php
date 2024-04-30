
<?= session()->getFlashdata('error') ?>
<?= validation_list_errors() ?>

<section class = "sectionPrincipal">
            
    <div class="container">

        <div class=" col-md-12 text-center" style=" margin-top: 20px;">
            <h2> <?php echo esc($tituloCuerpo)?></h2>
        </div><br><br>

        <form class="row g-3 " name= "formulario" id="formulario" method="post" action="/noticia" enctype="multipart/form-data" >
            <?= csrf_field() ?>

            <div class="col-md-12">
                <label for="titulo"><b><h5>Título:</h5></b></label>
                <input type="text" name="titulo" value="<?= set_value('titulo') ?>" class="form-control" required>
            </div>

            <div class="col-md-4">
                <label for="titulo"><b><h5>Categoría:</h5></b></label>
                <select class="form-select" aria-label="Default select example" id="inputGroupSelect01" 
                                                                                name = "categoria" required>
                <option value="" <?= set_select('categoria', '') ?>>Seleccione</option>
                    <?php                     
                    if(isset($categorias) && is_array($categorias))
                    {             
                        foreach($categorias as $categoria){
                            ?>
                            <option value="<?= esc($categoria['id']);?>"<?= set_select('categoria', $categoria['id']) ?>>
                                            <?= esc($categoria['nombre']);?>
                            </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="col-md-12">
                <label for="descripcion"><b><h5>Descripción:</h5></b></label>
                <textarea name="descripcion" cols="45" rows="10" class="form-control"><?= set_value('descripcion') ?></textarea required>
                <br>
            </div>

            <label for="inputGroupFile02"><b><h5>Ingresar Imagen:</h5></b></label>
            <div class="input-group mb-3">
                <input type="file" class="form-control" id="inputGroupFile02">
                <label class="input-group-text" for="inputGroupFile02"><b>Upload</b></label>
            </div>

            <div class="col-md-4">
                <label for="titulo"><b><h5>Guardar como:</h5></b></label>
                <select class="form-select" aria-label="Default select example" id="inputGroupSelect01" name = "estado" required>
                    <option value="" <?= set_select('estado', '') ?>>Seleccione</option>
                    <?php 
                    
                    if(isset($estados) && is_array($estados))
                    {             
                        foreach($estados as $estado){
                            ?>
                            <option value="<?= esc($estado['id']);?>"<?= set_select('estado', $estado['id']) ?>><?= esc($estado['nombre']);?></option>
                            <?php
                        }
                    }
                    ?>
                </select>

            </div>

            <div class="col-12 ">
                    <button type="submit" class="btn btn-secondary" id="enviar" name = "enviar">GUARDAR</button>
            </div>
        </form><br>

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
