<?php
    namespace App\Models;
    use CodeIgniter\Model;

    class ModeloBorrador extends Model
    {
        protected $table = 'borrador';
        protected $allowedFields = ['id_noticia', 'titulo', 'id_categoria','descripcion', 'imagen'];
    }
?>