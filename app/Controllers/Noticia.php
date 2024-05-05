<?php
namespace App\Controllers;
use App\Models\ModeloNoticia;
use App\Models\ModeloBorrador;
use App\Models\ModeloEstado;
use App\Models\ModeloCategoria;
use App\Models\ModeloEstadoNoticia;
use CodeIgniter\Exceptions\PageNotFoundException;
use  App\Validators\MisRules;
use CodeIgniter\I18n\Time;



class Noticia extends BaseController
{
    private $session;
    private $modeloNoticia;
    private $fechaHoraActual;

    public function __construct()
    {   
        helper(['form', 'text', 'time']);
        setlocale(LC_TIME, 'es_AR'); 
        $this->session = session();
        $this->modeloNoticia = model(ModeloNoticia::class);
        $this->fechaHoraActual =Time::now();
       
    }
 
    public function formatearFecha($fecha){
        $fechaFormateada = new \CodeIgniter\I18n\Time($fecha);
        return  $fechaFormateada->toLocalizedString('dd MMMM yyyy  hh:mm:ss ');
    }

    private function enlaceEnImagenVerDetalleNoticia($id, $imagen){
        return '<a href="' . site_url("/noticia/" . esc($id, 'url')) . '">
                <img src="' . site_url("imagenesNoticia/" . esc($imagen, 'url')) . '" 
                     title="Imagen de la noticia" class="img-fluid" 
                     style="max-width: 324px; max-height: 168px;">
                </a>';
    }

    private function enlaceEnNoticiaVerDetalleNoticia($id){
        return '<a href="' . site_url("/noticia/" . esc($id, 'url')) . '" style="text-decoration: none;">
                    Ver más
                </a>';
    }

   /* private function enlaceEnListadosTituloVerDetalleNoticia($id,$titulo){   
        $url = '/noticia/' . esc($id, 'url');
        $titulo = $titulo;
        return "<a href='$url'>$titulo</a>";
    }*/

    public function index()
    {
        // Instancia del modelo
        $noticias = $this->modeloNoticia->obtenerNoticias();      
  
        //setlocale(LC_TIME, 'es_AR');   

        $noticiasTitulos = array_map(function($item) {
            $titulo = isset($item['titulo']) ? $item['titulo'] : 'No disponible';            
            return "$titulo";
        }, $noticias);

        $noticiasSubtitulos = array_map(function($item) {
            $categoria = isset($item['categoria']) ? $item['categoria'] : 'No disponible';
            $fecha = isset($item['fecha']) ? $this->formatearFecha($item['fecha']) : 'Fecha No disponible';
            return "$categoria.  $fecha";
        }, $noticias);

        //var_dump($noticias);
        $noticiasInformacion = array_map(function($item) {
            $descripcion = isset($item['descripcion']) ? $item['descripcion'] : 'No disponible';
            $imagen = (isset($item['imagen']) && $item['imagen']!= "") 
                            ? $this->enlaceEnImagenVerDetalleNoticia($item['id'],$item['imagen']) 
                            : $this->enlaceEnImagenVerDetalleNoticia($item['id'],"imagen-no-disponible.jpeg");
            $urlNoticia = isset($item['id']) ? $this->enlaceEnNoticiaVerDetalleNoticia($item['id']): 'No disponible';          
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


        $fechaHoyFormateda = $this->formatearFecha($this->fechaHoraActual);

        $data = [
            'tituloCuerpo' => 'dNoticias',
            'tituloPagina' => 'Noticias',
            'titulos' => $noticiasTitulos,
            'subtitulos' => $noticiasSubtitulos,
            'noticias' => $noticiasInformacion,
            'listadoNoticias' => $listaNoticiasTitulos,
            'fechaDeHoy'  => $fechaHoyFormateda,
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

    private function esActivo($es_activo){
        if(isset($es_activo)){
            if($es_activo == 1 ){
                return 'Activo';
            }else{
                return 'Inactivo';
            } 
        } else{
            return 'No disponible';
        }
    }

    private function enlaceEditar($estado, $id){
        if(isset($estado)){
            if($estado === 'Borrador'  || $estado === 'Corregir'){
                return '<a href="/noticia/editar_noticia/' . esc($id, 'url') . '" 
                            style="display: flex; justify-content: center; align-items: center;">
                            Editar 
                        </a>';
            }else{
                return 'n/a';
            } 
        } else{
            return 'No disponible';
        }
    }

    private function enlaceValidar($id){

        if(isset($id)){
            return '<a href="/noticia/validar_noticia/' . esc($id, 'url') . '" 
                        style="display: flex; justify-content: center; align-items: center;">
                        Ver
                    </a>'; 
        } else{
            return 'No disponible';
        }
    }

    private function verBorradores($id){

        /*return '<a href="/noticia/' . esc($id, 'url') . '" 
                    style="display: flex; justify-content: center; align-items: center;"> 
                    Ver 
                </a>'; */
    }

    private function verHistorial($id){

        return '<a href="/noticia/historial/' . esc($id, 'url') . '"
                    style="display: flex; justify-content: center; align-items: center;">
                    Ver 
                </a>';    
    }

    private function botonActivar($estado, $esActivo, $id){

        $cantidadBorradoresActivos = $this->modeloNoticia->obtenerCantidadNotciasActivasEnBorradorPorUsuario($this->session->id);
       
        if(isset($esActivo) && isset($estado)){

            $url = base_url('noticia/nuevo_estado') . '?esActivo=' . $esActivo . '&id=' . $id. '&estado=' . $estado;  
            
            if($estado === "Borrador"){
                if($esActivo == 0 &&  $cantidadBorradoresActivos >= 3){
                    return '<button type="buttom" style = "min-width: 82px!important;" 
                            class="btn btn-secondary btn-block mt-2 btn-sm disabled" id="cancelar" name="inhabilitar_borrador"
                                onclick="window.location.href=\'' . $url . '\' " disabled>
                                Activar
                            </button>';
               
                } 
                if($esActivo === "0" &&  $cantidadBorradoresActivos < 3){
                    return '<button type="buttom" style = "min-width: 82px!important;" class="btn btn-secondary btn-block mt-2 btn-sm" id="cancelar" name="activar_borrador"
                                onclick="window.location.href=\'' . $url . '\' ">
                                Activar
                            </button>';
                
                }else{
                    return '<button type="buttom"  style = "min-width: 82px!important;" class="btn btn-secondary btn-block mt-2 btn-sm" id="cancelar" name="desactivar_borrador"
                                onclick="window.location.href=\'' . $url . '\'">
                                Desactivar
                            </button>';
                }
            }  
            if($estado === "Validar"){
                if($esActivo === "0"){   
                    return '<button type="buttom" style="min-width: 82px!important;" class="btn btn-secondary btn-block mt-2 btn-sm " id="cancelar" name="activar_validar"
                                onclick="window.location.href=\'' . $url . '\'">
                                    Activar
                            </button>';
                
                } else {
                    return '<button type="buttom" style = "min-width: 82px!important;" class="btn btn-secondary btn-block mt-2 btn-sm" id="cancelar" name="desactivar_validar"
                                onclick="window.location.href=\'' . $url . '\'">
                                Desactivar
                            </button>';
                            
                }    

            }
        }else{
            return 'No disponible';
        }
    }

    public function cambiarEstadoYBoton(){
     
        $esActivo = $this->request->getVar('esActivo');
        $id = $this->request->getVar('id');
        $estado = $this->request->getVar('estado');

        if(isset($estado) && isset($esActivo) && isset($id)){
            if($esActivo === "1"){
                $esActivo = 0;
                $this->modeloNoticia->save(['id'=> $id, 'es_activo'=> $esActivo]);
                return redirect()->to(base_url('noticia/mis_noticias'));
            }

            if($esActivo === "0"){
                $esActivo = 1;
                $this->modeloNoticia->save(['id'=> $id, 'es_activo'=> $esActivo]);
                return redirect()->to(base_url('noticia/mis_noticias'));
            }

            
        }
       
       
    }

    public function misNoticias(){

        if ($this->session->has('id')) {

            if($this->session->has('esEditor') && $this->session->esEditor ==1){

                $noticias = $this->modeloNoticia->obtenerNoticiasUsuario($this->session->id);
         
                //mapeamos para el contenido de la tabla
                $cabecera = ['T&iacute;tulo', 'Categor&iacute;a', 'Estado', 'Estatus', 'Fecha/estatus', 'Responsable/estatus', 
                            'Editar','Borradores','Historial', 'Acci&oacute;n'];

                

                $contenidoNoticias = array_map(function($item) {
                    // Verificar si las variables están definidas
                    $titulo = isset($item['titulo']) ? esc($item['titulo']) : 'No disponible';
                    $categoria = isset($item['categoria']) ? esc($item['categoria']) : 'No disponible';
                    $estado = $this->esActivo($item['es_activo']);                
                    $estatus = isset($item['estado']) ? esc($item['estado']) : 'No disponible';
                    $fecha = isset($item['fechaEstatus']) ? esc($item['fechaEstatus']) : 'No disponible';
                    $responsable = isset($item['correo']) ? esc($item['correo']) : 'No disponible';                    
                    $editarNoticia = $this->enlaceEditar($item['estado'], $item['id']);
                    $verBorradores = $this->verBorradores($item['id']);     
                    $verHistorial = $this->verHistorial($item['id']);
                    $accion = $this->botonActivar($item['estado'],$item['es_activo'],$item['id']);            
                    return [$titulo, $categoria, $estado, $estatus, $fecha, $responsable, $editarNoticia,
                            $verBorradores,$verHistorial, $accion];
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
            //'imagen'  => 'uploaded[imagen]|max_size[imagen,524]|is_image[imagen]|max_dims[imagen,800,500]|permit_empty ',
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

        if($imagen->isValid()){
            
            if(!$imagen->hasMoved()){
                $ruta = ROOTPATH . 'public/imagenesNoticia';
                $extension = pathinfo($imagen->getName(), PATHINFO_EXTENSION);            
                $imagen->move($ruta,$idBorrador.'.'.$extension);
                $nombreArchivo = $idBorrador.'.'.$extension;

                $modeloBorrador->save(['id'=> $idBorrador, 'imagen'=> $nombreArchivo]);
            }
        } else{

            echo $imagen->getErrorString();
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
            'imagen'  => 'uploaded[imagen]|max_size[imagen,1000]|is_image[imagen]|max_dims[imagen,1000,900]',// no lee avif
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
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function historialNoticia($idNoticia){
        
        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }

        $noticia = $this->modeloNoticia->obtenerNoticias($idNoticia);
        $noticiaHistorial = $this->modeloNoticia->obtenerHistorialNoticia($idNoticia);
        $cabecera = ['Estado', 'Responsable', 'Fecha/Modificaci&oacute;n', 'Observaciones'];

        $titulo = isset($noticia['titulo']) ? $noticia['titulo'] : 'No disponible';      

        $categoria = isset($noticia['categoria']) ? $noticia['categoria'] : 'No disponible';
        $fecha = isset($noticia['fecha']) ? $noticia['fecha'] : 'Fecha No disponible';

        $subtitulo = $categoria."     ".$fecha;      


        $historial = array_map(function($item) {
            $estado = isset($item['estado']) ? $item['estado'] : 'No disponible';
            $responsable = isset($item['responsable']) ? $item['responsable'] : 'Fecha No disponible';
            $fecha = isset($item['fecha']) ? $item['fecha'] : 'Fecha No disponible';
            $observaciones = isset($item['observaciones']) ? $item['observaciones'] : 'Fecha No disponible';
            return [$estado, $responsable, $fecha, $observaciones];
        }, $noticiaHistorial);

    
        $data = [
            'tituloCuerpo' => "Historial de noticias",
            'titulo' => $titulo,
            'subTitulo' => $subtitulo,
            'tituloPagina' => 'Histrorial de noticias',
            'cabecera' => $cabecera,
            'noticias' => $historial,        
        ];

          //Cargar vista principal con la plantilla
        return view('plantillas/header', $data)            
            . view('plantillas/tabla', $data)
            .view('plantillas/footer');
        

    }
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    public function historialParaValidar(){

        if (!$this->session->has('id')  || !$this->session->has('esValidador') || !$this->session->esValidador ==1) {
            return redirect()->to(base_url());
        }          
    
        $noticias = $this->modeloNoticia->obtenerNoticiasParaValidar();
          //mapeamos para el contenido de la tabla
        $cabecera = ['T&iacute;tulo', 'Categor&iacute;a', 'Fecha/estatus', 'Responsable/estatus', 
                    'Ver']; 

        $contenidoNoticias = array_map(function($item) {
            // Verificar si las variables están definidas
            $titulo = isset($item['titulo']) ? esc($item['titulo']) : 'No disponible';
            $categoria = isset($item['categoria']) ? esc($item['categoria']) : 'No disponible';
            $fecha = isset($item['fecha']) ? esc($item['fecha']) : 'No disponible';
            $responsable = isset($item['correo']) ? esc($item['correo']) : 'No disponible';                    
            $ver = $this->enlaceValidar($item['id']);      
            return [$titulo, $categoria, $fecha, $responsable, $ver];
        }, $noticias);


        $data = [
            'tituloCuerpo' => 'Validaciones',
            'tituloPagina' => 'Validaciones',
            'cabecera' => $cabecera,
            'noticias' => $contenidoNoticias,        
        ];

        // Cargar vista principal con la plantilla
        return view('plantillas/header', $data)            
            . view('plantillas/tabla', $data)
            .view('plantillas/footer');

    }

    public function detalleParaValidar($idNoticia){

        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }
    
        $noticia = $this->modeloNoticia->obtenerNoticias($idNoticia);

        if(empty($noticia)){
            throw new PageNotFoundException('No se encontro la noticia '.$idNoticia);
        }

        $estadoModelo = model(ModeloEstado::class);

        $cantidadVecesEnEstadoValidar = $this->modeloNoticia->obtenerCantindadVcesEnEstadoValidar($noticia['id']);

        if($cantidadVecesEnEstadoValidar > 1){
            $estados = $estadoModelo->find([5,10]);
        } else{
            $estados = $estadoModelo->find([5,9,10]);
        }        

        $categoriaModelo = model(ModeloCategoria::class);
        $categorias = $categoriaModelo -> findAll();
      
        return view('plantillas/header', ['tituloPagina' => 'Ver noticias para validar'])            
        . view('noticias/detalleParaValidar', ['tituloCuerpo' => 'Noticia para validar', 
                                            'estados' => $estados, 
                                            'categoria' => $categorias,
                                            'noticia' => $noticia])
        .view('plantillas/footer');
        }

    public function postDetalleParaValidar(){

        if(!$this->session->has('id')){
            return redirect()->to(base_url());
        }

        $data = $this->request->getPost(['id', 'estado', 'observaciones']);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'estado' => 'required',
        ]);

        if (! $validation->run($data)) {
            return $this->detalleParaValidar($data['id']);
        }
        $datosValidados = $validation->getValidated();

        $modeloEstadoNoticia = model(ModeloEstadoNoticia::class);
        $modeloEstadoNoticia->save([
            'id_noticia'=> $data['id'],
            'id_estado'=> $data['estado'],
            'observaciones'=> $data['observaciones'],
            'id_usuario'=> $this->session->id,            
        ]);

        $mensaje = "¡Cambios guardados con exito!";
        $this->session->setFlashdata('mensaje', $mensaje);
    
        
        $mensaje = $this->session->getFlashdata('mensaje');
        // Redirecciona a la siguiente página
        return redirect()->to('noticia/validar');

        
    }

}

