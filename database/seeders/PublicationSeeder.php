<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;
use App\Models\Publication;
use App\Models\Role;
use App\Models\User;

/**
 * PublicationSeeder
 *
 * Puebla la tabla 'publications' con reseñas de prueba para productos existentes.
 *
 * Requiere que RoleSeeder y ProductSeeder hayan sido ejecutados antes.
 * El orden correcto está garantizado en DatabaseSeeder.
 *
 * Para ejecutar individualmente:
 *   php artisan db:seed --class=PublicationSeeder
 */
class PublicationSeeder extends Seeder
{
    /**
     * Inserta publicaciones de prueba asociadas a usuarios y productos existentes.
     *
     * Se resuelve el rol cliente con firstOrFail() y se aseguran usuarios mínimos
     * dentro de este seeder para no depender de un UserSeeder separado.
     */
    public function run(): void
    {
        // Resolvemos el rol cliente una sola vez para los usuarios de prueba.
        $clientRole = Role::where('role_name', 'client')->firstOrFail();

        // PROVISIONAL: actualmente no existe un UserSeeder en ninguna rama del
        // proyecto, por lo que estos usuarios se crean aquí solo para poder
        // sembrar publicaciones de prueba. Cuando exista un UserSeeder real
        // (por ejemplo en feat/usuarios) o el módulo de usuarios esté listo,
        // este bloque debe eliminarse y reemplazarse por una dependencia en
        // DatabaseSeeder (orden: RoleSeeder -> UserSeeder -> CategorySeeder ->
        // ProductSeeder -> PublicationSeeder), resolviendo aquí los usuarios
        // ya sembrados con una query, por ejemplo:
        //   $users = User::where('role_id', $clientRole->id)->take(3)->get();
        $users = [
            User::firstOrCreate(
                ['email' => 'ana.cliente@example.com'],
                [
                    'role_id' => $clientRole->id,
                    'name' => 'AnaCliente',
                    'password' => Hash::make('password'),
                    'recovery_email' => 'ana.recovery@example.com',
                ]
            ),
            User::firstOrCreate(
                ['email' => 'luis.cliente@example.com'],
                [
                    'role_id' => $clientRole->id,
                    'name' => 'LuisCliente',
                    'password' => Hash::make('password'),
                    'recovery_email' => 'luis.recovery@example.com',
                ]
            ),
            User::firstOrCreate(
                ['email' => 'maria.cliente@example.com'],
                [
                    'role_id' => $clientRole->id,
                    'name' => 'MariaCliente',
                    'password' => Hash::make('password'),
                    'recovery_email' => 'maria.recovery@example.com',
                ]
            ),
        ];

        // Resolvemos los productos ya sembrados por ProductSeeder.
        $products = Product::all()->keyBy('name');

        $publications = [
            [
                'userId' => $users[0]->id,
                'productId' => $products->get('Desodorante Ambiental')->productId,
                'rating' => 4.5,
                'publicationDate' => now()->subDays(2),
                'numberOfLikes' => 12,
                'active' => true,
                'review' => 'Deja buen aroma en la casa y ayuda bastante con los olores fuertes.',
            ],
            [
                'userId' => $users[1]->id,
                'productId' => $products->get('Lavalozas')->productId,
                'rating' => 4.0,
                'publicationDate' => now()->subDays(5),
                'numberOfLikes' => 6,
                'active' => true,
                'review' => 'Rinde bien para lavar platos y no deja sensación grasosa.',
            ],
            [
                'userId' => $users[2]->id,
                'productId' => $products->get('Detergente')->productId,
                'rating' => 5.0,
                'publicationDate' => now()->subDays(8),
                'numberOfLikes' => 18,
                'active' => true,
                'review' => 'La ropa queda limpia y con olor agradable incluso en lavados cortos.',
            ],
            [
                'userId' => $users[0]->id,
                'productId' => $products->get('Desinfectante General')->productId,
                'rating' => 3.5,
                'publicationDate' => now()->subDays(12),
                'numberOfLikes' => 3,
                'active' => true,
                'review' => 'Funciona bien para superficies, aunque el aroma podría durar más.',
            ],
            [
                'userId' => $users[1]->id,
                'productId' => $products->get('Jabón Gel')->productId,
                'rating' => 4.8,
                'publicationDate' => now()->subDays(15),
                'numberOfLikes' => 21,
                'active' => true,
                'review' => 'Es suave para la piel y deja una sensación fresca después de la ducha.',
            ],
            [
                'userId' => $users[2]->id,
                'productId' => $products->get('Champú')->productId,
                'rating' => 4.2,
                'publicationDate' => now()->subDays(19),
                'numberOfLikes' => 8,
                'active' => true,
                'review' => 'Me dejó el cabello limpio y con brillo, lo volvería a comprar.',
            ],
            [
                'userId' => $users[0]->id,
                'productId' => $products->get('Bálsamo')->productId,
                'rating' => 5.0,
                'publicationDate' => now()->subDays(23),
                'numberOfLikes' => 15,
                'active' => true,
                'review' => 'Desenreda rápido y el aroma floral queda muy bien en el cabello.',
            ],
            [
                'userId' => $users[1]->id,
                'productId' => $products->get('Pasta de Dientes')->productId,
                'rating' => 3.0,
                'publicationDate' => now()->subDays(27),
                'numberOfLikes' => 0,
                'active' => false,
                'review' => 'Cumple, pero el sabor no fue de mi preferencia.',
            ],
            [
                'userId' => $users[2]->id,
                'productId' => $products->get('Hilo Dental')->productId,
                'rating' => 4.6,
                'publicationDate' => now()->subDays(31),
                'numberOfLikes' => 4,
                'active' => true,
                'review' => 'Resistente y cómodo para limpiar entre dientes sin romperse.',
            ],
        ];

        foreach ($publications as $publication) {
            Publication::create($publication);
        }
    }
}
