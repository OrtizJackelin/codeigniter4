<div class="container-fluid" >               
    <div class=" col-md-12 text-center" style=" margin-top: 40px;">
        <h2> <?php echo esc($tituloCuerpo)?></h2>
    </div>
    <div class = "table-responsive">
        <table class="table table-striped " id = "solicitudVerificacion" name = "solicitudVerificacion">

            <?php
            if (!empty($noticias) && is_array($noticias)){   
     
                for ($i = 0; $i < count($titulos); $i++) {
                ?>    
                    <tr>
                        <th colspan = 2 style="text-align: center;"><h3>
                            <?= esc($titulos[$i])?></h3><br>
                            <h6><?= esc($subtitulos[$i])?><h6>
                        </th>
                    </tr>
                    <tr>
                        <td>
                            <?=esc($noticias[$i][0])?>
                        </td>
                        <td style="text-align: right;">
                            <?= ($noticias[$i][1])?>
                        </td>
                    </tr>
                    <br>
                <?php
                }
            }    
            ?>
        </table>
    </div> 
    
</div>
