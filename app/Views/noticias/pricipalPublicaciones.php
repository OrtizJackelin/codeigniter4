<?php
    $session = session();
    $mensaje = $session->getFlashdata('mensaje');

    // Verifica si hay un mensaje
    if ($mensaje !== null) {
    ?>
        <div id="liveAlertPlaceholder"></div>                 
        <div class="alert alert-primary d-flex align-items-center alert-dismissible" role="alert" 
            style = "margin-top: 20px; margin-bottom: 5px;" type = "hidedeng">
            <?php include "../public/imagenes/redes/exclamation-triangle.svg" ?> 

            <div>
                <H6><b><?= esc( $mensaje); ?></H6></b>                
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div> 
    <?php            
    }
?>

<div class="container-fluid" style="display: flex; overflow:hidden; " >
    <div class="row no-margin">
        <div class="col-md-10" style="display: flex; height:100%; flex-direction:column; overflow:auto;" >
            <div class="contenidoCuerpo">
                <?php echo $contenidoPrincipal; ?>
            </div>
        </div>
        <div class="col-md-2" style="padding:0px;" >
            <div class="barraLateral">
                <?php echo $contenidoSecundario; ?>
            </div>
        </div>
    </div>
</div>