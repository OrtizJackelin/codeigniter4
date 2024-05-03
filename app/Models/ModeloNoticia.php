<?php
    namespace App\Models;
    use CodeIgniter\Model;

    class ModeloNoticia extends Model
    {

        protected $table = 'noticia';
        private $tablaBorrador = 'borrador';
        private $tablaCategoria = 'categoria';
        private $tablaEstadoNoticia = 'estado_noticia';
        protected $allowedFields = ['id_usuario', 'es_activo','titulo','id_categoria','descripcion'];

        public function obtenerNoticias($id = 0)
        {
            // Subconsulta para obtener la última fecha de modificación para cada ID
            $subconsulta = '(SELECT MAX(fecha_modificacion) FROM borrador WHERE noticia.id = borrador.id_noticia)';    
            $campos ="noticia.id as id, noticia.es_activo, borrador.fecha_modificacion as fecha, borrador.titulo, 
                    borrador.descripcion, borrador.id as id_borrador, borrador.imagen, categoria.nombre as categoria";   
            
            if($id > 0){
                $noticia =  $this->db->table($this->table)
                ->where('noticia.id', $id)
                ->join($this->tablaBorrador, 'noticia.id = borrador.id_noticia')
                ->where("$this->tablaBorrador.fecha_modificacion = $subconsulta")
                ->join($this->tablaCategoria, 'categoria.id = borrador.id_categoria') 
                ->select($campos)
                ->get()->getFirstRow('array'); 
                return $noticia;
            }

            // Realiza una consulta para unir las tablas y seleccionar los datos
            $noticia =  $this->db->table($this->table)
                        ->where('noticia.es_activo', '1')
                        ->join($this->tablaBorrador, "noticia.id = $this->tablaBorrador.id_noticia")
                        ->where("$this->tablaBorrador.fecha_modificacion = $subconsulta")
                        ->join($this->tablaCategoria, "$this->tablaCategoria.id = $this->tablaBorrador.id_categoria") 
                        ->select($campos)
                        ->get()->getResultArray();
            return $noticia;
                     
        }

        public function obtenerCantidadNotciasActivasEnBorradorPorUsuario($idUsuario){

            $subconsultaEstatus = '(SELECT MAX(id) FROM estado_noticia WHERE noticia.id = estado_noticia.id_noticia)';

            $noticias = $this->db->table($this->table)
                        ->where('noticia.id_usuario',$idUsuario)
                        ->join($this->tablaEstadoNoticia, 'noticia.id = estado_noticia.id_noticia')
                        ->where("estado_noticia.id = $subconsultaEstatus")
                        ->where('estado_noticia.id_estado', 2)
                        ->where('noticia.es_activo', true)
                        ->select('COUNT(*) as cantidad')                        
                        ->get()->getRow();

            if($noticias){           
                return $noticias->cantidad;
            } 
            
            return 0;
        }

        public function obtenerNoticiasUsuario($idUsuario){

            $subconsultaEstatus = '(SELECT MAX(id) FROM estado_noticia WHERE noticia.id = estado_noticia.id_noticia)';
            $subconsultaBorrador = '(SELECT MAX(id) FROM borrador WHERE noticia.id = borrador.id_noticia)';

            $noticias = $this->db->table($this->table)
                        ->where('noticia.id_usuario',$idUsuario)
                        ->join($this->tablaBorrador, 'noticia.id = borrador.id_noticia')
                        ->where("borrador.id = $subconsultaBorrador")
                        ->join($this->tablaEstadoNoticia, 'noticia.id = estado_noticia.id_noticia')
                        ->where("estado_noticia.id = $subconsultaEstatus")
                        ->join('estado', 'estado.id = estado_noticia.id_estado')
                        ->join('usuario', 'usuario.id = estado_noticia.id_usuario')
                        ->join($this->tablaCategoria, 'categoria.id = borrador.id_categoria')
                        ->select('noticia.id, noticia.es_activo, usuario.correo, estado.nombre as estado, titulo, 
                                categoria.nombre as categoria, estado_noticia.fecha as fechaEstatus')
                        ->get()->getResultArray();
            return $noticias;
        }

     /*   public function obtenerBorradoresNoticiaUsuario($idUsuario){

            $subconsultaBorrador = '(SELECT * FROM borrador WHERE noticia.id = borrador.id_noticia)';

            $noticias = $this->db->table($this->table)
                        ->where('id_noticia', $id_noticia);
                        ->where('estado', 2);
                        ->order_by('fecha', 'DESC');
                        ->get('borradores');
                        return $noticias;
        }*/
    }

