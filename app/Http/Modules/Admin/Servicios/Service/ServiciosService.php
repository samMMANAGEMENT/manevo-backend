<?php

namespace App\Http\Modules\Admin\Servicios\Service;

use App\Http\Modules\Admin\Servicios\Model\Servicios;

class ServiciosService
{
    public function crearServicio(array $data, $entidadId)
    {
        $data['entidad_id'] = $entidadId;
        return Servicios::create($data);
    }

    public function obtenerServicios($entidadId)
    {
        return Servicios::where('entidad_id', $entidadId)->get();
    }

    public function modificarServicio(array $data, int $id)
    {
        return Servicios::where('id', $id)->update($data);
    }
}
