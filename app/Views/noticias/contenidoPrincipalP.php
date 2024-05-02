
<div style="display: flex;flex-direction:column;  align-items:center;" >               
    <div class=" col-md-12 text-center" style=" display:flex; flex-direction:column; align-items:center; padding:10px; ">
        <h2> <?php echo esc($tituloCuerpo)?></h2>
         <h6 style="color:#808080!important; font-size: 13px; margin-top:-10px!important;  "> <em> <?php echo esc($fechaDeHoy);  ?></em></h6>
    </div>
    <div class = "container;" style="padding-top: 0px; flex:1; max-width:1000px; width:90%; height:100%;" >
        <table class="table table-striped " id = "solicitudVerificacion" name = "solicitudVerificacion"
             style=" margin-top: 0%;">
             
            <?php
       
            if (!empty($noticias) && is_array($noticias)){   
     
                for ($i = 0; $i < count($titulos); $i++) {
                  
                
                    ?>
                        <tr>
                            <th colspan = 2 style="text-align: center;"><h4>
                                <?= esc($titulos[$i])?></h4>
                                <h6><?= esc($subtitulos[$i])?><h6>
                            </th>
                        </tr>
                        <tr>
                            <td style="text-align: justify;flex-wrap:wrap-reverse; justify-content:space-evenly;  display:flex;">
                                 
                                  <p style="max-width: 600px; padding:5px;" ><?php echo word_limiter(esc($noticias[$i][0]), 100).($noticias[$i][2]); ?></p>
                                  <div style="max-width:260px; overflow:hidden; padding:5px; display:flex; " >
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
