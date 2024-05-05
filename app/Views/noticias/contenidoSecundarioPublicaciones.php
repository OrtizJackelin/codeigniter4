          

    <p style=" background: #FCFCFC80; margin:0px; padding: 10px;
        background: radial-gradient(at left top, #ffffff14, #8e7f9826); text-align: center;"><b>Contenido</b></p>

    <div class = "table-responsive"  style="display: flex;  height:100%; flex-direction:column; overflow:auto;"    >
        <table class="table table-light table-striped table-hover"  id = "solicitudVerificacion" name = "solicitudVerificacion">
            <?php
            if (!empty($listadoNoticias) && is_array($listadoNoticias)){

                foreach($listadoNoticias as $items){    
                    echo "<tr>";   
                ?>
                    <td style="text-align: left;"><?php if(isset($items)) echo($items);?></td>
                <?php
                    echo "</tr>  ";                   
                } 
            }
            ?>
        </table>
    </div>   


