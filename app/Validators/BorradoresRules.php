<?php

namespace App\Validators;

use App\Models\ModeloNoticia;

class BorradoresRules
{

    public function maximoBorradoresActivos(string $value, string $fields, array $data): bool
    {
        $session = session();
        $modeloNoticia = model(ModeloNoticia::class);
        $cantidadBorradoresActivos = $modeloNoticia->obtenerCantidadNotciasActivasPorUsuario($session->id);
      
        if ($cantidadBorradoresActivos >= 3 && !isset($data['es_activo_original']) && $data['es_activo']>0) {
            return false;
        }
        return true;
    }

    public function getMessage(string $field, array $data): string
    {
        return "You cannot create a new active notice as you have reached the maximum limit of 4.";
    }

}