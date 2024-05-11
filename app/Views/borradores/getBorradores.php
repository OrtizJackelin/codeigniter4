<h5> <?php echo esc($tituloCuerpo)?></h5>
<a 
    <?php
        if ($offSet > 0) {
            echo "href=\"" . base_url("noticia/" . $idNoticia . "/borradores") . "?offset=" . $offSet-1 . "\"";
        }
    ?>
    style="display: flex; justify-content: left; align-items: left;"> Ver más recientes 
</a>

<a <?php
        if ($offSet < $total-2) {
            echo "href=\"" . base_url("noticia/" . $idNoticia . "/borradores") . "?offset=" . $offSet+1 . "\"";
        }
    ?>
    style="display: flex; justify-content: rigth; align-items: rigth;"> Ver más antigüos 
</a>

<table>
    <tr>
        <th></th>
        <th><?= esc($numero1)?></th>
        <th><?= esc($modificaciones)?></th>
        <th><?= esc($numero2)?></th>
    </tr>
  
    <tr>
        <td>Fecha</td>
        <td><input readonly type="text" name="fecha1"  value="<?= esc($fecha1)?>" class="form-control" ></td>
        <td></td>
        <td><input readonly type="text" name="fecha2"  value="<?= esc($fecha2)?>" class="form-control" ></td>
    </tr>
    <tr>
        <td>Categoria</td>
        <td><input readonly type="text" name="categoria1"  value="<?= esc($categoria1)?>" class="form-control" ></td>
        <td><?= esc($diferencia_categoria)?></td>
        <td><input readonly type="text" name="categoria2"  value="<?= esc($categoria2)?>" class="form-control" ></td>
    </tr>
    <tr>
        <td>Titulo</td>
        <td><input readonly type="text" name="titulo1"  value="<?= esc($titulo1)?>" class="form-control" ></td>
        <td><?= esc($diferencia_titulo)?></td>
        <td><input readonly type="text" name="titulo2"  value="<?= esc($titulo2)?>" class="form-control" ></td>
    </tr>
    <tr>
        <td>Descripcion</td>
        <td>
            <textarea readonly name="descripcion1" cols="45" rows="10" class="form-control">
                <?= esc($descripcion1)?>             
            </textarea>
        </td>
        <td><?= esc($diferencia_descripcion)?></td>
        <td>
            <textarea readonly name="descripcion2" cols="45" rows="10" class="form-control">
                <?= esc($descripcion2)?>             
            </textarea>
        </td>
    </tr>
    <tr>
        <td>Imagen</td>
        <td><input readonly type="text" name="imagen1"  value="<?= esc($imagen1)?>" class="form-control" ></td>
        <td><?= esc($diferencia_imagen)?></td>
        <td><input readonly type="text" name="imagen2"  value="<?= esc($imagen2)?>" class="form-control" ></td>
    </tr>

</table>