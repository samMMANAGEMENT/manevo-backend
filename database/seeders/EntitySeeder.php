<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('entities')->updateOrInsert(
            ['id' => 1],
            [
                'nombre' => 'Suitpress',
                'descripcion' => 'Entidad por defecto del sistema',
                'estado' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
