<?php

namespace App\Http\Modules\Admin\Servicios\Model;

use App\Http\Modules\Entidad\Model\Entidad;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Servicios extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'nombre',
        'precio',
        'estado',
        'porcentaje_pago_empleado',
        'entidad_id'
    ];

    public function entidad()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id');
    }
}
