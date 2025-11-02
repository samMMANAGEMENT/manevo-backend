<?php

namespace App\Http\Modules\Entidad\Model;

use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    protected $table = 'entities';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];
}
