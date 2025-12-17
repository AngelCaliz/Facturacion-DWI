<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Si quieres crear un usuario de prueba
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Aquí llamas a todos los seeders, en orden correcto
        $this->call([
            UserSeeder::class,
            TipoArticulosSeeder::class,
            FormaPagosSeeder::class,
            CiudadesSeeder::class,
            TipoDocumentosSeeder::class,
            ClientesSeeder::class,
            ProveedoresSeeder::class,
        ]);
    }
}
