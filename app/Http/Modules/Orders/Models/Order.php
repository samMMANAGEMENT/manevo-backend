<?php

namespace App\Http\Modules\Orders\Models;

use App\Http\Modules\Entidad\Model\Entidad;
use App\Http\Modules\Orders\Models\OrderItem;
use App\Http\Modules\Orders\Models\Payment;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'entity_id',
        'status',
        'total',
    ];

    public const STATUS_DRAFT = 'DRAFT';
    public const STATUS_PAID = 'PAID';
    public const STATUS_CANCELLED = 'CANCELLED';

    public function scopeByEntity($query, int $entityId)
    {
        return $query->where('entity_id', $entityId);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'order_id');
    }

    public function entity()
    {
        return $this->belongsTo(Entidad::class, 'entity_id');
    }
}
