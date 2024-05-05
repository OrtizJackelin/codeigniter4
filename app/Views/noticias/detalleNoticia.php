           
    <?php
    
    if (!empty($noticia)){            
    ?>   

    <article>
        <div class = "container" >
            <div class = "row g-2">                       
                <div class="col-md-12">
                    <div style=" text-align: center;">
                        <label id = "titulo" style = "text-align: center; margin-top: 40px"><b><h2>
                            <?php if(isset($noticia['titulo'])) echo($noticia['titulo']); ?></h2></b>
                        </label>                  
                    </div>
                </div> 

                <div class="col-md-12">
                    <div style=" text-align: center;">
                        <label id = "categoria" style = "text-align: center"><b><h6>
                            <?php if(isset($noticia['categoria']) 
                                    && isset($noticia['fecha'])) 
                                        echo $noticia['categoria'] . " ". $noticia['fecha']; 
                            ?></h6></b>
                        </label>                   
                    </div>
                </div>
            </div> 
         
            <div class = "row g-2">                     
                <div class="col-md-7" >
                    <div >
                        <label id = "descripcion" ><h8>
                            <?php if(isset($noticia['descripcion'])) echo($noticia['descripcion']); ?></h8></b>
                        </label>                  
                    </div>
                </div> 

                <div class="col-md-5">
                    <div >
                        <label id = "imagen" style = "text-align: center"><b><h8>
                            <div class = "container">
                                <img src="<?php if(isset($noticia['imagen']) && $noticia['imagen']!= ""){
                                                    echo "../../imagenesNoticia/".$noticia['imagen']; 
                                                }else{
                                                    echo "../../imagenesNoticia/"."imagen-no-disponible.jpeg";
                                                }
                                            ?>" 
                                    class="img-fluid" alt="..."  style="max-width: 524px; max-height: 368px;"></h8></b>
                            </div>
                        </label>                  
                    </div>
                </div>        
            </div>
    </article>
    <?php
    } 
    ?>

</body>
</html>
