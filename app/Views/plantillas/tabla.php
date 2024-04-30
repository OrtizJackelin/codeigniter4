<div class="container-fluid" >               
    <div class=" col-md-12 text-center" style=" margin-top: 20px;">
        <h4> <?php echo esc($tituloCuerpo)?></h4>
    </div>
    <div class = "table-responsive">
        <table class="table table-striped table-hover" id = "solicitudVerificacion" name = "solicitudVerificacion">

            <?php
             //var_dump($noticias);
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