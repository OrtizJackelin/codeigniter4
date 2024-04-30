<?php
namespace App\Controllers;
use App\Models\ModeloNoticia;
use App\Models\ModeloBorrador;
use App\Models\ModeloEstado;
use App\Models\ModeloCategoria;
use App\Models\ModeloEstadoNoticia;
use CodeIgniter\Exceptions\PageNotFoundException;
use  App\Validators\BorradoresRules;

class Noticia extends BaseController
{
    private $session;
    private $modeloNoticia;

    public function __construct()
    {
        $this->session = session();
        $this->modeloNoticia = model(ModeloNoticia::class);
    }

    public function index()
    {
        // Instancia del modelo
        $noticias = $this->modeloNoticia->obtenerNoticias();
        
        $noticiasTitulos = array_map(function($item) {
            $titulo = isset($item['titulo']) ? $item['titulo'] : 'No disponible';            
            return "$titulo";
        }, $noticias);

        $noticiasSubtitulos = array_map(function($item) {
            $categoria = isset($item['categoria']) ? $item['categoria'] : 'No disponible';
            $fecha = isset($item['fecha']) ? $item['fecha'] : 'Fecha No disponible';
            return "$categoria.  $fecha";
        }, $noticias);

        $noticiasInformacion = array_map(function($item) {
            $descripcion = isset($item['descripcion']) ? $item['descripcion'] : 'No disponible';
            $imagen = isset($item['imagen']) 
                                            ? '<a href="/noticia/' 
                                                    . esc($item['id'], 'url') . '">
                                                    <img src="' . esc($item['imagen'], 'url') 
                                                    . '" title="Imagen de la noticia">
                                                </a>'
                                            : 'No disponible';
          
            return [$descripcion, $imagen];
        }, $noticias);

        //mapeamos para el listado lateral cuerpo 2s
        $listaNoticiasTitulos = array_map(function($item) {
            if (isset($item['titulo'])) {
                $url = '/noticia/' . esc($item['id'], 'url');
                $titulo = $item['titulo'];
                return "<a href='$url'>$titulo</a>";
            } else {
                return "Título no disponible";
            }
        }, $noticias);


        //Para imprimir en consola////
        echo "<script>";
        echo "console.log('Lista:', " . json_encode($listaNoticiasTitulos) . ");";
        echo "</script>";
    
        $data = [
            'tituloCuerpo' => 'dNoticias',
            'tituloPagina' => 'Noticias',
            'titulos' => $noticiasTitulos,
            'subtitulos' => $noticiasSubtitulos,
            'noticias' => $noticiasInformacion,
            'listadoNoticias' => $listaNoticiasTitulos          
        ];

        // Cargar vistas y pasar datos
        $contenidoPrincipal = view('noticias/contenidoPrincipal', $data);
        $contenidoSecundario = view('noticias/contenidoSecundario', $data);
        $data['contenidoPrincipal'] = $contenidoPrincipal;
        $data['contenidoSecundario'] = $contenidoSecundario;

        // Cargar vista principal con la plantilla
        return view('plantillas/header', $data)            
            . view('plantillas/cuerpo', $data)
            . view('plantillas/footer');
    }
            /*$model = model(Nuevomodelo::class);*/
   
    public function detalleNoticia($idNoticia = 0){

        $data = [
            'noticia' => $this->modeloNoticia->obtenerNoticias($idNoticia),
            'tituloPagina' => 'Detalle Noticia',
        ];
        if(empty($data['noticia'])){
            throw new PageNotFoundException('No se encontro la noticia '.$idNoticia);
        }
        return view('plantillas/header',$data)
        .view('noticias/detalleNoticia')
        .view('plantillas/footer');
    }

    public function nueva(){

        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }

        $cantidadNoticiasActivas = $this->modeloNoticia->obtenerCantidadNotciasActivasPorUsuario($this->session->id);

        if($cantidadNoticiasActivas >= 3){
            return view('plantillas/header', ['tituloPagina' => 'Crear Noticia'])
                    .view('plantillas/mensajes',['mensaje'=>'Usted ya posee tres noticias activas, 
                                                            para crear una nueva noticia debe desactivar una'])
                    .view('plantillas/footer');
        }
        helper('form');

        $estadoModelo = model(ModeloEstado::class);
        $estados = $estadoModelo->find([1,2]);

        $categoriaModelo = model(ModeloCategoria::class);
        $categorias = $categoriaModelo -> findAll();

        return view('plantillas/header', ['tituloPagina' => 'Crear Noticia'])
            . view('noticias/postNueva', ['tituloCuerpo' => 'Crear Noticia', 
                                        'estados' => $estados, 'categorias' => $categorias])
            . view('plantillas/footer');

    }

    public function postNueva(){

        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }

        helper('form');
        $data = $this->request->getPost(['titulo', 'categoria', 'descripcion','imagen', 'estado']);

        if (!$this->validateData($data, [
            'titulo' => 'required|max_length[500]|min_length[3]',
            'categoria'  => 'required',
            'descripcion'  => 'required|max_length[20000]|min_length[10]',
            //'imagen'  => 'uploaded[imagen]|max_size[imagen,1024]|is_image[imagen] ',
            'estado' => 'required',
        ])) {
            // The validation fails, so returns the form.
            return $this->nueva();
        }
        // Gets the validated data.
        $datosValidados = $this->validator->getValidated();

        $modeloBorrador = model(ModeloBorrador::class);
        $modeloEstadoNoticia = model(ModeloEstadoNoticia::class);
        

        $idNoticia = $this->modeloNoticia->insert([
            'id_usuario' => $this->session->id,  /// aqui hay que colocar el $id 
            'es_activo' =>  1  // siempre se guarda la noticia en estado activo
        ]);

        if($idNoticia>0){
            $modeloBorrador->save([
                'id_noticia'=> $idNoticia, 
                'titulo' => $datosValidados['titulo'],
                'id_categoria'  => $datosValidados['categoria'],
                'descripcion'  => $datosValidados['descripcion'],
            ]);

            $modeloEstadoNoticia->save([
                'id_noticia'=> $idNoticia,
                'id_estado'=> $datosValidados['estado'],
                'id_usuario'=> $this->session->id,
            ]);

        }
        
        return view('plantillas/header',['tituloPagina'=>'Noticia Creada'])
        .view('plantillas/mensajes', ['mensaje'=>'Noticia creada con éxito'])
        .view('plantillas/footer');
    }

    public function misNoticias(){

        if($this->session->has('id')){
    
            $noticias = $this->modeloNoticia->obtenerNoticiasUsuario($this->session->id);

            //mapeamos para el contenido de la tabla
            $cabecera = ['T&iacute;tulo', 'Catagor&iacute;a', 'Estatus', 'Fecha/estatus', 'Responsable/estatus', 'Editar noticia','Ver borradores','Ver historial'];


            $contenidoNoticias = array_map(function($item) {
                // Verificar si las variables están definidas
                $titulo = isset($item['titulo']) ? esc($item['titulo']) : 'No disponible';
                $categoria = isset($item['categoria']) ? esc($item['categoria']) : 'No disponible';
                $estatus = isset($item['estado']) ? esc($item['estado']) : 'No disponible';
                $fecha = isset($item['fechaEstatus']) ? esc($item['fechaEstatus']) : 'No disponible';
                $responsable = isset($item['correo']) ? esc($item['correo']) : 'No disponible';
                $editarNoticia = '<a href="/noticia/editar_noticia/' . esc($item['id'], 'url') . '"> Editar </a>';     
                $verBorradores = '<a href="/noticia/' . esc($item['id'], 'url') . '"> Ver borradores </a>';       
                $verHistorial = '<a href="/noticia/historial' . esc($item['id'], 'url') . '"> Ver Historial </a>';     
                                                
                // Retornar un array con los valores
            //return ["<p><h2>{$titulo}</h2></p>", "<p>{$categoria}</p>", "<p>{$estatus}</p>", "<p>{$fecha}</p>","<p>{$url}</p>"];
            //////Probar esta forma/////////
                return [$titulo, $categoria, $estatus, $fecha, $responsable, $editarNoticia,$verBorradores,$verHistorial];
            }, $noticias);

            $estadoModelo = model(ModeloEstado::class);
            $estados = $estadoModelo->find([1,2]);
    
            $categoriaModelo = model(ModeloCategoria::class);
            $categorias = $categoriaModelo -> findAll();

            $data = [
                'tituloCuerpo' => 'Mis Noticias',
                'tituloPagina' => 'Mis Noticias',
                'cabecera' => $cabecera,
                'noticias' => $contenidoNoticias,        
            ];

            // Cargar vista principal con la plantilla
            return view('plantillas/header', $data)            
                . view('plantillas/tabla', $data)
                .view('plantillas/footer');

        }
        
    }

    public function editar($idNoticia){

        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }

    
        helper('form');
        $noticia = $this->modeloNoticia->obtenerNoticias($idNoticia);

        if(empty($noticia)){
            throw new PageNotFoundException('No se encontro la noticia '.$idNoticia);
        }

        $estadoModelo = model(ModeloEstado::class);
        $estados = $estadoModelo->find([1,2]);

        $categoriaModelo = model(ModeloCategoria::class);
        $categorias = $categoriaModelo -> findAll();

        return view('plantillas/header', ['tituloPagina' => 'Editar Noticia'])            
        . view('noticias/editarNoticia', ['tituloCuerpo' => 'Editar Noticia', 
                                            'estados' => $estados, 
                                            'categorias' => $categorias,
                                            'noticia' => $noticia])
        .view('plantillas/footer');
    }

    private function validarCantidad($cantidadBorradoresActivos, $original, $esValido) {
        if ($cantidadBorradoresActivos >= 3 && !$original && $esValido) {
            return false; // La validación falla si se cumple esta condición
        }
        return true; // La validación pasa si la condición no se cumple
    }

    public function postEditar(){

        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }
        helper('form');

        $data = $this->request->getPost(['titulo', 'categoria', 'descripcion','imagen', 
                                        'estado', 'es_activo', 'id','es_activo_original']);

        
        if(isset($data['es_activo']) && $data['es_activo'] != null){
            $data['es_activo'] = 1;
        }else{
            $data['es_activo'] = 0;
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'titulo' => 'required|max_length[500]|min_length[3]',
            'categoria'  => 'required',
            'descripcion'  => 'required|max_length[20000]|min_length[10]',
            'es_activo' => 'maximoBorradoresActivos[maximo]'
        ]);
        if (! $validation->run($data)) {
            return $this->editar($data['id']);
        }
        $datosValidados = $validation->getValidated();

/*
revisa que isset y diferente
        if($data['es_activo_original'] != $esValido){
            $this->modeloNoticia->update(['id'=> $data['id'], 'es_activo'=> $esValido]);
        }
  */

        $modeloBorrador = model(ModeloBorrador::class);
        $modeloEstadoNoticia = model(ModeloEstadoNoticia::class);
        


            $modeloBorrador->save([
                'id_noticia'=> $data['id'], 
                'titulo' => $datosValidados['titulo'],
                'id_categoria'  => $datosValidados['categoria'],
                'descripcion'  => $datosValidados['descripcion'],
            ]);

            $modeloEstadoNoticia->save([
                'id_noticia'=> $data['id'],
                'id_estado'=> $data['estado'],
                'id_usuario'=> $this->session->id,
            ]);

        
        
        return view('plantillas/header',['tituloPagina'=>'Noticia Editada'])
        .view('plantillas/mensajes', ['mensaje'=>'Noticia editada con éxito'])
        .view('plantillas/footer');
    }
    
    
}

