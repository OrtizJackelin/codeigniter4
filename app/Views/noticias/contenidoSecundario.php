          
    <div class = "table-responsive">
        <table class="table table-light table-striped table-hover" id = "solicitudVerificacion" name = "solicitudVerificacion">
            <tr>
                <th style="text-align: center;">Contenido</th>
            </tr>
            <?php
            if (!empty($listadoNoticias) && is_array($listadoNoticias)){

                //var_dump($listadoNoticias);
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

