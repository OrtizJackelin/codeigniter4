           
    <?php
    
    if (!empty($noticia)){            
    ?>   

    <article>
        <div class = container style="width: 70%">
            <div class = "row g-2">                       
                <div class="col-md-12">
                    <div style=" text-align: center;">
                        <label id = "titulo" style = "text-align: center"><b><h2>
                            <?php if(isset($noticia->titulo)) echo($noticia->titulo); ?></h2></b>
                        </label>                  
                    </div>
                </div> 

                <div class="col-md-12">
                    <div style=" text-align: center;">
                        <label id = "categoria" style = "text-align: center"><b><h6>
                            <?php if(isset($noticia->categoria) 
                                    && isset($noticia->fecha_modificacion) 
                                    && isset($noticia->id_usuario) ) 
                                        echo $noticia->categoria . " ". $noticia->fecha_modificacion. " ". $noticia->id_usuario; 
                            ?></h6></b>
                        </label>                   
                    </div>
                </div>
            </div> 
         
            <div class = "row g-2">                     
                <div class="col-md-9" style = " width : 50%">
                    <div >
                        <label id = "descripcion" style = "text-align: center"><b><h8>
                            <?php if(isset($noticia->descripcion)) echo($noticia->descripcion); ?></h8></b>
                        </label>                  
                    </div>
                </div> 

                <div class="col-md-3">
                    <div >
                        <label id = "titulo" style = "text-align: center"><b><h8>
                            <?php if(isset($noticia->titulo)) echo($noticia->titulo); ?></h8></b>
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
