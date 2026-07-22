<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;

/**
 * Clase para ejecutar los seeders principales de la aplicacion.
 *
 * Incluye la carga de categorias y productos necesarios para probar
 * el modulo productos con datos iniciales.
 *
 * @author Equipo Sans Inc.
 * @version 1.0
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta los seeders base de la aplicacion.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RoleSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(PublicationSeeder::class);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
