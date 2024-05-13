
<div class="container-fluid" >               
    <div class=" col-md-12 text-center" style=" margin-top: 40px;">
        <h2> <?php echo esc($tituloCuerpo)?></h2>
        <h6> <?php echo esc($fechaDeHoy);  ?></h6><br><br>
    </div>
    <div class = "container;">
        <table class="table table-striped " id = "solicitudVerificacion" name = "solicitudVerificacion"
             style=" margin-top: 0%;">
             
            <?php
       
            if (!empty($noticias) && is_array($noticias)){   
     
                for ($i = 0; $i < count($titulos); $i++) {
                  
                
                    ?>
                        <tr>
                            <th colspan = 2 style="text-align: center;"><h3>
                                <?= esc($titulos[$i])?></h3>
                              <p style="color:#808080!important; background:tan; "> <em> <?= esc($subtitulos[$i])?></em><p>
                            </th>
                        </tr>
                        <tr>
                            <td style="text-align: justify;">
                                <?php echo word_limiter(esc($noticias[$i][0]), 100).($noticias[$i][2]); ?>
                            </td>
                            <td style="text-align: right;">
                                <div class = container>
                                    <?= ($noticias[$i][1])?>                             
                                </div>
                            </td>
                        </tr>
                    <?php
                    
                }
            }    
            ?>
        </table>
    </div> 
    
</div>
