<?php
    $session = session();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../estilos/style.css" type="text/css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../estilos/bootstrap.min.css">
    <link rel="stylesheet" href="../../estilos/bootstrap-icons.css">
    <link href="../../estilos/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!--<script type="text/javascript" src="../../js/validaciones.js"></script>-->
  
    <title><?php echo esc($tituloPagina)?></title>
</head>
<body  >
    <header>
    <nav style="display:flex; align-items: center; justify-content:space-between; padding: 2px; margin:0px!important; background:white; " 
        class=" sticky-top border-bottom background "><!--le saque el overflow:hidden; en style-->

        <div class= "container-fluid">
            <a class="navbar-brand" href="../../noticia">
            <img src="../../imagenes/imagenesIndex/Dnoticias2.png" alt="logo" 
                    style=" max-height:60px; margin:5px; " width="auto"
                class="d-inline-block align-text-top">
            </a>
        </div>

        <div class= "container ml-auto" style = "text-align: right;">
            <div class="btn-group " style="margin:4px; z-index:1111;  max-height: 36px;">
                <?php if ($session->has('id')) {  ?>
                    <a style="text-decoration:none; padding:0px; border-radius:0px; " class="dropdown-item"
                        href="../../noticia">
                        <button type="button" class="btn btn-primary" style="height:100%;"> <img
                                src="../../imagenes/redes/person-circle.svg" alt="person-circle">
                        </button>
                    </a>
                
                <?php } else { ?>
                    <a style="text-decoration:none; padding:0px; border-radius:0px; " class="dropdown-item"
                    href="../../usuario/iniciar_sesion">
                        <button type="button" class="btn btn-primary" style="height:100%;"> <img
                                src="../../imagenes/redes/person-circle.svg" alt="person-circle">
                        </button>
                    </a>
            
                <?php }?>
            

                <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-end">
                    <?php
                    if ($session->has('id')) { 
                        if($session->has('esEditor') && $session->esEditor ==1){//editor
                        ?>
                            <li><a class="dropdown-item" href="../../noticia/mis_noticias">Mis noticias</a></li>
                            <li><a class="dropdown-item" href="../../noticia/nueva">Crear nueva noticia</a></li>
                    
                        <?php
                        } 
                        if($session->has('esValidador') && $session->esValidador ==1) {//validador
                        ?>
                            <li><a class="dropdown-item" href="../../noticia/validar">Mis Validaciones</a></li>
                            <li><a class="dropdown-item" href="">Publicar</a></li>
                            

                        <?php 
                        } 
                        ?>                     
                        <li><a class="dropdown-item" href="../../usuario/cerrar_sesion">Cerrar sesión</a></li>
                        <?php
                    } else { ?>
                    <li><a class="dropdown-item" href="../../usuario/iniciar_sesion">Iniciar Sesion</a></li>
                    <li><a class="dropdown-item" href="../../../usuario/nueva">Registrarse</a></li>
                    <?php }?>
                </ul>

                
            </div>

            <p style = " font-weight: bold; font-size:12px; color:#7e7e7e;padding:0px; margin:0!important;">
                        <?php if($session->has('nombre')) echo "<em> Hola " . $session->nombre . " ". $session->apellido . "</em>";?>
            </p>
        </div>
        
    </nav>
    </header>
 

    
