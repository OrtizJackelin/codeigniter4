          

    <p style=" background: #FCFCFC80; margin:0px; padding: 10px;
        background: radial-gradient(at left top, #ffffff14, #8e7f9826); text-align: center;"><b>Categorías</b></p>

    <div class = "table-responsive"  style="display: flex;  height:100%; flex-direction:column; overflow:auto;"    >
        <table class="table table-light  table-hover"  id = "listadoCategorias" name = "listadoCategorias">
            <?php
            if (!empty($todasLasCategorias)){
                /*echo "<tr>
                        <td style="text-align: left;"><?php if(isset($todasLasCategorias)) echo($todasLasCategorias);?></td>
                    </tr>";*/
                echo "<tr>
                        <td style=\"text-align: left; text-align:right; \">" . (isset($todasLasCategorias) ? $todasLasCategorias : '') . "</td>
                    </tr>";
            }

            if (!empty($listadoCategorias) && is_array($listadoCategorias)){

                foreach($listadoCategorias as $items){    
                    echo "<tr>";   
                ?>
                    <td style="text-align: left;text-align:right;"><?php if(isset($items)) echo($items);?></td>
                <?php
                    echo "</tr>  ";                   
                } 
            }
            ?>
        </table>
    </div>   


