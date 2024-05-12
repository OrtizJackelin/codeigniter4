<div class = "container" style="align-content:center">
    <div class=" col-md-12 text-center" style=" margin: 40px;">
        <h4> <?php echo esc($tituloCuerpo)?></h4>
    </div>

    <div class="row" style = "margin-bottom:20px">
        <div class="col-md-6" style="margin-bottom:10px;" >
            <a 
            <?php
                if ($offSet > 0) {
                    echo "href=\"" . base_url("noticia/" . $idNoticia . "/borradores") . "?offset=" . $offSet-1 . "\"";
                }
                ?>
                style="display: flex; justify-content: left; align-items: left;"> Ver más recientes 
            </a>
        </div>

        <div class="col-md-6" style=" margin-bottom:10px; display: flex; justify-content: rigth; align-items: rigth; text-align:right" >
            <a <?php
                if ($offSet < $total-2) {
                    echo "href=\"" . base_url("noticia/" . $idNoticia . "/borradores") . "?offset=" . $offSet+1 . "\"";
                }
                ?>
                style="display: flex; justify-content: rigth; align-items: rigth !important; text-align:right"> 
                
                     Ver más antigüos <i class="bi bi-arrow-left-square-fill"></i>
            </a>

        </div>
    </div>

    <div class="row" style = "margin-bottom:20px">
        <div class="col-md-6" style=" height:100%; flex-direction:column; overflow:auto;" >
            <?= esc($numero1)?>          
        </div>

        <div class="col-md-6" style=" height:100%; flex-direction:column; overflow:auto;" >
            <?= esc($numero2)?>              
        </div>
    </div>
    

    <div class="row no-margin">
        <div class="col-md-6" style="align-items: rigth; display: flex; height:100%; flex-direction:column; overflow:auto;" >
            <table> 
                <tr>
                    <td>Fecha</td>
                    <td></td>
                </tr>
            
                <tr>
                    <td><input readonly type="text" name="fecha1"  value="<?= esc($fecha1)?>" class="form-control" ></td>
                </tr>

                <tr>
                    <td>Categoria</td>
                    <td></td>
                </tr>

                <tr>
                    <td><input readonly type="text" name="categoria1"  value="<?= esc($categoria1)?>" class="form-control" ></td>
                    <td><?= esc($diferencia_categoria)?></td>
                </tr>

                <tr>
                    <td>Titulo</td>
                    <td></td>
                </tr>

                <tr>
                    
                    <td><input readonly type="text" name="titulo1"  value="<?= esc($titulo1)?>" class="form-control" ></td>
                    <td><?= esc($diferencia_titulo)?></td>
                </tr>

                <tr>
                    <td>Descripcion</td>
                    <td></td>
                </tr>

                <tr>        
                    <td>
                        <textarea readonly name="descripcion1" cols="45" rows="10" class="form-control">
                            <?= esc($descripcion1)?>             
                        </textarea>
                    </td>
                    <td><?= esc($diferencia_descripcion)?></td>

                </tr>

                <tr>
                    <td>Imagen</td>
                    <td></td>
                </tr>

                <tr>        
                    <td><input readonly type="text" name="imagen1"  value="<?= esc($imagen1)?>" class="form-control" ></td>
                    <td><?= esc($diferencia_imagen)?></td>
                </tr>
            </table>
        </div>


        <div class="col-md-6" style="align-items: left; display: flex; height:100%; flex-direction:column; overflow:auto;" >
            <table>
                <tr>
                    <td>Fecha</td>
                </tr>
            
                <tr>
                    <td><input readonly type="text" name="fecha2"  value="<?= esc($fecha2)?>" class="form-control" ></td>
                </tr>

                <tr>
                    <td>Categoria</td>
                </tr>

                <tr>
                    <td><input readonly type="text" name="categoria2"  value="<?= esc($categoria2)?>" class="form-control" ></td>
                </tr>

                <tr>
                    <td>Titulo</td>
                </tr>

                <tr>                 
                    <td><input readonly type="text" name="titulo2"  value="<?= esc($titulo2)?>" class="form-control" ></td>
                </tr>

                <tr>
                    <td>Descripcion</td>
                </tr>

                <tr>        
                    
                    <td>
                        <textarea readonly name="descripcion2" cols="45" rows="10" class="form-control">
                            <?= esc($descripcion2)?>             
                        </textarea>
                    </td>
                </tr>

                <tr>
                    <td>Imagen</td>
                </tr>

                <tr>        
                    
                    <td><input readonly type="text" name="imagen2"  value="<?= esc($imagen2)?>" class="form-control" ></td>
                </tr>
            </table>
        </div>
    </div>
</div>