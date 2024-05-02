<?php

namespace App\Validators;

use App\Models\ModeloNoticia;

class BorradoresRules
{

    public function maximoBorradoresActivos(string $value, string $fields, array $data): bool
    {
        $session = session();
        $modeloNoticia = model(ModeloNoticia::class);
        $cantidadBorradoresActivos = $modeloNoticia->obtenerCantidadNotciasActivasEnBorradorPorUsuario($session->id);
      
        if ($cantidadBorradoresActivos >= 3 && $data['es_activo_original']=="1" && $data['es_activo']>0 && $data['estado'] == "2") {
            return false;
        }
        return true;
    }
}