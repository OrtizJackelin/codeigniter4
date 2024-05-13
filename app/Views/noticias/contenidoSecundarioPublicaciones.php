          

    <div class="categoriasEscritorio" >
        <p style=" margin:0px; padding: 10px; text-align: center;"><b>Categorías</b></p>

        <div   id="listaCategoriasEscritorio"   >
            <?php
                if (!empty($todasLasCategorias)){
                    echo (isset($todasLasCategorias) ? $todasLasCategorias : '');
                }

                if (!empty($listadoCategorias) && is_array($listadoCategorias)){

                    foreach($listadoCategorias as $items){    
                       if(isset($items)) echo($items);
                    } 
                }
            ?>
        </div> 
    </div>  

    <div class="categoriasMobile" >
                <div class="categoriaShowControl" >
                <p ><b>Categorías</b></p>
                     <span class="toggleList" data-bs-toggle="collapse" data-bs-target="#listaCategoriasMobile" aria-expanded="false" aria-controls="listaCategoriasMobile">
                        <i class="bi bi-arrow-down-square-fill" style="font-size: 1.3rem; color: cornflowerblue;" ></i>
                    </span>
                </div>
                
        <div   id="listaCategoriasMobile" class="collapse listaCategoriasMobile" >
            <?php
                if (!empty($todasLasCategorias)){
                    echo (isset($todasLasCategorias) ? $todasLasCategorias : '');
                }

                if (!empty($listadoCategorias) && is_array($listadoCategorias)){

                    foreach($listadoCategorias as $items){    
                       if(isset($items)) echo($items);
                    } 
                }
        ?>
        </div> 
    </div>  
