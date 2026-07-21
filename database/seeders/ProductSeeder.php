<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

/**
 * Clase para cargar productos iniciales.
 *
 * Puebla la tabla 'products' con los productos iniciales del sistema.
 *
 * Estructura de categorías:
 * - Cada producto pertenece a UNA categoría principal (Limpieza o Uso_Personal),
 *   reflejada en el campo 'categoryId'.
 * - Las categorías secundarias (Irritante, Inflamable, Aroma, Variedades, Dureza)
 *   se almacenan en el campo 'tag' como una cadena separada por comas.
 *   Ejemplo: 'Aroma,Inflamable'
 *
 * Precios en CLP (pesos chilenos).
 *
 * Requiere que CategorySeeder haya sido ejecutado antes.
 * El orden correcto está garantizado en DatabaseSeeder.
 *
 * Para ejecutar individualmente:
 *   php artisan db:seed --class=ProductSeeder
 *
 * @author Equipo Sans Inc.
 * @version 1.0
 */
class ProductSeeder extends Seeder
{
    /**
     * Inserta los productos iniciales en la base de datos.
     *
     * Se resuelven las categorías principales al inicio con firstOrFail()
     * para evitar múltiples queries repetidas (una por producto) y para
     * lanzar un error descriptivo si alguna categoría no existe en la BD.
     */
    public function run(): void
    {
        // Resolvemos las categorías principales una sola vez (2 queries en total)
        // Si alguna no existe, firstOrFail() lanza ModelNotFoundException con mensaje claro.
        $limpieza    = Category::where('categoryName', 'Limpieza')->firstOrFail();
        $usoPersonal = Category::where('categoryName', 'Uso_Personal')->firstOrFail();

        $products = [
            // ── Productos de Limpieza ───────────────────────────────────────────────
            // tag 'Irritante,Inflamable': requiere advertencias de seguridad
            ['categoryId' => $limpieza->categoryId,    'name' => 'Desodorante Ambiental', 'description' => 'Elimina olores y refresca el ambiente del hogar',                'price' => 3990, 'tag' => 'Irritante,Inflamable', 'active' => true],
            // Sin tag: producto sin características secundarias relevantes
            ['categoryId' => $limpieza->categoryId,    'name' => 'Lavalozas',             'description' => 'Lavavajillas líquido para una limpieza eficaz de utensilios',     'price' => 1990, 'tag' => null,                  'active' => true],
            // tag 'Irritante': puede irritar piel o mucosas
            ['categoryId' => $limpieza->categoryId,    'name' => 'Detergente',            'description' => 'Detergente para ropa con fórmula de acción profunda',             'price' => 5490, 'tag' => 'Irritante',           'active' => true],
            // tag 'Aroma': producto con fragancia destacada
            ['categoryId' => $limpieza->categoryId,    'name' => 'Desinfectante General', 'description' => 'Desinfectante multiusos con fragancia fresca para el hogar',      'price' => 2990, 'tag' => 'Aroma',               'active' => true],

            // ── Productos de Uso Personal ───────────────────────────────────────────
            ['categoryId' => $usoPersonal->categoryId, 'name' => 'Jabón Gel',             'description' => 'Gel de baño hidratante para todo tipo de piel',                   'price' => 2490, 'tag' => null,                  'active' => true],
            ['categoryId' => $usoPersonal->categoryId, 'name' => 'Champú',                'description' => 'Champú nutritivo para cabello sano y brillante',                  'price' => 4990, 'tag' => null,                  'active' => true],
            // tag 'Aroma': acondicionador con fragancia especial
            ['categoryId' => $usoPersonal->categoryId, 'name' => 'Bálsamo',               'description' => 'Acondicionador con aroma floral para cabello suave y manejable',  'price' => 5490, 'tag' => 'Aroma',               'active' => true],
            // tag 'Variedades': disponible en múltiples presentaciones o sabores (packs)
            ['categoryId' => $usoPersonal->categoryId, 'name' => 'Pasta de Dientes',      'description' => 'Pasta dental disponible en múltiples presentaciones y sabores',   'price' => 2290, 'tag' => 'Variedades',          'active' => true],
            // tag 'Dureza': producto con variantes de resistencia/dureza
            ['categoryId' => $usoPersonal->categoryId, 'name' => 'Hilo Dental',           'description' => 'Hilo dental resistente para una limpieza profunda entre dientes', 'price' => 1490, 'tag' => 'Dureza',              'active' => true],
            // tag 'Aroma,Inflamable': spray con fragancia, requiere precaución
            ['categoryId' => $usoPersonal->categoryId, 'name' => 'Desodorante',           'description' => 'Desodorante en spray de larga duración con aroma fresco',         'price' => 3490, 'tag' => 'Aroma,Inflamable',    'active' => true],
            // tag 'Variedades,Dureza': múltiples modelos con distinta dureza de cerdas
            ['categoryId' => $usoPersonal->categoryId, 'name' => 'Cepillo de Dientes',    'description' => 'Cepillo dental disponible en varios modelos y dureza de cerdas',  'price' => 2990, 'tag' => 'Variedades,Dureza',   'active' => true],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
