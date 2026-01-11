<?php

namespace App\Http\Modules\Categorias\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'name',
    ];
}
