<?php

namespace App\Http\Modules\Operador\Model;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Operador extends Model
{

    protected $table = 'operators';
    protected $fillable = [
        'nombre',
        'apellido',
        'tipo_documento',
        'documento',
        'user_id',
        'telefono',
    ];

    protected $appends = ['nombre_completo', 'tipo_documento_documento'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->nombre} {$this->apellido}";
    }

    public function getTipoDocumentoDocumentoAttribute(): string
    {
        return "{$this->tipo_documento} {$this->documento}";
    }
}
