<?php

namespace App\Http\Modules\Productos\Models;

use App\Http\Modules\Categorias\Models\Categories;
use App\Http\Modules\Entidad\Model\Entidad;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'name',
        'cost_price',
        'sale_price',
        'stock',
        'active',
        'category_id',
        'entity_id',
    ];

    public function scopeByEntity($query, int $entityId)
    {
        return $query->where('entity_id', $entityId);
    }

    public function category()
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function entity()
    {
        return $this->belongsTo(Entidad::class, 'entity_id');
    }
}
