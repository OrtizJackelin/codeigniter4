
<div style="display: flex;flex-direction:column;  align-items:center; margin-top:20px" >               

    <div class = "container;" style="padding-top: 0px; flex:1; max-width:1000px; width:90%; height:100%;" >
        <table class="table  " id = "solicitudVerificacion" name = "solicitudVerificacion"
             style=" margin-top: 0%;">
             
            <?php
       
            if (!empty($noticias) && is_array($noticias)){   
     
                for ($i = 0; $i < count($titulos); $i++) {                  
                
                ?>
                    <tr>
                        <th colspan = 2 style="text-align: center; background:transparent; ">
                            <h2 style="font-weight: 600; " ><?= esc($titulos[$i])?></h2>
                            <h6 style="color:#808080!important; font-size: 13px; margin-top:-10px!important;  "> 
                            <em> <?= esc($subtitulos[$i])?></em></h6>
                        </th>
                    </tr>
                    <tr>
                        <td style="text-align: justify;flex-wrap:wrap-reverse;border-bottom-color :transparent;  
                            justify-content:space-evenly;  display:flex;">
                                
                            <p style="max-width: 600px; font-size:17px; font-weight:lighter;  padding:5px;" >
                                <?php echo word_limiter(esc($noticias[$i][0]), 100).($noticias[$i][2]); ?>
                            </p>

                            <div style="max-width:260px; overflow:hidden; padding:5px; display:flex; " >
                                <?= ($noticias[$i][1])?>                             
                            </div>
                                
                        </td>
                    </tr>
                <?php
                    
                }
            }else{
                ?>
                <div class = "container">
                    <p><H4>¡No se encontrarón noticias!</h4></p>
                </div>

                <?php
            }    
            ?>
        </table>
    </div> 
    
</div>
