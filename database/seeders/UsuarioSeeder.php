<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Docente;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Crear docente admin
        $docente = Docente::create([
            'nombres' => 'Administrador',
            'apellidos' => 'del Sistema',
            'email' => 'admin@sistema.com',
            'telefono' => '123456789',
            'departamento' => 'Sistemas',
            'grado_academico' => 'Ingeniero',
            'fecha_ingreso' => now(),
            'activo' => true,
        ]);

        // Crear usuario admin
        Usuario::create([
            'docente_id' => $docente->id,
            'username' => 'admin',
            'password' => Hash::make('password123'),
            'rol' => 'administrador',
            'activo' => true,
        ]);

        // Crear docente normal
        $docente2 = Docente::create([
            'nombres' => 'Juan',
            'apellidos' => 'Pérez',
            'email' => 'juan.perez@facultad.edu',
            'telefono' => '987654321',
            'departamento' => 'Matemáticas',
            'grado_academico' => 'Magíster',
            'fecha_ingreso' => now()->subMonths(6),
            'activo' => true,
        ]);

        // Crear usuario normal
        Usuario::create([
            'docente_id' => $docente2->id,
            'username' => 'jperez',
            'password' => Hash::make('password123'),
            'rol' => 'docente',
            'activo' => true,
        ]);
    }
}