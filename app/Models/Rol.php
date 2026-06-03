<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Importación necesaria para el borrado lógico

/**
 * Modelo Rol
 * * Este modelo representa la tabla 'roles' en la base de datos.
 * Se encarga de gestionar los tipos de perfiles del sistema.
 */
class Rol extends Model
{
    // Permite usar "Factories" para generar datos de prueba falsos fácilmente
    use HasFactory;

    // Habilita el borrado lógico (los registros eliminados solo se ocultan llenando la columna 'deleted_at')
    use SoftDeletes;

    // Vincula explícitamente este modelo con la tabla 'roles' de nuestra base de datos
    protected $table = 'roles';

    // Define los únicos campos que pueden ser llenados mediante asignación masiva (medida de seguridad)
    protected $fillable = [
        'nombre_rol',
        'descripcion'
    ];
}
