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
<body>
    <header>
    <nav style=" padding: 2px; margin-left:0px!important; background:white; " 
        class=" navbar navbar-expand-lg navbar-dark sticky-top border-bottom background ">

        <div class="container-fluid">
            <div class= "container md-12">
                <a class="navbar-brand" href="../../noticia">
                <img src="../../imagenes/imagenesIndex/VamosGrande.png" alt="logo" width="400" height="auto"
                    class="d-inline-block align-text-top">
                </a>
                <p style = " font-weight: bold; font-size:12px; color:#7e7e7e;padding:0px; margin:0!important;">
                        <?php if($session->has('nombre')) echo "Hola " . $session->nombre . " ". $session->apellido;?>
                </p>
            </div>

            <div class="btn-group " style="margin-right:60px; z-index:1111;">
                <?php if ($session->has('id')) {  ?>
                    <a style="text-decoration:none; padding:0px; border-radius:0px; " class="dropdown-item"
                        href="../../noticia">
                        <button type="button" class="btn btn-success" style="height:100%;"> <img
                                src="../../imagenes/redes/person-circle.svg" alt="person-circle">
                        </button>
                    </a>
                
                <?php } else { ?>
                    <a style="text-decoration:none; padding:0px; border-radius:0px; " class="dropdown-item"
                    href="../../usuario/iniciar_sesion">
                        <button type="button" class="btn btn-success" style="height:100%;"> <img
                                src="../../imagenes/redes/person-circle.svg" alt="person-circle">
                        </button>
                    </a>
            
                <?php }?>
            

                <button type="button" class="btn btn-success dropdown-toggle dropdown-toggle-split"
                    data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                    <span class="visually-hidden">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-lg-end">
                    <?php
                    if ($session->has('id')) { 
                        if($session->has('esEditor')){//editor
                        ?>
                            <li><a class="dropdown-item" href="../../noticia/mis_noticias">Mis noticias</a></li>
                            <li><a class="dropdown-item" href="../../noticia/nueva">Crear nueva noticia</a></li>
                            <li><a class="dropdown-item" href="">Solicitudes</a></li>
                    
                        <?php
                        } 
                        if($session->has('esValidador')) {//validador
                        ?>
                            <li><a class="dropdown-item" href="">Mis Actividades</a></li>
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
        </div>
    </nav>
    </header>
    
