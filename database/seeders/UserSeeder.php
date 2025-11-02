<?php

namespace Database\Seeders;

use App\Http\Modules\Operador\Model\Operador;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       // Crear usuario desarrollador
        $user = User::updateOrCreate(
            ['email' => 'samuel.pineda@devsuitpress.com'],
            [
                'password' => Hash::make('TkNAZ1X.'),
                'estado' => true,
                'entity_id' => 1,
            ]
        );

        // Asignar rol
        $user->assignRole('desarrollador');

        // Crear operador asociado
        Operador::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nombre' => 'Samuel',
                'apellido' => 'Pineda',
                'tipo_documento' => 'CC',
                'documento' => '1011390710',
                'telefono' => '3236374624'
            ]
        );

        // Crear usuario admin
        $admin = User::updateOrCreate(
            ['email' => 'admin@devsuitpress.com'],
            [
                'password' => Hash::make('TkNAZ1X.'),
                'estado' => true,
                'entity_id' => 1,
            ]
        );

        $admin->assignRole('admin');

        Operador::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'nombre' => 'admin',
                'apellido' => 'admin',
                'tipo_documento' => 'CC',
                'documento' => '1234567890',
                'telefono' => '3009876543'
            ]
        );
    }
}
