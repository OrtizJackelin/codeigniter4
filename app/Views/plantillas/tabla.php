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

<div class="container-fluid" > 

    <?php if(isset($tituloCuerpo)) {?>             
            <div class=" col-md-12 text-center" style=" margin-top: 20px;  margin-bottom: 40px">
                <h4> <?php  echo esc($tituloCuerpo)?></h4>
            </div>
    <?php
         }
    ?>

    <?php if(isset($titulo)) {?>             
            <div class=" col-md-12 text-center" style=" margin-top: 40px;">
                <h5> <?php  echo esc($titulo)?></h5>
            </div>
    <?php
         }
    ?>

    <?php if(isset($subTitulo)) {?>             
            <div class=" col-md-12 text-center" style=" margin-top: 10px; margin-bottom: 40px">
                <h8> <?php  echo esc($subTitulo)?></h8>
            </div>
    <?php
         }
    ?>

    <div class = "table-responsive">
        <table class="table table-striped table-hover" id = "solicitudVerificacion" name = "solicitudVerificacion">

            <?php
            if (!empty($noticias) && is_array($noticias)){ 
                echo"<tr>";
                foreach($cabecera as $titulo){
                    echo"<th><h7>$titulo</h7></th>";
                }
                echo"<tr>";
                foreach($noticias as $items){    
                    echo "<tr>";   
                    foreach($items as $item){
                        ?>
                        <td><?php if(isset($item)) echo($item);?></td>
                        <?php
                    }
                    echo "</tr>  ";                   
                } 
                

            }
            ?>
        </table>
    </div> 
</div>