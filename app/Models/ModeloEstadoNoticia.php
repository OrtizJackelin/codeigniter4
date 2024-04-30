<?php
    namespace App\Models;
    use CodeIgniter\Model;

    class ModeloEstadoNoticia extends Model
    {
        protected $table = 'estado_noticia';
        protected $allowedFields = ['id_usuario','id_noticia','id_estado','observaciones'];

    }
?>