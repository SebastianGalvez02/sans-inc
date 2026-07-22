<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Elimina la columna 'role' (string) agregada por
 * 2026_06_24_180000_add_role_to_users_table.php.
 *
 * Esa columna es un residuo de un diseño anterior al uso de
 * role_id + tabla 'roles'. Al coexistir con el método de relación
 * User::role(), Eloquent le da prioridad al atributo de la columna
 * sobre la relación (getAttribute() revisa $attributes antes que
 * relaciones), lo que hace que $user->role devuelva el string de la
 * columna en vez del modelo Role cuando el usuario se carga fresco
 * desde la base de datos (como ocurre vía el guard JWT en producción).
 * Esto provocaba que EnsureUserIsClient rechazara con 403 a TODOS los
 * usuarios reales, sin importar su role_id, mientras que en los tests
 * (que usan instancias de User::factory() recién creadas en memoria,
 * sin la columna 'role' cargada) el bug nunca se manifestaba.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('client')->after('email');
        });
    }
};
