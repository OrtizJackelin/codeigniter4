<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\Noticia;
use App\Controllers\Usuario;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Noticia::index');
$routes->get('noticia', [Noticia::class, 'index']);           // mismo que la linea anterior pero cuando apuntan a noticia
$routes->get('noticia/nueva', [Noticia::class, 'nueva']);
$routes->post('noticia', [Noticia::class, 'postNueva']);
$routes->get('noticia/noticias', [Noticia::class, 'noticias']);
$routes->get('noticia/mis_noticias', [Noticia::class, 'misNoticias']);
$routes->get('noticia/nuevo_estado', [Noticia::class, 'cambiarEstadoYBoton']);
$routes->post('noticia/post_editar', [Noticia::class, 'postEditar']);
$routes->get('noticia/validar', [Noticia::class, 'historialParaValidar']);
$routes->post('noticia/post_validar', [Noticia::class, 'postDetalleParaValidar']);
$routes->get('noticia/historial/(:segment)', [Noticia::class, 'historialNoticia']);
$routes->get('noticia/(:segment)/deshacer_operacion/', [Noticia::class, 'deshacerUltimaOperacion']);
$routes->get('noticia/editar_noticia/(:segment)', [Noticia::class, 'editar']);
$routes->get('noticia/validar_noticia/(:segment)', [Noticia::class, 'detalleParaValidar']);
$routes->get('noticia/(:segment)', [Noticia::class, 'detalleNoticia']); // segment ->cuando no se el valor que llega en ese segmento no es conocido
$routes->get('usuario/nueva', [Usuario::class, 'nueva']);
$routes->post('usuario', [Usuario::class, 'crear']);
$routes->get('usuario/iniciar_sesion', [Usuario::class, 'iniciarSesion']);
$routes->post('usuario/validar', [Usuario::class, 'validarSesion']);
$routes->get('usuario/cerrar_sesion', [Usuario::class, 'cerrarSesion']);
