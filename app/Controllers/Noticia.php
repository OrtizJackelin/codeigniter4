<?php
namespace App\Controllers;
use App\Models\ModeloNoticia;
use App\Models\ModeloBorrador;
use App\Models\ModeloEstado;
use App\Models\ModeloCategoria;
use App\Models\ModeloEstadoNoticia;
use CodeIgniter\Exceptions\PageNotFoundException;
use  App\Validators\BorradoresRules;
use CodeIgniter\I18n\Time;


class Noticia extends BaseController
{
    private $session;
    private $modeloNoticia;

    public function __construct()
    {   
        helper(['form', 'text', 'time']);
        //helper('text');
        $this->session = session();
        $this->modeloNoticia = model(ModeloNoticia::class);
       
    }
 

    public function index()
    {
        // Instancia del modelo
        $noticias = $this->modeloNoticia->obtenerNoticias();      
  
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
        // Establecer la configuración regional en español
        setlocale(LC_TIME, 'es_AR');       
 
        $fechaHoraActual = Time::now(); // Obtener la fecha y hora actual

        // Formatear la fecha y hora en español
        $fechaFormateada = $fechaHoraActual->toLocalizedString('dd MMMM yyyy  hh:mm:ss ');

        //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        
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
                                            ? '<a href="' . site_url("/noticia/" . esc($item['id'], 'url')) . '">
                                            <img src="' . site_url("imagenesNoticia/" . esc($item['imagen'], 'url')) . '" 
                                                 title="Imagen de la noticia" class="img-fluid" 
                                                 style="max-width: 324px; max-height: 168px;">
                                          </a>'
                                            : 'No disponible';
            $urlNoticia = isset($item['id']) 
                                            ?'<a href="' . site_url("/noticia/" . esc($item['id'], 'url')) . '" style="text-decoration: none;">
                                                Ver más
                                             </a>'
                                            : 'No disponible';
          
            return [$descripcion, $imagen, $urlNoticia];
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
            'listadoNoticias' => $listaNoticiasTitulos,
            'fechaDeHoy'  => $fechaFormateada,
        ];
        

        // Cargar vistas y pasar datos
        $contenidoPrincipal = view('noticias/contenidoPrincipalP', $data);
        $contenidoSecundario = view('noticias/contenidoSecundarioPublicaciones', $data);
        $data['contenidoPrincipal'] = $contenidoPrincipal;
        $data['contenidoSecundario'] = $contenidoSecundario;

        // Cargar vista principal con la plantilla
        return view('plantillas/header', $data)            
            . view('noticias/pricipalPublicaciones', $data)
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
        .view('noticias/detalleNoticia',$data)
        .view('plantillas/footer');
    }

    public function misNoticias(){

        if($this->session->has('id')){
    
            $noticias = $this->modeloNoticia->obtenerNoticiasUsuario($this->session->id);

            //mapeamos para el contenido de la tabla
            $cabecera = ['T&iacute;tulo', 'Catagor&iacute;a', 'Estado', 'Estatus', 'Fecha/estatus', 'Responsable/estatus', 'Editar noticia','Ver borradores','Ver historial'];


            $contenidoNoticias = array_map(function($item) {
                // Verificar si las variables están definidas
                $titulo = isset($item['titulo']) ? esc($item['titulo']) : 'No disponible';
                $categoria = isset($item['categoria']) ? esc($item['categoria']) : 'No disponible';
                $estado = isset($item['es_activo']) ? esc($item['es_activo']) : 'No disponible';
                $estatus = isset($item['estado']) ? esc($item['estado']) : 'No disponible';
                $fecha = isset($item['fechaEstatus']) ? esc($item['fechaEstatus']) : 'No disponible';
                $responsable = isset($item['correo']) ? esc($item['correo']) : 'No disponible';
                $editarNoticia = '<a href="/noticia/editar_noticia/' . esc($item['id'], 'url') . '"> Editar </a>';     
                $verBorradores = '<a href="/noticia/' . esc($item['id'], 'url') . '"> Ver </a>';       
                $verHistorial = '<a href="/noticia/historial' . esc($item['id'], 'url') . '"> Ver </a>';     
                                                
                // Retornar un array con los valores
            //return ["<p><h2>{$titulo}</h2></p>", "<p>{$categoria}</p>", "<p>{$estatus}</p>", "<p>{$fecha}</p>","<p>{$url}</p>"];
            //////Probar esta forma/////////
                return [$titulo, $categoria, $estado, $estatus, $fecha, $responsable, $editarNoticia,$verBorradores,$verHistorial];
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
////////////////////////////////////////////////////////////////////////EDITAR Y POST//////////////////////////////////////////////////////////////

    public function editar($idNoticia){

        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }
    
        $noticia = $this->modeloNoticia->obtenerNoticias($idNoticia);

        if(empty($noticia)){
            throw new PageNotFoundException('No se encontro la noticia '.$idNoticia);
        }

        $estadoModelo = model(ModeloEstado::class);
        $estados = $estadoModelo->find([1,2,12,13]);

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
     
        $data = $this->request->getPost(['titulo', 'categoria', 'descripcion', 
                                        'estado', 'es_activo', 'id','es_activo_original']);

        $imagen = $this->request->getFile('imagen');

                
        if(isset($data['es_activo']) && $data['es_activo'] != null){
            $data['es_activo'] = 1;
        }else{
            $data['es_activo'] = 0;
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'titulo' => 'required|max_length[500]|min_length[3]',
            'categoria'  => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Seleccione una categoría',
                ],
            ],
            'descripcion'  => 'required|max_length[20000]|min_length[10]',
            'imagen'  => 'uploaded[imagen]|max_size[imagen,524]|is_image[imagen]|max_dims[imagen,800,500]|permit_empty ',
            'es_activo' => [
                    'rules' => 'maximoBorradoresActivos[maximo]',
                    'errors' => [
                        'maximoBorradoresActivos' => 'No puede guardar como borrador porque 
                                    supera el máximo de borradoes activos permitidos'
                    ]
            ],
        ]);

        if (! $validation->run($data)) {
            return $this->editar($data['id']);
        }
        $datosValidados = $validation->getValidated();

      
        //Covertir de string a entero
        $data['es_activo_original'] = intval($data['es_activo_original']);

    
      //revisa que isset y diferente para hacer el upDate en la bd
        if($data['es_activo_original'] != $data['es_activo'] ){
            $this->modeloNoticia->save(['id'=> $data['id'], 'es_activo'=> $data['es_activo']]);
        }
       
  
        $modeloBorrador = model(ModeloBorrador::class);
        $modeloEstadoNoticia = model(ModeloEstadoNoticia::class);
        


        $idBorrador = $modeloBorrador->insert([
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

        if(!$imagen->isValid()){
            echo $imagen->getErrorString();
            //exit;
        } elseif(!$imagen->hasMoved()){

            $ruta = ROOTPATH . 'public/imagenesNoticia';
            $extension = pathinfo($imagen->getName(), PATHINFO_EXTENSION);            
            $imagen->move($ruta,$idBorrador.'.'.$extension);
            $nombreArchivo = $idBorrador.'.'.$extension;

            $modeloBorrador->save(['id'=> $idBorrador, 'imagen'=> $nombreArchivo]);
        }

     
   
      
        return view('plantillas/header',['tituloPagina'=>'Noticia Editada'])
        .view('plantillas/mensajes', ['mensaje'=>'Noticia editada con éxito'])
        .view('plantillas/footer');
    }

    ////////////////////////////////////////////////////////NUEVA Y POST/////////////////////////////////////////////////////////////////////////

    public function nueva(){

        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }
      

        $estadoModelo = model(ModeloEstado::class);
        $estados = $estadoModelo->find([1,2]);

        $categoriaModelo = model(ModeloCategoria::class);
        $categorias = $categoriaModelo -> findAll();

        return view('plantillas/header', ['tituloPagina' => 'Crear Noticia'])
            . view('noticias/nueva', ['tituloCuerpo' => 'Crear Noticia', 
                                        'estados' => $estados, 'categorias' => $categorias])
            . view('plantillas/footer');

    }


    public function postNueva() {

        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }
     
        $data = $this->request->getPost(['titulo', 'categoria', 'descripcion', 
                                        'estado', 'es_activo', 'id']);

        $imagen = $this->request->getFile('imagen');
        $data['es_activo_original'] = "1";
                
        if(isset($data['es_activo']) && $data['es_activo'] != null){
            $data['es_activo'] = 1;
        }else{
            $data['es_activo'] = 0;
        }

        $validation = \Config\Services::validation();
        $validation->setRules([
            'titulo' => 'required|max_length[500]|min_length[3]',
            'categoria'  => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Seleccione una categoría',
                ],
            ],
            'descripcion'  => 'required|max_length[20000]|min_length[10]',
            //'imagen'  => 'max_size[imagen,1000]|max_dims[imagen,1024,800]|mime_in[imagen,image/png,image/jpeg,image/avif ]', no lee avif
            'es_activo' => [
                    'rules' => 'maximoBorradoresActivos[maximo]',
                    'errors' => [
                        'maximoBorradoresActivos' => 'No puede guardar como borrador porque 
                                    supera el máximo de borradoes activos permitidos'
                    ]
            ],
        ]);


        if (!$validation->run($data)) {
            return $this->nueva();
        }
        $datosValidados = $validation->getValidated();

        $modeloBorrador = model(ModeloBorrador::class);
        $modeloEstadoNoticia = model(ModeloEstadoNoticia::class);

        $idNoticia = $this->modeloNoticia->insert([
            'id_usuario' => $this->session->id,  /// aqui hay que colocar el $id 
            'es_activo' =>  $data['es_activo'],
        ]);

        if($idNoticia>0){
            $idBorrador = $modeloBorrador->insert([
                'id_noticia'=> $idNoticia, 
                'titulo' => $datosValidados['titulo'],
                'id_categoria'  => $datosValidados['categoria'],
                'descripcion'  => $datosValidados['descripcion'],
            ]);
    
            $modeloEstadoNoticia->save([
                'id_noticia'=> $idNoticia,
                'id_estado'=> $data['estado'],
                'id_usuario'=> $this->session->id,
            ]);

            if(!$imagen->isValid()){              //////REVISAR
                echo $imagen->getErrorString();

               // $this->session->set_flashdata('error_imagen', $imagen->getErrorString()); para guardar el error en una variable de seccion que luego se elimina sola "flashdata"
                //redirect('tu_controlador/tu_metodo');
                // //if ($this->session->flashdata('error_imagen'))://Para la vista
                //exit;
            } else{
                if(!$imagen->hasMoved()){            //////REVISAR
                    $ruta = ROOTPATH . 'public/imagenesNoticia';
                    $extension = pathinfo($imagen->getName(), PATHINFO_EXTENSION);            
                    $imagen->move($ruta,$idBorrador.'.'.$extension);
                    $nombreArchivo = $idBorrador.'.'.$extension;
        
                    $modeloBorrador->save(['id'=> $idBorrador, 'imagen'=> $nombreArchivo]);
                }
            } 
        }              
        return view('plantillas/header',['tituloPagina'=>'Noticia Creada'])
        .view('plantillas/mensajes', ['mensaje'=>'Noticia creada con éxito'])
        .view('plantillas/footer');
    } 
    
}

